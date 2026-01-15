@extends('layouts.app')

@section('title', 'Usuarios del Sistema')

@section('content')
<div>
    <h1 class="page-title">
        <i class="bi bi-people"></i> Usuarios del Sistema
    </h1>
    <p class="page-subtitle">Gestiona los usuarios registrados en el sistema.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="bi bi-table"></i> Lista de Usuarios
            </h5>
            <span class="badge bg-primary">{{ $totalUsers }} usuarios</span>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Registrado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <small class="text-muted">#{{ $user->id }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar" style="width: 35px; height: 35px; font-size: 14px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <small class="text-muted">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" 
                                    data-bs-target="#userModal" onclick="viewUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}')">
                                    <i class="bi bi-eye"></i> Ver
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> No hay usuarios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer bg-light">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Ver Usuario -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person"></i> Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">ID:</dt>
                    <dd class="col-sm-8" id="modalUserId"></dd>
                    <dt class="col-sm-4">Nombre:</dt>
                    <dd class="col-sm-8" id="modalUserName"></dd>
                    <dt class="col-sm-4">Email:</dt>
                    <dd class="col-sm-8" id="modalUserEmail"></dd>
                    <dt class="col-sm-4">Registrado:</dt>
                    <dd class="col-sm-8" id="modalUserDate"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function viewUser(id, name, email, date) {
    document.getElementById('modalUserId').textContent = '#' + id;
    document.getElementById('modalUserName').textContent = name;
    document.getElementById('modalUserEmail').textContent = email;
    document.getElementById('modalUserDate').textContent = date;
}
</script>
@endsection
