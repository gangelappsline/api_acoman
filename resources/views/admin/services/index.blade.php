@extends('layouts.admin', ["title" => "Servicios"])

@section('main')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Gestión de Servicios</h2>
        <p class="text-gray-600 mt-1">Administra los servicios disponibles para clientes y maniobras.</p>
    </div>
    <div class="flex items-center space-x-3">
        <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <i class="fas fa-download mr-2"></i>
            Exportar
        </button>
        <a href="#" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Servicio
        </a>
    </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <livewire:services-table />
    </div>
@endsection