<div>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-bold text-gray-900">Gestión de Maniobras</h2>
                <p class="text-gray-600 mt-1">Administra y monitorea todas las maniobras del sistema</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-download mr-2"></i>
                    Exportar
                </button>
                <a href="{{ url('/administrador/maniobras/create') }}" 
                   class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nueva Maniobra
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Maniobras</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $maneuvers->total() ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +12% vs mes anterior
                    </p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-truck text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">En Proceso</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $maneuvers->where('status', 'en_proceso')->count() ?? 0 }}</p>
                    <p class="text-xs text-yellow-600 mt-1">
                        <i class="fas fa-clock mr-1"></i>
                        En tiempo real
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
                    <p class="text-sm font-medium text-gray-600">Completadas</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $maneuvers->where('status', 'completado')->count() ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-check mr-1"></i>
                        Este mes
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
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $maneuvers->where('status', 'pendiente')->count() ?? 0 }}</p>
                    <p class="text-xs text-red-600 mt-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Requieren atención
                    </p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <!-- Filters Section -->
        <div class="p-6 border-b border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado
                    </label>
                    <select wire:model.live="status" 
                            id="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos los estados</option>
                        @foreach($statuses as $statusOption)
                            <option value="{{ $statusOption }}">{{ ucfirst($statusOption) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Cliente
                    </label>
                    <select wire:model.live="client_id" 
                            id="client_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos los clientes</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha Desde
                    </label>
                    <input type="date" 
                           wire:model.live="dateFrom" 
                           id="dateFrom" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha Hasta
                    </label>
                    <input type="date" 
                           wire:model.live="dateTo" 
                           id="dateTo" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Acciones
                    </label>
                    <button wire:click="resetFilters" 
                            class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Lista de Maniobras</h3>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span>{{ $maneuvers->count() ?? 0 }} de {{ $maneuvers->total() ?? 0 }} maniobras</span>
                </div>
            </div>
        </div>
        
        <!-- Table Content -->
        <div class="overflow-x-auto">
            @if($maneuvers->count())
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($maneuvers as $maneuver)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">#{{ str_pad($maneuver->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-indigo-600">{{ substr($maneuver->client->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $maneuver->client->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $maneuver->client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($maneuver->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'completado' => 'bg-green-100 text-green-800',
                                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'en_proceso' => 'bg-blue-100 text-blue-800',
                                            'cancelado' => 'bg-red-100 text-red-800',
                                        ];
                                        $colorClass = $statusColors[$maneuver->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                        @if($maneuver->status === 'completado')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @elseif($maneuver->status === 'pendiente')
                                            <i class="fas fa-clock mr-1"></i>
                                        @elseif($maneuver->status === 'en_proceso')
                                            <i class="fas fa-spinner mr-1"></i>
                                        @else
                                            <i class="fas fa-times-circle mr-1"></i>
                                        @endif
                                        {{ ucfirst($maneuver->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $maneuver->created_at->format('d M Y') }}</span>
                                        <span class="text-xs">{{ $maneuver->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.maniobras.show', $maneuver->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200"
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.maniobras.edit', $maneuver->id) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition-colors duration-200"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
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
                            <span class="font-medium">{{ $maneuvers->firstItem() ?? 0 }}</span>
                            a 
                            <span class="font-medium">{{ $maneuvers->lastItem() ?? 0 }}</span>
                            de 
                            <span class="font-medium">{{ $maneuvers->total() ?? 0 }}</span>
                            resultados
                        </div>
                        <div>
                            {{ $maneuvers->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-truck text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay maniobras registradas</h3>
                    <p class="text-gray-600 mb-8 max-w-sm mx-auto">Comienza agregando tu primera maniobra al sistema para empezar a gestionar las operaciones.</p>
                    <a href="{{ url('/administrador/maniobras/create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar Primera Maniobra
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>