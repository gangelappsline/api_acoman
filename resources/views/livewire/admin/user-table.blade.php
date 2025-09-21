<div>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-bold text-gray-900">Gestión de Usuarios</h2>
                <p class="text-gray-600 mt-1">Administra los usuarios del sistema y sus permisos</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-download mr-2"></i>
                    Exportar
                </button>
                <a href="{{ url('administrador/usuarios/create') }}" 
                   class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Usuario
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->total() ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        +5% vs mes anterior
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
                    <p class="text-sm font-medium text-gray-600">Administradores</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->where('role', 'admin')->count() ?? 0 }}</p>
                    <p class="text-xs text-indigo-600 mt-1">
                        <i class="fas fa-crown mr-1"></i>
                        Activos
                    </p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg">
                    <i class="fas fa-user-shield text-2xl text-indigo-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Clientes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->where('role', 'client')->count() ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-handshake mr-1"></i>
                        Activos
                    </p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-user-tie text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nuevos (7 días)</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->where('created_at', '>=', now()->subDays(7))->count() ?? 0 }}</p>
                    <p class="text-xs text-yellow-600 mt-1">
                        <i class="fas fa-star mr-1"></i>
                        Esta semana
                    </p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-lg">
                    <i class="fas fa-user-plus text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <!-- Filters Section -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" 
                               wire:model.live="search" 
                               placeholder="Buscar por nombre o email..."
                               class="w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <label class="text-sm text-gray-600">Mostrar:</label>
                    <select wire:model.live="perPage" 
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Lista de Usuarios</h3>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span>{{ $users->count() ?? 0 }} de {{ $users->total() ?? 0 }} usuarios</span>
                </div>
            </div>
        </div>
        
        <!-- Table Content -->
        <div class="overflow-x-auto">
            @if($users->count())
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="order('name')" 
                                        class="group inline-flex items-center space-x-1 hover:text-gray-900">
                                    <span>Usuario</span>
                                    @if($sort == 'name')
                                        <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }} text-indigo-600"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300 group-hover:text-gray-500"></i>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="order('email')" 
                                        class="group inline-flex items-center space-x-1 hover:text-gray-900">
                                    <span>Email</span>
                                    @if($sort == 'email')
                                        <i class="fas fa-sort-{{ $direction == 'asc' ? 'up' : 'down' }} text-indigo-600"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300 group-hover:text-gray-500"></i>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rol
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registro
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f46e5&color=ffffff&size=40" 
                                                 alt="{{ $user->name }}" 
                                                 class="w-10 h-10 rounded-full ring-2 ring-white shadow-sm">
                                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-crown mr-1"></i>
                                            Administrador
                                        </span>
                                    @elseif($user->role === 'client')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-user-tie mr-1"></i>
                                            Cliente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Activo
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                                        <span class="text-xs">{{ $user->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ url('/administrador/usuarios/'.$user->id.'/edit') }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200"
                                           title="Editar usuario">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                title="Eliminar usuario">
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
                            <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                            a 
                            <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                            de 
                            <span class="font-medium">{{ $users->total() ?? 0 }}</span>
                            resultados
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-users text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay usuarios registrados</h3>
                    <p class="text-gray-600 mb-8 max-w-sm mx-auto">Comienza agregando tu primer usuario al sistema para empezar a gestionar los accesos.</p>
                    <a href="{{ url('administrador/usuarios/create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar Primer Usuario
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
