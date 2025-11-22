@extends('cms.layout')

@push('css')
<style>
    .variables-container {
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

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
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
        max-width: 600px;
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

    /* Valor truncado */
    .valor-truncado {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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

        .valor-truncado {
            max-width: 200px;
        }
    }

    @media (max-width: 480px) {
        .valor-truncado {
            max-width: 150px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Variables Globales</h1>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('cms.dash') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Configuración</a></li>
                <li class="breadcrumb-item active">Variables Globales</li>
            </ol>
        </nav>
    </div>

    <div class="variables-container">
        <!-- Sección de Lista de Variables -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Variables Globales del Sistema</h2>
                <p class="section-description">Gestiona las variables de configuración del sistema</p>
            </div>
            <div class="section-content">
                <!-- Controles de la tabla -->
                <div class="datatable-controls">
                    <div class="datatable-search">
                        <input type="text" class="form-control" placeholder="Buscar variables..." id="searchVariables">
                    </div>
                    <div class="datatable-actions">
                        <button class="btn primary sm" id="refreshVariables">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button class="btn success sm" id="addVariable">
                            <i class="fas fa-plus"></i> Nueva Variable
                        </button>
                    </div>
                </div>

                <!-- Tabla de variables -->
                <div class="table-responsive">
                    <table class="table" id="variablesTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="variablesTableBody">
                            <!-- Los datos se cargan via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-cogs"></i>
                    <h3>No hay variables</h3>
                    <p>No se han configurado variables globales en el sistema.</p>
                    <button class="btn primary mt-3" id="addFirstVariable">
                        <i class="fas fa-plus"></i> Crear Primera Variable
                    </button>
                </div>

                <!-- Loading -->
                <div class="loading" id="loadingVariables">
                    <i class="fas fa-spinner"></i>
                    <p>Cargando variables...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar variable -->
<div class="modal-overlay" id="variableModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Nueva Variable</h3>
            <button class="modal-close" data-modal="variableModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="variableForm">
                <input type="hidden" id="variableId">
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" 
                           placeholder="Ej: nombre_sistema, smtp_host, etc." required>
                    <small class="text-muted">Usa snake_case para los nombres (ej: nombre_variable)</small>
                </div>
                <div class="form-group">
                    <label class="form-label" for="valor">Valor *</label>
                    <textarea class="form-control" id="valor" 
                              placeholder="Valor de la variable..." 
                              rows="6" required></textarea>
                    <small class="text-muted">Puede ser texto plano o JSON para valores complejos</small>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="variableModal">Cancelar</button>
            <button class="btn primary" id="saveVariable">
                <i class="fas fa-save"></i> Guardar Variable
            </button>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" style="color: var(--danger);">
                <i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación
            </h3>
            <button class="modal-close" data-modal="confirmModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert danger">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <div class="alert-content">
                    <h4 class="alert-title">¡Atención!</h4>
                    <p class="alert-message" id="confirmMessage">¿Estás seguro de que quieres eliminar esta variable?</p>
                </div>
            </div>
            <p>Variable a eliminar: <strong id="variableToDelete"></strong></p>
            <div class="alert warning mt-3">
                <i class="fas fa-exclamation-triangle alert-icon"></i>
                <div class="alert-content">
                    <p class="alert-message">Esta acción no se puede deshacer. Algunas variables pueden ser críticas para el funcionamiento del sistema.</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="confirmModal">Cancelar</button>
            <button class="btn danger" id="confirmDelete">
                <i class="fas fa-trash"></i> Eliminar Permanentemente
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
        let variables = [];
        let currentVariableId = null;

        // Elementos del DOM
        const variablesTableBody = document.getElementById('variablesTableBody');
        const emptyState = document.getElementById('emptyState');
        const loadingVariables = document.getElementById('loadingVariables');
        const searchInput = document.getElementById('searchVariables');
        const variableForm = document.getElementById('variableForm');
        const variableModal = document.getElementById('variableModal');
        const confirmModal = document.getElementById('confirmModal');

        // ===== INICIALIZACIÓN =====
        initializeVariables();

        function initializeVariables() {
            loadVariables();
            setupEventListeners();
        }

        // ===== CARGAR VARIABLES =====
        function loadVariables() {
            showLoading();
            
            $.ajax({
                url: '/api/variables-globales',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        variables = response.data;
                        renderVariables(variables);
                    } else {
                        showAlert('error', 'Error al cargar las variables: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar las variables';
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

        // ===== RENDERIZAR VARIABLES =====
        function renderVariables(variablesList) {
            if (variablesList.length === 0) {
                variablesTableBody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            
            const html = variablesList.map(variable => `
                <tr>
                    <td>
                        <strong>${variable.nombre}</strong>
                    </td>
                    <td>
                        <div class="valor-truncado" title="${variable.valor}">
                            ${variable.valor}
                        </div>
                    </td>
                    <td>
                        <button class="btn-icon edit-variable" 
                                data-id="${variable.id}"
                                data-nombre="${variable.nombre}"
                                data-valor="${variable.valor}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon danger delete-variable" 
                                data-id="${variable.id}" 
                                data-nombre="${variable.nombre}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            variablesTableBody.innerHTML = html;
        }

        // ===== BÚSQUEDA =====
        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredVariables = variables.filter(variable => 
                    variable.nombre.toLowerCase().includes(searchTerm) ||
                    variable.valor.toLowerCase().includes(searchTerm) ||
                    variable.id.toString().includes(searchTerm)
                );
                renderVariables(filteredVariables);
            });
        }

        // ===== CRUD OPERATIONS =====
        function createVariable(variableData) {
            $.ajax({
                url: '/api/variables-globales',
                method: 'POST',
                data: variableData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Variable creada correctamente');
                        closeModal('variableModal');
                        loadVariables();
                    } else {
                        showAlert('error', 'Error al crear la variable: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al crear la variable';
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

        function updateVariable(id, variableData) {
            $.ajax({
                url: `/api/variables-globales/${id}`,
                method: 'PUT',
                data: variableData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Variable actualizada correctamente');
                        closeModal('variableModal');
                        loadVariables();
                    } else {
                        showAlert('error', 'Error al actualizar la variable: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar la variable';
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

        function deleteVariable(id) {
            $.ajax({
                url: `/api/variables-globales/${id}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Variable eliminada correctamente');
                        closeModal('confirmModal');
                        loadVariables();
                    } else {
                        showAlert('error', 'Error al eliminar la variable: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al eliminar la variable';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        // ===== MANEJO DE FORMULARIOS =====
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Nueva Variable';
            document.getElementById('variableId').value = '';
            document.getElementById('variableForm').reset();
            clearFormFeedback();
            openModal('variableModal');
        }

        function openEditModal(variable) {
            document.getElementById('modalTitle').textContent = 'Editar Variable';
            document.getElementById('variableId').value = variable.id;
            document.getElementById('nombre').value = variable.nombre;
            document.getElementById('valor').value = variable.valor;
            
            clearFormFeedback();
            openModal('variableModal');
        }

        function openDeleteModal(id, nombre) {
            document.getElementById('variableToDelete').textContent = nombre;
            document.getElementById('confirmMessage').textContent = 
                `¿Estás seguro de que quieres eliminar la variable "${nombre}"?`;
            currentVariableId = id;
            openModal('confirmModal');
        }

        function handleFormSubmit() {
            const id = document.getElementById('variableId').value;
            const nombre = document.getElementById('nombre').value.trim();
            const valor = document.getElementById('valor').value.trim();

            // Validación básica
            if (!nombre) {
                showAlert('error', 'El nombre de la variable es obligatorio');
                return;
            }
            if (!valor) {
                showAlert('error', 'El valor de la variable es obligatorio');
                return;
            }

            const variableData = { nombre, valor };

            if (id) {
                updateVariable(id, variableData);
            } else {
                createVariable(variableData);
            }
        }

        // ===== EVENT LISTENERS =====
        function setupEventListeners() {
            // Botón agregar variable
            document.getElementById('addVariable').addEventListener('click', openCreateModal);
            document.getElementById('addFirstVariable').addEventListener('click', openCreateModal);

            // Botón refrescar
            document.getElementById('refreshVariables').addEventListener('click', loadVariables);

            // Guardar variable
            document.getElementById('saveVariable').addEventListener('click', handleFormSubmit);

            // Confirmar eliminación
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (currentVariableId) {
                    deleteVariable(currentVariableId);
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

            // Event delegation para botones de editar/eliminar
            document.getElementById('variablesTableBody').addEventListener('click', function(e) {
                const target = e.target.closest('button');
                if (!target) return;

                if (target.classList.contains('edit-variable')) {
                    const variable = {
                        id: target.getAttribute('data-id'),
                        nombre: target.getAttribute('data-nombre'),
                        valor: target.getAttribute('data-valor')
                    };
                    openEditModal(variable);
                } else if (target.classList.contains('delete-variable')) {
                    const id = target.getAttribute('data-id');
                    const nombre = target.getAttribute('data-nombre');
                    openDeleteModal(id, nombre);
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

            // Enter en el formulario
            document.getElementById('valor').addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.ctrlKey) {
                    e.preventDefault();
                    handleFormSubmit();
                }
            });
        }

        // ===== UTILIDADES =====
        function showLoading() {
            loadingVariables.style.display = 'block';
            variablesTableBody.innerHTML = '';
            emptyState.style.display = 'none';
        }

        function hideLoading() {
            loadingVariables.style.display = 'none';
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
            currentVariableId = null;
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
            const inputs = document.querySelectorAll('#variableForm .form-control');
            inputs.forEach(input => {
                input.style.borderColor = '';
            });
        }
    });
</script>
@endpush