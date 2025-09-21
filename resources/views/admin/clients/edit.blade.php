@extends('layouts.admin', ["title" => "Editar Cliente"])

@section('main')
<div class="max-w-5xl mx-auto">
	<div class="mb-8 flex items-center justify-between">
		<div>
			<h2 class="text-2xl font-bold text-gray-900">Editar cliente</h2>
			<p class="text-gray-600 mt-1">Actualiza la información del cliente.</p>
		</div>
		<a href="{{ url('administrador/clientes') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
			<i class="fas fa-arrow-left mr-2"></i>
			Volver
		</a>
	</div>

	<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
		<form action="{{ route('clientes.update', $client->id) }}" method="POST" class="space-y-8">
			@csrf
			@method('PUT')

			<div>
				<h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
					<i class="fas fa-id-card text-indigo-600 mr-2"></i>
					Información del Cliente
				</h3>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
						<input type="text" name="name" value="{{ old('name', $client->name) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
						@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
						<input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" readonly>
						@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
						<input type="text" name="company" value="{{ old('company', optional($client->company)->name) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
						@error('company')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
						<input type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
						@error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
				</div>
			</div>

			<div>
				<h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
					<i class="fas fa-lock text-indigo-600 mr-2"></i>
					Acceso (opcional)
				</h3>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
						<input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Dejar vacío para no cambiar">
						@error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
						<input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
					</div>
				</div>
			</div>

			<div class="flex items-center justify-between pt-4 border-t border-gray-100">
				<button type="button" onclick="confirmDeleteClient({{ $client->id }}, '{{ $client->name }}')" class="inline-flex items-center px-4 py-2 text-sm text-red-600 hover:text-red-700">
					<i class="fas fa-trash mr-2"></i>
					Eliminar Cliente
				</button>
				<div class="flex items-center space-x-4">
					<a href="{{ url('administrador/clientes') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
						<i class="fas fa-times mr-2"></i>
						Cancelar
					</a>
					<button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
						<i class="fas fa-save mr-2"></i>
						Guardar Cambios
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteClientModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
	<div class="relative top-24 mx-auto p-6 border w-full max-w-md shadow-lg rounded-lg bg-white">
		<div class="text-center">
			<div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
				<i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
			</div>
			<h3 class="text-lg font-semibold text-gray-900">Eliminar Cliente</h3>
			<p class="text-sm text-gray-600 mt-2">¿Seguro que deseas eliminar a <span id="deleteClientName" class="font-medium"></span>? Esta acción no se puede deshacer.</p>
			<div class="mt-6 flex items-center justify-center space-x-4">
				<button onclick="closeDeleteClientModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancelar</button>
				<form id="deleteClientForm" method="POST" class="inline">
					@csrf
					@method('DELETE')
					<button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
						<i class="fas fa-trash mr-2"></i>Eliminar
					</button>
				</form>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	function confirmDeleteClient(id, name){
		document.getElementById('deleteClientName').textContent = name;
		document.getElementById('deleteClientForm').action = '/administrador/clientes/' + id;
		document.getElementById('deleteClientModal').classList.remove('hidden');
	}
	function closeDeleteClientModal(){
		document.getElementById('deleteClientModal').classList.add('hidden');
	}
	document.getElementById('deleteClientModal')?.addEventListener('click', function(e){
		if(e.target === this){ closeDeleteClientModal(); }
	});
	document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeDeleteClientModal(); });
</script>
@endpush
@endsection
