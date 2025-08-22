@extends('layouts.admin', ["title" => "Nuevo usuario"])

@section('main')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-4">Nuevo Usuario</h2>
        </div>
        <form action="{{ url('/administrador/usuarios') }}" method="post" class="w-full grid grid-cols-3 gap-4">
            @csrf
            @method('post')
            <div class="flex flex-col">
                <label for="name">Nombre</label>
                <input type="text" name="name" value="{{ old('name', '') }}" class="p-2 rounded-lg border">
                @error('name')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="name">Rol</label>
                <select name="role" id="" class="p-2 rounded-lg border">
                    <option value="administrador">Administrador</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="recepcion">Recepción</option>
                    <option value="tarjeador">Tarjeador</option>
                    <option value="caseta">Caseta</option>
                    <option value="cliente">Cliente</option>
                </select>
                @error('role')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="email">Correo</label>
                <input type="text" name="email" value="{{ old('email', '') }}" class="p-2 rounded-lg border">
                @error('email')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="password">Contraseña</label>
                <input type="password" name="password" class="p-2 rounded-lg border">
                @error('password')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <hr class="col-span-3 border-b">
            <div class="col-span-3">
                <a href="{{ url('/admin/usuarios') }}" class="px-4 py-2 rounded-lg bg-gray-600 text-white">Cancelar</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#274275] text-white">Guardar</button>
            </div>
        </form>
    </div>
@endsection
