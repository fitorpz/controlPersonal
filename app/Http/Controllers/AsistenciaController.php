<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\Horario;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Muestra todas las asistencias registradas.
     */
    public function index()
    {
        $usuario = Auth::user();

        if ($usuario->rol === 'usuario') {
            $empleado = $usuario->empleado;

            if (!$empleado) {
                abort(403, 'No se encontró un empleado vinculado al usuario.');
            }

            $asistencias = $empleado->asistencias()->latest()->get();
        } else {
            $asistencias = Asistencia::with('empleado')->latest()->get();
        }

        return view('asistencias.index', compact('asistencias'));
    }


    /**
     * Registrar entrada (puede ser desde login sin sesión).
     */
    public function storeEntrada(Request $request)
    {
        Log::info('Intentando registrar entrada', $request->all());
        $request->validate([
            'codigo' => 'required|string',
            'ubicacion_marcaje' => 'nullable|string',
        ]);

        // Buscar empleado por código en lugar de CI
        $empleado = Empleado::where('codigo', $request->codigo)->first();

        if (!$empleado) {
            Log::warning('Empleado no encontrado con código: ' . $request->codigo);
            return back()->with('error', 'Empleado no encontrado con ese código.');
        }

        Log::info('Empleado encontrado', ['empleado_id' => $empleado->id]);


        $hoy = Carbon::today()->toDateString();

        $asistencia = Asistencia::where('empleado_id', $empleado->id)
            ->whereDate('fecha', $hoy)
            ->first();


        if ($asistencia && $asistencia->hora_entrada) {
            return back()->with('error', 'Ya se registró la entrada hoy.');
        }

        $horaActual = Carbon::now()->format('H:i:s');

        $horario = Horario::where('empleado_id', $empleado->id)->first();

        $estado = 'PRESENTE';
        if ($horario && $horaActual > $horario->hora_entrada) {
            $estado = 'RETRASO';
        }

        if (!$asistencia) {
            $asistencia = new Asistencia();
            $asistencia->empleado_id = $empleado->id;
            $asistencia->fecha = $hoy;
        }

        $asistencia->hora_entrada = $horaActual;
        $asistencia->ubicacion_marcaje = $request->ubicacion_marcaje;
        $asistencia->estado = $estado;
        $asistencia->save();

        return back()->with('success', 'Entrada registrada correctamente.');
    }


    /**
     * Registrar salida del empleado.
     */
    public function storeSalida(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        $empleado = Empleado::where('codigo', $request->codigo)->first();

        if (!$empleado) {
            return back()->with('error', 'Empleado no encontrado con ese código.');
        }

        $hoy = Carbon::today()->toDateString();

        $asistencia = Asistencia::where('empleado_id', $empleado->id)
            ->whereDate('fecha', $hoy)
            ->first();


        if (!$asistencia || !$asistencia->hora_entrada) {
            return back()->with('error', 'No se registró entrada hoy.');
        }

        if ($asistencia->hora_salida) {
            return back()->with('error', 'Ya se registró la salida.');
        }

        $horaActual = Carbon::now()->format('H:i:s');

        $horario = Horario::where('empleado_id', $empleado->id)->first();
        if ($horario && $horaActual < $horario->hora_salida) {
            $asistencia->estado = 'SALIDA_ANTICIPADA';
        }

        $asistencia->hora_salida = $horaActual;
        $asistencia->save();

        return back()->with('success', 'Salida registrada correctamente.');
    }
}
