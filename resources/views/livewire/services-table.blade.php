<div>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Listado de Servicios</h1>
        <button wire:click="toggleModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Agregar Nuevo Servicio
        </button>
    </div>

    <!-- Tabla de servicios existentes -->
    <table class="min-w-full bg-white">
        <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedimento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenedor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compañia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Importador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                </tbody>
        </table>
    </table>

    <!-- Modal para seleccionar tipo de servicio -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Seleccionar Tipo de Servicio</h2>
                
                <div class="grid grid-cols-1 gap-4">
                    <button wire:click="seleccionarTipo('maniobra')" 
                            class="bg-blue-500 hover:bg-blue-700 text-white py-3 px-4 rounded-lg text-center">
                        Maniobra
                    </button>
                    
                    <button wire:click="seleccionarTipo('almacenaje')" 
                            class="bg-green-500 hover:bg-green-700 text-white py-3 px-4 rounded-lg text-center">
                        Almacenaje
                    </button>
                    
                    <button wire:click="seleccionarTipo('traslado')" 
                            class="bg-purple-500 hover:bg-purple-700 text-white py-3 px-4 rounded-lg text-center">
                        Traslado
                    </button>
                </div>
                
                <div class="mt-4 flex justify-end">
                    <button wire:click="toggleModal" class="text-gray-500 hover:text-gray-700">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
