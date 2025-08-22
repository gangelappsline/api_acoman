@extends('layouts.admin', ["title" => "Nueva maniobra"])

@section('main')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form action="{{ url('/administrador/maniobras') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
        @method("POST")
        @csrf
        <div class="flex flex-col gap-2">
            <label for="">Cliente</label>
            <input type="text" name="client" value="{{ old('client','')}}" class="border border-gray-400 rounded-md p-2">
            @error('client')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Pedimento</label>
            <input type="text" name="pediment" value="{{ old("pediment",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('pediment')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Patente</label>
            <input type="text" name="patent" value="{{ old("patent",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('patent')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Contenedor</label>
            <input type="text" name="container" value="{{ old("container",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('container')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2 relative">
            <label for="">Producto</label>
            <input type="text" name="product" value="{{ old("product",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('product')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Pais de origen</label>
            <input type="text" name="country" value="{{ old("country",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('country')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Bultos</label>
            <input type="text" name="bulks" value="{{ old("bulks",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('bulks')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Agencia</label>
            <input type="text" name="company" value="{{ old("company",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('company')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Importador</label>
            <input type="text" name="importer" value="{{ old("importer",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('importer')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Folio 200</label>
            <input type="text" name="200" value="{{ old("200",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('200')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Folio 500</label>
            <input type="text" name="500" value="{{ old("500",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('500')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <hr class="w-full border-t col-span-4 my-4 border-gray-400">
        <div>
           <a href="{{ url('/administrador/maniobras') }}" class="w-full py-3 bg-gray-500 rounded-md text-white text-center flex gap-2 items-center justify-center"><i class="fa-solid fa-arrow-left"></i>Cancelar</a> 
        </div>
        <div>
            <button class="cursor-pointer w-full py-3 bg-app-darkblue rounded-md text-white flex gap-2 items-center justify-center"><i class="fa-regular fa-floppy-disk"></i>Guardar</button>
        </div>
    </form>
</div>
@endsection