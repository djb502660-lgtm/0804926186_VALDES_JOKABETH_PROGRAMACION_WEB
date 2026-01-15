@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Volver
            </a>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="mb-3">
                                <i class="bi bi-tags"></i> {{ $category->nombre }}
                            </h1>

                            @if($category->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $category->image_path) }}" alt="Imagen de la categoría" class="img-fluid rounded border" style="max-width: 240px;">
                                </div>
                            @endif
                            
                            <dl class="row">
                                <dt class="col-sm-4">Nombre:</dt>
                                <dd class="col-sm-8">
                                    <strong>{{ $category->nombre }}</strong>
                                </dd>

                                <dt class="col-sm-4">Descripción:</dt>
                                <dd class="col-sm-8">
                                    {{ $category->descripcion ?? 'Sin descripción' }}
                                </dd>

                                <dt class="col-sm-4">Productos asociados:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-primary">{{ $category->products_count ?? $category->products->count() }} productos</span>
                                </dd>

                                <dt class="col-sm-4">Creado:</dt>
                                <dd class="col-sm-8">{{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A' }}</dd>

                                <dt class="col-sm-4">Actualizado:</dt>
                                <dd class="col-sm-8">{{ $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'N/A' }}</dd>
                            </dl>

                            @if(($category->products_count ?? $category->products->count()) > 0)
                                <div class="mt-4">
                                    <h5 class="mb-3">Productos en esta categoría:</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Stock</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->products as $product)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                                                {{ $product->nombre }}
                                                            </a>
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
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar esta categoría? Los productos no serán eliminados.')">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

