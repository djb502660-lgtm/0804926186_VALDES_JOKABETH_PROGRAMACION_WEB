@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4">Productos</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('products.export') }}" class="btn btn-light border btn-lg me-2">
                <i class="bi bi-file-earmark-spreadsheet"></i> Exportar CSV
            </a>
            <a href="{{ route('products.print') }}" class="btn btn-light border btn-lg me-2" target="_blank">
                <i class="bi bi-printer"></i> Imprimir
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Nuevo Producto
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <strong>Â¡Ã‰xito!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> <strong>¡Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-3">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-center mb-3">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagen de {{ $product->nombre }}" style="width: 96px; height: 96px; object-fit: cover; border-radius: 10px; border: 1px solid #fecaca;">
                            @else
                                <div style="width: 96px; height: 96px; border-radius: 10px; border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; color: #dc2626;">
                                    <i class="bi bi-image" style="font-size: 28px;"></i>
                                </div>
                            @endif
                        </div>

                        <div class="fw-semibold">{{ $product->nombre }}</div>
                        <div class="text-muted small mb-2">{{ $product->category->nombre ?? 'N/A' }}</div>

                        <div class="small mb-2">Precio: ${{ number_format($product->precio, 2) }}</div>
                        <div class="d-flex gap-2 mb-3">
                            @if($product->stock > 5)
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-danger">Agotado</span>
                            @endif

                            @if($product->estado === 'activo')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </div>

                        <div class="mt-auto d-flex gap-1">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" 
                                    onclick="return confirm('¨Est s seguro de eliminar este producto?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                No hay productos registrados
            </div>
        @endforelse
    </div>

    <div class="card shadow-sm d-none">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td style="width: 70px;">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagen de {{ $product->nombre }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid #fecaca;">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 8px; border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; color: #dc2626;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $product->nombre }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ $product->category->nombre ?? 'N/A' }}</span>
                            </td>
                            <td>${{ number_format($product->precio, 2) }}</td>
                            <td>
                                @if($product->stock > 5)
                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Agotado</span>
                                @endif
                            </td>
                            <td>
                                @if($product->estado === 'activo')
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" 
                                        onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay productos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection



