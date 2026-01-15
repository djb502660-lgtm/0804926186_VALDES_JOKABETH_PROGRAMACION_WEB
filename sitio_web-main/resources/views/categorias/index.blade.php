@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4">Categorías</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.categories.export') }}" class="btn btn-light border btn-lg me-2">
                <i class="bi bi-file-earmark-spreadsheet"></i> Exportar CSV
            </a>
            <a href="{{ route('admin.categories.print') }}" class="btn btn-light border btn-lg me-2" target="_blank">
                <i class="bi bi-printer"></i> Imprimir
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Nueva Categoría
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
        @forelse($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-center mb-3">
                            @if($category->image_path)
                                <img src="{{ asset('storage/' . $category->image_path) }}" alt="Icono de {{ $category->nombre }}" style="width: 96px; height: 96px; object-fit: cover; border-radius: 10px; border: 1px solid #fecaca;">
                            @else
                                <div style="width: 96px; height: 96px; border-radius: 10px; border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; color: #dc2626;">
                                    <i class="bi bi-image" style="font-size: 28px;"></i>
                                </div>
                            @endif
                        </div>

                        <div class="fw-semibold">{{ $category->nombre }}</div>
                        <div class="text-muted small mb-2">{{ Str::limit($category->descripcion, 60) ?? '-' }}</div>
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $category->products_count }} productos</span>
                        </div>

                        <div class="mt-auto d-flex gap-1">
                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" 
                                    onclick="return confirm('¨Est s seguro? Los productos de esta categor¡a no ser n eliminados.')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-4">
                No hay Categor¡as registradas
            </div>
        @endforelse
    </div>

    <div class="card shadow-sm d-none">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Icono</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Productos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td style="width: 70px;">
                                @if($category->image_path)
                                    <img src="{{ asset('storage/' . $category->image_path) }}" alt="Icono de {{ $category->nombre }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid #fecaca;">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 8px; border: 1px solid #fecaca; display: flex; align-items: center; justify-content: center; color: #dc2626;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $category->nombre }}</strong></td>
                            <td>{{ Str::limit($category->descripcion, 50) ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $category->products_count }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" 
                                        onclick="return confirm('¿Estás seguro? Los productos de esta categoría no serán eliminados.')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No hay Categorías registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection




