<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneSignal Test - Acoman</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }

        button:hover {
            background: #0056b3;
        }

        #log {
            background: #000;
            color: #0f0;
            padding: 10px;
            height: 200px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>OneSignal - Test de Integración</h1>

        <div class="info">
            <strong>App ID:</strong> {{ env('ONESIGNAL_APP_ID') }}<br>
            <strong>Dominio:</strong> {{ request()->getSchemeAndHttpHost() }}
        </div>

        <div>
            <button onclick="testServiceWorker()">⚙️ Test Service Worker</button>
            <button onclick="manualInit()">🔄 Re-inicializar</button>
            <button onclick="testPermission()">🔔 Solicitar Permisos</button>
            <button onclick="testSubscription()">✅ Verificar Suscripción</button>
            <button onclick="sendTestNotification()">📤 Enviar Prueba</button>
            <button onclick="testBrowserCompatibility()">🌐 Test Compatibilidad</button>
            <button onclick="clearLog()">🗑️ Limpiar Log</button>
        </div>

        <h3>Estado del Sistema:</h3>
        <div id="status" class="status info">Inicializando...</div>

        <h3>Log de Eventos:</h3>
        <div id="log">Iniciando OneSignal...<br></div>
    </div>

    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js"></script>
    <script>
        let isInitialized = false;
        
        function log(message, type = 'info') {
            const logEl = document.getElementById('log');
            const time = new Date().toLocaleTimeString();
            const color = type === 'error' ? '#f00' : type === 'success' ? '#0f0' : '#ff0';
            logEl.innerHTML += `<span style="color: ${color}">[${time}] ${message}</span><br>`;
            logEl.scrollTop = logEl.scrollHeight;
            console.log(`[OneSignal ${type}]`, message);
        }
        
        function updateStatus(message, type = 'info') {
            const statusEl = document.getElementById('status');
            statusEl.textContent = message;
            statusEl.className = `status ${type}`;
        }

        // Inicialización completa de OneSignal
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            try {
                log('Inicializando OneSignal...');
                log(`App ID: {{ env('ONESIGNAL_APP_ID') }}`);
                log(`Dominio: ${location.origin}`);
                
                // Verificar Service Worker antes de inicializar
                if (!('serviceWorker' in navigator)) {
                    throw new Error('Service Workers no están soportados en este navegador');
                }
                
                log('Service Worker soportado, continuando...');
                
                // Configuración simplificada de OneSignal
                await OneSignal.init({
                    appId: "{{ env('ONESIGNAL_APP_ID') }}",
                    allowLocalhostAsSecureOrigin: true
                });

                // Marcar como inicializado
                isInitialized = true;
                log('✅ OneSignal inicializado correctamente', 'success');
                updateStatus('✅ OneSignal inicializado - Listo para usar', 'success');

                // Verificar estado inicial
                const permission = await OneSignal.getNotificationPermission();
                const isEnabled = await OneSignal.isPushNotificationsEnabled();
                const userId = await OneSignal.getUserId();

                log(`Estado inicial:`);
                log(`- Permisos: ${permission}`);
                log(`- Push habilitado: ${isEnabled}`);
                log(`- User ID: ${userId || 'No disponible'}`);

                // Event listeners
                OneSignal.on('subscriptionChange', function(isSubscribed) {
                    log(`Cambio de suscripción: ${isSubscribed ? 'Suscrito' : 'No suscrito'}`, 
                        isSubscribed ? 'success' : 'info');
                });

                OneSignal.on('notificationPermissionChange', function(permissionChange) {
                    log(`Cambio de permisos: ${permissionChange.to}`, 
                        permissionChange.to === 'granted' ? 'success' : 'error');
                });

            } catch (error) {
                log(`❌ Error inicializando OneSignal: ${error.message}`, 'error');
                updateStatus('❌ Error en la inicialización', 'error');
                console.error('OneSignal init error:', error);
                
                // Información adicional de debug
                log(`Stack trace: ${error.stack}`, 'error');
                if (error.name) log(`Error type: ${error.name}`, 'error');
            }
        });
        
        function testPermission() {
            if (!isInitialized) {
                log('⚠️ Esperando inicialización de OneSignal...', 'error');
                setTimeout(testPermission, 1000); // Reintentar en 1 segundo
                return;
            }
            
            log('Solicitando permisos de notificación...');
            
            OneSignalDeferred.push(async function(OneSignal) {
                try {
                    const permission = await OneSignal.requestPermission();
                    if (permission) {
                        log('✅ Permisos concedidos', 'success');
                        updateStatus('✅ Permisos concedidos - Listo para notificaciones', 'success');
                        
                        // Verificar suscripción después de conceder permisos
                        const isSubscribed = await OneSignal.isPushNotificationsEnabled();
                        const userId = await OneSignal.getUserId();
                        
                        log(`Después del permiso:`);
                        log(`- Suscrito: ${isSubscribed}`);
                        log(`- User ID: ${userId || 'Generando...'}`);
                        
                    } else {
                        log('❌ Permisos denegados', 'error');
                        updateStatus('❌ Permisos denegados', 'error');
                    }
                } catch (error) {
                    log(`❌ Error solicitando permisos: ${error.message}`, 'error');
                    updateStatus('❌ Error en permisos', 'error');
                }
            });
        }
        
        function testSubscription() {
            if (!isInitialized) {
                log('⚠️ Esperando inicialización de OneSignal...', 'error');
                setTimeout(testSubscription, 1000); // Reintentar en 1 segundo
                return;
            }
            
            log('Verificando estado de suscripción...');
            
            OneSignalDeferred.push(async function(OneSignal) {
                try {
                    const permission = await OneSignal.getNotificationPermission();
                    const isEnabled = await OneSignal.isPushNotificationsEnabled();
                    const userId = await OneSignal.getUserId();
                    const externalUserId = await OneSignal.getExternalUserId();
                    
                    log(`Estado detallado:`);
                    log(`- Permisos: ${permission}`);
                    log(`- Push habilitado: ${isEnabled}`);
                    log(`- User ID: ${userId || 'No disponible'}`);
                    log(`- External User ID: ${externalUserId || 'No configurado'}`);
                    
                    if (permission === 'granted' && isEnabled && userId) {
                        updateStatus('✅ Completamente configurado y suscrito', 'success');
                        log('✅ Todo está funcionando correctamente', 'success');
                    } else if (permission === 'denied') {
                        updateStatus('❌ Permisos denegados por el usuario', 'error');
                        log('❌ Los permisos fueron denegados', 'error');
                    } else if (permission === 'default') {
                        updateStatus('⚠️ Permisos no solicitados aún', 'info');
                        log('⚠️ Necesitas solicitar permisos primero', 'info');
                    } else {
                        updateStatus('⚠️ Configuración incompleta', 'error');
                        log('⚠️ La suscripción no está completa', 'error');
                    }
                    
                } catch (error) {
                    log(`❌ Error verificando suscripción: ${error.message}`, 'error');
                    updateStatus('❌ Error verificando estado', 'error');
                }
            });
        }
        
        function sendTestNotification() {
            log('Enviando notificación de prueba...');
            
            fetch('{{ route("notifications.test") ?? "/api/test-notification" }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    title: 'Prueba desde Acoman',
                    message: 'Esta es una notificación de prueba del sistema Acoman'
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    log('✅ Notificación enviada correctamente', 'success');
                } else {
                    log(`❌ Error enviando: ${data.message}`, 'error');
                }
            }).catch(error => {
                log(`❌ Error de red: ${error.message}`, 'error');
            });
        }
        
        function testServiceWorker() {
            log('⚙️ Probando Service Workers manualmente...');
            
            if (!('serviceWorker' in navigator)) {
                log('❌ Service Workers no soportados', 'error');
                return;
            }
            
            log('✅ Service Worker API disponible', 'success');
            
            // Verificar workers existentes
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
                log(`Registraciones actuales: ${registrations.length}`);
                
                registrations.forEach((registration, index) => {
                    log(`SW ${index + 1}: ${registration.scope}`, 'info');
                    log(`- Estado: ${registration.active ? 'Activo' : 'Inactivo'}`, 'info');
                });
                
                // Probar registro manual de OneSignal
                log('Probando registro de OneSignal Worker...');
                
                // Primero verificar que los archivos existan
                Promise.all([
                    fetch('/OneSignalSDKWorker.js').then(r => r.ok),
                    fetch('/OneSignalSDKUpdaterWorker.js').then(r => r.ok)
                ]).then(function([worker1, worker2]) {
                    log(`Worker principal existe: ${worker1 ? '✅' : '❌'}`, worker1 ? 'success' : 'error');
                    log(`Worker updater existe: ${worker2 ? '✅' : '❌'}`, worker2 ? 'success' : 'error');
                    
                    if (!worker1 || !worker2) {
                        log('❌ Archivos de Service Worker no encontrados', 'error');
                        updateStatus('❌ Archivos SW no encontrados', 'error');
                        return;
                    }
                    
                    // Si los archivos existen, intentar registro
                    return navigator.serviceWorker.register('/OneSignalSDKWorker.js', {
                        scope: '/'
                    });
                })
                .then(function(registration) {
                    if (registration) {
                        log('✅ OneSignal Worker registrado correctamente', 'success');
                        log(`Scope: ${registration.scope}`, 'success');
                        updateStatus('✅ Service Worker funcionando', 'success');
                    }
                })
                .catch(function(error) {
                    log(`❌ Error en el proceso: ${error.message}`, 'error');
                    log(`Detalles: ${error.stack}`, 'error');
                    updateStatus('❌ Error en Service Worker', 'error');
                });
                
            }).catch(function(error) {
                log(`❌ Error obteniendo registraciones: ${error.message}`, 'error');
            });
        }

        function clearLog() {
            document.getElementById('log').innerHTML = '';
        }

        function manualInit() {
            log('🔄 Reinicializando OneSignal manualmente...');
            isInitialized = false;
            updateStatus('🔄 Reinicializando...', 'info');
            
            // Force reload del SDK
            location.reload();
        }

        function testBrowserCompatibility() {
            log('🌐 Verificando compatibilidad del navegador...');
            
            const checks = {
                'Service Worker': 'serviceWorker' in navigator,
                'Push API': 'PushManager' in window,
                'Notifications API': 'Notification' in window,
                'HTTPS': location.protocol === 'https:' || location.hostname === 'localhost',
                'Promises': typeof Promise !== 'undefined',
                'Fetch': typeof fetch !== 'undefined'
            };
            
            let allPassed = true;
            
            log('Resultados de compatibilidad:');
            for (const [feature, supported] of Object.entries(checks)) {
                const status = supported ? '✅' : '❌';
                const color = supported ? 'success' : 'error';
                log(`${status} ${feature}: ${supported ? 'Soportado' : 'No soportado'}`, color);
                
                if (!supported) allPassed = false;
            }
            
            if (allPassed) {
                log('🎉 Navegador completamente compatible con OneSignal', 'success');
                updateStatus('✅ Navegador compatible', 'success');
            } else {
                log('⚠️ Algunas características no están soportadas', 'error');
                updateStatus('⚠️ Compatibilidad limitada', 'error');
            }
            
            // Información adicional
            log(`Navegador: ${navigator.userAgent}`);
            log(`URL actual: ${location.href}`);
        }
    </script>
</body>

</html>