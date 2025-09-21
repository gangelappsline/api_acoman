<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneSignal Diagnóstico - Acoman</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold mb-6">OneSignal Diagnóstico</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Estado -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold">Estado Actual</h2>
                <div class="space-y-2">
                    <div class="p-3 bg-gray-50 rounded">
                        <strong>App ID:</strong> <span id="appId">{{ env('ONESIGNAL_APP_ID') }}</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <strong>Inicializado:</strong> <span id="initialized" class="font-medium">No</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <strong>Permisos:</strong> <span id="permission">Verificando...</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <strong>Suscrito:</strong> <span id="subscribed">Verificando...</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <strong>User ID:</strong> <span id="userId" class="font-mono text-xs">-</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <strong>Push Token:</strong> <span id="pushToken" class="font-mono text-xs">-</span>
                    </div>
                </div>
            </div>
            
            <!-- Acciones -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold">Acciones</h2>
                <div class="space-y-2">
                    <button id="requestPermission" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                        Solicitar Permisos
                    </button>
                    <button id="showPrompt" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                        Mostrar Prompt
                    </button>
                    <button id="subscribe" class="w-full bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700">
                        Suscribirse
                    </button>
                    <button id="unsubscribe" class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                        Desuscribirse
                    </button>
                    <button id="refresh" class="w-full bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700">
                        Actualizar Estado
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Log -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-3">Log de Eventos</h2>
            <div id="log" class="bg-black text-green-400 p-4 rounded h-64 overflow-y-auto font-mono text-sm">
                <div>[INFO] Página cargada. Esperando OneSignal...</div>
            </div>
        </div>
        
        <!-- Instrucciones -->
        <div class="mt-6 p-4 bg-blue-50 rounded">
            <h3 class="font-semibold text-blue-800">Instrucciones:</h3>
            <ol class="list-decimal list-inside mt-2 text-blue-700">
                <li>Abre las herramientas de desarrollador (F12)</li>
                <li>Ve a la pestaña "Console" para ver logs detallados</li>
                <li>Haz clic en "Solicitar Permisos" si no aparece el prompt automáticamente</li>
                <li>Permite las notificaciones cuando el navegador lo solicite</li>
                <li>Verifica que el estado cambie a "Suscrito: true"</li>
            </ol>
        </div>
    </div>

    <script>
        let OneSignalInstance = null;
        
        function addLog(message, type = 'INFO') {
            const log = document.getElementById('log');
            const time = new Date().toLocaleTimeString();
            const entry = document.createElement('div');
            entry.innerHTML = `[${type}] [${time}] ${message}`;
            log.appendChild(entry);
            log.scrollTop = log.scrollHeight;
            console.log(`[OneSignal ${type}]`, message);
        }
        
        async function updateStatus() {
            if (!OneSignalInstance) {
                addLog('OneSignal no está inicializado', 'ERROR');
                return;
            }
            
            try {
                const permission = await OneSignalInstance.getNotificationPermission();
                const isSubscribed = await OneSignalInstance.getSubscription();
                
                document.getElementById('permission').textContent = permission;
                document.getElementById('subscribed').textContent = isSubscribed ? 'Sí' : 'No';
                document.getElementById('subscribed').className = isSubscribed ? 'font-medium text-green-600' : 'font-medium text-red-600';
                
                if (isSubscribed) {
                    const userId = await OneSignalInstance.getUserId();
                    const pushToken = await OneSignalInstance.getPushSubscription();
                    
                    document.getElementById('userId').textContent = userId || 'No disponible';
                    document.getElementById('pushToken').textContent = pushToken ? 'Disponible' : 'No disponible';
                }
                
                addLog(`Estado actualizado - Permisos: ${permission}, Suscrito: ${isSubscribed}`);
            } catch (error) {
                addLog(`Error actualizando estado: ${error.message}`, 'ERROR');
            }
        }
        
        // Configurar OneSignal
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            OneSignalInstance = OneSignal;
            addLog('OneSignal SDK cargado');
            
            try {
                await OneSignal.init({
                    appId: "{{ env('ONESIGNAL_APP_ID') }}",
                    safari_web_id: "{{ env('ONESIGNAL_SAFARI_WEB_ID') }}",
                    allowLocalhostAsSecureOrigin: true,
                    requiresUserPrivacyConsent: false
                });
                
                document.getElementById('initialized').textContent = 'Sí';
                document.getElementById('initialized').className = 'font-medium text-green-600';
                addLog('OneSignal inicializado correctamente', 'SUCCESS');
                
                // Actualizar estado inicial
                await updateStatus();
                
                // Configurar listeners
                OneSignal.on('subscriptionChange', function (isSubscribed) {
                    addLog(`Cambio de suscripción: ${isSubscribed}`, 'INFO');
                    updateStatus();
                });
                
                OneSignal.on('notificationPermissionChange', function (permission) {
                    addLog(`Cambio de permisos: ${permission}`, 'INFO');
                    updateStatus();
                });
                
            } catch (error) {
                addLog(`Error inicializando OneSignal: ${error.message}`, 'ERROR');
                console.error('OneSignal init error:', error);
            }
        });
        
        // Event listeners para botones
        document.getElementById('requestPermission').addEventListener('click', async () => {
            if (!OneSignalInstance) return;
            
            try {
                addLog('Solicitando permisos...');
                await OneSignalInstance.requestPermission();
                addLog('Permisos solicitados', 'SUCCESS');
                setTimeout(updateStatus, 1000);
            } catch (error) {
                addLog(`Error solicitando permisos: ${error.message}`, 'ERROR');
            }
        });
        
        document.getElementById('showPrompt').addEventListener('click', async () => {
            if (!OneSignalInstance) return;
            
            try {
                addLog('Mostrando prompt de suscripción...');
                await OneSignalInstance.showSlidedownPrompt();
                addLog('Prompt mostrado', 'SUCCESS');
            } catch (error) {
                addLog(`Error mostrando prompt: ${error.message}`, 'ERROR');
            }
        });
        
        document.getElementById('subscribe').addEventListener('click', async () => {
            if (!OneSignalInstance) return;
            
            try {
                addLog('Intentando suscribir...');
                await OneSignalInstance.setSubscription(true);
                addLog('Suscripción activada', 'SUCCESS');
                setTimeout(updateStatus, 1000);
            } catch (error) {
                addLog(`Error suscribiendo: ${error.message}`, 'ERROR');
            }
        });
        
        document.getElementById('unsubscribe').addEventListener('click', async () => {
            if (!OneSignalInstance) return;
            
            try {
                addLog('Desuscribiendo...');
                await OneSignalInstance.setSubscription(false);
                addLog('Suscripción desactivada', 'SUCCESS');
                setTimeout(updateStatus, 1000);
            } catch (error) {
                addLog(`Error desuscribiendo: ${error.message}`, 'ERROR');
            }
        });
        
        document.getElementById('refresh').addEventListener('click', updateStatus);
    </script>
</body>
</html>
