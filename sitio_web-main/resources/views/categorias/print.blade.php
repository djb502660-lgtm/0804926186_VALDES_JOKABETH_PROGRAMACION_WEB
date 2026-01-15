<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Imprimir</title>
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
        <a href="{{ route('admin.categories.index') }}">Volver</a>
    </div>

    <h1>Categorias</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Productos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->nombre }}</td>
                    <td>{{ $category->descripcion ?? '' }}</td>
                    <td>{{ $category->products_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Sin resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
