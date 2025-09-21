<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acoman</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @if(env('APP_ENV') == 'production')
    <link rel="stylesheet" href="{{ asset('build/assets/app-DDxjqB61.css') }}">
    @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Hide sidebar by default on small screens */
        #sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        @media (min-width: 1024px) {
            #sidebar {
                transform: translateX(0%);
                transition: transform 0.3s ease;
            }
        }
    </style>
    @livewireStyles
</head>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Sidebar -->
    <div class="flex w-full h-screen">
        <aside id="sidebar" class="w-64 bg-white shadow-md flex flex-col fixed lg:static h-full z-50 lg:transform-none">
            <div class="p-4 flex items-center justify-between gap-2">
                <img src="{{ asset('./images/logos/logo_acoman_small.jpg') }}" alt="Acoman" class="block mx-auto w-32">
                <svg xmlns="http://www.w3.org/2000/svg" id="menuCloseButton" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-move-left cursor-pointer lg:hidden">
                    <path d="M6 8L2 12L6 16" />
                    <path d="M2 12H22" />
                </svg>
            </div>
            <nav class="flex-1 mt-6">
                <ul class="space-y-4">
                    <li><a href="{{ url('admin/dashboard') }}"
                            class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-200 rounded gap-2"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-gauge">
                                <path d="m12 14 4-4" />
                                <path d="M3.34 19a10 10 0 1 1 17.32 0" />
                            </svg><span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="{{ url('cliente/maniobras') }}"
                            class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-200 rounded gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-truck">
                                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                <path d="M15 18H9" />
                                <path
                                    d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                <circle cx="17" cy="18" r="2" />
                                <circle cx="7" cy="18" r="2" />
                            </svg>
                            </svg><span>{{ __("Maniobras")}}</span></a>
                    </li>
                    <li><a href="{{ url('admin/users') }}"
                            class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-200 rounded gap-2"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-chart-line">
                                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="m16 13-3.5 3.5-2-2L8 17" />
                            </svg><span>{{ __("Reportes")}}</span></a></li>

                    <li><a href="{{ url('admin/configuracion') }}"
                            class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-200 rounded gap-2"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-wrench">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                            </svg>
                            </svg><span>{{ __("Configuración")}}</span></a></li>

                </ul>
            </nav>
            <div class="p-4">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-500 text-white py-2 px-4 rounded flex gap-2 justify-center items-center cursor-pointer"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-log-out">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" x2="9" y1="12" y2="12" />
                        </svg><span>{{ __('Salir del Panel') }}</span></button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="grow p-6">
            <!-- Header -->
            <header class="flex justify-between items-center mb-6">
                <div class="flex justify-start items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        id="menuButton" class="lucide lucide-menu lg:hidden cursor-pointer">
                        <line x1="4" x2="20" y1="12" y2="12" />
                        <line x1="4" x2="20" y1="6" y2="6" />
                        <line x1="4" x2="20" y1="18" y2="18" />
                    </svg>
                    <h1 class="text-2xl font-semibold">{{ $title }}</h1>
                </div>
                <div class="flex items-center gap-4">
                    <input type="text" placeholder="" class="border rounded-lg px-4 py-2 w-72">
                    <div class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="User"
                            class="w-10 h-10 rounded-full">
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </header>

            @if (session('success'))
            <div class="p-4 mb-2 bg-green-600 text-white rounded shadow-md w-full">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="p-4 mb-2 bg-red-600 text-white rounded shadow-md w-full">
                {{ session('error') }}
            </div>
            @endif

            @yield('main')



        </div>
    </div>
    @livewireScripts
    <script src="{{ asset('js/lucide.js') }}"></script>
    <script>
        const menuButton = document.getElementById('menuButton');
        const menuCloseButton = document.getElementById('menuCloseButton');
        const sidebar = document.getElementById('sidebar');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        menuCloseButton.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });

        window.addEventListener('resize', function(event) {
            if (document.body.clientWidth < 1024)
                sidebar.classList.remove('open');
            else
                sidebar.classList.add('open');
        }, true);
    </script>
    @yield('scripts')
</body>

</html>