@extends('layouts.admin', ["title" => "Nuevo Cliente"])

@section('main')
<div class="max-w-5xl mx-auto">
	<div class="mb-8 flex items-center justify-between">
		<div>
			<h2 class="text-2xl font-bold text-gray-900">Registrar nuevo cliente</h2>
			<p class="text-gray-600 mt-1">Introduce los datos principales del cliente.</p>
		</div>
		<a href="{{ url('administrador/clientes') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
			<i class="fas fa-arrow-left mr-2"></i>
			Volver
		</a>
	</div>

	<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
		<form action="{{ route('clientes.store') }}" method="POST" class="space-y-8">
			@csrf
			@method('POST')

			<div>
				<h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
					<i class="fas fa-id-card text-indigo-600 mr-2"></i>
					Información del Cliente
				</h3>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
						<input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nombre completo">
						@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
						<input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="cliente@correo.com">
						@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
						<input type="text" name="company" value="{{ old('company') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Razón social">
						@error('company')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
						<input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: +52 55 1234 5678">
						@error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
				</div>
			</div>

			<div>
				<h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
					<i class="fas fa-lock text-indigo-600 mr-2"></i>
					Acceso
				</h3>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
						<input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Mínimo 8 caracteres">
						@error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
						<input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Repite la contraseña">
					</div>
				</div>
			</div>

			<div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
				<a href="{{ url('administrador/clientes') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
					<i class="fas fa-times mr-2"></i>
					Cancelar
				</a>
				<button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
					<i class="fas fa-save mr-2"></i>
					Guardar Cliente
				</button>
			</div>
		</form>
	</div>
</div>
@endsection
