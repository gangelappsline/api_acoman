@extends('layouts.admin', ["title" => "Editar Usuario"])

@section('main')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Editar usuario</h2>
            <p class="text-gray-600 mt-1">Actualiza la información del usuario seleccionado.</p>
        </div>
        <a href="{{ url('administrador/usuarios') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        <form action="{{ url('/admin/usuarios/'.$user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-indigo-600 mr-2"></i>
                    Información Básica
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" readonly class="w-full bg-gray-100 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Role & Access -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-shield text-indigo-600 mr-2"></i>
                    Rol y Accesos
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rol del Usuario</label>
                        <select name="role" id="role" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="administrador" {{ $user->role == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="supervisor" {{ $user->role == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option value="recepcion" {{ $user->role == 'recepcion' ? 'selected' : '' }}>Recepción</option>
                            <option value="tarjeador" {{ $user->role == 'tarjeador' ? 'selected' : '' }}>Tarjeador</option>
                            <option value="caseta" {{ $user->role == 'caseta' ? 'selected' : '' }}>Caseta</option>
                            <option value="cliente" {{ $user->role == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Actualizar Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="Dejar en blanco para no cambiar" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                <a href="{{ url('administrador/usuarios') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
