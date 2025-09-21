<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <title>{{ env('APP_NAME', 'Acoman') }}</title>
    @if(env('APP_ENV') == 'production')
    <link rel="stylesheet" href="{{ asset('build/assets/app-DDxjqB61.css') }}">
    @else
    @vite('resources/css/app.css')
    @endif
</head>

<body class="bg-gradient-to-r from-purple-200 to-blue-200 h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-4xl flex overflow-hidden">
        <!-- Left Illustration Section -->
        <div class="hidden lg:flex items-center justify-center bg-gradient-to-b from-blue-500 to-purple-500 w-1/2">
            <img src="{{ asset('./images/manzanillo.webp') }}" alt="Illustration" class="object-cover h-full">
        </div>

        <!-- Right Form Section -->
        <div class="w-full lg:w-1/2 p-8">
            <div class="mb-8">
                <img src="{{ asset('images/logos/logo_acoman_small.jpg') }}" alt="Acoman" class="block mx-auto">
                <h1 class="text-2xl text-center font-bold text-gray-700 mb-2">{{ __('Bienvenido') }}</h1>
            </div>
            <form method="POST" action="{{ url('/login-post') }}">
                @csrf


                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-2">{{ __('Correo') }}</label>
                    <input type="email" name="email" id="email" placeholder=""
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-2">{{ __('Contraseña')
                        }}</label>
                    <input type="password" name="password" id="password" placeholder=""
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Login Button -->
                <div class="mb-6">
                    <button type="submit"
                        class="w-full bg-[#274275] text-white py-2 px-4 rounded-lg hover:bg-[#274275] transition duration-300 cursor-pointer">{{
                        __('Iniciar Sesión') }}</button>
                </div>

                <!-- Social Media Links -->
                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-4">{{ __('Olvidé mi contaseña') }}</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-gray-900 mb-4"><a href="{{ url('/caseta') }}">{{ __('Caseta')
                            }}</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>