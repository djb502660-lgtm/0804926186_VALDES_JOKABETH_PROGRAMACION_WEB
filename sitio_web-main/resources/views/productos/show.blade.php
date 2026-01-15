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

            <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Volver
            </a>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="mb-3">{{ $product->nombre }}</h1>
                            
                            <dl class="row">
                                <dt class="col-sm-4">Categoría:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-info">{{ $product->category->nombre ?? 'N/A' }}</span>
                                </dd>

                                <dt class="col-sm-4">Precio:</dt>
                                <dd class="col-sm-8">
                                    <strong class="text-success">${{ number_format($product->precio, 2) }}</strong>
                                </dd>

                                <dt class="col-sm-4">Stock:</dt>
                                <dd class="col-sm-8">
                                    @if($product->stock > 5)
                                        <span class="badge bg-success">{{ $product->stock }} unidades</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning">{{ $product->stock }} unidades</span>
                                    @else
                                        <span class="badge bg-danger">Agotado</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Estado:</dt>
                                <dd class="col-sm-8">
                                    @if($product->estado === 'activo')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Creado:</dt>
                                <dd class="col-sm-8">{{ $product->created_at ? $product->created_at->format('d/m/Y H:i') : 'N/A' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-4">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Imagen del producto" class="img-fluid rounded border">
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">
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
