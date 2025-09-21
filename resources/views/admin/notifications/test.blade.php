@extends('layouts.admin')

@section('main')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Prueba de Notificaciones OneSignal</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Formulario de prueba -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold">Enviar Notificación de Prueba</h3>
            
            <form id="testNotificationForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                        <input type="text" id="title" name="title" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="Notificación de Prueba desde Acoman" required>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                        <textarea id="message" name="message" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required>Esta es una notificación de prueba del sistema Acoman. ¡Todo funciona correctamente!</textarea>
                    </div>
                    
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL (opcional)</label>
                        <input type="url" id="url" name="url" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="https://example.com">
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Enviar Notificación
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Estado e información -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold">Estado de OneSignal</h3>
            
            <div class="space-y-2">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm"><strong>App ID:</strong> <span id="appId">{{ env('ONESIGNAL_APP_ID') }}</span></p>
                </div>
                
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm"><strong>Estado de Suscripción:</strong> <span id="subscriptionStatus" class="font-medium">Verificando...</span></p>
                </div>
                
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm"><strong>User ID:</strong> <span id="userId" class="font-mono text-xs">Obteniendo...</span></p>
                </div>
                
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm"><strong>Permission:</strong> <span id="permission">Verificando...</span></p>
                </div>
            </div>
            
            <div class="space-y-2">
                <button id="requestPermission" 
                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Solicitar Permisos
                </button>
                
                <button id="showPrompt" 
                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Mostrar Prompt de Suscripción
                </button>
            </div>
        </div>
    </div>
    
    <!-- Log de resultados -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-3">Log de Actividad</h3>
        <div id="activityLog" class="bg-gray-900 text-green-400 p-4 rounded-lg h-64 overflow-y-auto font-mono text-sm">
            <div class="log-entry">Sistema iniciado - Esperando interacciones...</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const logElement = document.getElementById('activityLog');
    
    function addLog(message, type = 'info') {
        const now = new Date().toLocaleTimeString();
        const colors = {
            'info': 'text-green-400',
            'error': 'text-red-400',
            'warning': 'text-yellow-400',
            'success': 'text-blue-400'
        };
        
        const logEntry = document.createElement('div');
        logEntry.className = `log-entry ${colors[type]}`;
        logEntry.innerHTML = `[${now}] ${message}`;
        logElement.appendChild(logEntry);
        logElement.scrollTop = logElement.scrollHeight;
    }
    
    // Verificar estado de OneSignal cuando esté listo
    if (typeof OneSignal !== 'undefined') {
        OneSignalDeferred.push(async function(OneSignal) {
            addLog('OneSignal inicializado correctamente', 'success');
            
            // Verificar estado de suscripción
            const isSubscribed = await OneSignal.getSubscription();
            document.getElementById('subscriptionStatus').textContent = isSubscribed ? 'Suscrito' : 'No suscrito';
            document.getElementById('subscriptionStatus').className = isSubscribed ? 'font-medium text-green-600' : 'font-medium text-red-600';
            
            // Obtener User ID
            const userId = await OneSignal.getUserId();
            document.getElementById('userId').textContent = userId || 'No disponible';
            
            // Verificar permisos
            const permission = await OneSignal.getNotificationPermission();
            document.getElementById('permission').textContent = permission;
            
            addLog(`Estado: ${isSubscribed ? 'Suscrito' : 'No suscrito'}, Permisos: ${permission}`, 'info');
        });
    }
    
    // Manejar envío del formulario
    document.getElementById('testNotificationForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const data = {
            title: formData.get('title'),
            message: formData.get('message'),
            url: formData.get('url'),
            _token: formData.get('_token')
        };
        
        try {
            addLog('Enviando notificación...', 'info');
            
            const response = await fetch('{{ route("notifications.test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                addLog('✓ Notificación enviada exitosamente', 'success');
            } else {
                addLog('✗ Error: ' + result.message, 'error');
            }
        } catch (error) {
            addLog('✗ Error de conexión: ' + error.message, 'error');
        }
    });
    
    // Botón para solicitar permisos
    document.getElementById('requestPermission').addEventListener('click', function() {
        if (typeof OneSignal !== 'undefined') {
            OneSignalDeferred.push(async function(OneSignal) {
                try {
                    addLog('Solicitando permisos de notificación...', 'info');
                    await OneSignal.requestPermission();
                    addLog('✓ Permisos solicitados', 'success');
                    
                    // Actualizar estado
                    setTimeout(async () => {
                        const permission = await OneSignal.getNotificationPermission();
                        document.getElementById('permission').textContent = permission;
                        addLog('Permisos actualizados: ' + permission, 'info');
                    }, 1000);
                } catch (error) {
                    addLog('✗ Error solicitando permisos: ' + error.message, 'error');
                }
            });
        }
    });
    
    // Botón para mostrar prompt
    document.getElementById('showPrompt').addEventListener('click', function() {
        if (typeof OneSignal !== 'undefined') {
            OneSignalDeferred.push(async function(OneSignal) {
                try {
                    addLog('Mostrando prompt de suscripción...', 'info');
                    await OneSignal.showSlidedownPrompt();
                    addLog('✓ Prompt mostrado', 'success');
                } catch (error) {
                    addLog('✗ Error mostrando prompt: ' + error.message, 'error');
                }
            });
        }
    });
});
</script>
@endsection
