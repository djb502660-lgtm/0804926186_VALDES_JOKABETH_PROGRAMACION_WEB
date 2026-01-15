<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Imprimir</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; margin: 20px; }
        h1 { font-size: 20px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { background: #f8fafc; }
        .no-print { margin-bottom: 12px; }
        .no-print a, .no-print button { margin-right: 8px; }
        @media print { .no-print { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button type="button" onclick="window.print()">Imprimir</button>
        <a href="{{ route('products.index') }}">Volver</a>
    </div>

    <h1>Productos</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->nombre }}</td>
                    <td>{{ $product->category->nombre ?? 'N/A' }}</td>
                    <td>${{ number_format($product->precio, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->estado }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Sin resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
