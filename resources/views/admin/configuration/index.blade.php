@extends('layouts.admin', ["title" => "Configuración"])

@section("main")
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="mb-4 sm:mb-0">
            <h2 class="text-2xl font-bold text-gray-900">Configuración del Sistema</h2>
            <p class="text-gray-600 mt-1">Gestiona las configuraciones generales y parámetros del sistema</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Exportar Config
            </button>
        </div>
    </div>
</div>

<!-- Configuration Sections -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- General Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-cog text-indigo-600 mr-3"></i>
                Configuración General
            </h3>
        </div>
        <div class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Sistema</label>
                <input type="text" value="ACOMAN" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email de Administrador</label>
                <input type="email" value="admin@acoman.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Zona Horaria</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="America/Mexico_City" selected>América/Ciudad de México</option>
                    <option value="America/Tijuana">América/Tijuana</option>
                    <option value="America/Cancun">América/Cancún</option>
                </select>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="maintenance" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="maintenance" class="ml-2 block text-sm text-gray-900">Modo de mantenimiento</label>
            </div>
        </div>
    </div>

    <!-- Notification Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-bell text-yellow-600 mr-3"></i>
                Configuración de Notificaciones
            </h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <label class="text-sm font-medium text-gray-900">Notificaciones por Email</label>
                    <p class="text-sm text-gray-600">Enviar notificaciones importantes por correo</p>
                </div>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="email_notifications" id="email_notifications" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" checked/>
                    <label for="email_notifications" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <label class="text-sm font-medium text-gray-900">Push Notifications</label>
                    <p class="text-sm text-gray-600">Notificaciones push en tiempo real</p>
                </div>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="push_notifications" id="push_notifications" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" checked/>
                    <label for="push_notifications" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <label class="text-sm font-medium text-gray-900">SMS Notifications</label>
                    <p class="text-sm text-gray-600">Alertas importantes por SMS</p>
                </div>
                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                    <input type="checkbox" name="sms_notifications" id="sms_notifications" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                    <label for="sms_notifications" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-shield-alt text-green-600 mr-3"></i>
                Configuración de Seguridad
            </h3>
        </div>
        <div class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo de sesión (minutos)</label>
                <input type="number" value="120" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Intentos de login máximos</label>
                <input type="number" value="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="two_factor" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" checked>
                <label for="two_factor" class="ml-2 block text-sm text-gray-900">Autenticación de dos factores</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="strong_password" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" checked>
                <label for="strong_password" class="ml-2 block text-sm text-gray-900">Requerir contraseñas seguras</label>
            </div>
        </div>
    </div>

    <!-- API Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-code text-purple-600 mr-3"></i>
                Configuración API
            </h3>
        </div>
        <div class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">API Rate Limit (req/min)</label>
                <input type="number" value="60" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">API Version</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="v1" selected>v1.0</option>
                    <option value="v2">v2.0 (Beta)</option>
                </select>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                <div class="flex">
                    <input type="text" value="ak_live_*********************" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg bg-gray-100" readonly>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-600 mt-1">Última regeneración: hace 15 días</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Acciones Rápidas</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <button class="flex items-center justify-center px-6 py-4 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200">
            <i class="fas fa-database mr-3"></i>
            Respaldar BD
        </button>
        <button class="flex items-center justify-center px-6 py-4 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors duration-200">
            <i class="fas fa-broom mr-3"></i>
            Limpiar Cache
        </button>
        <button class="flex items-center justify-center px-6 py-4 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition-colors duration-200">
            <i class="fas fa-file-alt mr-3"></i>
            Ver Logs
        </button>
        <button class="flex items-center justify-center px-6 py-4 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors duration-200">
            <i class="fas fa-sync mr-3"></i>
            Sincronizar
        </button>
    </div>
</div>

<!-- Save Button -->
<div class="mt-8 flex justify-end">
    <button class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 shadow-sm">
        <i class="fas fa-save mr-2"></i>
        Guardar Configuración
    </button>
</div>

<style>
.toggle-checkbox:checked {
    @apply: right-0 border-indigo-600;
    right: 0;
    border-color: #4f46e5;
}
.toggle-checkbox:checked + .toggle-label {
    @apply: bg-indigo-600;
    background-color: #4f46e5;
}
</style>
@endsection