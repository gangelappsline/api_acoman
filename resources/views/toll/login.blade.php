<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Caseta - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .digit-input {
            transition: all 0.2s ease;
        }

        .digit-input:focus {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        #error-message {
            transition: opacity 0.3s ease;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-purple-200 to-blue-200 h-screen flex items-center justify-center">

    <main class="max-w-4xl w-full mx-auto">
        <div class="flex items-center justify-center lg:w-8/12 mx-auto">
            <div class="w-full p-8 space-y-8 bg-white rounded-lg shadow-md">
                <img src="{{ asset('images/logos/logo_acoman.jpg') }}" alt="Acoman Logo" class="mx-auto mb-6 w-1/2">
                <div id="error-message" class="hidden bg-red-50 border-l-4 border-red-500 p-4">
                    <p class="text-sm text-red-700">Credenciales incorrectas</p>
                </div>
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Acceso Caseta</h2>
                    <p class="mt-2 text-sm text-gray-600">Ingrese su código único</p>
                </div>

                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                    @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form class="mt-8 space-y-6" action="{{ url('/caseta/login') }}" method="POST">
                    @method("POST")
                    @csrf
                    <div class="flex justify-center space-x-2">
                        @for($i = 1; $i <= 6; $i++) <input type="text" maxlength="1"
                            class="w-16 h-16 text-center text-2xl border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 digit-input"
                            data-index="{{ $i-1 }}" oninput="moveToNext(this)" onkeydown="handleBackspace(this, event)">
                            @endfor
                    </div>

                    <input type="hidden" id="full-code" name="code">

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent
                           text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Acceder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        const digitInputs = document.querySelectorAll('.digit-input');
    const fullCodeInput = document.getElementById('full-code');
    const errorMessage = document.getElementById('error-message');
    const form = document.getElementById('code-form');
    
    // Mover al siguiente campo al ingresar un dígito
    function moveToNext(input) {
        const currentIndex = parseInt(input.dataset.index);
        const value = input.value;
        
        if (value.length === 1) {
            // Actualizar el código completo
            updateFullCode();
            
            // Si no es el último campo, mover al siguiente
            if (currentIndex < 5) {
                digitInputs[currentIndex + 1].focus();
            } else {
                // Si es el último campo, validar el código
                validateCode();
            }
        }
    }
    
    // Manejar la tecla de retroceso
    function handleBackspace(input, event) {
        if (event.key === 'Backspace' && input.value === '') {
            const currentIndex = parseInt(input.dataset.index);
            if (currentIndex > 0) {
                digitInputs[currentIndex - 1].focus();
            }
        }
    }
    
    // Actualizar el código completo oculto
    function updateFullCode() {
        let code = '';
        digitInputs.forEach(input => {
            code += input.value;
        });
        fullCodeInput.value = code;
    }
    
    // Validar el código via fetch
    async function validateCode() {
        const code = fullCodeInput.value;
        
        if (code.length !== 6) return;
        
        try {
            const response = await fetch('/caseta/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ code })
            });
            
            const data = await response.json();
            
            if (data.success) {
                window.location.href = '/caseta/programacion';
            } else {
                showError();
                clearInputs();
            }
        } catch (error) {
            showError();
            clearInputs();
        }
    }
    
    function showError() {
        errorMessage.classList.remove('hidden');
        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, 3000);
    }
    
    function clearInputs() {
        digitInputs.forEach(input => {
            input.value = '';
        });
        digitInputs[0].focus();
    }
    </script>

</body>

</html>