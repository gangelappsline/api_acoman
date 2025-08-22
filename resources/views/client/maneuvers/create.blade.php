@extends('layouts.client', ["title" => "Nueva maniobra"])

@section('main')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form action="{{ url('/cliente/maniobras') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
        @method("POST")
        @csrf
        <!--<div class="flex flex-col gap-2">
            <label for="">Cliente</label>
            <input type="text" name="client" value="{{ old('client','')}}" class="border border-gray-400 rounded-md p-2">
            @error('client')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>-->
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
            <input 
                type="text" 
                id="productInput" 
                name="product" 
                autocomplete="off"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Buscar producto..."
            >
            <input type="hidden" id="productId" name="product_id">
            
            <div id="autocompleteResults" class="absolute z-10 -bottom-20 mt-1 w-full bg-white shadow-lg rounded-md py-1 hidden max-h-60 overflow-auto">
            </div>
            <!--<input type="text" name="product" value="{{ old("product",'')}}" class="border border-gray-400 rounded-md p-2">-->
            @error('product')
                <div class="text-sm text-red-700">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col gap-2 relative">
            <label for="">Pais de origen</label>
            <input type="text" name="country" id="countryInput" value="{{ old("country",'')}}" class="border border-gray-400 rounded-md p-2">
            <div id="autocompleteResultsCountries" class="absolute z-10 -bottom-20 mt-1 w-full bg-white shadow-lg rounded-md py-1 hidden max-h-60 overflow-auto">
            </div>
            @error('country')
                    <div class="text-sm text-red-700">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Cantidad de bultos</label>
            <input type="text" name="bulks" value="{{ old("bulks",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('bulks')
                <div class="text-sm text-red-700">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Presentación</label>
            <select name="presentation" id="" class="border border-gray-400 rounded-md p-2">
                <option value="">Seleccionar presentación</option>
                @foreach (config('app.presentations') as $presentation)
                  <option value="{{ $presentation }}">{{ $presentation }}</option>
                @endforeach
            </select>
            @error('presentation')
                <div class="text-sm text-red-700">{{ $message }}</div>
            @enderror
        </div>
        <!--<div class="flex flex-col gap-2">
            <label for="">Agencia</label>
            <input type="text" name="company" value="{{ old("company",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('company')
                <div class="text-sm text-red-700">{{ $message }}</div>
            @enderror
        </div>-->
        <div class="flex flex-col gap-2">
            <label for="">Importador</label>
            <input type="text" name="importer" value="{{ old("importer",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('importer')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Folio 200</label>
            <input type="text" name="folio_200" value="{{ old("200",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('200')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Folio 500</label>
            <input type="text" name="folio_500" value="{{ old("500",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('500')
                    <div class="text-sm text-red-700">{{ $message }}</div>
                @enderror
        </div>
        <div class="flex flex-col gap-2">
            <label for="">Fecha de entrada</label>
            <input type="date" name="programming_date" value="{{ old("programming_date",'')}}" class="border border-gray-400 rounded-md p-2">
            @error('programming_date')
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
@section('scripts')
<script>
    const allProducts = @json($products);
    const allCountries = @json($countries);
    
    document.addEventListener('DOMContentLoaded', function() {
        const productInput = document.getElementById('productInput');
        const productIdInput = document.getElementById('productId');
        const autocompleteResults = document.getElementById('autocompleteResults');

        const countryInput = document.getElementById('countryInput');
        const autocompleteResultsCountries = document.getElementById('autocompleteResultsCountries');

        countryInput.addEventListener('input', function(e) {
            const query = e.target.value.trim().toLowerCase();
            
            if (query.length < 1) {
                autocompleteResultsCountries.classList.add('hidden');
                countryIdInput.value = '';
                return;
            }
            
            // Filtrar productos localmente
            const filteredCountries = allCountries.filter(country => 
                country.name.toLowerCase().includes(query)
            );
            
            if (filteredCountries.length > 0 || query.length > 0) {
                let html = '';
                
                // Mostrar productos filtrados
                filteredCountries.forEach(country => {
                    html += `
                        <div 
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                            data-id="${country.id}"
                            data-name="${country.name}"
                        >
                            ${country.name}
                        </div>
                    `;
                });
                
                // Opción para usar el texto ingresado (si hay texto)
                if (query.length > 0) {
                    /*html += `
                        <div 
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer font-semibold text-indigo-600"
                            data-id="0"
                            data-name="${e.target.value}"
                        >
                            Usar "${e.target.value}" (nuevo producto)
                        </div>
                    `;*/
                }
                
                autocompleteResultsCountries.innerHTML = html;
                autocompleteResultsCountries.classList.remove('hidden');
            } else {
                autocompleteResultsCountries.classList.add('hidden');
            }
        });
        
        productInput.addEventListener('input', function(e) {
            const query = e.target.value.trim().toLowerCase();
            
            if (query.length < 1) {
                autocompleteResults.classList.add('hidden');
                productIdInput.value = '';
                return;
            }
            
            // Filtrar productos localmente
            const filteredProducts = allProducts.filter(product => 
                product.name.toLowerCase().includes(query)
            );
            
            if (filteredProducts.length > 0 || query.length > 0) {
                let html = '';
                
                // Mostrar productos filtrados
                filteredProducts.forEach(product => {
                    html += `
                        <div 
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                            data-id="${product.id}"
                            data-name="${product.name}"
                        >
                            ${product.name}
                        </div>
                    `;
                });
                
                // Opción para usar el texto ingresado (si hay texto)
                if (query.length > 0) {
                    html += `
                        <div 
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer font-semibold text-indigo-600"
                            data-id="0"
                            data-name="${e.target.value}"
                        >
                            Usar "${e.target.value}" (nuevo producto)
                        </div>
                    `;
                }
                
                autocompleteResults.innerHTML = html;
                autocompleteResults.classList.remove('hidden');
            } else {
                autocompleteResults.classList.add('hidden');
            }
        });
        
        // Manejar clic en un resultado del autocomplete
        autocompleteResults.addEventListener('click', function(e) {
            const item = e.target.closest('[data-id]');
            if (item) {
                productInput.value = item.dataset.name;
                productIdInput.value = item.dataset.id;
                autocompleteResults.classList.add('hidden');
            }
        });

        autocompleteResultsCountries.addEventListener('click', function(e) {
            const item = e.target.closest('[data-id]');
            if (item) {
                countryInput.value = item.dataset.name;
                autocompleteResultsCountries.classList.add('hidden');
            }
        });
        
        // Ocultar resultados al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!productInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
                autocompleteResults.classList.add('hidden');
            }
        });
    });
</script>
@endsection