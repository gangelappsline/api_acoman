<div>
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold mb-4">Usuarios</h2>
            <input type="text" class="p-2 rounded-lg border border-gray-300 w-80" wire:model.live="search" placeholder="Buscar por nombre o correo">
            <a href="{{ url('administrador/usuarios/create') }}" class="bg-[#274275] text-white px-4 py-2 rounded-lg">Nuevo Usuario</a>
        </div>
        <div class="overflow-x-auto">
            @if($users->count())
            <table class="min-w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium"></th>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium"></th>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium cursor-pointer"><button wire:click="order('name')">Nombre</button></th>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium cursor-pointer" wire:click.live="order('email')">Correo</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium">Rol</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium">Activo</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-medium"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t border-gray-200">
                            <td class="px-4 py-2"><input type="checkbox" class="form-checkbox h-4 w-4"></td>
                            <td class="px-4 py-2 text-gray-700 font-semibold">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="User"
                                    class="w-10 h-10 rounded-full">
                            </td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <span class="text-gray-700">{{ $user->name }}</span>
                            </td>
                            <td class="px-4 py-2 text-gray-700">{{ $user->email }}</td>
                            <td class="px-4 py-2 text-gray-700 capitalize">{{ $user->role }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 text-sm font-medium text-white bg-green-500 rounded">Activo</span>
                            </td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <a href="{{ url('/administrador/usuarios/'.$user->id.'/edit') }}" class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-pen">
                                        <path d="M11.5 15H7a4 4 0 0 0-4 4v2" />
                                        <path
                                            d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                        <circle cx="10" cy="7" r="4" />
                                    </svg>
                                </a>
                                <button class="p-2 bg-pink-500 text-white rounded-full hover:bg-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <span>Show items: </span>
                    <select name="" id="" wire:model.live='perPage' wire:key="perPage">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
            @else
            <h1>No hay</h1>
            @endif
            
        </div>
    </div>
</div>
