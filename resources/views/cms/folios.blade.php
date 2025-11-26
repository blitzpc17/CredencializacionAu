@extends('cms.layout')

@push('css')
<style>
    .folios-container {
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

    .btn-icon.danger {
        color: var(--danger);
    }

    .btn-icon.danger:hover {
        background: rgba(220, 53, 69, 0.1);
    }

    /* Formularios */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

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

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
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
    <h1 class="page-title">Gestión de Folios</h1>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Configuración</a></li>
                <li class="breadcrumb-item active">Folios</li>
            </ol>
        </nav>
    </div>

    <div class="folios-container">
        <!-- Sección de Lista de Folios -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Configuración de Folios</h2>
                <p class="section-description">Gestiona los consecutivos de folios por proceso</p>
            </div>
            <div class="section-content">
                <!-- Controles de la tabla -->
                <div class="datatable-controls">
                    <div class="datatable-search">
                        <input type="text" class="form-control" placeholder="Buscar folios..." id="searchFolios">
                    </div>
                    <div class="datatable-actions">
                        <button class="btn primary sm" id="refreshFolios">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button class="btn success sm" id="addFolio">
                            <i class="fas fa-plus"></i> Nuevo Folio
                        </button>
                    </div>
                </div>

                <!-- Tabla de folios -->
                <div class="table-responsive">
                    <table class="table" id="foliosTable">
                        <thead>
                            <tr>
                                <th>Proceso</th>
                                <th>Auxiliar</th>
                                <th>Consecutivo</th>                             
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="foliosTableBody">
                            <!-- Los datos se cargan via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-file-alt"></i>
                    <h3>No hay folios</h3>
                    <p>No se han configurado folios en el sistema.</p>
                    <button class="btn primary mt-3" id="addFirstFolio">
                        <i class="fas fa-plus"></i> Crear Primer Folio
                    </button>
                </div>

                <!-- Loading -->
                <div class="loading" id="loadingFolios">
                    <i class="fas fa-spinner"></i>
                    <p>Cargando folios...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar folio -->
<div class="modal-overlay" id="folioModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Nuevo Folio</h3>
            <button class="modal-close" data-modal="folioModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="folioForm">
                <input type="hidden" id="folioId">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="proceso">Proceso *</label>
                        <input type="text" class="form-control" id="proceso" 
                               placeholder="Ej: Credencialización" required>
                        <div class="form-feedback" id="procesoFeedback"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="auxiliar">Auxiliar *</label>
                        <input type="text" class="form-control" id="auxiliar" 
                               placeholder="Ej: CR" maxlength="2" required>
                        <div class="form-feedback" id="auxiliarFeedback"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="consecutivo">Consecutivo *</label>
                        <input type="number" class="form-control" id="consecutivo" 
                               placeholder="Ej: 1" min="0" required>
                        <div class="form-feedback" id="consecutivoFeedback"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="folioModal">Cancelar</button>
            <button class="btn primary" id="saveFolio">
                <i class="fas fa-save"></i> Guardar Folio
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
                    <p class="alert-message" id="confirmMessage">¿Estás seguro de que quieres eliminar este folio?</p>
                </div>
            </div>
            <p>Folio a eliminar: <strong id="folioToDelete"></strong></p>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables globales
        let folios = [];
        let currentFolioId = null;

        // Elementos del DOM
        const foliosTableBody = document.getElementById('foliosTableBody');
        const emptyState = document.getElementById('emptyState');
        const loadingFolios = document.getElementById('loadingFolios');
        const searchInput = document.getElementById('searchFolios');
        const folioForm = document.getElementById('folioForm');
        const folioModal = document.getElementById('folioModal');
        const confirmModal = document.getElementById('confirmModal');

        // ===== INICIALIZACIÓN =====
        initializeFolios();

        function initializeFolios() {
            loadFolios();
            setupEventListeners();
        }

        // ===== CARGAR FOLIOS =====
        function loadFolios() {
            showLoading();
            
            $.ajax({
                url: '/api/folios',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        folios = response.data;
                        renderFolios(folios);
                    } else {
                        showAlert('error', 'Error al cargar los folios: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar los folios';
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

        // ===== RENDERIZAR FOLIOS =====
        function renderFolios(foliosList) {
            if (foliosList.length === 0) {
                foliosTableBody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            
            const html = foliosList.map(folio => `
                <tr>
                    <td>${folio.proceso}</td>
                    <td><span class="badge primary">${folio.auxiliar}</span></td>
                    <td><strong>${folio.consecutivo}</strong></td>                   
                    <td>
                        <button class="btn-icon edit-folio" 
                                data-id="${folio.id}"
                                data-proceso="${folio.proceso}"
                                data-auxiliar="${folio.auxiliar}"
                                data-consecutivo="${folio.consecutivo}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon danger delete-folio" 
                                data-id="${folio.id}" 
                                data-proceso="${folio.proceso}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            foliosTableBody.innerHTML = html;
        }

        // ===== BÚSQUEDA =====
        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredFolios = folios.filter(folio => 
                    folio.proceso.toLowerCase().includes(searchTerm) ||
                    folio.auxiliar.toLowerCase().includes(searchTerm) ||
                    folio.consecutivo.toString().includes(searchTerm) ||
                    folio.id.toString().includes(searchTerm)
                );
                renderFolios(filteredFolios);
            });
        }

        // ===== CRUD OPERATIONS =====
        function createFolio(folioData) {
            $.ajax({
                url: '/api/folios',
                method: 'POST',
                data: folioData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Folio creado correctamente');
                        closeModal('folioModal');
                        loadFolios();
                    } else {
                        showAlert('error', 'Error al crear el folio: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al crear el folio';
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

        function updateFolio(id, folioData) {
            $.ajax({
                url: `/api/folios/${id}`,
                method: 'PUT',
                data: folioData,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Folio actualizado correctamente');
                        closeModal('folioModal');
                        loadFolios();
                    } else {
                        showAlert('error', 'Error al actualizar el folio: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar el folio';
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

        function deleteFolio(id) {
            $.ajax({
                url: `/api/folios/${id}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Folio eliminado correctamente');
                        closeModal('confirmModal');
                        loadFolios();
                    } else {
                        showAlert('error', 'Error al eliminar el folio: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al eliminar el folio';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        // ===== MANEJO DE FORMULARIOS =====
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Nuevo Folio';
            document.getElementById('folioId').value = '';
            document.getElementById('proceso').value = '';
            document.getElementById('auxiliar').value = '';
            document.getElementById('consecutivo').value = '';
            clearFormFeedback();
            openModal('folioModal');
        }

        function openEditModal(folio) {
            document.getElementById('modalTitle').textContent = 'Editar Folio';
            document.getElementById('folioId').value = folio.id;
            document.getElementById('proceso').value = folio.proceso;
            document.getElementById('auxiliar').value = folio.auxiliar;
            document.getElementById('consecutivo').value = folio.consecutivo;
            clearFormFeedback();
            openModal('folioModal');
        }

        function openDeleteModal(id, proceso) {
            document.getElementById('folioToDelete').textContent = proceso;
            document.getElementById('confirmMessage').textContent = 
                `¿Estás seguro de que quieres eliminar el folio "${proceso}"?`;
            currentFolioId = id;
            openModal('confirmModal');
        }

        function handleFormSubmit() {
            const proceso = document.getElementById('proceso').value.trim();
            const auxiliar = document.getElementById('auxiliar').value.trim();
            const consecutivo = document.getElementById('consecutivo').value;
            const id = document.getElementById('folioId').value;

            // Validación básica
            let hasErrors = false;

            if (!proceso) {
                showFieldError('proceso', 'El proceso es obligatorio');
                hasErrors = true;
            }

            if (!auxiliar) {
                showFieldError('auxiliar', 'El auxiliar es obligatorio');
                hasErrors = true;
            } else if (auxiliar.length !== 2) {
                showFieldError('auxiliar', 'El auxiliar debe tener exactamente 2 caracteres');
                hasErrors = true;
            }

            if (!consecutivo || consecutivo < 0) {
                showFieldError('consecutivo', 'El consecutivo debe ser un número mayor o igual a 0');
                hasErrors = true;
            }

            if (hasErrors) return;

            const folioData = {
                proceso: proceso,
                auxiliar: auxiliar.toUpperCase(),
                consecutivo: parseInt(consecutivo)
            };

            if (id) {
                updateFolio(id, folioData);
            } else {
                createFolio(folioData);
            }
        }

        // ===== EVENT LISTENERS =====
        function setupEventListeners() {
            // Botón agregar folio
            document.getElementById('addFolio').addEventListener('click', openCreateModal);
            document.getElementById('addFirstFolio').addEventListener('click', openCreateModal);

            // Botón refrescar
            document.getElementById('refreshFolios').addEventListener('click', loadFolios);

            // Guardar folio
            document.getElementById('saveFolio').addEventListener('click', handleFormSubmit);

            // Confirmar eliminación
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (currentFolioId) {
                    deleteFolio(currentFolioId);
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
            document.getElementById('foliosTableBody').addEventListener('click', function(e) {
                const target = e.target.closest('button');
                if (!target) return;

                if (target.classList.contains('edit-folio')) {
                    const folio = {
                        id: target.getAttribute('data-id'),
                        proceso: target.getAttribute('data-proceso'),
                        auxiliar: target.getAttribute('data-auxiliar'),
                        consecutivo: target.getAttribute('data-consecutivo')
                    };
                    openEditModal(folio);
                } else if (target.classList.contains('delete-folio')) {
                    const id = target.getAttribute('data-id');
                    const proceso = target.getAttribute('data-proceso');
                    openDeleteModal(id, proceso);
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

            // Auto mayúsculas en auxiliar
            document.getElementById('auxiliar').addEventListener('input', function(e) {
                this.value = this.value.toUpperCase();
            });
        }

        // ===== UTILIDADES =====
        function showLoading() {
            loadingFolios.style.display = 'block';
            foliosTableBody.innerHTML = '';
            emptyState.style.display = 'none';
        }

        function hideLoading() {
            loadingFolios.style.display = 'none';
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
            currentFolioId = null;
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES') + ' ' + date.toLocaleTimeString('es-ES');
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
            
            if (input) {
                input.style.borderColor = 'var(--danger)';
            }
            if (feedback) {
                feedback.className = 'form-feedback error';
                feedback.innerHTML = `<i class="fas fa-times-circle"></i> ${message}`;
            }
        }

        function clearFormFeedback() {
            ['proceso', 'auxiliar', 'consecutivo'].forEach(field => {
                const input = document.getElementById(field);
                const feedback = document.getElementById(field + 'Feedback');
                
                if (input) {
                    input.style.borderColor = '';
                }
                if (feedback) {
                    feedback.innerHTML = '';
                }
            });
        }
    });
</script>
@endpush