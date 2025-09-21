<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneSignal Minimal Test</title>
</head>
<body>
    <h1>OneSignal Minimal Test</h1>
    <div id="status">Inicializando...</div>
    <div id="log" style="background: black; color: green; padding: 10px; height: 300px; overflow-y: auto;"></div>
    
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js"></script>
    <script>
        function log(msg) {
            const logDiv = document.getElementById('log');
            const time = new Date().toLocaleTimeString();
            logDiv.innerHTML += `[${time}] ${msg}<br>`;
            logDiv.scrollTop = logDiv.scrollHeight;
            console.log(msg);
        }
        
        function updateStatus(msg) {
            document.getElementById('status').textContent = msg;
        }
        
        log('Iniciando test minimal...');
        
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            try {
                log('OneSignal SDK cargado');
                updateStatus('SDK cargado, inicializando...');
                
                // Configuración mínima
                await OneSignal.init({
                    appId: "{{ env('ONESIGNAL_APP_ID') }}"
                });
                
                log('✅ OneSignal inicializado correctamente');
                updateStatus('✅ Inicializado correctamente');
                
                // Verificar estado
                const permission = await OneSignal.getNotificationPermission();
                log(`Permisos: ${permission}`);
                
            } catch (error) {
                log(`❌ Error: ${error.message}`);
                log(`Stack: ${error.stack}`);
                updateStatus('❌ Error en inicialización');
            }
        });
    </script>
</body>
</html>
