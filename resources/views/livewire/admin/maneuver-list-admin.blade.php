<div>
    <div class="mb-6 bg-white p-4 rounded-lg shadow">        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
            <!-- Filtro por Estado -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                <select 
                    wire:model.live="status" 
                    id="status" 
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border p-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                    <option value="">Todos</option>
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Cliente -->
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <select 
                    wire:model.live="client_id" 
                    id="client_id" 
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border p-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                    <option value="">Todos los clientes</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por Fecha Desde -->
            <div>
                <label for="dateFrom" class="block text-sm font-medium text-gray-700">Desde</label>
                <input 
                    type="date" 
                    wire:model.live="dateFrom" 
                    id="dateFrom" 
                    class="mt-1 block w-full border p-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
            </div>

            <!-- Filtro por Fecha Hasta -->
            <div>
                <label for="dateTo" class="block text-sm font-medium text-gray-700">Hasta</label>
                <input 
                    type="date" 
                    wire:model.live="dateTo" 
                    id="dateTo" 
                    class="mt-1 block w-full border p-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
            </div>
            <div>
                <a href="{{ url('/administrador/maniobras/create') }}" class="px-5 py-2 bg-app-darkblue rounded-md text-white">Nueva maniobra</a>
            </div>
        </div>

        <!--<div class="mt-4">
            <button 
                wire:click="resetFilters" 
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
            >
                Limpiar Filtros
            </button>
        </div>-->
    </div>

    <!-- Tabla de resultados -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($maneuvers as $maneuver)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->client->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $maneuver->status === 'completado' ? 'bg-green-100 text-green-800' : 
                                       ($maneuver->status === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $maneuver->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No se encontraron maniobras</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $maneuvers->links() }}
        </div>
    </div>
</div>