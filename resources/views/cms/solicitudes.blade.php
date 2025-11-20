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
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Nueva Solicitud</h3>
            <button class="modal-close" data-modal="solicitudModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="solicitudForm">
                <input type="hidden" id="solicitudId">
                <input type="hidden" id="folio" readonly>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="nombres">Nombres *</label>
                        <input type="text" class="form-control" id="nombres" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="apellidos">Apellidos *</label>
                        <input type="text" class="form-control" id="apellidos" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="perfil_academico">Perfil Académico *</label>
                        <select class="form-control" id="perfil_academico" required>
                            <option value="">Seleccione perfil</option>
                        </select>
                    </div>
                    <div class="form-group form-full-width">
                        <label class="form-label" for="escuela_procedencia">Escuela de Procedencia *</label>
                        <input type="text" class="form-control" id="escuela_procedencia" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lugar_residencia">Lugar de Residencia *</label>
                        <input type="text" class="form-control" id="lugar_residencia" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lugar_origen">Lugar de Origen *</label>
                        <input type="text" class="form-control" id="lugar_origen" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lugar_viaja_frecuente">Lugar que Viaja Frecuente *</label>
                        <input type="text" class="form-control" id="lugar_viaja_frecuente" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="terminalesId">Terminal *</label>
                        <select class="form-control" id="terminalesId" required>
                            <option value="">Seleccione terminal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="veces_semana">Veces por Semana *</label>
                        <input type="text" class="form-control" id="veces_semana" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dia_semana_viaja">Día de la Semana *</label>
                        <select class="form-control" id="dia_semana_viaja" required>
                            <option value="">Seleccione día</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="curp">CURP *</label>
                        <input type="text" class="form-control" id="curp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="credencial">Credencial *</label>
                        <input type="text" class="form-control" id="credencial" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fotografia">Fotografía *</label>
                        <input type="text" class="form-control" id="fotografia" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="correo">Correo *</label>
                        <input type="email" class="form-control" id="correo" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="telefono">Teléfono *</label>
                        <input type="text" class="form-control" id="telefono" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="formaPago">Forma de Pago *</label>
                        <select class="form-control" id="formaPago" required>
                            <option value="">Seleccione forma de pago</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="solicitudes_estadosId">Estado *</label>
                        <select class="form-control" id="solicitudes_estadosId" required>
                            <option value="">Seleccione estado</option>
                        </select>
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
    <div class="modal" style="max-width: 700px;">
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
                <i class="fas fa-exclamation-triangle"></i> Confirmar Acción
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
                    <p class="alert-message" id="confirmMessage">¿Estás seguro de que quieres realizar esta acción?</p>
                </div>
            </div>
            <p>Solicitud: <strong id="solicitudToAction"></strong></p>
            <p>Acción: <strong id="accionType"></strong></p>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="confirmModal">Cancelar</button>
            <button class="btn warning" id="confirmAction">
                <i class="fas fa-check"></i> Confirmar
            </button>
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
        const solicitudModal = document.getElementById('solicitudModal');
        const detailModal = document.getElementById('detailModal');
        const confirmModal = document.getElementById('confirmModal');

        // ===== INICIALIZACIÓN =====
        initializeSolicitudes();

        function initializeSolicitudes() {
            loadFormData();
            loadSolicitudes();
            setupEventListeners();
        }

        // ===== CARGAR DATOS DEL FORMULARIO =====
        function loadFormData() {
            $.ajax({
                url: '/api/solicitudes/form-data',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        formData = response.data;
                        renderFormSelects();
                    } else {
                        showAlert('error', 'Error al cargar los datos del formulario: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar datos del formulario';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        function renderFormSelects() {
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
                return;
            }

            emptyState.style.display = 'none';
            
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
                    <td>${solicitud.terminal?.nombre || 'N/A'}</td>
                    <td>
                        <span class="badge ${getEstadoBadgeClass(solicitud.estado?.nombre)}">
                            ${solicitud.estado?.nombre || 'Pendiente'}
                        </span>
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
                                data-correo="${solicitud.correo}"
                                data-telefono="${solicitud.telefono}"
                                data-formapago="${solicitud.formaPago}"
                                data-solicitudes_estadosid="${solicitud.solicitudes_estadosId}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon danger delete-solicitud" 
                                data-id="${solicitud.id}" 
                                data-folio="${solicitud.folio}">
                            <i class="fas fa-trash"></i>
                        </button>
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
            } else if (estado.includes('aprobado') || estado.includes('aprobada') || estado.includes('completado') || estado.includes('completada')) {
                return 'success';
            } else if (estado.includes('rechazado') || estado.includes('rechazada') || estado.includes('cancelado') || estado.includes('cancelada')) {
                return 'danger';
            } else if (estado.includes('proceso') || estado.includes('procesando')) {
                return 'info';
            } else {
                return 'primary';
            }
        }

        // ===== BÚSQUEDA =====
        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredSolicitudes = solicitudes.filter(solicitud => 
                    solicitud.folio.toLowerCase().includes(searchTerm) ||
                    solicitud.nombres.toLowerCase().includes(searchTerm) ||
                    solicitud.apellidos.toLowerCase().includes(searchTerm) ||
                    solicitud.correo.toLowerCase().includes(searchTerm) ||
                    solicitud.escuela_procedencia.toLowerCase().includes(searchTerm)
                );
                renderSolicitudes(filteredSolicitudes);
            });
        }

        // ===== CRUD OPERATIONS =====
        function createSolicitud(solicitudData) {
            $.ajax({
                url: '/api/solicitudes',
                method: 'POST',
                data: solicitudData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Solicitud creada correctamente');
                        closeModal('solicitudModal');
                        loadSolicitudes();
                    } else {
                        showAlert('error', 'Error al crear la solicitud: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al crear la solicitud';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        function updateSolicitud(id, solicitudData) {
            $.ajax({
                url: `/api/solicitudes/${id}`,
                method: 'PUT',
                data: solicitudData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Solicitud actualizada correctamente');
                        closeModal('solicitudModal');
                        loadSolicitudes();
                    } else {
                        showAlert('error', 'Error al actualizar la solicitud: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar la solicitud';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage += ': ' + Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        function deleteSolicitud(id) {
            $.ajax({
                url: `/api/solicitudes/${id}`,
                method: 'DELETE',
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
            document.getElementById('solicitudId').value = '';
            document.getElementById('folio').value = 'Se generará automáticamente';
            document.getElementById('solicitudForm').reset();
            clearFormFeedback();
            openModal('solicitudModal');
        }

        function openEditModal(solicitud) {
            document.getElementById('modalTitle').textContent = 'Editar Solicitud';
            document.getElementById('solicitudId').value = solicitud.id;
            document.getElementById('folio').value = solicitud.folio;
            
            // Llenar formulario con datos
            Object.keys(solicitud).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = solicitud[key];
                    } else {
                        element.value = solicitud[key];
                    }
                }
            });
            
            clearFormFeedback();
            openModal('solicitudModal');
        }

        function openDeleteModal(id, folio) {
            document.getElementById('solicitudToAction').textContent = folio;
            document.getElementById('accionType').textContent = 'Dar de baja';
            document.getElementById('confirmMessage').textContent = 
                `¿Estás seguro de que quieres dar de baja la solicitud ${folio}?`;
            currentSolicitudId = id;
            currentAction = 'delete';
            openModal('confirmModal');
        }

        function showDetailModal(solicitud) {
            const modalContent = document.getElementById('modalContent');
            
            modalContent.innerHTML = `
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Folio</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.folio}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div>
                            <span class="badge ${getEstadoBadgeClass(solicitud.estado?.nombre)}">
                                ${solicitud.estado?.nombre || 'Pendiente'}
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Solicitante</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${solicitud.nombres} ${solicitud.apellidos}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Perfil Académico</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${getPerfilAcademicoTexto(solicitud.perfil_academico)}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Escuela de Procedencia</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.escuela_procedencia}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Terminal</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${solicitud.terminal?.nombre || 'No asignada'}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Correo</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.correo}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.telefono}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Forma de Pago</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${getFormaPagoTexto(solicitud.formaPago)}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha de Solicitud</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${formatDateTime(solicitud.created_at)}
                        </div>
                    </div>
                </div>
            `;

            openModal('detailModal');
        }

        function handleFormSubmit() {
            const id = document.getElementById('solicitudId').value;
            const formData = new FormData(document.getElementById('solicitudForm'));
            
            // Convertir FormData a objeto
            const solicitudData = {};
            for (let [key, value] of formData.entries()) {
                if (key !== 'solicitudId' && key !== 'folio') {
                    solicitudData[key] = value;
                }
            }

            // Validación básica
            if (!solicitudData.nombres || !solicitudData.apellidos) {
                showAlert('error', 'Los nombres y apellidos son obligatorios');
                return;
            }

            if (id) {
                updateSolicitud(id, solicitudData);
            } else {
                createSolicitud(solicitudData);
            }
        }

        // ===== EVENT LISTENERS =====
        function setupEventListeners() {
            // Botón agregar solicitud
            document.getElementById('addSolicitud').addEventListener('click', openCreateModal);
            document.getElementById('addFirstSolicitud').addEventListener('click', openCreateModal);

            // Botón refrescar
            document.getElementById('refreshSolicitudes').addEventListener('click', loadSolicitudes);

            // Guardar solicitud
            document.getElementById('saveSolicitud').addEventListener('click', handleFormSubmit);

            // Confirmar acción
            document.getElementById('confirmAction').addEventListener('click', function() {
                if (currentAction === 'delete' && currentSolicitudId) {
                    deleteSolicitud(currentSolicitudId);
                }
            });

            // Búsqueda
            setupSearch();

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
                        correo: target.getAttribute('data-correo'),
                        telefono: target.getAttribute('data-telefono'),
                        formaPago: target.getAttribute('data-formapago'),
                        solicitudes_estadosId: target.getAttribute('data-solicitudes_estadosid')
                    };
                    openEditModal(solicitud);
                } else if (target.classList.contains('delete-solicitud')) {
                    const id = target.getAttribute('data-id');
                    const folio = target.getAttribute('data-folio');
                    openDeleteModal(id, folio);
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
    });
</script>
@endpush