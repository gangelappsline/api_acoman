<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Acoman Dashboard' }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @if(env('APP_ENV') == 'production')
    <link rel="stylesheet" href="{{ asset('build/assets/app-DDxjqB61.css') }}">
    @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @livewireStyles
    @stack('styles')
</head>

<body class="font-inter bg-gray-50 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
    <aside id="sidebar" class="w-72 min-h-screen bg-white shadow-lg transform transition-transform duration-300 ease-in-out fixed lg:static h-full z-50 flex flex-col lg:translate-x-0">
            <!-- Logo & User Profile -->
            <div class="flex flex-col px-6 py-2 border-b border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <img src="{{ asset('./images/logos/logo_acoman_small.jpg') }}" alt="Acoman" class="h-18 block mx-auto w-auto">
                    <button id="menuCloseButton" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>
                
                <!-- User Profile Card -->
                <!--<div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4f46e5&color=ffffff&size=40" 
                             alt="User" class="w-10 h-10 rounded-full ring-2 ring-white shadow-sm">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Administrador' }}</p>
                    </div>
                </div>-->
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <div class="space-y-1">
                    <a href="{{ url('administrador/dashboard') }}" 
                       class="nav-link {{ request()->is('administrador/dashboard*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="nav-icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ url('administrador/clientes') }}" 
                       class="nav-link {{ request()->is('administrador/clientes*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="nav-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span>Clientes</span>
                        </div>
                    </a>

                    <a href="{{ url('administrador/maniobras') }}" 
                       class="nav-link {{ request()->is('administrador/maniobras*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="nav-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <span>Maniobras</span>
                        </div>
                    </a>

                    <a href="{{ url('administrador/usuarios') }}" 
                       class="nav-link {{ request()->is('administrador/usuarios*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="nav-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <span>Personal</span>
                        </div>
                    </a>

                    <a href="{{ url('administrador/reportes') }}" 
                       class="nav-link {{ request()->is('administrador/reportes*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <span>Reportes</span>
                        </div>
                    </a>

                    <a href="{{ url('administrador/configuracion') }}" 
                       class="nav-link {{ request()->is('administrador/configuracion*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <div class="nav-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <span>Configuración</span>
                        </div>
                    </a>
                </div>

                <!-- Settings Section -->
                <div class="pt-6 mt-6 border-t border-gray-100">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Sistema</h3>
                    <div class="space-y-1">
                        <a href="{{ url('administrador/configuracion') }}" class="nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="nav-icon">
                                    <i class="fas fa-wrench"></i>
                                </div>
                                <span>Configuración</span>
                            </div>
                        </a>
                        
                        <a href="#" class="nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="nav-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <span>Ayuda</span>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Logout Button -->
            <div class="p-4 border-t border-gray-100">
                <form action="{{ route('logout') }}" method="post" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium transition-colors duration-200 group">
                        <i class="fas fa-sign-out-alt group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-40">
                <div class="max-w-full mx-auto px-6 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Left side -->
                        <div class="flex items-center space-x-4">
                            <button id="menuButton" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-bars text-gray-600"></i>
                            </button>
                            
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
                                <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="relative hidden md:block">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       placeholder="Buscar..." 
                                       class="w-80 pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200">
                            </div>

                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- Theme Toggle -->
                            <button class="p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg">
                                <i class="fas fa-moon text-xl"></i>
                            </button>

                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4f46e5&color=ffffff&size=32" 
                                         alt="User" class="w-8 h-8 rounded-full">
                                    <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto">
                <div class="p-6">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-center space-x-3">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('main')
                </div>
            </main>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    @livewireScripts
    @stack('scripts')

    <style>
        .font-inter {
            font-family: 'Inter', sans-serif;
        }
        
        .nav-link {
            @apply flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 rounded-lg transition-all duration-200 hover:bg-indigo-50 hover:text-indigo-700 group;
        }
        
        .nav-link.active {
            @apply bg-indigo-600 text-white shadow-md;
        }
        
        .nav-link.active .nav-icon {
            @apply text-white;
        }
        
        .nav-icon {
            @apply w-5 h-5 flex items-center justify-center text-gray-500 group-hover:text-indigo-600;
        }
        
        .nav-link.active .nav-icon {
            @apply text-white;
        }
    </style>

    <script>
        // Sidebar toggle functionality
        const menuButton = document.getElementById('menuButton');
        const menuCloseButton = document.getElementById('menuCloseButton');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        menuButton?.addEventListener('click', toggleSidebar);
        menuCloseButton?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', toggleSidebar);

        // Close sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });

        // Auto-close sidebar on mobile after navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    setTimeout(toggleSidebar, 150);
                }
            });
        });
    </script>
</body>

</html>