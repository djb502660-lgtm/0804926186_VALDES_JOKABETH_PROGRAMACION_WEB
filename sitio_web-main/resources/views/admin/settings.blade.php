@extends('layouts.app')

@section('title', 'Configuración del Sistema')

@section('content')
<div>
    <h1 class="page-title">
        <i class="bi bi-sliders"></i> Configuración del Sistema
    </h1>
    <p class="page-subtitle">Administra los parámetros generales de la aplicación.</p>

    <div class="row">
        <!-- Configuración General -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-gear"></i> Configuración General</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="siteName" class="form-label">Nombre del Sitio</label>
                            <input type="text" class="form-control" id="siteName" value="Sistema de Gestión" placeholder="Nombre del sitio">
                        </div>

                        <div class="mb-3">
                            <label for="siteUrl" class="form-label">URL del Sitio</label>
                            <input type="url" class="form-control" id="siteUrl" value="http://localhost:8000" placeholder="URL del sitio">
                        </div>

                        <div class="mb-3">
                            <label for="siteEmail" class="form-label">Email del Sitio</label>
                            <input type="email" class="form-control" id="siteEmail" value="admin@example.com" placeholder="admin@example.com">
                        </div>

                        <div class="mb-3">
                            <label for="timezone" class="form-label">Zona Horaria</label>
                            <select class="form-select" id="timezone">
                                <option selected>America/Mexico_City</option>
                                <option>America/New_York</option>
                                <option>America/Los_Angeles</option>
                                <option>Europe/Madrid</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="itemsPerPage" class="form-label">Items por Página</label>
                            <input type="number" class="form-control" id="itemsPerPage" value="10" min="5" max="100">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>

            <!-- Configuración de Seguridad -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-shield-lock"></i> Seguridad</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Autenticación de dos factores</h6>
                            <small class="text-muted">Habilita 2FA para mayor seguridad</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="twoFactor">
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Notificaciones por Email</h6>
                            <small class="text-muted">Recibe alertas importantes por email</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Modo de Mantenimiento</h6>
                            <small class="text-muted">Desactiva el acceso al público</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="maintenance">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Información del Sistema -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Sistema</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-truncate">Versión:</dt>
                        <dd class="col-sm-7">1.0.0</dd>

                        <dt class="col-sm-5 text-truncate">Laravel:</dt>
                        <dd class="col-sm-7">12.43.1</dd>

                        <dt class="col-sm-5 text-truncate">PHP:</dt>
                        <dd class="col-sm-7">8.0.30</dd>

                        <dt class="col-sm-5 text-truncate">Base de Datos:</dt>
                        <dd class="col-sm-7">MySQL</dd>

                        <dt class="col-sm-5 text-truncate">Últimas Actualizaciones:</dt>
                        <dd class="col-sm-7">
                            <small class="text-muted">Hoy a las 10:30 AM</small>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Acciones -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-lightning"></i> Acciones</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-arrow-clockwise"></i> Limpiar Cache
                    </button>
                    <button class="btn btn-info w-100 mb-2">
                        <i class="bi bi-download"></i> Backup Base de Datos
                    </button>
                    <button class="btn btn-danger w-100">
                        <i class="bi bi-exclamation-triangle"></i> Restablecer Valores
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
