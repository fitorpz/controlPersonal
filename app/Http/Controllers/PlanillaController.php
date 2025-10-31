<?php

namespace App\Http\Controllers;

use App\Models\Planilla;
use App\Models\Empleado;
use App\Models\Parametro;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PlanillaController extends Controller
{
    public function index()
    {
        $planillas = Planilla::with('empleado')->latest('mes')->get();
        return view('planillas.index', compact('planillas'));
    }

    public function create()
    {
        return view('planillas.create');
    }


    public function show(Planilla $planilla)
    {
        return view('planillas.show', compact('planilla'));
    }

    public function generar(Request $request)
    {
        $mes = $request->input('mes'); // ej: "2025-10"
        $empleados = Empleado::all();

        foreach ($empleados as $empleado) {
            $existe = Planilla::where('empleado_id', $empleado->id)
                ->where('mes', $mes)
                ->exists();

            if ($existe) continue;

            // Calcular rango de fechas
            $fechaInicio = Carbon::parse("$mes-01")->startOfMonth();
            $fechaFin = Carbon::parse("$mes-01")->endOfMonth();

            // Obtener asistencias del mes
            $asistencias = Asistencia::where('empleado_id', $empleado->id)
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->get();

            $diasTrabajados = $asistencias->whereNotNull('hora_entrada')->count();
            $retrasos = $asistencias->where('estado', 'RETRASO')->count();
            $diasHabiles = $fechaFin->diffInWeekdays($fechaInicio) + 1;
            $faltas = max(0, $diasHabiles - $diasTrabajados);

            // Obtener parámetros (usa el valor por empleado si existe)
            $montoFalta = Parametro::valor('monto_por_falta', $empleado->id);
            $montoRetraso = Parametro::valor('monto_por_retraso', $empleado->id);
            $bonoPuntualidad = Parametro::valor('bono_puntualidad', $empleado->id);
            $bonoAsistencia = Parametro::valor('bono_asistencia', $empleado->id);

            // Cálculos
            $total_descuento = ($faltas * $montoFalta) + ($retrasos * $montoRetraso);
            $detalle_descuento = "Faltas: $faltas × $montoFalta + Retrasos: $retrasos × $montoRetraso";

            $bonos = 0;
            $detalle_bonificacion = '';

            if ($faltas === 0) {
                $bonos += $bonoAsistencia;
                $detalle_bonificacion .= "Asistencia perfecta (+$bonoAsistencia). ";
            }

            if ($retrasos === 0) {
                $bonos += $bonoPuntualidad;
                $detalle_bonificacion .= "Puntualidad perfecta (+$bonoPuntualidad).";
            }

            $salario_base = $empleado->salario_mensual ?? 0;
            $salario_neto = max(0, $salario_base - $total_descuento + $bonos);

            Planilla::create([
                'empleado_id' => $empleado->id,
                'generado_por' => Auth::id(),
                'mes' => $mes,
                'dias_trabajados' => $diasTrabajados,
                'faltas' => $faltas,
                'retrasos' => $retrasos,
                'horas_extra' => 0,
                'salario_base' => $salario_base,
                'total_descuento' => $total_descuento,
                'total_bonificacion' => $bonos,
                'salario_neto' => $salario_neto,
                'detalle_descuento' => $detalle_descuento,
                'detalle_bonificacion' => $detalle_bonificacion,
                'estado' => 'GENERADO',
            ]);
        }

        return redirect()->route('planillas.index')->with('success', 'Planillas generadas correctamente.');
    }
}
