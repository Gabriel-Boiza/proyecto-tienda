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
            <p>Número de Pedido: 1</p>
        </div>
        <div>
            <h3>Datos de Envío</h3>
            <p>Dirección Falsa 123</p>
            <p>Ciudad, 08001</p>
            <p>España</p>
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
                <tr>
                    <td>Ratón Logitech G Pro</td>
                    <td>Ratón gaming profesional con sensor HERO</td>
                    <td>89.99 €</td>
                </tr>
                <tr>
                    <td>Teclado mecánico Corsair K95</td>
                    <td>Teclado mecánico con retroiluminación RGB</td>
                    <td>149.99 €</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="invoice-total">
        <p>Total: 150.75 €</p>
        <p>Estado del Pedido: Cancelado</p>
    </div>
</body>
</html>