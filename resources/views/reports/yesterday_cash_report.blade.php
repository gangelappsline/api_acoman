<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Efectivo - {{ $date->format('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background-color: #f8f9fb;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background-color: white;
            padding: 30px 40px 20px 40px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            margin-right: 15px;
        }
        
        .company-info h1 {
            font-size: 22px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .company-info p {
            font-size: 14px;
            color: #6b7280;
        }
        
        .report-info {
            text-align: right;
        }
        
        .report-title {
            font-size: 18px;
            font-weight: 600;
            color: #3b82f6;
            margin-bottom: 5px;
        }
        
        .report-date {
            font-size: 14px;
            color: #6b7280;
        }
        
        .content {
            padding: 30px 40px;
        }
        
        .expand-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            text-align: center;
            line-height: 18px;
            font-size: 12px;
            margin-bottom: 20px;
            cursor: pointer;
        }
        
        .table-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 15px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
            color: #1f2937;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .id-cell {
            font-weight: 600;
            color: #3b82f6;
            text-align: center;
        }
        
        .client-cell {
            color: #1f2937;
        }
        
        .amount-cell {
            color: #059669;
            font-weight: 600;
            text-align: right;
        }
        
        .date-cell {
            color: #6b7280;
            font-size: 12px;
        }
        
        .user-cell {
            color: #6b7280;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }
        
        .no-data h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #6b7280;
        }
        
        .no-data p {
            font-size: 14px;
        }
        
        .summary-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        
        .summary-grid {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        
        .summary-item {
            flex: 1;
        }
        
        .summary-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
        }
        
        .summary-value.amount {
            color: #059669;
        }
        
        @media print {
            body { 
                margin: 0; 
                padding: 10px;
                background-color: white;
            }
            .container {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <img src="{{ public_path('images/logos/logo_acoman.jpg') }}" alt="Acoman Logo" class="logo">
                <div class="company-info">
                    <h1>ACOMAN</h1>
                    <p>Agencia Aduanal</p>
                </div>
            </div>
            <div class="report-info">
                <div class="report-title">Reporte de Efectivo</div>
                <div class="report-date">{{ $date->format('l, d \d\e F \d\e\l Y') }}</div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Summary Section -->
            @if($payments->count() > 0)
            <div class="summary-section">
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-label">Total de Pagos</div>
                        <div class="summary-value">{{ $payments->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Monto Total</div>
                        <div class="summary-value amount">${{ number_format($totalAmount, 2) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Método</div>
                        <div class="summary-value">Efectivo</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Expand Icon (like in the image) -->
            <div class="expand-icon">⊞</div>

            <!-- Table -->
            <div class="table-container">
                @if($payments->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 8%">ID</th>
                                <th style="width: 25%">Cliente</th>
                                <th style="width: 15%">Monto</th>
                                <th style="width: 20%">Fecha y Hora</th>
                                <th style="width: 17%">Registrado Por</th>
                                <th style="width: 15%">Maniobra</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td class="id-cell">{{ $payment->id }}</td>
                                <td class="client-cell">{{ $payment->maneuver->user->name ?? 'Cliente no encontrado' }}</td>
                                <td class="amount-cell">${{ number_format($payment->amount, 2) }}</td>
                                <td class="date-cell">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                <td class="user-cell">{{ $payment->user->name ?? 'Sistema' }}</td>
                                <td class="id-cell">#{{ $payment->maneuver->id ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-data">
                        <h3>No hay registros</h3>
                        <p>No se encontraron pagos en efectivo para la fecha {{ $date->format('d/m/Y') }}</p>
                    </div>
                @endif
            </div>

            <!-- Report Details -->
            @if($payments->count() > 0)
            <div style="margin-top: 30px; padding: 20px; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e5e7eb;">
                <h4 style="color: #374151; margin-bottom: 15px; font-size: 14px; font-weight: 600;">Detalles del Reporte:</h4>
                <div style="display: flex; justify-content: space-between; font-size: 12px; color: #6b7280;">
                    <div>
                        <strong>Período:</strong> {{ $date->format('d/m/Y') }}<br>
                        <strong>Tipo:</strong> Solo pagos en efectivo<br>
                        <strong>Estado:</strong> Todos los estados incluidos
                    </div>
                    <div style="text-align: right;">
                        <strong>Generado:</strong> {{ now()->format('d/m/Y H:i') }}<br>
                        <strong>Ordenamiento:</strong> Por fecha de creación<br>
                        <strong>Moneda:</strong> Pesos mexicanos (MXN)
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>