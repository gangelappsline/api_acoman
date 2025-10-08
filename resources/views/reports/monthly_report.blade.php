<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Mensual de Maniobras - {{ $month }}</title>
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
            max-width: 900px;
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
        
        .summary-value.count {
            color: #dc2626;
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
        
        .service-group {
            margin-bottom: 30px;
        }
        
        .service-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 6px 6px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .service-name {
            font-size: 16px;
            font-weight: 600;
        }
        
        .service-stats {
            display: flex;
            gap: 20px;
            font-size: 14px;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .table-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 6px 6px;
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
            font-weight: 500;
        }
        
        .status-cell {
            text-align: center;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-in-progress {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .date-cell {
            color: #6b7280;
            font-size: 12px;
        }
        
        .amount-cell {
            color: #059669;
            font-weight: 600;
            text-align: right;
        }
        
        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }
        
        .no-data h3 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #6b7280;
        }
        
        .totals-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        
        .totals-row td {
            border-top: 2px solid #d1d5db;
            color: #374151;
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
            .service-group {
                page-break-inside: avoid;
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
            </div>
            <div class="report-info">
                <div class="report-title">Reporte Mensual de Maniobras</div>
                <div class="report-date">{{ $month }}</div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @php
                // Agrupar maniobras por servicio
                $groupedManeuvers = $maneuvers->groupBy('service.name');
                $totalManeuvers = $maneuvers->count();
                $totalServices = $groupedManeuvers->count();
                $totalAmount = $maneuvers->sum('total_amount');
            @endphp

            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-label">Total Maniobras</div>
                        <div class="summary-value count">{{ $totalManeuvers }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Servicios Activos</div>
                        <div class="summary-value">{{ $totalServices }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Valor Total</div>
                        <div class="summary-value amount">${{ number_format($totalAmount, 2) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Promedio por Maniobra</div>
                        <div class="summary-value">${{ $totalManeuvers > 0 ? number_format($totalAmount / $totalManeuvers, 2) : '0.00' }}</div>
                    </div>
                </div>

            @if($totalManeuvers > 0)
                @foreach($groupedManeuvers as $serviceName => $serviceManeuvers)
                    @php
                        $serviceTotal = $serviceManeuvers->sum('total');
                        $serviceCount = $serviceManeuvers->count();
                        $statusCounts = $serviceManeuvers->groupBy('status')->map->count();
                    @endphp
                    
                    <div class="service-group">
                        <!-- Service Header -->
                        <div class="service-header">
                            <div class="service-name">
                                📋 {{ $serviceName ?: 'Sin Servicio Asignado' }}
                            </div>
                            <div class="service-stats">
                                <div class="stat-item">
                                    <span>📊</span>
                                    <span>{{ $serviceCount }} maniobras</span>
                                </div>
                                <div class="stat-item">
                                    <span>💰</span>
                                    <span>${{ number_format($serviceTotal, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Service Table -->
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 8%">ID</th>
                                        <th style="width: 25%">Cliente</th>
                                        <th style="width: 15%">Pedimento</th>
                                        <th style="width: 12%">Estado</th>
                                        <th style="width: 15%">Fecha Programada</th>
                                        <th style="width: 15%">Monto Total</th>
                                        <th style="width: 10%">Contenedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviceManeuvers as $maneuver)
                                    <tr>
                                        <td class="id-cell">{{ $maneuver->id }}</td>
                                        <td class="client-cell">{{ $maneuver->client->name ?? 'Cliente no encontrado' }}</td>
                                        <td>{{ $maneuver->pedimento ?: 'Sin pedimento' }}</td>
                                        <td class="status-cell">
                                            @php
                                                $statusClass = match($maneuver->status) {
                                                    'pendiente' => 'status-pending',
                                                    'en_proceso', 'en proceso' => 'status-in-progress',
                                                    'completada', 'completado' => 'status-completed',
                                                    'cancelada', 'cancelado' => 'status-cancelled',
                                                    default => 'status-pending'
                                                };
                                            @endphp
                                            <span>
                                                {{ ucfirst($maneuver->status ?: 'Pendiente') }}
                                            </span>
                                        </td>
                                        <td class="date-cell">
                                            {{ $maneuver->programming_date ? \Carbon\Carbon::parse($maneuver->programming_date)->format('d/m/Y') : 'Sin fecha' }}
                                        </td>
                                        <td class="amount-cell">
                                            ${{ number_format($maneuver->total ?? 0, 2) }}
                                        </td>
                                        <td>{{ $maneuver->container ?: '-' }}</td>
                                    </tr>
                                    @endforeach
                                    
                                    <!-- Totals Row for Service -->
                                    <tr class="totals-row">
                                        <td colspan="5" style="text-align: right; padding-right: 20px;">
                                            <strong>Total {{ $serviceName ?: 'Sin Servicio' }}:</strong>
                                        </td>
                                        <td class="amount-cell">
                                            <strong>${{ number_format($serviceTotal, 2) }}</strong>
                                        </td>
                                        <td style="text-align: center;">
                                            <strong>{{ $serviceCount }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                <!-- Grand Total Section -->
                <div style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 6px; color: white;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="font-size: 18px; margin-bottom: 5px;">📊 Resumen General del Mes</h3>
                            <p style="opacity: 0.9; font-size: 14px;">{{ $month }}</p>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 24px; font-weight: bold; margin-bottom: 5px;">
                                ${{ number_format($totalAmount, 2) }}
                            </div>
                            <div style="font-size: 14px; opacity: 0.9;">
                                {{ $totalManeuvers }} maniobras en {{ $totalServices }} servicios
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="no-data">
                    <h3>No hay maniobras registradas</h3>
                    <p>No se encontraron maniobras para el mes de {{ $month }}</p>
                </div>
            @endif

            <!-- Report Details -->
            @if($totalManeuvers > 0)
            <div style="margin-top: 30px; padding: 20px; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e5e7eb;">
                <h4 style="color: #374151; margin-bottom: 15px; font-size: 14px; font-weight: 600;">Detalles del Reporte:</h4>
                <div style="display: flex; justify-content: space-between; font-size: 12px; color: #6b7280;">
                    <div>
                        <strong>Período:</strong> {{ $month }}<br>
                        <strong>Agrupación:</strong> Por tipo de servicio<br>
                        <strong>Estados incluidos:</strong> Todos los estados<br>
                        <strong>Ordenamiento:</strong> Por servicio y fecha
                    </div>
                    <div style="text-align: right;">
                        <strong>Generado:</strong> {{ now()->format('d/m/Y H:i') }}<br>
                        <strong>Servicios activos:</strong> {{ $totalServices }}<br>
                        <strong>Moneda:</strong> Pesos mexicanos (MXN)<br>
                        <strong>Promedio por servicio:</strong> ${{ $totalServices > 0 ? number_format($totalAmount / $totalServices, 2) : '0.00' }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>