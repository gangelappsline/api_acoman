<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Acoman</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .welcome-message {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .welcome-message h2 {
            margin: 0 0 15px 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .welcome-message p {
            margin: 0;
            font-size: 16px;
            opacity: 0.95;
        }
        
        .account-info {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .account-info h3 {
            margin: 0 0 20px 0;
            color: #2d3748;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }
        
        .info-value {
            color: #2d3748;
            font-size: 14px;
            font-weight: 500;
        }
        
        .password-info {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        
        .password-info h4 {
            margin: 0 0 15px 0;
            color: #744210;
            font-size: 18px;
            font-weight: 600;
        }
        
        .password-display {
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px dashed #d69e2e;
            border-radius: 8px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #744210;
            letter-spacing: 2px;
            margin: 15px 0;
        }
        
        .security-note {
            font-size: 13px;
            color: #744210;
            margin: 10px 0 0 0;
            opacity: 0.8;
        }
        
        .features {
            background-color: #f7fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .features h4 {
            margin: 0 0 20px 0;
            color: #2d3748;
            font-size: 18px;
            font-weight: 600;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .feature-list li {
            padding: 8px 0;
            color: #4a5568;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .feature-list li:before {
            content: "✓";
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 35px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .footer {
            background-color: #2d3748;
            color: #a0aec0;
            padding: 25px 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/logos/logo_acoman_small.jpg') }}" alt="Acoman Logo" class="logo">
            <h1>¡Bienvenido a Acoman!</h1>
            <p>Tu cuenta ha sido creada exitosamente</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Message -->
            <div class="welcome-message">
                <h2>🎉 ¡Hola {{ $client->name }}!</h2>
                <p>Nos complace tenerte como parte de la familia Acoman. Tu cuenta ya está lista para usar.</p>
            </div>

            <!-- Account Information -->
            <div class="account-info">
                <h3>📋 Información de tu Cuenta</h3>
                
                <div class="info-row">
                    <span class="info-label">👤 Nombre Completo:</span>
                    <span class="info-value">{{ $client->name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">📧 Email de Acceso:</span>
                    <span class="info-value">{{ $client->email }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">👥 Tipo de Cuenta:</span>
                    <span class="info-value">Cliente</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">💳 Crédito Disponible:</span>
                    <span class="info-value">${{ number_format($client->credit ?? 0, 2) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">✅ Estado de Validación:</span>
                    <span class="info-value">{{ $client->need_validation ? 'Requiere Validación' : 'Validado' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">📅 Fecha de Registro:</span>
                    <span class="info-value">{{ $client->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <!-- Password Information -->
            <div class="password-info">
                <h4>🔐 Tu Contraseña Temporal</h4>
                <p style="color: #744210; margin: 0 0 15px 0;">Usa esta contraseña para acceder por primera vez:</p>
                
                <div class="password-display">
                    {{ $password }}
                </div>
                
                <div class="security-note">
                    <strong>⚠️ Importante:</strong> Por tu seguridad, te recomendamos cambiar esta contraseña después de tu primer inicio de sesión.
                </div>
            </div>

            <!-- Features -->
            <div class="features">
                <h4>🚀 ¿Qué puedes hacer con tu cuenta?</h4>
                <ul class="feature-list">
                    <li>Registrar nuevas maniobras de importación/exportación</li>
                    <li>Subir documentos y comprobantes de pago</li>
                    <li>Consultar el estado de tus operaciones en tiempo real</li>
                    <li>Recibir notificaciones sobre el progreso de tus maniobras</li>
                    <li>Acceder al historial completo de tus operaciones</li>
                    <li>Gestionar tu información de cuenta y preferencias</li>
                </ul>
            </div>

            <!-- Call to Action -->
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}" class="cta-button">
                    🌐 Acceder a Mi Cuenta
                </a>
            </div>

            <!-- Additional Information -->
            <div style="background-color: #ebf8ff; border: 1px solid #bee3f8; border-radius: 8px; padding: 20px; margin: 25px 0; text-align: center;">
                <p style="margin: 0; color: #2c5282; font-size: 14px;">
                    <strong>💬 ¿Necesitas ayuda?</strong><br>
                    Nuestro equipo de soporte está disponible para asistirte en cualquier momento.
                    Contáctanos y te ayudaremos con gusto.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Acoman - Agencia Aduanal</strong></p>
            <p>© {{ date('Y') }} Todos los derechos reservados</p>
            <p>
                📞 Soporte: <a href="tel:+1234567890">+123 456 7890</a> | 
                📧 Email: <a href="mailto:soporte@acoman.com">soporte@acoman.com</a>
            </p>
            <p style="font-size: 12px; margin-top: 15px; opacity: 0.8;">
                Este es un correo automático, por favor no respondas a esta dirección.
            </p>
        </div>
    </div>
</body>
</html>