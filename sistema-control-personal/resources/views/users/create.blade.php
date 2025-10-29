<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Registrar Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-500">

            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                <strong>Se encontraron algunos errores:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombres -->
                    <div>
                        <label for="nombres" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombres</label>
                        <input type="text" name="nombres" id="nombres"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                            value="{{ old('nombres') }}" required>
                    </div>

                    <!-- Apellido Paterno -->
                    <div>
                        <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" id="apellido_paterno"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                            value="{{ old('apellido_paterno') }}">
                    </div>

                    <!-- Apellido Materno -->
                    <div>
                        <label for="apellido_materno" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido Materno</label>
                        <input type="text" name="apellido_materno" id="apellido_materno"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                            value="{{ old('apellido_materno') }}">
                    </div>

                    <!-- Correo -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                            value="{{ old('email') }}" required>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                            required>
                    </div>

                    <!-- Rol -->
                    <div>
                        <label for="rol" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                        <select name="rol" id="rol"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                            required>
                            <option value="">Seleccione un rol</option>
                            <option value="ADMINISTRADOR" {{ old('rol') == 'ADMINISTRADOR' ? 'selected' : '' }}>Administrador</option>
                            <option value="OPERADOR" {{ old('rol') == 'OPERADOR' ? 'selected' : '' }}>Operador</option>
                            <option value="USUARIO" {{ old('rol') == 'USUARIO' ? 'selected' : '' }}>Usuario</option>
                        </select>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('usuarios.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Cancelar</a>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>