@extends('cms.layout')

@push('css')
<style>
    .usuarios-container {
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

    /* Badges para estados */
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

    .badge.success { background: var(--success); color: white; }
    .badge.danger { background: var(--danger); color: white; }
    .badge.primary { background: var(--primary); color: white; }

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

    .btn-icon.warning {
        color: var(--warning);
    }

    .btn-icon.warning:hover {
        background: rgba(255, 193, 7, 0.1);
    }

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
        max-width: 500px;
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
    }
</style>
@endpush

@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Gestión de Usuarios</h1>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('cms.dash') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Configuración</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
        </nav>
    </div>

    <div class="usuarios-container">
        <!-- Sección de Lista de Usuarios -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Usuarios del Sistema</h2>
                <p class="section-description">Gestiona los usuarios y sus permisos en el sistema</p>
            </div>
            <div class="section-content">
                <!-- Controles de la tabla -->
                <div class="datatable-controls">
                    <div class="datatable-search">
                        <input type="text" class="form-control" placeholder="Buscar usuarios..." id="searchUsuarios">
                    </div>
                    <div class="datatable-actions">
                        <button class="btn primary sm" id="refreshUsuarios">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button class="btn success sm" id="addUsuario">
                            <i class="fas fa-plus"></i> Nuevo Usuario
                        </button>
                    </div>
                </div>

                <!-- Tabla de usuarios -->
                <div class="table-responsive">
                    <table class="table" id="usuariosTable">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Perfil</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="usuariosTableBody">
                            <!-- Los datos se cargan via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-users"></i>
                    <h3>No hay usuarios</h3>
                    <p>No se han registrado usuarios en el sistema.</p>
                    <button class="btn primary mt-3" id="addFirstUsuario">
                        <i class="fas fa-plus"></i> Crear Primer Usuario
                    </button>
                </div>

                <!-- Loading -->
                <div class="loading" id="loadingUsuarios">
                    <i class="fas fa-spinner"></i>
                    <p>Cargando usuarios...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar usuario -->
<div class="modal-overlay" id="usuarioModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Nuevo Usuario</h3>
            <button class="modal-close" data-modal="usuarioModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="usuarioForm">
                <input type="hidden" id="usuarioId">
                <div class="form-group">
                    <label class="form-label" for="nombres">Nombres *</label>
                    <input type="text" class="form-control" id="nombres" required>
                    <div class="form-feedback" id="nombresFeedback"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="apellidos">Apellidos *</label>
                    <input type="text" class="form-control" id="apellidos" required>
                    <div class="form-feedback" id="apellidosFeedback"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="usuario">Usuario *</label>
                    <input type="text" class="form-control" id="usuario" required>
                    <div class="form-feedback" id="usuarioFeedback"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="perfilesId">Perfil *</label>
                    <select class="form-control" id="perfilesId" required>
                        <option value="">Seleccione un perfil</option>
                    </select>
                    <div class="form-feedback" id="perfilesIdFeedback"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">
                        Contraseña <span id="passwordRequired">*</span>
                        <span id="passwordOptional" style="display: none; color: var(--gray); font-weight: normal;">(Opcional - dejar en blanco para mantener la actual)</span>
                    </label>
                    <input type="password" class="form-control" id="password">
                    <div class="form-feedback" id="passwordFeedback"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation">
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        <input type="checkbox" id="activo" value="1" checked>
                        <span class="checkmark"></span>
                        Usuario activo
                    </label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="usuarioModal">Cancelar</button>
            <button class="btn primary" id="saveUsuario">
                <i class="fas fa-save"></i> Guardar Usuario
            </button>
        </div>
    </div>
</div>

