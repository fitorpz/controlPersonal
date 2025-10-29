<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between max-w-5xl mx-auto w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios del Sistema') }}
            </h2>

            {{-- Botón para nuevo usuario --}}
            <a href="{{ route('usuarios.create') }}"
                class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-6">
            {{-- Mensaje de éxito --}}
            @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6 border border-green-300 text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Tabla de usuarios --}}
            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
                {{-- ✅ Contenedor con scroll horizontal --}}
                <div class="overflow-x-auto">
                    <table class="table-auto min-w-max border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm font-semibold">
                                <th class="px-4 py-3 text-left border-b">ID</th>
                                <th class="px-4 py-3 text-left border-b">Nombre</th>
                                <th class="px-4 py-3 text-left border-b">Correo</th>
                                <th class="px-4 py-3 text-left border-b">Rol</th>
                                <th class="px-4 py-3 text-left border-b">Estado</th>
                                <th class="px-4 py-3 text-center border-b w-44">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($usuarios as $usuario)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-800 border-b">{{ $usuario->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 border-b whitespace-nowrap">
                                    {{ $usuario->nombres }} {{ $usuario->apellido_paterno }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 border-b whitespace-nowrap">{{ $usuario->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 border-b capitalize whitespace-nowrap">{{ $usuario->rol }}</td>
                                <td class="px-4 py-3 text-sm border-b whitespace-nowrap">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ strtoupper($usuario->estado) === 'ACTIVO'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst(strtolower($usuario->estado)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center border-b whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-4">
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                            class="flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-1.5l-9.192 9.192a2 2 0 01-.878.515l-3.39.848a.5.5 0 01-.606-.606l.848-3.39a2 2 0 01.515-.878l9.192-9.192a2 2 0 012.828 0z" />
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST"
                                            onsubmit="return confirm('¿Desactivar este usuario?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center text-red-600 hover:text-red-800 font-medium">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Desactivar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-5 text-center text-gray-600">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>