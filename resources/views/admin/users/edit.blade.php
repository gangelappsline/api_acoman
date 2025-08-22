@extends('layouts.admin', ["title" => "Modificar usuario"])

@section('main')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-4">Modificar Usuario</h2>
        </div>
        <form action="{{ url('/admin/usuarios/'.$user->id) }}" method="post" class="w-full grid grid-cols-3 gap-4">
            @csrf
            @method('put')
            <div class="flex flex-col">
                <label for="name">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="p-2 rounded-lg border">
                @error('name')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="name">Rol</label>
                <select name="role" id="" class="p-2 rounded-lg border">
                    <option value="administrador" {{ $user->role == "administrador" ? 'selected':''}}>Admin</option>
                    <option value="supervisor" {{ $user->role == "supervisor" ? 'selected':''}}>Supervisor</option>
                    <option value="recepcion" {{ $user->role == "recepcion" ? 'selected':''}}>Recepción</option>
                    <option value="caseta" {{ $user->role == "caseta" ? 'selected':''}}>Caseta</option>
                    <option value="cliente" {{ $user->role == "cliente" ? 'selected':''}}>Cliente</option>
                </select>
                @error('role')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <label for="email">Correo</label>
                <input type="text" name="email" readonly value="{{ old('email', $user->email) }}" class="p-2 rounded-lg border">
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
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Guardar</button>
            </div>
        </form>
    </div>
@endsection