<!-- Modal de confirmación para cambiar estado -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" style="color: var(--warning);">
                <i class="fas fa-exclamation-triangle"></i> Confirmar Cambio de Estado
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
                    <p class="alert-message" id="confirmMessage">¿Estás seguro de que quieres cambiar el estado de este usuario?</p>
                </div>
            </div>
            <p>Usuario: <strong id="usuarioToToggle"></strong></p>
            <p>Acción: <strong id="accionToggle"></strong></p>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="confirmModal">Cancelar</button>
            <button class="btn warning" id="confirmToggle">
                <i class="fas fa-user-check"></i> Confirmar
            </button>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let usuarios = [];
        let perfiles = [];
        let currentUsuarioId = null;

        // Elementos del DOM
        const usuariosTableBody = document.getElementById('usuariosTableBody');
        const emptyState = document.getElementById('emptyState');
        const loadingUsuarios = document.getElementById('loadingUsuarios');
        const searchInput = document.getElementById('searchUsuarios');
        const usuarioForm = document.getElementById('usuarioForm');
        const usuarioModal = document.getElementById('usuarioModal');
        const confirmModal = document.getElementById('confirmModal');
        const perfilesSelect = document.getElementById('perfilesId');

        // ===== INICIALIZACIÓN =====
        initializeUsuarios();

        function initializeUsuarios() {
            loadPerfiles();
            loadUsuarios();
            setupEventListeners();
        }

        // ===== CARGAR PERFILES =====
        function loadPerfiles() {
            $.ajax({
                url: '/api/perfiles',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        perfiles = response.data;
                        renderPerfilesSelect();
                    } else {
                        showAlert('error', 'Error al cargar los perfiles: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar los perfiles';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        function renderPerfilesSelect() {
            perfilesSelect.innerHTML = '<option value="">Seleccione un perfil</option>';
            perfiles.forEach(perfil => {
                const option = document.createElement('option');
                option.value = perfil.id;
                option.textContent = perfil.nombre;
                perfilesSelect.appendChild(option);
            });
        }

        // ===== CARGAR USUARIOS =====
        function loadUsuarios() {
            showLoading();
            
            $.ajax({
                url: '/api/usuarios',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        usuarios = response.data;
                        renderUsuarios(usuarios);
                    } else {
                        showAlert('error', 'Error al cargar los usuarios: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar los usuarios';
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

        // ===== RENDERIZAR USUARIOS =====
        function renderUsuarios(usuariosList) {
            if (usuariosList.length === 0) {
                usuariosTableBody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            
            const html = usuariosList.map(usuario => `
                <tr>
                    <td>
                        <div>
                            <strong>${usuario.nombres} ${usuario.apellidos}</strong><br>
                            <small class="text-muted">@${usuario.usuario}</small>
                        </div>
                    </td>
                    <td>
                        <span class="badge primary">
                            ${usuario.perfil?.nombre || 'N/A'}
                        </span>
                    </td>
                    <td>
                        <span class="badge ${usuario.activo ? 'success' : 'danger'}">
                            ${usuario.activo ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td>
                        <button class="btn-icon edit-usuario" 
                                data-id="${usuario.id}" 
                                data-nombres="${usuario.nombres}"
                                data-apellidos="${usuario.apellidos}"
                                data-usuario="${usuario.usuario}"
                                data-perfilesid="${usuario.perfilesId}"
                                data-activo="${usuario.activo}">
                            <i class="fas fa-edit"></i>
                        </button>
                        ${usuario.id !== {{ /*auth()->id()*/1 }} ? `
                            <button class="btn-icon warning toggle-usuario" 
                                    data-id="${usuario.id}" 
                                    data-nombre="${usuario.nombres} ${usuario.apellidos}"
                                    data-activo="${usuario.activo}">
                                <i class="fas fa-${usuario.activo ? 'user-slash' : 'user-check'}"></i>
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');

            usuariosTableBody.innerHTML = html;
        }

        // ===== BÚSQUEDA =====
        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredUsuarios = usuarios.filter(usuario => 
                    usuario.nombres.toLowerCase().includes(searchTerm) ||
                    usuario.apellidos.toLowerCase().includes(searchTerm) ||
                    usuario.usuario.toLowerCase().includes(searchTerm) ||
                    usuario.perfil?.nombre.toLowerCase().includes(searchTerm) ||
                    usuario.id.toString().includes(searchTerm)
                );
                renderUsuarios(filteredUsuarios);
            });
        }

        // ===== CRUD OPERATIONS =====
        function createUsuario(usuarioData) {
            $.ajax({
                url: '/api/usuarios',
                method: 'POST',
                data: usuarioData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Usuario creado correctamente');
                        closeModal('usuarioModal');
                        loadUsuarios();
                    } else {
                        showAlert('error', 'Error al crear el usuario: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al crear el usuario';
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

        function updateUsuario(id, usuarioData) {
            $.ajax({
                url: `/api/usuarios/${id}`,
                method: 'PUT',
                data: usuarioData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Usuario actualizado correctamente');
                        closeModal('usuarioModal');
                        loadUsuarios();
                    } else {
                        showAlert('error', 'Error al actualizar el usuario: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar el usuario';
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

        function toggleUsuarioStatus(id) {
            $.ajax({
                url: `/api/usuarios/${id}/toggle-status`,
                method: 'PUT',
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        closeModal('confirmModal');
                        loadUsuarios();
                    } else {
                        showAlert('error', 'Error al cambiar el estado: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cambiar el estado';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        // ===== MANEJO DE FORMULARIOS =====
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Nuevo Usuario';
            document.getElementById('usuarioId').value = '';
            document.getElementById('usuarioForm').reset();
            
            // Mostrar campos de contraseña como requeridos
            document.getElementById('passwordRequired').style.display = 'inline';
            document.getElementById('passwordOptional').style.display = 'none';
            document.getElementById('password').required = true;
            document.getElementById('password_confirmation').required = true;
            
            clearFormFeedback();
            openModal('usuarioModal');
        }

        function openEditModal(usuario) {
            document.getElementById('modalTitle').textContent = 'Editar Usuario';
            document.getElementById('usuarioId').value = usuario.id;
            document.getElementById('nombres').value = usuario.nombres;
            document.getElementById('apellidos').value = usuario.apellidos;
            document.getElementById('usuario').value = usuario.usuario;
            document.getElementById('perfilesId').value = usuario.perfilesId;
            document.getElementById('activo').checked = usuario.activo;
            
            // Limpiar campos de contraseña y hacerlos opcionales
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('passwordOptional').style.display = 'inline';
            document.getElementById('password').required = false;
            document.getElementById('password_confirmation').required = false;
            
            clearFormFeedback();
            openModal('usuarioModal');
        }

        function openToggleModal(id, nombre, activo) {
            const accion = activo ? 'desactivar' : 'activar';
            const mensaje = activo ? 
                '¿Estás seguro de que deseas desactivar este usuario? El usuario no podrá acceder al sistema.' :
                '¿Estás seguro de que deseas activar este usuario? El usuario podrá acceder al sistema nuevamente.';
            
            document.getElementById('usuarioToToggle').textContent = nombre;
            document.getElementById('accionToggle').textContent = accion.charAt(0).toUpperCase() + accion.slice(1);
            document.getElementById('confirmMessage').textContent = mensaje;
            currentUsuarioId = id;
            openModal('confirmModal');
        }

        function handleFormSubmit() {
            const id = document.getElementById('usuarioId').value;
            const nombres = document.getElementById('nombres').value.trim();
            const apellidos = document.getElementById('apellidos').value.trim();
            const usuario = document.getElementById('usuario').value.trim();
            const perfilesId = document.getElementById('perfilesId').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const activo = document.getElementById('activo').checked;

            // Validación básica
            if (!nombres) {
                showFieldError('nombres', 'Los nombres son obligatorios');
                return;
            }
            if (!apellidos) {
                showFieldError('apellidos', 'Los apellidos son obligatorios');
                return;
            }
            if (!usuario) {
                showFieldError('usuario', 'El usuario es obligatorio');
                return;
            }
            if (!perfilesId) {
                showFieldError('perfilesId', 'El perfil es obligatorio');
                return;
            }
            if (!id && !password) {
                showFieldError('password', 'La contraseña es obligatoria para nuevos usuarios');
                return;
            }
            if (password && password !== passwordConfirmation) {
                showFieldError('password_confirmation', 'Las contraseñas no coinciden');
                return;
            }

            const usuarioData = { 
                nombres, 
                apellidos, 
                usuario, 
                perfilesId, 
                activo: activo ? 1 : 0
            };

            // Solo incluir contraseña si se proporcionó
            if (password) {
                usuarioData.password = password;
                usuarioData.password_confirmation = passwordConfirmation;
            }

            if (id) {
                updateUsuario(id, usuarioData);
            } else {
                createUsuario(usuarioData);
            }
        }

        // ===== EVENT LISTENERS =====
        function setupEventListeners() {
            // Botón agregar usuario
            document.getElementById('addUsuario').addEventListener('click', openCreateModal);
            document.getElementById('addFirstUsuario').addEventListener('click', openCreateModal);

            // Botón refrescar
            document.getElementById('refreshUsuarios').addEventListener('click', loadUsuarios);

            // Guardar usuario
            document.getElementById('saveUsuario').addEventListener('click', handleFormSubmit);

            // Confirmar cambio de estado
            document.getElementById('confirmToggle').addEventListener('click', function() {
                if (currentUsuarioId) {
                    toggleUsuarioStatus(currentUsuarioId);
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

            // Event delegation para botones de editar/cambiar estado
            document.getElementById('usuariosTableBody').addEventListener('click', function(e) {
                const target = e.target.closest('button');
                if (!target) return;

                if (target.classList.contains('edit-usuario')) {
                    const usuario = {
                        id: target.getAttribute('data-id'),
                        nombres: target.getAttribute('data-nombres'),
                        apellidos: target.getAttribute('data-apellidos'),
                        usuario: target.getAttribute('data-usuario'),
                        perfilesId: target.getAttribute('data-perfilesid'),
                        activo: target.getAttribute('data-activo') === 'true'
                    };
                    openEditModal(usuario);
                } else if (target.classList.contains('toggle-usuario')) {
                    const id = target.getAttribute('data-id');
                    const nombre = target.getAttribute('data-nombre');
                    const activo = target.getAttribute('data-activo') === 'true';
                    openToggleModal(id, nombre, activo);
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
            loadingUsuarios.style.display = 'block';
            usuariosTableBody.innerHTML = '';
            emptyState.style.display = 'none';
        }

        function hideLoading() {
            loadingUsuarios.style.display = 'none';
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
            currentUsuarioId = null;
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES');
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

        function showFieldError(field, message) {
            const input = document.getElementById(field);
            const feedback = document.getElementById(field + 'Feedback');
            
            input.style.borderColor = 'var(--danger)';
            feedback.className = 'form-feedback error';
            feedback.innerHTML = `<i class="fas fa-times-circle"></i> ${message}`;
        }

        function clearFormFeedback() {
            const fields = ['nombres', 'apellidos', 'usuario', 'perfilesId', 'password', 'password_confirmation'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                const feedback = document.getElementById(field + 'Feedback');
                if (input) input.style.borderColor = '';
                if (feedback) feedback.innerHTML = '';
            });
        }
    });
</script>
@endpush