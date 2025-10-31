<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('user')->get();
        return view('empleados.index', compact('empleados'));
    }

    private function generarCodigoUnico()
    {
        do {
            // Obtener el último registro de empleados ordenado por código numérico
            $ultimo = Empleado::orderByDesc('codigo')->first();

            // Si hay registros, incrementa; si no, empieza desde 1000
            $numero = $ultimo ? intval($ultimo->codigo) + 1 : 1000;

            // Formatear el código a 4 dígitos (sin letras ni ceros a la izquierda)
            $codigo = str_pad($numero, 4, '0', STR_PAD_LEFT);
        } while (Empleado::where('codigo', $codigo)->exists());

        return $codigo;
    }




    public function create()
    {
        // Obtener los IDs de los usuarios que ya están registrados como empleados
        $usuariosRegistrados = Empleado::pluck('user_id');

        // Filtrar usuarios que NO estén en la lista anterior
        $usuarios = User::whereNotIn('id', $usuariosRegistrados)->get();

        $codigo = $this->generarCodigoUnico();

        return view('empleados.create', compact('usuarios', 'codigo'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if (\App\Models\Empleado::where('user_id', $value)->exists()) {
                        $fail('Este usuario ya tiene un empleado registrado.');
                    }
                },
            ],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'edad' => 'required|integer|min:18|max:100',
            'ci' => 'required|string|max:20',
            'codigo' => 'required|unique:empleados,codigo',
            'celular' => 'required|regex:/^[0-9]{8}$/',
            'salario_mensual' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'fecha_retiro' => 'nullable|date|after_or_equal:fecha_ingreso',
            'referencia_1_nombre' => 'required|string|max:100',
            'referencia_1_celular' => 'required|regex:/^[0-9]{8}$/',
            'referencia_2_nombre' => 'nullable|string|max:100',
            'referencia_2_celular' => 'nullable|regex:/^[0-9]{8}$/',
            'ubicacion_domicilio' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('empleados', 'public');
        }

        Empleado::create($data);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');


        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }

    public function edit(Empleado $empleado)
    {
        $usuarios = User::all();
        return view('empleados.edit', compact('empleado', 'usuarios'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'edad' => 'required|integer|min:18|max:100',
            'ci' => 'required|string|max:20',
            'celular' => 'required|regex:/^[0-9]{8}$/',
            'salario_mensual' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'fecha_retiro' => 'nullable|date|after_or_equal:fecha_ingreso',
            'referencia_1_nombre' => 'required|string|max:100',
            'referencia_1_celular' => 'required|regex:/^[0-9]{8}$/',
            'referencia_2_nombre' => 'nullable|string|max:100',
            'referencia_2_celular' => 'nullable|regex:/^[0-9]{8}$/',
            'ubicacion_domicilio' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($empleado->foto) {
                Storage::disk('public')->delete($empleado->foto);
            }
            $data['foto'] = $request->file('foto')->store('empleados', 'public');
        }

        $empleado->update($data);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $empleado)
    {
        if ($empleado->foto) {
            Storage::disk('public')->delete($empleado->foto);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado.');
    }
}
