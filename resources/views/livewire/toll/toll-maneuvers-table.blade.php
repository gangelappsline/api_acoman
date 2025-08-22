<div>
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-2xl font-bold text-gray-800">Servicios Programados para Hoy</h1>
        <button wire:click="openModal" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
            Agregar Servicio
        </button>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4 mb-2">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Búsqueda por número de servicio -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar por Número</label>
                <input type="text" id="search" wire:model.lazy="search"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Número de servicio">
            </div>

            <!-- Filtro por estado -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="statusFilter" wire:model="statusFilter"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_proceso">En proceso</option>
                    <option value="completado">Completado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>

            <!-- Filtro por tipo de servicio -->
            <div>
                <label for="serviceTypeFilter" class="block text-sm font-medium text-gray-700">Tipo de Servicio</label>
                <select id="serviceTypeFilter" wire:model="serviceTypeFilter"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="traslado">Traslado</option>
                    <option value="almacenaje">Almacenaje</option>
                    <option value="maniobra">Maniobra</option>
                </select>
            </div>
        </div>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Contenedor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Agencia</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Importador</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Folio 500/600</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Autorizó</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Ahora de ingreso</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Hora de salida</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($maneuvers as $maneuver)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->container }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ "-" }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->importer }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">

                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->user_check_in != NULL ?
                    $maneuver->checkInUser->name:'' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->check_in == NULL ? ' -
                    ':date("d/m/Y H:i a", strtotime($maneuver->check_in)) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $maneuver->check_out == NULL ? ' -
                    ':date("d/m/Y H:i a", strtotime($maneuver->check_out)) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">

                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-4">
                    <div class="tooltip" data-tip="Documentos de transportista">
                        <button wire:click="showUploadModal({{ $maneuver->id }})"
                            class="text-blue-600 hover:text-blue-900 mr-3 cursor-pointer">
                            <i class="fa-regular fa-file-arrow-up text-2xl"></i>
                        </button>
                    </div>
                    <div class="tooltip" data-tip="Pago en efectivo">
                        <button wire:click="showUploadMoneyModal({{ $maneuver->id }})"
                            class="text-blue-600 hover:text-blue-900 mr-3 cursor-pointer">
                            <i class="fa-solid fa-sack-dollar text-2xl"></i>
                        </button>
                    </div>
                    @if($maneuver->check_in == NULL)
                    <button wire:click="checkIn({{ $maneuver->id }})"
                        class="text-green-600 hover:text-green-900 cursor-pointer">
                        <i class="fa-solid fa-download text-2xl"></i>
                    </button>
                    @else
                    <button wire:click="checkOut({{ $maneuver->id }})"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <i class="fa-solid fa-upload text-2xl"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                    <img src="{{ asset('images/schedule_icon.png') }}" class="block mx-auto my-6"
                        alt="Programación de maniobras">
                    <p class="font-bold text-xl text-center">No hay servicios programados para hoy</p>
                    <p class="text-center">
                        <button
                            class="px-5 py-3 rounded-md bg-app-darkblue text-white mt-4 flex gap-4 items-center mx-auto"><i
                                class="fa-solid fa-plus"></i>Nuevo servicio</button>
                    </p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($showModalNew)
<div class="fixed inset-0 overflow-y-auto z-50">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75" wire:click="closeModal"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Seleccionar Tipo de Servicio
                </h3>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Opción Traslado -->
                    <button wire:click="selectServiceType('traslado')"
                        class="group bg-blue-50 hover:bg-blue-100 p-4 rounded-lg border border-blue-200 transition">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <div class="ml-4 text-left">
                                <h4 class="text-sm font-medium text-blue-900 group-hover:text-blue-800">Traslado</h4>
                                <p class="text-xs text-blue-600">Servicio de transporte de bienes entre ubicaciones</p>
                            </div>
                        </div>
                    </button>

                    <!-- Opción Almacenaje -->
                    <button wire:click="selectServiceType('almacenaje')"
                        class="group bg-green-50 hover:bg-green-100 p-4 rounded-lg border border-green-200 transition">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="ml-4 text-left">
                                <h4 class="text-sm font-medium text-green-900 group-hover:text-green-800">Almacenaje
                                </h4>
                                <p class="text-xs text-green-600">Servicio de guarda y custodia de bienes</p>
                            </div>
                        </div>
                    </button>

                    <!-- Opción Maniobra -->
                    <button wire:click="selectServiceType('maniobra')"
                        class="group bg-purple-50 hover:bg-purple-100 p-4 rounded-lg border border-purple-200 transition">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4 text-left">
                                <h4 class="text-sm font-medium text-purple-900 group-hover:text-purple-800">Maniobra
                                </h4>
                                <p class="text-xs text-purple-600">Servicio de carga/descarga y manipulación de bienes
                                </p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <div class="mt-5 sm:mt-6">
                <button type="button" wire:click="closeModal"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endif

    <!-- Modal para subir archivos -->
    @if($showModalMoney)
    <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
        <div
            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg mx-auto relative">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Pago en efectivo de maniobra #{{ $selectedManeuver->id }}
                </h3>
                <div class="inset-0 transform transition-all" wire:click="closePaymentModal">
                    <div class="inset-0 text-gray-600 cursor-pointer opacity-75">X</div>
                </div>
            </div>

            <div class="px-6 py-4 space-y-4">
                <div>
                    <label for="cashAmount" class="block text-sm font-medium text-gray-700">Cantidad de efectivo</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" wire:model.defer="cashAmount" id="cashAmount"
                            class="focus:ring-blue-500 focus:border-blue-500 text-black block w-full pl-7 pr-12 py-2 sm:text-sm border-gray-300 rounded-md"
                            placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <span class="text-gray-500 sm:text-sm mr-3">MXN</span>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button class="px-5 py-3 bg-app-darkblue text-white rounded-md" wire:click='savePayment'>Guardar
                            pago</button>
                    </div>
                    @error('cashAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Modal para subir archivos -->
    @if($showModal)
    <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
        <div
            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg mx-auto relative">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Documentos para maniobra #{{ $selectedManeuver->id }}</h3>
                <div class="inset-0 transform transition-all" wire:click="closeFilesModal">
                    <div class="inset-0 text-gray-400 cursor-pointer opacity-75">X</div>
                </div>
            </div>

            <div class="px-6 py-4 space-y-4 flex justify-around">
                <!-- INE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">INE</label>
                    @if($existingIne)
                    <div class="mb-2">
                        <img src="{{ $existingIne }}" alt="INE"
                            class="previewable-image h-32 object-contain border rounded">
                        <p class="text-xs text-gray-500 mt-1">Documento ya subido</p>
                    </div>
                    @else
                    <input type="file" wire:model="ineFile" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                    @endif
                </div>

                <!-- Licencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Licencia de manejo</label>
                    @if($existingLicense)
                    <div class="mb-2">
                        <img src="{{ $existingLicense }}" alt="Licencia"
                            class="previewable-image h-32 object-contain border rounded">
                        <p class="text-xs text-gray-500 mt-1">Documento ya subido</p>
                    </div>
                    @else
                    <input type="file" wire:model="licenseFile" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                    @endif
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                <button wire:click="closeFilesModal" type="button"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </button>
                <button wire:click="uploadFiles" type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Guardar documentos
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

