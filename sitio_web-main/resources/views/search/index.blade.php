@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-5">Resultados de busqueda</h1>
            @if($query !== '')
                <p class="page-subtitle">Termino: <strong>{{ $query }}</strong></p>
            @endif
        </div>
    </div>

    @if($query === '')
        <div class="alert alert-warning" role="alert">
            Ingresa un termino para buscar.
        </div>
    @else
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Productos
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th class="text-end">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                                    {{ $product->nombre }}
                                                </a>
                                            </td>
                                            <td>{{ $product->category->nombre ?? 'N/A' }}</td>
                                            <td class="text-end">${{ number_format($product->precio, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">
                                                Sin resultados en productos
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        Categorias
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th class="text-end">Productos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.categories.show', $category) }}" class="text-decoration-none">
                                                    {{ $category->nombre }}
                                                </a>
                                            </td>
                                            <td class="text-end">{{ $category->products_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-3">
                                                Sin resultados en categorias
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
