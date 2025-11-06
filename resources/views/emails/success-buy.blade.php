<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compra exitosa</title>
    <style>
        /* Estilos mínimos, compatibles con la mayoría de clientes */
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fb;
        }

        table {
            border-collapse: collapse;
        }

        .wrap {
            width: 100%;
            background: #f5f7fb;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
        }

        .p-24 {
            padding: 24px;
        }

        .header {
            background: #0b3b8e;
            color: #ffffff;
        }

        .h1 {
            margin: 0;
            font: 600 20px/1.3 Arial, Helvetica, sans-serif;
        }

        .text {
            margin: 0 0 12px 0;
            font: 14px/1.6 Arial, Helvetica, sans-serif;
            color: #0f172a;
        }

        .muted {
            color: #64748b;
            font: 12px/1.6 Arial, Helvetica, sans-serif;
        }

        .panel {
            background: #f1f5ff;
            border: 1px solid #dbeafe;
            padding: 12px;
        }

        .table {
            width: 100%;
            border: 1px solid #e5e7eb;
        }

        .table th {
            text-align: left;
            background: #f9fafb;
            padding: 10px;
            font: 600 12px Arial, Helvetica, sans-serif;
            color: #334155;
        }

        .table td {
            padding: 10px;
            font: 13px Arial, Helvetica, sans-serif;
            color: #0f172a;
            border-top: 1px solid #f1f5f9;
        }

        .num {
            text-align: right;
            white-space: nowrap;
        }

        .btn {
            display: inline-block;
            background: #0b3b8e;
            color: #ffffff;
            padding: 12px 18px;
            font: 700 14px Arial, Helvetica, sans-serif;
            text-decoration: none;
            border-radius: 4px;
        }

        .mb-16 {
            margin-bottom: 16px;
        }

        .mb-8 {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

    <table class="wrap" role="presentation" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f5f7fb">
        <tr>
            <td align="center" style="padding:16px;">
                <table class="container" role="presentation" width="100%" cellpadding="0" cellspacing="0"
                    bgcolor="#ffffff" style="max-width:600px;">
                    <tr>
                        <td class="header p-24" bgcolor="#0b3b8e">
                            <table role="presentation" width="100%">
                                <tr>
                                    <td>
                                        <h1 class="h1" style="color:#ffffff;">Kong Tienda Online</h1>
                                    </td>
                                    <td align="right" style="color:#e6efff; font:12px Arial, Helvetica, sans-serif;">
                                        N° Orden: <strong> #{{ $order['id'] }} </strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-24">
                            <p class="text"><strong>¡Compra exitosa!</strong></p>
                            <p class="text">Hola <strong>{{ $order['address']['receiver_info']['name'] }}
                                    {{ $order['address']['receiver_info']['last_name'] }}</strong>, tu pago fue
                                procesado correctamente y tu
                                orden se ha generado.</p>

                            <table class="panel mb-16" role="presentation" width="100%">
                                <tr>
                                    <td style="font:13px Arial, Helvetica, sans-serif; color:#0f172a;">
                                        N° Orden: <strong>#{{ $order['id'] }}</strong><br>
                                        Fecha:
                                        <strong>{{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}</strong><br>
                                        Estado: <strong>COMPLETADO</strong>
                                    </td>
                                </tr>
                            </table>

                            <p class="text mb-8" style="font-weight:700; color:#0b3b8e;">Datos del cliente</p>
                            <p class="text" style="margin-bottom:16px;">
                                Nombre: <strong>{{ $order['address']['receiver_info']['name'] }}
                                    {{ $order['address']['receiver_info']['last_name'] }}</strong><br>

                                @if($order['address']['receiver_info']['document_type'] == 1)
                                DNI: <strong>{{ $order['address']['receiver_info']['document_number'] }}</strong><br>
                                @else
                                CUIL: <strong>{{ $order['address']['receiver_info']['document_number'] }}</strong><br>
                                @endif

                                Email: <strong>{{ $order['user']['email'] }}</strong><br>
                                Teléfono: <strong>{{ $order['address']['receiver_info']['phone'] }}</strong><br>
                            </p>

                            <p class="text mb-8" style="font-weight:700; color:#0b3b8e;">Datos del envio</p>
                            <p class="text" style="margin-bottom:16px;">
                                Dirección: <strong>{{ $order['address']['description'] }}</strong><br>
                                Referencia: <strong>{{ $order['address']['reference'] }}</strong><br>
                                Localidad: <strong>{{ $order['address']['locality'] }}</strong><br>
                                Ciudad: <strong>{{ $order['address']['province'] }}</strong><br>
                                Código Postal: <strong>{{ $order['address']['postal_code'] }}</strong>
                            </p>

                            <p class="text mb-8" style="font-weight:700; color:#0b3b8e;">Detalle de la compra</p>
                            <table class="table" role="presentation" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="num">Precio</th>
                                        <th class="num">Cant.</th>
                                        <th class="num">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order['products'] as $product)
                                        <tr>
                                            <td>{{ $product['name'] }}</td>
                                            <td class="num"> ${{ number_format($product['price'], 2) }}</td>
                                            <td class="num">{{ $product['qty'] }}</td>
                                            <td class="num">${{ number_format($product['price'] * $product['qty'], 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table role="presentation" width="100%" style="margin-top:12px;">
                                <tr>
                                    <td align="left" style="font:700 14px Arial, Helvetica, sans-serif;">Total pagado
                                    </td>
                                    <td align="right" style="font:800 16px Arial, Helvetica, sans-serif;">
                                        ${{ number_format($order['total'], 2) }}</td>
                                </tr>
                            </table>

                            <div style="padding-top:16px;">
                                <a href="https://kong.com" class="btn">Ir a la tienda</a>
                            </div>

                            <p class="muted" style="margin-top:16px;">¿Dudas sobre tu pedido? Escribinos a <a
                                    href="mailto:soporte@kong.com">soporte@kong.com</a>.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-24" style="text-align:center; background:#ffffff;">
                            <p class="muted" style="margin:0;">© 2025 KongStore • Salta, Argentina</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>