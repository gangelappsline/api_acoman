<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Operación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #274275;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .header img {
            max-width: 200px;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            color: #274275;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .data-table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        .data-table .label {
            font-weight: bold;
            color: #274275;
            width: 40%;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .highlight {
            color: #009fdb;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://acoman-api.appsline.com.mx/images/logo.png" alt="Logo">
        </div>
        
        <div class="content">
            <div class="section">
                <p>Hola,</p>
                <p>Se ha registrado una nueva operación con los siguientes detalles:</p>
            </div>
            
            <div class="section">
                <div class="section-title">Información General</div>
                <table class="data-table">
                    <tr>
                        <td class="label">Pedimento:</td>
                        <td>{{ $maneuver->pediment ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Patente:</td>
                        <td>{{ $maneuver->patent ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Contenedor:</td>
                        <td>{{ $maneuver->container ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Producto:</td>
                        <td>{{ $maneuver->product ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">País:</td>
                        <td>{{ $maneuver->country ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="section">
                <div class="section-title">Detalles de la Operación</div>
                <table class="data-table">
                    <tr>
                        <td class="label">Bultos:</td>
                        <td>{{ $maneuver->bulks ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Presentación:</td>
                        <td>{{ $maneuver->presentation ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Importador:</td>
                        <td>{{ $maneuver->importer ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Folio 200:</td>
                        <td>{{ $maneuver->folio_200 ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Folio 500:</td>
                        <td>{{ $maneuver->folio_500 ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="section">
                <div class="section-title">Información Adicional</div>
                <table class="data-table">
                    <tr>
                        <td class="label">Empresa:</td>
                        <td>{{ $maneuver->company ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Registrado por:</td>
                        <td>{{ $maneuver->created_by ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Cliente ID:</td>
                        <td>{{ $maneuver->client->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Fecha de programación:</td>
                        <td>{{ date("d/m/Y", strtotime($maneuver->programming_date)) }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="section">
                <p>Para cualquier aclaración, no dude en contactarnos.</p>
                <p>Atentamente,</p>
                <p class="highlight">El equipo de operaciones</p>
            </div>
        </div>
        
        <div class="footer">
            <p>Este es un correo automático, por favor no responda directamente a este mensaje.</p>
            <p>&copy; {{ date('Y') }} Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>