<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Venta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .ticket {
            width: 700px;
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
            border: 1px solid #000000;
            padding: 5px;
            text-align: left;
            font-size: 0.8rem;
        }

        th {
            background-color: #d6cfcf;
        }
    </style>
</head>
<body>

<div class="ticket">
    <div class="header">
        REPORTE Nº {{$reporte->id}}
    </div>
    <div class="informacion">
        <strong>Reporte : {{$reporte->titulo}}</strong> <br>
        Empresa: {{$empresa->razon_social}} <br>
        Direccion: {{$empresa->direccion}} <br>
        RUC: {{$empresa->ruc}} <br>
        Telefono: {{$empresa->telefono}} <br>
    </div>
    <div class="info">
        <div><strong>Fechas:</strong> del {{$data['fechaInicio']}} al {{$data['fechaFin']}}</div>
        <div><strong>Fecha Emisión del Reporte:</strong> {{\Carbon\Carbon::parse($reporte->fecha_emision)->format('d/m/Y')}}</div>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th>nro Venta</th>
                <th>nro Boleta</th>
                <th>Cliente</th>
                <th>fecha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>
                        {{ $venta->ventaID}}
                    </td>
                    <td>
                        {{ $venta->nro_boleta }}
                    </td>
                    <td>
                        {{ $venta->cliente->full_name }}
                    </td>
                    <td>
                        {{-- {{ $venta->fecha_emision }} --}}
                        {{ \Carbon\Carbon::parse($venta->fecha_emision)->format('d-m-Y') }}
                    </td>
                    <td>
                        S/. {{ $venta->total }}
                    </td>
                </tr>
            @endforeach>
        </tbody>
    </table>
    <br>
    <div class="total">
        Total Recaudado: S/. {{$data['totalRecaudado']}}
    </div>
</div>
</body>
</html>
