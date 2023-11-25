<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Factura</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .ticket {
            width: 600px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .informacion{
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .header {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .total {
            margin-top: 10px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="ticket">
    <div class="header">
        COMPROBANTE Nº {{$venta->id}}
    </div>
    <div class="informacion">
        <strong>Nº Boleta : {{$venta->nro_boleta}}</strong> <br>
        Empresa: {{$empresa->razon_social}} <br>
        Direccion: {{$empresa->direccion}} <br>
        RUC: {{$empresa->ruc}} <br>
        Telefono: {{$empresa->telefono}} <br>
    </div>
    <div class="info">
        <div><strong>Fecha:</strong> {{$data['fechaEmision']}}</div>
        <div><strong>Cliente:</strong> {{$venta->cliente->full_name}}</div>
        <div><strong>DNI:</strong> {{$venta->cliente->dni}}</div>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>
                        @if($item->tipo_item == 'PRODUCTO')
                            {{ $item->producto->nombre_producto }}
                        @else
                            {{ $item->servicio->nombre_servicio }}
                        @endif
                    </td>
                    <td>
                        {{ $item->tipo_item }}
                    </td>
                    <td>
                        {{ $item->cantidad }}
                    </td>
                    <td>
                        S/. {{ $item->precio }}
                    </td>
                    <td>
                        S/. {{ $item->total }}
                    </td>
                </tr>
            @endforeach>
        </tbody>
    </table>
    <br>
    <div class="total">
        Total a pagar: S/. {{$venta->total}}
    </div>
</div>
</body>
</html>

