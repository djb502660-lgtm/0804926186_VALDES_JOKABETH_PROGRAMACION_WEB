@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="page-title">
        <i class="bi bi-speedometer2"></i> Dashboard
    </h1>
    <p class="page-subtitle">Bienvenido al sistema de gestión. Aquí puedes ver un resumen de tu operación.</p>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="icon" style="color: var(--primary);">
                    <i class="bi bi-people"></i>
                </div>
                <div class="number">{{ $totalUsers }}</div>
                <div class="label">Usuarios Registrados</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="icon" style="color: var(--success);">
                    <i class="bi bi-box"></i>
                </div>
                <div class="number">{{ $totalProducts }}</div>
                <div class="label">Productos</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="icon" style="color: var(--warning);">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="number">{{ $totalCategories }}</div>
                <div class="label">Categorías</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="icon" style="color: var(--danger);">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="number">{{ $lowStockProducts }}</div>
                <div class="label">Stock Bajo</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning"></i> Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Agregar Producto
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Nueva Categoría
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-info">
                            <i class="bi bi-list"></i> Ver Productos
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-warning">
                            <i class="bi bi-list"></i> Ver Categorías
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos Recientes -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-box"></i> Productos Recientes
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentProducts = \App\Models\Product::orderBy('created_at', 'desc')->limit(5)->get();
                            @endphp
                            @forelse($recentProducts as $product)
                                <tr>
                                    <td>{{ $product->nombre }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No hay productos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-tags"></i> Categorías
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Productos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $categories = \App\Models\Category::withCount('products')->limit(5)->get();
                            @endphp
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->nombre }}</td>
                                    <td><span class="badge bg-primary">{{ $category->products_count }}</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No hay categorías</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
