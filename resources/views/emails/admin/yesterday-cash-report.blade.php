<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pagos en Efectivo</title>
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
        
        .report-summary {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .report-summary h2 {
            margin: 0 0 15px 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        
        .stat-card {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .report-details {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .report-details h3 {
            margin: 0 0 20px 0;
            color: #2d3748;
            font-size: 20px;
            font-weight: 600;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }
        
        .detail-value {
            color: #2d3748;
            font-size: 14px;
            font-weight: 500;
        }
        
        .attachment-info {
            background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }
        
        .attachment-info h4 {
            margin: 0 0 15px 0;
            color: #742a2a;
            font-size: 18px;
            font-weight: 600;
        }
        
        .attachment-info p {
            color: #742a2a;
            margin: 10px 0;
            font-size: 14px;
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
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .detail-row {
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
            <h1>📊 Reporte Diario</h1>
            <p>Pagos en Efectivo - {{ $date->format('d/m/Y') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Summary -->
            <div class="report-summary">
                <h2>💰 Resumen de Pagos en Efectivo</h2>
                <p>Reporte correspondiente al día {{ $date->format('l, d \d\e F \d\e Y') }}</p>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ $totalPayments }}</div>
                        <div class="stat-label">Total de Pagos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">${{ number_format($totalAmount, 2) }}</div>
                        <div class="stat-label">Monto Total</div>
                    </div>
                </div>
            </div>

            <!-- Report Details -->
            <div class="report-details">
                <h3>📋 Detalles del Reporte</h3>
                
                <div class="detail-row">
                    <span class="detail-label">📅 Fecha del Reporte:</span>
                    <span class="detail-value">{{ $date->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">🕐 Generado el:</span>
                    <span class="detail-value">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">💵 Método de Pago:</span>
                    <span class="detail-value">Solo Efectivo</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📊 Total de Transacciones:</span>
                    <span class="detail-value">{{ $totalPayments }} pagos</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">💰 Monto Total Recaudado:</span>
                    <span class="detail-value">${{ number_format($totalAmount, 2) }} MXN</span>
                </div>
            </div>

            <!-- Attachment Information -->
            <div class="attachment-info">
                <h4>📎 Archivo Adjunto</h4>
                <p><strong>📄 Reporte Completo en PDF</strong></p>
                <p>El archivo PDF adjunto contiene el detalle completo de todas las transacciones en efectivo realizadas el {{ $date->format('d/m/Y') }}.</p>
                <p><strong>Incluye:</strong> ID de maniobra, cliente, monto, referencia, fecha y hora de cada pago.</p>
            </div>

            <!-- Additional Information -->
            <div style="background-color: #ebf8ff; border: 1px solid #bee3f8; border-radius: 8px; padding: 20px; margin: 25px 0; text-align: center;">
                <p style="margin: 0; color: #2c5282; font-size: 14px;">
                    <strong>ℹ️ Información Importante</strong><br>
                    Este reporte se genera automáticamente todos los días para el control de pagos en efectivo.
                    Para consultas o aclaraciones, contacta al departamento de administración.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Acoman - Agencia Aduanal</strong></p>
            <p>© {{ date('Y') }} Todos los derechos reservados</p>
            <p>📧 Reporte generado automáticamente - No responder a este correo</p>
            <p style="font-size: 12px; margin-top: 15px; opacity: 0.8;">
                Este documento es confidencial y está destinado únicamente para uso interno.
            </p>
        </div>
    </div>
</body>
</html>