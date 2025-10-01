<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pago Registrado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .logo img {
            width: 60px;
            height: auto;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .alert-box {
            background: #d1fae5;
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            text-align: center;
        }
        
        .alert-box .icon {
            font-size: 24px;
            color: #059669;
            margin-bottom: 8px;
        }
        
        .alert-box h3 {
            color: #047857;
            font-size: 18px;
            font-weight: 600;
        }
        
        .payment-info {
            background: #f0fdf4;
            border-radius: 8px;
            padding: 24px;
            margin: 20px 0;
        }
        
        .amount-section {
            background: #fefce8;
            border: 2px solid #facc15;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        
        .amount-label {
            font-size: 14px;
            color: #92400e;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .amount-value {
            font-size: 32px;
            color: #92400e;
            font-weight: bold;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-item {
            background: white;
            padding: 16px;
            border-radius: 8px;
            border-left: 4px solid #059669;
        }
        
        .info-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 15px;
            color: #1f2937;
            font-weight: 500;
        }
        
        .client-section {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .client-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .client-icon {
            width: 40px;
            height: 40px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 18px;
        }
        
        .client-name {
            font-size: 18px;
            font-weight: 600;
            color: #1e40af;
        }
        
        .client-email {
            font-size: 14px;
            color: #6b7280;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #d1fae5;
            color: #047857;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .maneuver-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .action-section {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            background: #059669;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 12px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background: #047857;
        }
        
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 20px 0;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                padding: 20px;
            }
            
            .content {
                padding: 20px;
            }
            
            .amount-value {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/logos/logo_acoman_small.jpg') }}" alt="Acoman Logo">
            </div>
            <h1>Nuevo Pago Registrado</h1>
            <p>Se ha registrado un nuevo pago para una maniobra</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Alert -->
            <div class="alert-box">
                <div class="icon">💰</div>
                <h3>Pago para Maniobra #{{ $payment->maneuver_id }}</h3>
            </div>

            <!-- Amount Section -->
            <div class="amount-section">
                <div class="amount-label">Monto del Pago</div>
                <div class="amount-value">${{ number_format($payment->amount, 2) }}</div>
            </div>

            <!-- Client Information -->
            <div class="client-section">
                <div class="client-header">
                    <div class="client-icon">👤</div>
                    <div>
                        <div class="client-name">{{ $payment->maneuver->client->name }}</div>
                        <div class="client-email">{{ $payment->maneuver->client->email }}</div>
                    </div>
                </div>
                <span class="status-badge">Cliente</span>
            </div>

            <!-- Payment Details -->
            <div class="payment-info">
                <h3 style="color: #1f2937; margin-bottom: 16px; font-size: 18px;">💳 Detalles del Pago</h3>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">ID del Pago</div>
                        <div class="info-value">#{{ $payment->id }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Monto</div>
                        <div class="info-value">${{ number_format($payment->amount, 2) }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Referencia</div>
                        <div class="info-value">{{ $payment->reference }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Método de Pago</div>
                        <div class="info-value">{{ ucfirst($payment->payment_method) }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Estado</div>
                        <div class="info-value">{{ $payment->status ?? 'Pendiente' }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Fecha de Pago</div>
                        <div class="info-value">{{ $payment->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>

                @if($payment->payment_file)
                <div style="margin-top: 16px; padding: 12px; background: #e0f2fe; border-radius: 6px;">
                    <div class="info-label">Comprobante</div>
                    <div class="info-value">📎 Archivo adjunto disponible</div>
                </div>
                @endif
            </div>

            <!-- Maneuver Details -->
            <div class="maneuver-section">
                <h3 style="color: #1f2937; margin-bottom: 16px; font-size: 18px;">🚚 Información de la Maniobra</h3>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">ID Maniobra</div>
                        <div class="info-value">#{{ $payment->maneuver->id }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Pedimento</div>
                        <div class="info-value">{{ $payment->maneuver->pediment }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Patente</div>
                        <div class="info-value">{{ $payment->maneuver->patent }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Contenedor</div>
                        <div class="info-value">{{ $payment->maneuver->container }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Empresa</div>
                        <div class="info-value">{{ $payment->maneuver->company }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Fecha de Programación</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($payment->maneuver->programming_date)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Action Section -->
            <div class="action-section">
                <h3 style="color: #92400e; margin-bottom: 8px;">⚠️ Acción Requerida</h3>
                <p style="color: #4b5563; margin-bottom: 12px;">
                    Revisa y valida el pago registrado. Confirma que los datos sean correctos y procede con la verificación contable.
                </p>
                <a href="{{ config('app.url') }}/administrador/maniobras/{{ $payment->maneuver->id }}" class="btn">
                    Ver Pago en el Sistema
                </a>
            </div>

            <!-- Additional Info -->
            <div style="background: #fafafa; padding: 16px; border-radius: 8px; margin-top: 20px;">
                <p style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">
                    <strong>Fecha de registro:</strong> {{ $payment->created_at->format('d/m/Y H:i:s') }}
                </p>
                <p style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">
                    <strong>Registrado por:</strong> {{ $payment->creator->name ?? 'Sistema' }}
                </p>
                <p style="font-size: 13px; color: #6b7280;">
                    <strong>ID del pago:</strong> #{{ $payment->id }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Sistema de Gestión Acoman</strong></p>
            <p>Esta es una notificación automática del sistema. No responder a este correo.</p>
            <p style="margin-top: 12px; font-size: 11px; color: #9ca3af;">
                © {{ date('Y') }} Acoman. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>