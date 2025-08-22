@extends('layouts.admin', ["title" => "Servicios"])

@section('main')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-4">Servicios</h2>
        </div>
        <livewire:services-table/>
    </div>
@endsection