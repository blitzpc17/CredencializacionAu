@extends('cms.layout')

@push('css')
<style>
    .solicitudes-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .section-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .section-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .section-description {
        color: var(--gray);
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .section-content {
        padding: 2rem;
    }

    /* Tabla */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .table th {
        background: #f8f9fa;
        font-weight: 600;
        color: var(--dark);
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge.primary { background: var(--primary); color: white; }
    .badge.success { background: var(--success); color: white; }
    .badge.warning { background: var(--warning); color: var(--dark); }
    .badge.danger { background: var(--danger); color: white; }
    .badge.info { background: var(--accent); color: white; }

    .folio-badge {
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'Courier New', monospace;
    }

    /* Botones */
    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn.primary { background: var(--primary); color: white; }
    .btn.success { background: var(--success); color: white; }
    .btn.danger { background: var(--danger); color: white; }
    .btn.warning { background: var(--warning); color: var(--dark); }
    .btn.sm { padding: 0.4rem 0.8rem; font-size: 0.75rem; }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .btn-icon {
        background: none;
        border: none;
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        color: var(--gray);
    }

    .btn-icon:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .btn-icon.primary { color: var(--primary); }
    .btn-icon.primary:hover { background: rgba(67, 97, 238, 0.1); }

    .btn-icon.warning { color: var(--warning); }
    .btn-icon.warning:hover { background: rgba(255, 193, 7, 0.1); }

    .btn-icon.danger { color: var(--danger); }
    .btn-icon.danger:hover { background: rgba(220, 53, 69, 0.1); }

    /* Formularios */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: var(--transition);
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    /* Controles de tabla */
    .datatable-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .datatable-search {
        flex: 1;
        min-width: 200px;
    }

    .datatable-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Estados vacíos */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e9ecef;
    }

    /* Loading */
    .loading {
        text-align: center;
        padding: 2rem;
        color: var(--gray);
    }

    .loading i {
        font-size: 2rem;
        margin-bottom: 1rem;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Alertas */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        border-left: 4px solid transparent;
    }

    .alert.primary {
        background: rgba(67, 97, 238, 0.1);
        border-left-color: var(--primary);
        color: #2c44c4;
    }

    .alert.success {
        background: rgba(75, 181, 67, 0.1);
        border-left-color: var(--success);
        color: #2e7d32;
    }

    .alert.danger {
        background: rgba(220, 53, 69, 0.1);
        border-left-color: var(--danger);
        color: #c53030;
    }

    .alert.warning {
        background: rgba(255, 204, 0, 0.1);
        border-left-color: var(--warning);
        color: #b38f00;
    }

    .alert-icon {
        font-size: 1.25rem;
        margin-top: 0.1rem;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .alert-message {
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .alert-close {
        background: none;
        border: none;
        color: inherit;
        opacity: 0.7;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .alert-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.1);
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1100;
        padding: 1rem;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal {
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 800px;
        max-height: 90vh;
        overflow: hidden;
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: var(--gray);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: var(--transition);
    }

    .modal-close:hover {
        background: #f8f9fa;
        color: var(--dark);
    }

    .modal-body {
        padding: 2rem;
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        background: #f8f9fa;
    }

    /* Grid de formulario */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .form-full-width {
        grid-column: 1 / -1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .datatable-controls {
            flex-direction: column;
            align-items: stretch;
        }
        
        .datatable-search {
            min-width: auto;
        }

        .modal {
            margin: 1rem;
            max-width: calc(100% - 2rem);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            flex-direction: column;
        }

        .modal-footer .btn {
            width: 100%;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }


     /* Nuevos estilos para archivos y vista detalle */
    .file-preview {
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
        background: #f8f9fa;
    }

    .file-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 6px;
    }

    .file-info {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        color: var(--gray);
    }

    .file-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 0.5rem;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .file-input-wrapper input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
    }

    .document-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
    }

    .status-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }

    .detail-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .detail-value {
        color: var(--gray);
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-left: 2px solid var(--primary);
        padding-left: 1rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 50%;
        background: var(--primary);
    }

    .conditional-field {
        display: none;
    }

    .conditional-field.show {
        display: flex;
    }

     /* Estilos para errores en formularios */
    .form-control.error {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .error-message {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    /* Alertas dentro del modal */
    .modal-alert {
        margin-bottom: 1.5rem;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Paginación */
    .pagination-container {
        margin-top: 1.5rem;
        padding: 1rem 0;
        border-top: 1px solid #e9ecef;
    }

    .pagination-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .pagination-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .pagination-numbers {
        display: flex;
        gap: 0.25rem;
    }

    .pagination-size {
        min-width: 150px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Gestión de Solicitudes</h1>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('cms.dash') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Credencialización</a></li>
                <li class="breadcrumb-item active">Solicitudes</li>
            </ol>
        </nav>
    </div>

    <div class="solicitudes-container">
        <!-- Sección de Lista de Solicitudes -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Solicitudes de Credencialización</h2>
                <p class="section-description">Gestiona las solicitudes de credencialización del sistema</p>
            </div>
            <div class="section-content">
                <!-- Controles de la tabla -->
                <div class="datatable-controls">
                    <div class="datatable-search">
                        <input type="text" class="form-control" placeholder="Buscar por folio, nombre o correo..." id="searchSolicitudes">
                    </div>
                    <div class="datatable-actions">
                        <button class="btn primary sm" id="refreshSolicitudes">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button class="btn success sm" id="addSolicitud">
                            <i class="fas fa-plus"></i> Nueva Solicitud
                        </button>
                    </div>
                </div>

                <!-- Tabla de solicitudes -->
                <div class="table-responsive">
                    <table class="table" id="solicitudesTable">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Solicitante</th>
                                <th>Escuela</th>
                                <th>Terminal</th>
                                <th>Estado</th>
                                <th>ID Credencial</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="solicitudesTableBody">
                            <!-- Los datos se cargan via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-file-alt"></i>
                    <h3>No hay solicitudes</h3>
                    <p>No se han registrado solicitudes en el sistema.</p>
                    <button class="btn primary mt-3" id="addFirstSolicitud">
                        <i class="fas fa-plus"></i> Crear Primera Solicitud
                    </button>
                </div>

                <!-- Loading -->
                <div class="loading" id="loadingSolicitudes">
                    <i class="fas fa-spinner"></i>
                    <p>Cargando solicitudes...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar solicitud -->
<div class="modal-overlay" id="solicitudModal">
    <div class="modal" style="max-width: 900px;">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Nueva Solicitud</h3>
            <button class="modal-close" data-modal="solicitudModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <!-- Contenedor para alertas dentro del modal -->
            <div id="modalAlerts"></div>
            
            <form id="solicitudForm" enctype="multipart/form-data">
                <input type="hidden" id="solicitudId">
                <input type="hidden" id="folio" readonly>
                
                <div class="form-grid">
                    <!-- Información Personal -->
                    <div class="form-group form-full-width">
                        <h4 style="margin-bottom: 1rem; color: var(--primary);">Información Personal</h4>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nombres">Nombres *</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                        <div class="error-message" id="nombresError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="apellidos">Apellidos *</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        <div class="error-message" id="apellidosError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="perfil_academico">Perfil Académico *</label>
                        <select class="form-control" id="perfil_academico" name="perfil_academico" required>
                            <option value="">Seleccione perfil</option>
                        </select>
                        <div class="error-message" id="perfil_academicoError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="correo">Correo *</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                        <div class="error-message" id="correoError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="telefono">Teléfono *</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                        <div class="error-message" id="telefonoError"></div>
                    </div>

                    <!-- Información de Viaje -->
                    <div class="form-group form-full-width">
                        <h4 style="margin-bottom: 1rem; color: var(--primary);">Información de Viaje</h4>
                    </div>
                    <div class="form-group form-full-width">
                        <label class="form-label" for="escuela_procedencia">Escuela de Procedencia *</label>
                        <input type="text" class="form-control" id="escuela_procedencia" name="escuela_procedencia" required>
                        <div class="error-message" id="escuela_procedenciaError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lugar_residencia">Lugar de Residencia *</label>
                        <input type="text" class="form-control" id="lugar_residencia" name="lugar_residencia" required>
                        <div class="error-message" id="lugar_residenciaError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lugar_origen">Lugar de Origen *</label>
                        <input type="text" class="form-control" id="lugar_origen" name="lugar_origen" required>
                        <div class="error-message" id="lugar_origenError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lugar_viaja_frecuente">Lugar que Viaja Frecuente *</label>
                        <input type="text" class="form-control" id="lugar_viaja_frecuente" name="lugar_viaja_frecuente" required>
                        <div class="error-message" id="lugar_viaja_frecuenteError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="terminalesId">Terminal *</label>
                        <select class="form-control" id="terminalesId" name="terminalesId" required>
                            <option value="">Seleccione terminal</option>
                        </select>
                        <div class="error-message" id="terminalesIdError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="veces_semana">Veces por Semana *</label>
                        <input type="text" class="form-control" id="veces_semana" name="veces_semana" required>
                        <div class="error-message" id="veces_semanaError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dia_semana_viaja">Día de la Semana *</label>
                        <select class="form-control" id="dia_semana_viaja" name="dia_semana_viaja" required>
                            <option value="">Seleccione día</option>
                        </select>
                        <div class="error-message" id="dia_semana_viajaError"></div>
                    </div>

                    <!-- Documentos -->
                    <div class="form-group form-full-width">
                        <h4 style="margin-bottom: 1rem; color: var(--primary);">Documentos</h4>
                    </div>
                    
                    <!-- CURP -->
                    <div class="form-group">
                        <label class="form-label">CURP *</label>
                        <div class="file-preview" id="curpPreview">
                            <i class="fas fa-file-pdf fa-3x" style="color: #dc3545;"></i>
                            <div class="file-info" id="curpInfo">No se ha cargado archivo</div>
                            <div class="file-actions">
                                <button type="button" class="btn sm primary view-file" data-field="curp">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <div class="file-input-wrapper">
                                    <button type="button" class="btn sm warning">
                                        <i class="fas fa-upload"></i> Cambiar
                                    </button>
                                    <input type="file" class="form-control file-input" id="curp" name="curp" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                        <div class="error-message" id="curpError"></div>
                    </div>

                    <!-- Credencial -->
                    <div class="form-group">
                        <label class="form-label">Credencial *</label>
                        <div class="file-preview" id="credencialPreview">
                            <i class="fas fa-file-image fa-3x" style="color: #28a745;"></i>
                            <div class="file-info" id="credencialInfo">No se ha cargado archivo</div>
                            <div class="file-actions">
                                <button type="button" class="btn sm primary view-file" data-field="credencial">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <div class="file-input-wrapper">
                                    <button type="button" class="btn sm warning">
                                        <i class="fas fa-upload"></i> Cambiar
                                    </button>
                                    <input type="file" class="form-control file-input" id="credencial" name="credencial" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                        <div class="error-message" id="credencialError"></div>
                    </div>

                    <!-- Fotografía -->
                    <div class="form-group">
                        <label class="form-label">Fotografía *</label>
                        <div class="file-preview" id="fotografiaPreview">
                            <i class="fas fa-camera fa-3x" style="color: #007bff;"></i>
                            <div class="file-info" id="fotografiaInfo">No se ha cargado archivo</div>
                            <div class="file-actions">
                                <button type="button" class="btn sm primary view-file" data-field="fotografia">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <div class="file-input-wrapper">
                                    <button type="button" class="btn sm warning">
                                        <i class="fas fa-upload"></i> Cambiar
                                    </button>
                                    <input type="file" class="form-control file-input" id="fotografia" name="fotografia" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                        <div class="error-message" id="fotografiaError"></div>
                    </div>

                    <!-- Voucher de Pago -->
                    <div class="form-group">
                        <label class="form-label">Voucher de Pago</label>
                        <div class="file-preview" id="voucherPreview">
                            <i class="fas fa-receipt fa-3x" style="color: #6f42c1;"></i>
                            <div class="file-info" id="voucherInfo">No se ha cargado archivo</div>
                            <div class="file-actions">
                                <button type="button" class="btn sm primary view-file" data-field="voucher_pago">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                                <div class="file-input-wrapper">
                                    <button type="button" class="btn sm warning">
                                        <i class="fas fa-upload"></i> Cambiar
                                    </button>
                                    <input type="file" class="form-control file-input" id="voucher_pago" name="voucher_pago" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                        <div class="error-message" id="voucher_pagoError"></div>
                    </div>

                    <!-- Información de Pago y Estado -->
                    <div class="form-group form-full-width">
                        <h4 style="margin-bottom: 1rem; color: var(--primary);">Información de Pago y Estado</h4>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="formaPago">Forma de Pago *</label>
                        <select class="form-control" id="formaPago" name="formaPago" required>
                            <option value="">Seleccione forma de pago</option>
                        </select>
                        <div class="error-message" id="formaPagoError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="solicitudes_estadosId">Estado *</label>
                        <select class="form-control" id="solicitudes_estadosId" name="solicitudes_estadosId" required>
                            <option value="">Seleccione estado</option>
                        </select>
                        <div class="error-message" id="solicitudes_estadosIdError"></div>
                    </div>

                    <!-- Campos condicionales para estado PAGADO -->
                    <div class="form-group conditional-field" id="vigenciaField">
                        <label class="form-label" for="vigencia">Vigencia</label>
                        <input type="date" class="form-control" id="vigencia" name="vigencia">
                        <div class="error-message" id="vigenciaError"></div>
                    </div>

                    <div class="form-group conditional-field" id="idCredencialField">
                        <label class="form-label" for="id_credencial">ID Credencial</label>
                        <input type="text" class="form-control" id="id_credencial" name="id_credencial" maxlength="10" placeholder="Ingrese ID de credencial">
                        <div class="error-message" id="id_credencialError"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="solicitudModal">Cancelar</button>
            <button class="btn primary" id="saveSolicitud">
                <i class="fas fa-save"></i> Guardar Solicitud
            </button>
        </div>
    </div>
</div>

<!-- Modal de detalles de solicitud -->
<div class="modal-overlay" id="detailModal">
    <div class="modal" style="max-width: 800px;">
        <div class="modal-header">
            <h3 class="modal-title">Detalles de Solicitud</h3>
            <button class="modal-close" data-modal="detailModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="modalContent">
                <!-- Contenido se carga dinámicamente -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="detailModal">Cerrar</button>
        </div>
    </div>
</div>

<!-- Modal de confirmación para cambiar estado -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" style="color: var(--warning);">
                <i class="fas fa-exclamation-triangle"></i> Confirmar Baja
            </h3>
            <button class="modal-close" data-modal="confirmModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert warning">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <div class="alert-content">
                    <h4 class="alert-title">¡Atención!</h4>
                    <p class="alert-message" id="confirmMessage">¿Estás seguro de que quieres dar de baja esta solicitud?</p>
                </div>
            </div>
            <p>Solicitud: <strong id="solicitudToAction"></strong></p>
            
            <div class="form-group">
                <label class="form-label" for="motivo_baja">Motivo de la baja *</label>
                <textarea class="form-control" id="motivo_baja" rows="4" placeholder="Ingrese el motivo por el cual se da de baja esta solicitud..." required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="confirmModal">Cancelar</button>
            <button class="btn warning" id="confirmAction">
                <i class="fas fa-check"></i> Confirmar Baja
            </button>
        </div>
    </div>
</div>

<!-- Modal para visualizar archivos -->
<div class="modal-overlay" id="fileModal">
    <div class="modal" style="max-width: 90%; max-height: 90%;">
        <div class="modal-header">
            <h3 class="modal-title" id="fileModalTitle">Visualizar Archivo</h3>
            <button class="modal-close" data-modal="fileModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" style="text-align: center; padding: 0;">
            <div id="fileModalContent" style="max-height: 70vh; overflow: auto;">
                <!-- Contenido del archivo se carga dinámicamente -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="fileModal">Cerrar</button>
            <a href="#" class="btn primary" id="downloadFile" download>
                <i class="fas fa-download"></i> Descargar
            </a>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let solicitudes = [];
        let formData = {};
        let currentSolicitudId = null;
        let currentAction = '';

        // Elementos del DOM
        const solicitudesTableBody = document.getElementById('solicitudesTableBody');
        const emptyState = document.getElementById('emptyState');
        const loadingSolicitudes = document.getElementById('loadingSolicitudes');
        const searchInput = document.getElementById('searchSolicitudes');
        const solicitudForm = document.getElementById('solicitudForm');
        const estadoSelect = document.getElementById('solicitudes_estadosId');
        const vigenciaField = document.getElementById('vigenciaField');
        const idCredencialField = document.getElementById('idCredencialField');
        const modalAlerts = document.getElementById('modalAlerts');


               // ===== FUNCIONES NUEVAS PARA MANEJO DE ERRORES EN MODAL =====
        
        function clearModalErrors() {
            // Limpiar alertas del modal
            modalAlerts.innerHTML = '';
            
            // Limpiar errores de campos
            document.querySelectorAll('.error-message').forEach(error => {
                error.classList.remove('show');
                error.textContent = '';
            });
            
            // Limpiar estilos de error en inputs
            document.querySelectorAll('.form-control.error').forEach(input => {
                input.classList.remove('error');
            });
        }

        function showModalAlert(type, message, title = null) {
            const alertTypes = {
                info: { class: 'primary', icon: 'fa-info-circle', defaultTitle: 'Información' },
                success: { class: 'success', icon: 'fa-check-circle', defaultTitle: 'Éxito' },
                warning: { class: 'warning', icon: 'fa-exclamation-triangle', defaultTitle: 'Advertencia' },
                error: { class: 'danger', icon: 'fa-times-circle', defaultTitle: 'Error' }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;
            const alertTitle = title || alertConfig.defaultTitle;

            const alertHTML = `
                <div class="alert ${alertConfig.class} modal-alert">
                    <i class="fas ${alertConfig.icon} alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">${alertTitle}</h4>
                        <p class="alert-message">${message}</p>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            modalAlerts.insertAdjacentHTML('afterbegin', alertHTML);
        }

        function showFieldErrors(errors) {
            // Limpiar errores previos
            clearModalErrors();
            
            // Mostrar errores por campo
            Object.keys(errors).forEach(field => {
                const errorElement = document.getElementById(field + 'Error');
                const inputElement = document.getElementById(field);
                
                if (errorElement && inputElement) {
                    errorElement.textContent = errors[field].join(', ');
                    errorElement.classList.add('show');
                    inputElement.classList.add('error');
                }
            });
            
            // Mostrar alerta general
            if (Object.keys(errors).length > 0) {
                showModalAlert('error', 'Por favor corrige los errores en el formulario', 'Errores de Validación');
                
                // Hacer scroll al primer error
                const firstError = document.querySelector('.error-message.show');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        }

        // ===== FUNCIONES NUEVAS PARA MANEJO DE ERRORES EN MODAL =====
        
        function clearModalErrors() {
            // Limpiar alertas del modal
            modalAlerts.innerHTML = '';
            
            // Limpiar errores de campos
            document.querySelectorAll('.error-message').forEach(error => {
                error.classList.remove('show');
                error.textContent = '';
            });
            
            // Limpiar estilos de error en inputs
            document.querySelectorAll('.form-control.error').forEach(input => {
                input.classList.remove('error');
            });
        }

        // ===== INICIALIZACIÓN =====
        initializeSolicitudes();

        function initializeSolicitudes() {
            // Cargar formData primero, luego las solicitudes
            loadFormData().then(() => {
                console.log("FormData cargado, estados disponibles:", formData.estados);
                loadSolicitudes();
                setupPagination();
                setupEventListeners();
            }).catch(error => {
                console.error("Error cargando formData:", error);
                showAlert('warning', 'Algunos datos del formulario no se pudieron cargar. Los campos condicionales podrían no funcionar correctamente.');
                loadSolicitudes();
                setupPagination();
                setupEventListeners();
            });
        }

        // ===== PAGINACIÓN =====
        let currentPage = 1;
        let perPage = 10;
        let totalPages = 1;
        let filteredSolicitudes = [];

        // ===== PAGINACIÓN =====
        function setupPagination() {
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.innerHTML = `
                <div class="pagination-controls">
                    <div class="pagination-info">
                        Mostrando <span id="paginationFrom">0</span>-<span id="paginationTo">0</span> de <span id="paginationTotal">0</span> registros
                    </div>
                    <div class="pagination-buttons">
                        <button class="btn sm light" id="firstPage" disabled>
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button class="btn sm light" id="prevPage" disabled>
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span class="pagination-numbers" id="paginationNumbers"></span>
                        <button class="btn sm light" id="nextPage" disabled>
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button class="btn sm light" id="lastPage" disabled>
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                    <div class="pagination-size">
                        <select class="form-control sm" id="perPageSelect">
                            <option value="5">5 por página</option>
                            <option value="10" selected>10 por página</option>
                            <option value="25">25 por página</option>
                            <option value="50">50 por página</option>
                            <option value="100">100 por página</option>
                        </select>
                    </div>
                </div>
            `;
            
            // Insertar después de la tabla
            const tableContainer = document.querySelector('.table-responsive');
            if (tableContainer && tableContainer.parentNode) {
                tableContainer.parentNode.insertBefore(paginationContainer, tableContainer.nextSibling);
            }
            
            // Event listeners para paginación
            document.getElementById('firstPage').addEventListener('click', function() {
                goToPage(1);
            });
            
            document.getElementById('prevPage').addEventListener('click', function() {
                goToPage(currentPage - 1);
            });
            
            document.getElementById('nextPage').addEventListener('click', function() {
                goToPage(currentPage + 1);
            });
            
            document.getElementById('lastPage').addEventListener('click', function() {
                goToPage(totalPages);
            });
            
            document.getElementById('perPageSelect').addEventListener('change', function(e) {
                perPage = parseInt(e.target.value);
                currentPage = 1;
                renderPagination();
            });
        }

        function goToPage(page) {
            if (page < 1 || page > totalPages) {
                return;
            }
            
            currentPage = page;
            renderPagination();
        }

        function renderPagination() {
            const startIndex = (currentPage - 1) * perPage;
            const endIndex = Math.min(startIndex + perPage, filteredSolicitudes.length);
            const pageData = filteredSolicitudes.slice(startIndex, endIndex);
            
            // Renderizar datos de la página actual
            renderSolicitudes(pageData);
            
            // Actualizar información de paginación
            const paginationFrom = document.getElementById('paginationFrom');
            const paginationTo = document.getElementById('paginationTo');
            const paginationTotal = document.getElementById('paginationTotal');
            
            if (paginationFrom) paginationFrom.textContent = startIndex + 1;
            if (paginationTo) paginationTo.textContent = endIndex;
            if (paginationTotal) paginationTotal.textContent = filteredSolicitudes.length;
            
            // Calcular total de páginas
            totalPages = Math.ceil(filteredSolicitudes.length / perPage);
            
            // Actualizar botones
            const firstPageBtn = document.getElementById('firstPage');
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');
            const lastPageBtn = document.getElementById('lastPage');
            
            if (firstPageBtn) firstPageBtn.disabled = (currentPage === 1);
            if (prevPageBtn) prevPageBtn.disabled = (currentPage === 1);
            if (nextPageBtn) nextPageBtn.disabled = (currentPage === totalPages);
            if (lastPageBtn) lastPageBtn.disabled = (currentPage === totalPages);
            
            // Actualizar números de página
            const paginationNumbers = document.getElementById('paginationNumbers');
            if (paginationNumbers) {
                paginationNumbers.innerHTML = '';
                
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                
                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }
                
                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `btn sm ${i === currentPage ? 'primary' : 'light'}`;
                    pageBtn.textContent = i;
                    pageBtn.addEventListener('click', function() {
                        goToPage(i);
                    });
                    paginationNumbers.appendChild(pageBtn);
                }
            }
            
            // Actualizar select de items por página
            const perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.value = perPage;
            }
        }     

        // Modificar la función de búsqueda para usar paginación
        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filteredSolicitudes = solicitudes.filter(solicitud => 
                    solicitud.folio.toLowerCase().includes(searchTerm) ||
                    solicitud.nombres.toLowerCase().includes(searchTerm) ||
                    solicitud.apellidos.toLowerCase().includes(searchTerm) ||
                    solicitud.correo.toLowerCase().includes(searchTerm) ||
                    solicitud.escuela_procedencia.toLowerCase().includes(searchTerm) ||
                    (solicitud.id_credencial && solicitud.id_credencial.toLowerCase().includes(searchTerm))
                );
                currentPage = 1;
                renderPagination();
            });
        }

        function refreshData() {
            loadSolicitudes();
        }

        // Modificar loadSolicitudes para inicializar la paginación
        function loadSolicitudes() {
            showLoading();
            
            $.ajax({
                url: '/api/solicitudes',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        solicitudes = response.data;
                        filteredSolicitudes = [...solicitudes]; // Copia para filtrado
                        currentPage = 1;
                        renderPagination();
                    } else {
                        showAlert('error', 'Error al cargar las solicitudes: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar las solicitudes';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                },
                complete: function() {
                    hideLoading();
                }
            });
        }

        // ===== CARGAR DATOS DEL FORMULARIO =====
        function loadFormData() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/api/solicitudes/form-data',
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            formData = response.data;
                            renderFormSelects();
                            console.log("FormData cargado exitosamente. Estados:", formData.estados);
                            resolve(formData);
                        } else {
                            showAlert('error', 'Error al cargar los datos del formulario: ' + response.message);
                            reject(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error al cargar datos del formulario';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += ': ' + xhr.responseJSON.message;
                        }
                        showAlert('error', errorMessage);
                        reject(errorMessage);
                    }
                });
            });
        }

        function renderFormSelects() {
            console.log("Iniciando renderFormSelects...");
            
            // Perfiles académicos
            const perfilSelect = document.getElementById('perfil_academico');
            formData.perfiles_academicos.forEach(perfil => {
                const option = document.createElement('option');
                option.value = perfil.id;
                option.textContent = perfil.nombre;
                perfilSelect.appendChild(option);
            });

            // Terminales
            const terminalSelect = document.getElementById('terminalesId');
            formData.terminales.forEach(terminal => {
                const option = document.createElement('option');
                option.value = terminal.id;
                option.textContent = terminal.nombre;
                terminalSelect.appendChild(option);
            });

            // Días de la semana
            const diaSelect = document.getElementById('dia_semana_viaja');
            formData.dias_semana.forEach(dia => {
                const option = document.createElement('option');
                option.value = dia.id;
                option.textContent = dia.nombre;
                diaSelect.appendChild(option);
            });

            // Formas de pago
            const pagoSelect = document.getElementById('formaPago');
            formData.formas_pago.forEach(pago => {
                const option = document.createElement('option');
                option.value = pago.id;
                option.textContent = pago.nombre;
                pagoSelect.appendChild(option);
            });

            // Estados
            const estadoSelect = document.getElementById('solicitudes_estadosId');
            formData.estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.id;
                option.textContent = estado.nombre;
                estadoSelect.appendChild(option);
            });

            console.log("FormSelects renderizados. Estados cargados:", formData.estados);
        }

        function refreshData() {
            loadSolicitudes();
        }

        // ===== CARGAR SOLICITUDES =====
        function loadSolicitudes() {
            showLoading();
            
            $.ajax({
                url: '/api/solicitudes',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        solicitudes = response.data;
                        renderSolicitudes(solicitudes);
                    } else {
                        showAlert('error', 'Error al cargar las solicitudes: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar las solicitudes';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                },
                complete: function() {
                    hideLoading();
                }
            });
        }

        // ===== RENDERIZAR SOLICITUDES =====
        function renderSolicitudes(solicitudesList) {
            if (solicitudesList.length === 0) {
                solicitudesTableBody.innerHTML = '';
                emptyState.style.display = 'block';
                
                // Verificación tradicional en lugar de encadenamiento opcional
                const paginationContainer = document.querySelector('.pagination-container');
                if (paginationContainer) {
                    paginationContainer.style.display = 'none';
                }
                
                return;
            }

            emptyState.style.display = 'none';
            
            // Mostrar paginación si existe
            const paginationContainer = document.querySelector('.pagination-container');
            if (paginationContainer) {
                paginationContainer.style.display = 'block';
            }
            
            const html = solicitudesList.map(solicitud => `
                <tr>
                    <td>
                        <span class="folio-badge">${solicitud.folio}</span>
                    </td>
                    <td>
                        <div>
                            <strong>${solicitud.nombres} ${solicitud.apellidos}</strong><br>
                            <small class="text-muted">${solicitud.correo}</small>
                        </div>
                    </td>
                    <td>${solicitud.escuela_procedencia}</td>
                    <td>${(solicitud.terminal && solicitud.terminal.nombre) || 'N/A'}</td>
                    <td>
                        <span class="badge ${getEstadoBadgeClass(solicitud.estado ? solicitud.estado.nombre : '')}">
                            ${(solicitud.estado && solicitud.estado.nombre) || 'Pendiente'}
                        </span>
                    </td>
                    <td>
                        ${solicitud.id_credencial ? 
                            `<span class="badge success">${solicitud.id_credencial}</span>` : 
                            '<span class="badge warning">Sin asignar</span>'
                        }
                    </td>
                    <td>${formatDate(solicitud.created_at)}</td>
                    <td>
                        <button class="btn-icon primary view-solicitud" data-id="${solicitud.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon edit-solicitud" 
                                data-id="${solicitud.id}"
                                data-folio="${solicitud.folio}"
                                data-nombres="${solicitud.nombres}"
                                data-apellidos="${solicitud.apellidos}"
                                data-perfil_academico="${solicitud.perfil_academico}"
                                data-escuela_procedencia="${solicitud.escuela_procedencia}"
                                data-lugar_residencia="${solicitud.lugar_residencia}"
                                data-lugar_origen="${solicitud.lugar_origen}"
                                data-lugar_viaja_frecuente="${solicitud.lugar_viaja_frecuente}"
                                data-terminalesid="${solicitud.terminalesId}"
                                data-veces_semana="${solicitud.veces_semana}"
                                data-dia_semana_viaja="${solicitud.dia_semana_viaja}"
                                data-curp="${solicitud.curp}"
                                data-credencial="${solicitud.credencial}"
                                data-fotografia="${solicitud.fotografia}"
                                data-voucher_pago="${solicitud.voucher_pago || ''}"
                                data-correo="${solicitud.correo}"
                                data-telefono="${solicitud.telefono}"
                                data-formapago="${solicitud.formaPago}"
                                data-solicitudes_estadosid="${solicitud.solicitudes_estadosId}"
                                data-vigencia="${solicitud.vigencia ? solicitud.vigencia.split('T')[0] : ''}"
                                data-id_credencial="${solicitud.id_credencial || ''}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon danger delete-solicitud" 
                                data-id="${solicitud.id}" 
                                data-folio="${solicitud.folio}">
                            <i class="fas fa-trash"></i>
                        </button>
                           ${solicitud.solicitudes_estadosId === 9 ? `
                        <button class="btn-icon success download-credencial" 
                                data-id="${solicitud.id}"
                                data-folio="${solicitud.folio}"
                                title="Descargar Credencial">
                            <i class="fas fa-download"></i>
                        </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');

            solicitudesTableBody.innerHTML = html;
        }

        function getEstadoBadgeClass(estadoNombre) {
            if (!estadoNombre) return 'warning';
            
            const estado = estadoNombre.toLowerCase();
            
            if (estado.includes('pendiente') || estado.includes('espera')) {
                return 'warning';
            } else if (estado.includes('pagado') || estado.includes('aprobado') || estado.includes('aprobada') || estado.includes('completado') || estado.includes('completada')) {
                return 'success';
            } else if (estado.includes('rechazado') || estado.includes('rechazada') || estado.includes('cancelado') || estado.includes('cancelada')) {
                return 'danger';
            } else if (estado.includes('proceso') || estado.includes('procesando')) {
                return 'info';
            } else if (estado.includes('impresa') || estado.includes('impreso')) {
                return 'primary'; // Color diferente para estado IMPRESA
            } else {
                return 'primary';
            }
        }

        // ===== MANEJO DE CAMPOS CONDICIONALES =====
        function toggleConditionalFields(estadoId) {
            console.log("Estado ID recibido:", estadoId);
            console.log("FormData estados disponibles:", formData.estados);
            
            // Si formData no está cargado o estadoId es null/empty, ocultar campos
            if (!formData.estados || !formData.estados.length || !estadoId) {
                console.log("Datos no disponibles, ocultando campos condicionales");
                vigenciaField.classList.remove('show');
                idCredencialField.classList.remove('show');
                
                // Quitar required
                document.getElementById('vigencia').required = false;
                document.getElementById('id_credencial').required = false;
                return;
            }

            // Buscar estados que contengan "PAGADO" o "PAGADA" (case insensitive)
            const estadoPagado = formData.estados.find(e => {
                const nombre = e.nombre.toLowerCase();
                return nombre.includes('pagado') || nombre.includes('pagada');
            });

            console.log("Estado pagado encontrado:", estadoPagado);
            
            if (estadoPagado && estadoId == estadoPagado.id) {
                console.log("Mostrando campos condicionales para estado pagado");
                vigenciaField.classList.add('show');
                idCredencialField.classList.add('show');
                
                // Hacer required los campos solo si estamos en estado pagado
                document.getElementById('vigencia').required = true;
                document.getElementById('id_credencial').required = true;
            } else {
                console.log("Ocultando campos condicionales");
                vigenciaField.classList.remove('show');
                idCredencialField.classList.remove('show');
                
                // Quitar required si no es estado pagado
                document.getElementById('vigencia').required = false;
                document.getElementById('id_credencial').required = false;
            }
        }

        // ===== MANEJO DE ARCHIVOS =====
        function setupFileInputs() {
            // Configurar inputs de archivo
            document.querySelectorAll('.file-input').forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        updateFilePreview(this.id, file);
                        
                        // Mostrar botón de ver archivo
                        const preview = document.getElementById(this.id + 'Preview');
                        preview.querySelector('.view-file').style.display = 'inline-block';
                    }
                });
            });

            // Configurar botones para ver archivos
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-file')) {
                    const button = e.target.closest('.view-file');
                    const field = button.getAttribute('data-field');
                    const solicitudId = document.getElementById('solicitudId').value;
                    
                    if (solicitudId) {
                        viewFile(solicitudId, field);
                    }
                }
            });
        }

        function updateFilePreview(fieldId, file) {
            const preview = document.getElementById(fieldId + 'Preview');
            const info = document.getElementById(fieldId + 'Info');
            
            if (file) {
                info.textContent = `${file.name} (${formatFileSize(file.size)})`;
                
                // Mostrar preview de imagen si es una imagen
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Buscar si ya existe una imagen preview
                        let img = preview.querySelector('img');
                        if (!img) {
                            img = document.createElement('img');
                            preview.insertBefore(img, preview.firstChild);
                        }
                        img.src = e.target.result;
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '200px';
                        img.style.borderRadius = '6px';
                        img.style.marginBottom = '0.5rem';
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Remover imagen preview si existe
                    const img = preview.querySelector('img');
                    if (img) {
                        img.remove();
                    }
                }
            }
        }

        function viewFile(solicitudId, field) {
            $.ajax({
                url: `/api/solicitudes/${solicitudId}/file/${field}`,
                method: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob, status, xhr) {
                    // Verificar si el blob está vacío o es inválido
                    if (blob.size === 0) {
                        showAlert('error', 'El archivo está vacío o no se pudo cargar');
                        return;
                    }
                    
                    const url = URL.createObjectURL(blob);
                    const fileModal = document.getElementById('fileModal');
                    const fileModalContent = document.getElementById('fileModalContent');
                    const fileModalTitle = document.getElementById('fileModalTitle');
                    const downloadLink = document.getElementById('downloadFile');
                    
                    // Obtener el nombre real del archivo del header Content-Disposition si está disponible
                    let fileName = `${field}_${solicitudId}`;
                    const disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition && disposition.includes('filename=')) {
                        const matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
                        if (matches != null && matches[1]) {
                            fileName = matches[1].replace(/['"]/g, '');
                        }
                    }
                    
                    fileModalTitle.textContent = `Visualizar ${getFieldName(field)}`;
                    downloadLink.href = url;
                    downloadLink.download = fileName;
                    
                    if (blob.type.includes('pdf')) {
                        fileModalContent.innerHTML = `
                            <embed src="${url}" type="application/pdf" width="100%" height="600px">
                        `;
                    } else if (blob.type.includes('image')) {
                        fileModalContent.innerHTML = `
                            <img src="${url}" style="max-width: 100%; max-height: 70vh;" alt="${field}">
                        `;
                    } else {
                        fileModalContent.innerHTML = `
                            <div class="alert info">
                                <i class="fas fa-info-circle"></i>
                                <p>No se puede previsualizar este tipo de archivo. Por favor descárguelo para verlo.</p>
                            </div>
                        `;
                    }
                    
                    openModal('fileModal');
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar el archivo';
                    if (xhr.status === 404) {
                        errorMessage = 'Archivo no encontrado';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        function getFieldName(field) {
            const names = {
                'curp': 'CURP',
                'credencial': 'Credencial',
                'fotografia': 'Fotografía',
                'voucher_pago': 'Voucher de Pago'
            };
            return names[field] || field;
        }

        function getAcceptTypes(field) {
            const types = {
                'curp': '.pdf,.jpg,.jpeg,.png',
                'credencial': '.pdf,.jpg,.jpeg,.png',
                'fotografia': '.jpg,.jpeg,.png',
                'voucher_pago': '.pdf,.jpg,.jpeg,.png'
            };
            return types[field] || '*';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // ===== CRUD OPERATIONS =====
         function createSolicitud(formData) {
            $.ajax({
                url: '/api/solicitudes',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Solicitud creada correctamente' + (response.email_enviado ? ' y correo enviado' : ''));
                        closeModal('solicitudModal');
                        loadSolicitudes();
                    } else {
                        showModalAlert('error', 'Error al crear la solicitud: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al crear la solicitud';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Mostrar errores de validación en el modal
                        showFieldErrors(xhr.responseJSON.errors);
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                        showModalAlert('error', errorMessage);
                    } else {
                        showModalAlert('error', errorMessage);
                    }
                }
            });
        }

         function updateSolicitud(id, formData) {
            $.ajax({
                url: `/api/solicitudes/${id}`,
                method: 'POST', // Laravel requiere POST para FormData con _method PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        let mensajeExito = 'Solicitud actualizada correctamente';
                        
                        if (response.cambio_automatico_estado) {
                            mensajeExito += ' (cambio automático de estado aplicado)';
                        }
                        
                        if (response.email_enviado) {
                            mensajeExito += ' y correo enviado';
                        }
                        
                        if (response.archivos_actualizados && response.archivos_actualizados.length > 0) {
                            mensajeExito += ' - Archivos actualizados: ' + response.archivos_actualizados.join(', ');
                        }
                        
                        showAlert('success', mensajeExito);
                        closeModal('solicitudModal');
                        loadSolicitudes();
                    } else {
                        showModalAlert('error', 'Error al actualizar la solicitud: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar la solicitud';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Mostrar errores de validación en el modal
                        showFieldErrors(xhr.responseJSON.errors);
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                        showModalAlert('error', errorMessage);
                    } else {
                        showModalAlert('error', errorMessage);
                    }
                }
            });
        }

        function deleteSolicitud(id, motivo) {
            $.ajax({
                url: `/api/solicitudes/${id}`,
                method: 'DELETE',
                data: {
                    motivo_baja: motivo
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Solicitud dada de baja correctamente');
                        closeModal('confirmModal');
                        loadSolicitudes();
                    } else {
                        showAlert('error', 'Error al dar de baja la solicitud: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al dar de baja la solicitud';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        function viewSolicitud(id) {
            $.ajax({
                url: `/api/solicitudes/${id}`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        showDetailModal(response.data);
                    } else {
                        showAlert('error', 'Error al cargar los detalles: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar los detalles';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        // ===== MANEJO DE FORMULARIOS =====
                function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Nueva Solicitud';
            resetFormAndPreviews();
            
            // Limpiar errores
            clearModalErrors();
            
            // Asegurar que campos condicionales estén ocultos al crear
            vigenciaField.classList.remove('show');
            idCredencialField.classList.remove('show');
            
            // Quitar required por defecto
            document.getElementById('vigencia').required = false;
            document.getElementById('id_credencial').required = false;
            
            openModal('solicitudModal');
        }

        function openEditModal(solicitud) {
            document.getElementById('modalTitle').textContent = 'Editar Solicitud';
            document.getElementById('solicitudId').value = solicitud.id;
            document.getElementById('folio').value = solicitud.folio;
            
            // Limpiar errores
            clearModalErrors();
            
            // Llenar formulario con datos, excluyendo inputs de archivo
            Object.keys(solicitud).forEach(key => {
                const element = document.getElementById(key);
                if (element && element.type !== 'file') {
                    if (element.type === 'checkbox') {
                        element.checked = solicitud[key];
                    } else {
                        element.value = solicitud[key] || '';
                    }
                }
            });
            
            // Actualizar previews de archivos
            updateFilePreviews(solicitud);
            
            // Manejar campos condicionales
            if (formData.estados && formData.estados.length > 0) {
                toggleConditionalFields(solicitud.solicitudes_estadosId);
            } else {
                loadFormData().then(() => {
                    toggleConditionalFields(solicitud.solicitudes_estadosId);
                }).catch(error => {
                    console.error("Error cargando formData para modal:", error);
                    vigenciaField.classList.remove('show');
                    idCredencialField.classList.remove('show');
                });
            }
            
            openModal('solicitudModal');
        }


        function updateFilePreviews(solicitud) {
            // CURP
            if (solicitud.curp) {
                const fileName = solicitud.curp.split('/').pop(); // Obtener solo el nombre del archivo
                document.getElementById('curpInfo').textContent = fileName;
                document.getElementById('curpPreview').querySelector('.view-file').style.display = 'inline-block';
            } else {
                document.getElementById('curpInfo').textContent = 'No se ha cargado archivo';
                document.getElementById('curpPreview').querySelector('.view-file').style.display = 'none';
            }
            
            // Credencial
            if (solicitud.credencial) {
                const fileName = solicitud.credencial.split('/').pop();
                document.getElementById('credencialInfo').textContent = fileName;
                document.getElementById('credencialPreview').querySelector('.view-file').style.display = 'inline-block';
            } else {
                document.getElementById('credencialInfo').textContent = 'No se ha cargado archivo';
                document.getElementById('credencialPreview').querySelector('.view-file').style.display = 'none';
            }
            
            // Fotografía
            if (solicitud.fotografia) {
                const fileName = solicitud.fotografia.split('/').pop();
                document.getElementById('fotografiaInfo').textContent = fileName;
                document.getElementById('fotografiaPreview').querySelector('.view-file').style.display = 'inline-block';
            } else {
                document.getElementById('fotografiaInfo').textContent = 'No se ha cargado archivo';
                document.getElementById('fotografiaPreview').querySelector('.view-file').style.display = 'none';
            }
            
            // Voucher
            if (solicitud.voucher_pago) {
                const fileName = solicitud.voucher_pago.split('/').pop();
                document.getElementById('voucherInfo').textContent = fileName;
                document.getElementById('voucherPreview').querySelector('.view-file').style.display = 'inline-block';
            } else {
                document.getElementById('voucherInfo').textContent = 'No se ha cargado archivo';
                document.getElementById('voucherPreview').querySelector('.view-file').style.display = 'none';
            }
        }

        function resetFilePreviews() {
            document.querySelectorAll('.file-info').forEach(info => {
                info.textContent = 'No se ha cargado archivo';
            });
            
            // Ocultar botones de ver archivo
            document.querySelectorAll('.view-file').forEach(btn => {
                btn.style.display = 'none';
            });
        }

        function openDeleteModal(id, folio) {
            document.getElementById('solicitudToAction').textContent = folio;
            document.getElementById('confirmMessage').textContent = 
                `¿Estás seguro de que quieres dar de baja la solicitud ${folio}?`;
            document.getElementById('motivo_baja').value = '';
            currentSolicitudId = id;
            currentAction = 'delete';
            openModal('confirmModal');
        }

        function showDetailModal(solicitud) {
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <div class="detail-section">
                    <h4 style="color: var(--primary); margin-bottom: 1rem;">Información General</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <div class="detail-label">Folio</div>
                            <div class="detail-value">
                                <span class="folio-badge">${solicitud.folio}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Estado</div>
                            <div class="detail-value">
                                <span class="badge ${getEstadoBadgeClass(solicitud.estado?.nombre)}">
                                    ${solicitud.estado?.nombre || 'Pendiente'}
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Fecha de Solicitud</div>
                            <div class="detail-value">${formatDateTime(solicitud.created_at)}</div>
                        </div>
                        ${solicitud.vigencia ? `
                        <div class="form-group">
                            <div class="detail-label">Vigencia</div>
                            <div class="detail-value">${formatDate(solicitud.vigencia)}</div>
                        </div>
                        ` : ''}
                        ${solicitud.id_credencial ? `
                        <div class="form-group">
                            <div class="detail-label">ID Credencial</div>
                            <div class="detail-value">
                                <span class="badge success">${solicitud.id_credencial}</span>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <div class="detail-section">
                    <h4 style="color: var(--primary); margin-bottom: 1rem;">Información Personal</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <div class="detail-label">Solicitante</div>
                            <div class="detail-value">${solicitud.nombres} ${solicitud.apellidos}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Perfil Académico</div>
                            <div class="detail-value">${getPerfilAcademicoTexto(solicitud.perfil_academico)}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Correo</div>
                            <div class="detail-value">${solicitud.correo}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Teléfono</div>
                            <div class="detail-value">${solicitud.telefono}</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4 style="color: var(--primary); margin-bottom: 1rem;">Información de Viaje</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <div class="detail-label">Escuela de Procedencia</div>
                            <div class="detail-value">${solicitud.escuela_procedencia}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Terminal</div>
                            <div class="detail-value">${solicitud.terminal?.nombre || 'No asignada'}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Lugar de Residencia</div>
                            <div class="detail-value">${solicitud.lugar_residencia}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Lugar de Origen</div>
                            <div class="detail-value">${solicitud.lugar_origen}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Lugar que Viaja Frecuente</div>
                            <div class="detail-value">${solicitud.lugar_viaja_frecuente}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Veces por Semana</div>
                            <div class="detail-value">${solicitud.veces_semana}</div>
                        </div>
                        <div class="form-group">
                            <div class="detail-label">Día de la Semana</div>
                            <div class="detail-value">${getDiaSemanaTexto(solicitud.dia_semana_viaja)}</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4 style="color: var(--primary); margin-bottom: 1rem;">Documentos Adjuntos</h4>
                    <div class="document-grid">
                        <div class="document-item">
                            <i class="fas fa-file-pdf fa-2x" style="color: #dc3545;"></i>
                            <div class="detail-label">CURP</div>
                            <button class="btn sm primary view-detail-file" data-field="curp" data-id="${solicitud.id}">
                                <i class="fas fa-eye"></i> Ver Documento
                            </button>
                        </div>
                        <div class="document-item">
                            <i class="fas fa-file-image fa-2x" style="color: #28a745;"></i>
                            <div class="detail-label">Credencial</div>
                            <button class="btn sm primary view-detail-file" data-field="credencial" data-id="${solicitud.id}">
                                <i class="fas fa-eye"></i> Ver Documento
                            </button>
                        </div>
                        <div class="document-item">
                            <i class="fas fa-camera fa-2x" style="color: #007bff;"></i>
                            <div class="detail-label">Fotografía</div>
                            <button class="btn sm primary view-detail-file" data-field="fotografia" data-id="${solicitud.id}">
                                <i class="fas fa-eye"></i> Ver Documento
                            </button>
                        </div>
                        ${solicitud.voucher_pago ? `
                        <div class="document-item">
                            <i class="fas fa-receipt fa-2x" style="color: #6f42c1;"></i>
                            <div class="detail-label">Voucher de Pago</div>
                            <button class="btn sm primary view-detail-file" data-field="voucher_pago" data-id="${solicitud.id}">
                                <i class="fas fa-eye"></i> Ver Documento
                            </button>
                        </div>
                        ` : ''}
                    </div>
                </div>

                ${solicitud.motivo_baja ? `
                <div class="detail-section">
                    <h4 style="color: var(--danger); margin-bottom: 1rem;">Información de Baja</h4>
                    <div class="form-group">
                        <div class="detail-label">Motivo de Baja</div>
                        <div class="detail-value">${solicitud.motivo_baja}</div>
                    </div>
                    <div class="form-group">
                        <div class="detail-label">Fecha de Baja</div>
                        <div class="detail-value">${formatDateTime(solicitud.baja_at)}</div>
                    </div>
                </div>
                ` : ''}
            `;

            // Agregar event listeners para los botones de ver archivos en el detalle
            modalContent.querySelectorAll('.view-detail-file').forEach(button => {
                button.addEventListener('click', function() {
                    const field = this.getAttribute('data-field');
                    const id = this.getAttribute('data-id');
                    viewFile(id, field);
                });
            });

            openModal('detailModal');
        }

        function handleFormSubmit() {
            const id = document.getElementById('solicitudId').value;
            const formElement = document.getElementById('solicitudForm');
            const formData = new FormData(formElement);
            
            // Limpiar errores previos
            clearModalErrors();

            // Validación básica de campos requeridos para nuevas solicitudes
            if (!id) {
                const curpFile = document.getElementById('curp').files[0];
                const credencialFile = document.getElementById('credencial').files[0];
                const fotografiaFile = document.getElementById('fotografia').files[0];
                
                if (!curpFile || !credencialFile || !fotografiaFile) {
                    showModalAlert('error', 'Los archivos de CURP, Credencial y Fotografía son obligatorios para nuevas solicitudes');
                    return;
                }
            }

            // Detectar si se está subiendo un voucher
            const voucherFile = document.getElementById('voucher_pago').files[0];
            if (voucherFile) {
                if (!confirm('Se detectó un voucher de pago. Al guardar, el estado se cambiará automáticamente a PAGADO. ¿Continuar?')) {
                    return;
                }
            }

            // Agregar el método PUT para Laravel si es una actualización
            if (id) {
                formData.append('_method', 'PUT');
            }

            if (id) {
                updateSolicitud(id, formData);
            } else {
                createSolicitud(formData);
            }
        }

        // ===== EVENT LISTENERS =====
        function setupEventListeners() {
            // Botón agregar solicitud
            document.getElementById('addSolicitud').addEventListener('click', openCreateModal);
            document.getElementById('addFirstSolicitud').addEventListener('click', openCreateModal);

            // Botón refrescar
           // document.getElementById('refreshSolicitudes').addEventListener('click', loadSolicitudes);
            document.getElementById('refreshSolicitudes').addEventListener('click', refreshData);

            // Guardar solicitud
            document.getElementById('saveSolicitud').addEventListener('click', handleFormSubmit);

            // Confirmar acción
            document.getElementById('confirmAction').addEventListener('click', function() {
                const motivo = document.getElementById('motivo_baja').value;
                if (!motivo.trim()) {
                    showAlert('error', 'Debe ingresar el motivo de la baja');
                    return;
                }
                
                if (currentAction === 'delete' && currentSolicitudId) {
                    deleteSolicitud(currentSolicitudId, motivo);
                }
            });

            // Cambio de estado para mostrar/ocultar campos condicionales
            estadoSelect.addEventListener('change', function() {
                const selectedEstadoId = this.value;
                console.log("Select de estado cambiado a:", selectedEstadoId);
                
                // Pequeño delay para asegurar que el valor se actualizó
                setTimeout(() => {
                    toggleConditionalFields(selectedEstadoId);
                }, 10);
            });
            // Búsqueda
            setupSearch();

            // Configurar manejo de archivos
            setupFileInputs();

            // Cerrar modales
            document.querySelectorAll('.modal-close, .modal-overlay, .btn[data-modal]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal');
                    closeModal(modalId);
                });
            });

            // Event delegation para botones de la tabla
            document.getElementById('solicitudesTableBody').addEventListener('click', function(e) {
                const target = e.target.closest('button');
                if (!target) return;

                if (target.classList.contains('view-solicitud')) {
                    const id = target.getAttribute('data-id');
                    viewSolicitud(id);
                } else if (target.classList.contains('edit-solicitud')) {
                    const solicitud = {
                        id: target.getAttribute('data-id'),
                        folio: target.getAttribute('data-folio'),
                        nombres: target.getAttribute('data-nombres'),
                        apellidos: target.getAttribute('data-apellidos'),
                        perfil_academico: target.getAttribute('data-perfil_academico'),
                        escuela_procedencia: target.getAttribute('data-escuela_procedencia'),
                        lugar_residencia: target.getAttribute('data-lugar_residencia'),
                        lugar_origen: target.getAttribute('data-lugar_origen'),
                        lugar_viaja_frecuente: target.getAttribute('data-lugar_viaja_frecuente'),
                        terminalesId: target.getAttribute('data-terminalesid'),
                        veces_semana: target.getAttribute('data-veces_semana'),
                        dia_semana_viaja: target.getAttribute('data-dia_semana_viaja'),
                        curp: target.getAttribute('data-curp'),
                        credencial: target.getAttribute('data-credencial'),
                        fotografia: target.getAttribute('data-fotografia'),
                        voucher_pago: target.getAttribute('data-voucher_pago'),
                        correo: target.getAttribute('data-correo'),
                        telefono: target.getAttribute('data-telefono'),
                        formaPago: target.getAttribute('data-formapago'),
                        solicitudes_estadosId: target.getAttribute('data-solicitudes_estadosid'),
                        vigencia: target.getAttribute('data-vigencia'),
                        id_credencial: target.getAttribute('data-id_credencial')
                    };
                    openEditModal(solicitud);
                } else if (target.classList.contains('delete-solicitud')) {
                    const id = target.getAttribute('data-id');
                    const folio = target.getAttribute('data-folio');
                    openDeleteModal(id, folio);
                }  else if (target.classList.contains('download-credencial')) {
                    const id = target.getAttribute('data-id');
                    const folio = target.getAttribute('data-folio');
                    descargarCredencial(id, folio);
                }
            });

            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay.show').forEach(modal => {
                        modal.classList.remove('show');
                    });
                }
            });
        }

        // ===== UTILIDADES =====
        function showLoading() {
            loadingSolicitudes.style.display = 'block';
            solicitudesTableBody.innerHTML = '';
            emptyState.style.display = 'none';
        }

        function hideLoading() {
            loadingSolicitudes.style.display = 'none';
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
            currentSolicitudId = null;
            currentAction = '';
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES');
        }

        function formatDateTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleString('es-ES');
        }

        function getPerfilAcademicoTexto(perfilId) {
            const perfil = formData.perfiles_academicos.find(p => p.id == perfilId);
            return perfil ? perfil.nombre : 'Desconocido';
        }

        function getDiaSemanaTexto(diaId) {
            const dia = formData.dias_semana.find(d => d.id == diaId);
            return dia ? dia.nombre : 'Desconocido';
        }

        function getFormaPagoTexto(pagoId) {
            const pago = formData.formas_pago.find(p => p.id == pagoId);
            return pago ? pago.nombre : 'Desconocido';
        }

        function showAlert(type, message, title = null) {
            const alertTypes = {
                info: { class: 'primary', icon: 'fa-info-circle', defaultTitle: 'Información' },
                success: { class: 'success', icon: 'fa-check-circle', defaultTitle: 'Éxito' },
                warning: { class: 'warning', icon: 'fa-exclamation-triangle', defaultTitle: 'Advertencia' },
                error: { class: 'danger', icon: 'fa-times-circle', defaultTitle: 'Error' }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;
            const alertTitle = title || alertConfig.defaultTitle;

            const alertHTML = `
                <div class="alert ${alertConfig.class}">
                    <i class="fas ${alertConfig.icon} alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">${alertTitle}</h4>
                        <p class="alert-message">${message}</p>
                    </div>
                    <button class="alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            // Insertar al inicio del contenido
            const sectionContent = document.querySelector('.section-content');
            sectionContent.insertAdjacentHTML('afterbegin', alertHTML);

            // Agregar evento al botón de cerrar
            sectionContent.querySelector('.alert:first-child .alert-close').addEventListener('click', function() {
                this.closest('.alert').style.display = 'none';
            });

            // Auto-remover después de 5 segundos
            setTimeout(() => {
                const alert = sectionContent.querySelector('.alert:first-child');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        }

        function clearFormFeedback() {
            // Limpiar estilos de validación si los hay
            const inputs = document.querySelectorAll('#solicitudForm .form-control');
            inputs.forEach(input => {
                input.style.borderColor = '';
            });
        }

        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredSolicitudes = solicitudes.filter(solicitud => 
                    solicitud.folio.toLowerCase().includes(searchTerm) ||
                    solicitud.nombres.toLowerCase().includes(searchTerm) ||
                    solicitud.apellidos.toLowerCase().includes(searchTerm) ||
                    solicitud.correo.toLowerCase().includes(searchTerm) ||
                    solicitud.escuela_procedencia.toLowerCase().includes(searchTerm) ||
                    (solicitud.id_credencial && solicitud.id_credencial.toLowerCase().includes(searchTerm))
                );
                renderSolicitudes(filteredSolicitudes);
            });
        }

        function resetFormAndPreviews() {
            document.getElementById('solicitudForm').reset();
            document.getElementById('solicitudId').value = '';
            document.getElementById('folio').value = 'Se generará automáticamente';
            
            // Resetear previews de archivos
            document.querySelectorAll('.file-info').forEach(info => {
                info.textContent = 'No se ha cargado archivo';
            });
            
            // Ocultar botones de ver archivo
            document.querySelectorAll('.view-file').forEach(btn => {
                btn.style.display = 'none';
            });
            
            // Remover previews de imágenes
            document.querySelectorAll('.file-preview img').forEach(img => {
                img.remove();
            });
            
            // Resetear campos condicionales
            document.getElementById('vigenciaField').classList.remove('show');
            document.getElementById('idCredencialField').classList.remove('show');
        }

        function descargarCredencial(id, folio) {
            window.open(`/api/solicitudes/${id}/descargar-credencial`, '_blank');
        }



    });
</script>
@endpush