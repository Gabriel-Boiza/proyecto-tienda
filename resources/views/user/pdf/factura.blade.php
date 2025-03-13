<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .invoice-details {
            margin: 20px 0;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .invoice-total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div>
            <h1>Factura</h1>
            <p>Número de Pedido: {{$pedido->id}}</p>
        </div>
        <div>
            <h3>Datos de Envío</h3>
            <p>{{$pedido->cliente->nombre}}</p>
            <p>{{$pedido->cliente->ciudad}}, {{$pedido->cliente->codigo_postal}}</p>
            <p>{{$pedido->cliente->pais}}</p>
        </div>
    </div>

    <div class="invoice-details">
        <table class="invoice-items">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{$producto->nombre}}</td>
                        <td>{{$producto->descripcion}}</td>
                        <td>{{$producto->precio}}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="invoice-total">
        <p>Total: {{$pedido->total}} €</p>
        <p>Estado del Pedido: {{$pedido->estado}}</p>
    </div>
</body>
</html>