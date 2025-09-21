@extends('layouts.admin', ["title" => "Gestión de Clientes"])

@section('main')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="mb-4 sm:mb-0">
            <h2 class="text-2xl font-bold text-gray-900">Gestión de Clientes</h2>
            <p class="text-gray-600 mt-1">Administra y gestiona todos los clientes del sistema</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Exportar
            </button>
            <a href="{{ route('clientes.create') }}" 
               class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Cliente
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $clients->total() ?? 0 }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +12% vs mes anterior
                </p>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg">
                <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Clientes Activos</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $clients->where('email_verified_at', '!=', null)->count() ?? 0 }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +8% vs mes anterior
                </p>
            </div>
            <div class="p-3 bg-green-50 rounded-lg">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pendientes</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $clients->where('email_verified_at', null)->count() ?? 0 }}</p>
                <p class="text-xs text-yellow-600 mt-1">
                    <i class="fas fa-minus mr-1"></i>
                    -2% vs mes anterior
                </p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-lg">
                <i class="fas fa-clock text-2xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Nuevos (7 días)</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $clients->where('created_at', '>=', now()->subDays(7))->count() ?? 0 }}</p>
                <p class="text-xs text-indigo-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +18% vs semana anterior
                </p>
            </div>
            <div class="p-3 bg-indigo-50 rounded-lg">
                <i class="fas fa-star text-2xl text-indigo-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Card -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <!-- Filters Section -->
    <div class="p-6 border-b border-gray-100">
        <form method="GET" action="{{ route('clientes.index') }}" id="filtersForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Buscar Cliente
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Nombre, email..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Activos
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Pendientes
                        </option>
                    </select>
                </div>
                
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordenar por
                    </label>
                    <select id="sort" 
                            name="sort" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                            Nombre
                        </option>
                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>
                            Email
                        </option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>
                            Fecha de registro
                        </option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Acciones
                    </label>
                    <div class="flex space-x-2">
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Filtrar
                        </button>
                        <a href="{{ route('clientes.index') }}" 
                           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Header -->
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Lista de Clientes</h3>
            <div class="flex items-center space-x-4 text-sm text-gray-600">
                <span>{{ $clients->count() ?? 0 }} de {{ $clients->total() ?? 0 }} clientes</span>
                <div class="flex items-center space-x-1">
                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                    <span>En línea</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Table Content -->
    <div class="overflow-x-auto">
        @if($clients && $clients->count() > 0)
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="group inline-flex items-center space-x-1 hover:text-gray-900">
                                <span>Cliente</span>
                                @if(request('sort') == 'name')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300 group-hover:text-gray-500"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('sort') == 'email' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="group inline-flex items-center space-x-1 hover:text-gray-900">
                                <span>Email</span>
                                @if(request('sort') == 'email')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300 group-hover:text-gray-500"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Empresa
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="group inline-flex items-center space-x-1 hover:text-gray-900">
                                <span>Registro</span>
                                @if(request('sort') == 'created_at')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-indigo-600"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300 group-hover:text-gray-500"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clients as $client)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($client->name) }}&background=4f46e5&color=ffffff&size=40" 
                                             alt="{{ $client->name }}" 
                                             class="w-10 h-10 rounded-full ring-2 ring-white shadow-sm">
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $client->name }}</div>
                                        <div class="text-sm text-gray-500">ID: #{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $client->email }}</div>
                                <div class="text-sm text-gray-500">{{ $client->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($client->company)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-building mr-1"></i>
                                        {{ $client->company->name ?? 'Sin empresa' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-minus-circle mr-1"></i>
                                        Sin empresa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($client->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $client->created_at->format('d M Y') }}</span>
                                    <span class="text-xs">{{ $client->created_at->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('clientes.show', $client->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $client->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition-colors duration-200"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $client->id }}, '{{ $client->name }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando 
                        <span class="font-medium">{{ $clients->firstItem() ?? 0 }}</span>
                        a 
                        <span class="font-medium">{{ $clients->lastItem() ?? 0 }}</span>
                        de 
                        <span class="font-medium">{{ $clients->total() ?? 0 }}</span>
                        resultados
                    </div>
                    <div>
                        {{ $clients->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay clientes registrados</h3>
                <p class="text-gray-600 mb-8 max-w-sm mx-auto">Comienza agregando tu primer cliente al sistema para empezar a gestionar tu cartera.</p>
                <a href="{{ route('clientes.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar Primer Cliente
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Confirmar Eliminación</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    ¿Estás seguro de que deseas eliminar al cliente 
                    <span id="clientName" class="font-semibold"></span>?
                </p>
                <p class="text-xs text-gray-400 mt-2">Esta acción no se puede deshacer.</p>
            </div>
            <div class="items-center px-4 py-3 space-x-4 flex justify-center">
                <button onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-200">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(clientId, clientName) {
        document.getElementById('clientName').textContent = clientName;
        document.getElementById('deleteForm').action = '/administrador/clientes/' + clientId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Auto-submit filters after 500ms of typing
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filtersForm').submit();
        }, 500);
    });
    
    // Auto-submit on filter changes
    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('filtersForm').submit();
    });
    
    document.getElementById('sort').addEventListener('change', function() {
        document.getElementById('filtersForm').submit();
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endpush
