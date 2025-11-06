<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Orden</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 100%;
            /* max-width: 400px; Ancho para un formato de recibo */
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        header {
            text-align: center;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        h1 {
            color: #333;
            font-size: 18px;
            margin: 0;
        }
        .info-section {
            font-size: 14px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ccc;
        }
        .info-section p {
            margin: 5px 0;
        }
        .info-section p.no-border {
            border-bottom: none;
        }
        .info-section span {
            font-weight: bold;
            color: #555;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th, .items-table td {
            border-bottom: 1px dashed #ccc;
            padding: 8px 0;
            text-align: left;
            font-size: 13px;
        }
        .items-table th {
            font-weight: bold;
            color: #333;
        }
        .items-table td:nth-child(2),
        .items-table td:last-child {
            text-align: right;
        }
        .total-summary {
            text-align: right;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }
        .total-summary p {
            font-size: 14px;
            margin: 5px 0;
        }
        .total-summary p span {
            font-weight: bold;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            color: #777;
            font-size: 11px;
        }
    </style>
    
</head>
<body>

<div class="container">
    <header>
        <h1>Factura de Compra</h1>
    </header>


    <div class="info-section">
        <p><span>Numero de Orden:</span> #{{ $order['id'] }}</p>
        <p class="no-border">
    <span>Fecha:</span> {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}
</p>
    </div>

    <div class="info-section">
        <h3>Datos de la empresa</h3>
        <p><span>Nombre: Tienda Kong</span></p>
        <p><span>Correo: tiendakong@gmail.com</span></p>
        <p><span>Teléfono: 3874232208</span></p>
    </div>

    <div class="info-section">
        <h3>Datos del Cliente</h3>
        <p><span>Nombre:</span> {{ $order['address']['receiver_info']['name'] }}</p>
        <p><span>Apellido:</span> {{ $order['address']['receiver_info']['last_name'] }}</p>
        <p><span>{{ $order['address']['receiver_info']['document_type'] }}:</span> {{ $order['address']['receiver_info']['document_number'] }}</p>
        <p><span>Telefono:</span> {{ $order['address']['receiver_info']['phone'] }}</p>


    </div>

    <div class="info-section">
        <h3>Datos de Envío</h3>
        <p><span>Dirección:</span> {{ $order['address']['description'] }}</p>
        <p><span>Referencia:</span> {{ $order['address']['reference'] }}</p>
        <p><span>Localidad:</span> {{ $order['address']['locality'] }}</p>
        <p><span>Ciudad:</span> {{ $order['address']['province'] }}</p>
        <p><span>Código Postal:</span> {{ $order['address']['postal_code'] }}</p>
    </div>

    <table class="items-table gap-3">
        <thead>
            <tr>
                <th>Producto</th>
                <th style="text-align: right;">Cant.</th>
                <th style="text-align: right;">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order['products'] as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['qty'] }} x </td>
                <td> ${{ number_format($product['price'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-summary">
        <p>Total: <span>${{ number_format($order['total'], 2) }}</span></p>
    </div>

    <footer>
        <p>¡Gracias por tu compra!</p>
        <p>Visítanos en: [www.kong.com]</p>
    </footer>
</div>

</body>
</html>