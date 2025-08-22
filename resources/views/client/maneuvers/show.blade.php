@extends('layouts.client', ["title" => "Detalles de la Maniobra"])

@section('main')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <div class="container mx-auto px-4 py-6">
        <!-- Tarjeta de Información General -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-[#274275] px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Información General</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Pedimento:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->pediment ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Patente:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->patent ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Contenedor:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->container ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Cliente:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->client->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Producto:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->product ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">País:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->country ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Bultos:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->bulks ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Información Adicional -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-[#009fdb] px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Información Adicional</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Presentación:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->presentation ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Importador:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->importer ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Folio 200:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->folio_200 ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Folio 500:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->folio_500 ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Empresa:</label>
                            <p class="mt-1 text-gray-900">{{ $maneuver->company ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#274275]">Fecha de programación:</label>
                            <p class="mt-1 text-gray-900">
                                {{ $maneuver->programming_date ? \Carbon\Carbon::parse($maneuver->programming_date)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Archivos Adjuntos -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                @if($maneuver->files->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <p class="mt-4">No hay archivos adjuntos</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($maneuver->files as $file)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $file->type === 'imagen' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($file->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if(in_array(pathinfo($file->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                            <span class="text-sm text-gray-900 truncate max-w-xs">{{ basename($file->path) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex space-x-2">
                                            <a href="{{ asset('storage/' . $file->path) }}" 
                                            target="_blank"
                                            class="p-2 rounded-md text-blue-600 hover:bg-blue-50"
                                            title="Ver">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <p class="mt-8 text-center">
            <a href="{{ url('/cliente/maniobras') }}" class="px-5 py-3 bg-app-darkblue text-white rounded-md flex w-32 mx-auto gap-2 items-center"><i class="fa-solid fa-arrow-left"></i>Regresar</a>
        </p>
    </div>
</div>
@endsection
@section('scripts')
<script>
   
</script>
@endsection