@extends('cms.layout')

@push('css')
<style>
    .horarios-container {
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

    /* Imagen en tabla */
    .table-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid #e9ecef;
    }

    .table-image-placeholder {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
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
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
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
        resize: vertical;
        min-height: 100px;
    }

    /* File Input */
    .file-input-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input {
        position: absolute;
        left: -9999px;
        opacity: 0;
    }

    .file-input-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        background: #f8f9fa;
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
        gap: 1rem;
    }

    .file-input-label:hover {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.05);
    }

    .file-input-label.dragover {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.1);
        transform: scale(1.02);
    }

    .file-input-icon {
        font-size: 2.5rem;
        color: var(--primary);
    }

    .file-input-text h4 {
        margin: 0 0 0.5rem 0;
        color: var(--dark);
        font-size: 1.1rem;
    }

    .file-input-text p {
        margin: 0;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .file-preview {
        margin-top: 1rem;
        display: none;
    }

    .file-preview.show {
        display: block;
    }

    .file-preview-image {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
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

        .table-image, .table-image-placeholder {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Horarios de Credencialización</h1>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Administración</a></li>
                <li class="breadcrumb-item active">Horarios Credencialización</li>
            </ol>
        </nav>
    </div>

    <div class="horarios-container">
        <!-- Sección de Lista de Horarios -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Horarios de Credencialización</h2>
                <p class="section-description">Gestiona los horarios y lugares para la credencialización</p>
            </div>
            <div class="section-content">
                <!-- Controles de la tabla -->
                <div class="datatable-controls">
                    <div class="datatable-search">
                        <input type="text" class="form-control" placeholder="Buscar horarios..." id="searchHorarios">
                    </div>
                    <div class="datatable-actions">
                        <button class="btn primary sm" id="refreshHorarios">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button class="btn success sm" id="addHorario">
                            <i class="fas fa-plus"></i> Nuevo Horario
                        </button>
                    </div>
                </div>

                <!-- Tabla de horarios -->
                <div class="table-responsive">
                    <table class="table" id="horariosTable">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Fecha</th>
                                <th>Lugar</th>
                                <th>Horario</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="horariosTableBody">
                            <!-- Los datos se cargan via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>No hay horarios</h3>
                    <p>No se han encontrado horarios de credencialización en el sistema.</p>
                    <button class="btn primary mt-3" id="addFirstHorario">
                        <i class="fas fa-plus"></i> Crear Primer Horario
                    </button>
                </div>

                <!-- Loading -->
                <div class="loading" id="loadingHorarios">
                    <i class="fas fa-spinner"></i>
                    <p>Cargando horarios...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar horario -->
<div class="modal-overlay" id="horarioModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Nuevo Horario</h3>
            <button class="modal-close" data-modal="horarioModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="horarioForm">
                <input type="hidden" id="horarioId">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="fecha">Fecha *</label>
                        <input type="date" class="form-control" id="fecha" 
                               placeholder="Ej: Lunes 15 de Enero 2024" required>
                        <div class="form-feedback" id="fechaFeedback"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="lugar">Lugar *</label>
                        <input type="text" class="form-control" id="lugar" 
                               placeholder="Ej: Auditorio Principal">
                        <div class="form-feedback" id="lugarFeedback"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="horario">Horario *</label>
                        <input type="text" class="form-control" id="horario" 
                               placeholder="Ej: 09:00 - 17:00">
                        <div class="form-feedback" id="horarioFeedback"></div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" 
                                  placeholder="Descripción adicional del horario..."
                                  rows="3"></textarea>
                        <div class="form-feedback" id="descripcionFeedback"></div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Imagen</label>
                        <div class="file-input-container">
                            <input type="file" class="file-input" id="imagen" accept="image/*">
                            <label for="imagen" class="file-input-label" id="imagenLabel">
                                <i class="fas fa-cloud-upload-alt file-input-icon"></i>
                                <div class="file-input-text">
                                    <h4>Subir imagen</h4>
                                    <p>Haz clic o arrastra una imagen aquí</p>
                                    <small>Formatos: JPEG, PNG, JPG, GIF (Máx. 2MB)</small>
                                </div>
                            </label>
                        </div>
                        <div class="file-preview" id="imagenPreview"></div>
                        <div class="form-feedback" id="imagenFeedback"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="horarioModal">Cancelar</button>
            <button class="btn primary" id="saveHorario">
                <i class="fas fa-save"></i> Guardar Horario
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
                    <p class="alert-message" id="confirmMessage">¿Estás seguro de que quieres eliminar este horario?</p>
                </div>
            </div>
            <p>Horario a eliminar: <strong id="horarioToDelete"></strong></p>
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
        let horarios = [];
        let currentHorarioId = null;
        let currentImageFile = null;

        // Elementos del DOM
        const horariosTableBody = document.getElementById('horariosTableBody');
        const emptyState = document.getElementById('emptyState');
        const loadingHorarios = document.getElementById('loadingHorarios');
        const searchInput = document.getElementById('searchHorarios');
        const horarioForm = document.getElementById('horarioForm');
        const horarioModal = document.getElementById('horarioModal');
        const confirmModal = document.getElementById('confirmModal');
        const imagenInput = document.getElementById('imagen');
        const imagenPreview = document.getElementById('imagenPreview');
        const imagenLabel = document.getElementById('imagenLabel');

        const IMAGE_BASE_URL = "{{ route('tools.getimagen', ['path' => '']) }}";

        // ===== INICIALIZACIÓN =====
        initializeHorarios();

        function initializeHorarios() {
            loadHorarios();
            setupEventListeners();
            setupFileInput();
        }

        // ===== CARGAR HORARIOS =====
        function loadHorarios() {
            showLoading();
            
            $.ajax({
                url: '/api/horarios-credencializacion',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        horarios = response.data;
                        renderHorarios(horarios);
                    } else {
                        showAlert('error', 'Error al cargar los horarios: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al cargar los horarios';
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

        // ===== RENDERIZAR HORARIOS =====
        function renderHorarios(horariosList) {
            if (horariosList.length === 0) {
                horariosTableBody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            
            const html = horariosList.map(horario => `
                <tr>                   
                    <td>
                        ${horario.imagen ? 
                            `<img src="${IMAGE_BASE_URL}/${horario.imagen}" alt="Imagen" class="table-image" onerror="this.style.display='none'">` :
                            `<div class="table-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>`
                        }
                    </td>
                    <td>${horario.fecha}</td>
                    <td>${horario.lugar || '-'}</td>
                    <td>${horario.horario || '-'}</td>
                    <td>
                        <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            ${horario.descripcion || '-'}
                        </div>
                    </td>
                    <td>
                        <button class="btn-icon edit-horario" 
                                data-id="${horario.id}"
                                data-fecha="${horario.fecha}"
                                data-lugar="${horario.lugar}"
                                data-horario="${horario.horario}"
                                data-descripcion="${horario.descripcion}"
                                data-imagen="${horario.imagen}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon danger delete-horario" 
                                data-id="${horario.id}" 
                                data-fecha="${horario.fecha}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            horariosTableBody.innerHTML = html;
        }

        // ===== BÚSQUEDA =====
        function setupSearch() {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const filteredHorarios = horarios.filter(horario => 
                    horario.fecha.toLowerCase().includes(searchTerm) ||
                    (horario.lugar && horario.lugar.toLowerCase().includes(searchTerm)) ||
                    (horario.descripcion && horario.descripcion.toLowerCase().includes(searchTerm)) ||
                    horario.id.toString().includes(searchTerm)
                );
                renderHorarios(filteredHorarios);
            });
        }

        // ===== MANEJO DE ARCHIVOS =====
        function setupFileInput() {
            // Cambio de archivo
            imagenInput.addEventListener('change', function(e) {
                handleImageSelection(e.target.files);
            });

            // Drag and drop
            imagenLabel.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            imagenLabel.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            imagenLabel.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imagenInput.files = files;
                    handleImageSelection(files);
                }
            });
        }

        function handleImageSelection(files) {
            if (files.length === 0) return;

            const file = files[0];
            
            // Validar tipo de archivo
            if (!file.type.startsWith('image/')) {
                showFieldError('imagen', 'Por favor, selecciona un archivo de imagen válido');
                return;
            }

            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showFieldError('imagen', 'La imagen no debe superar los 2MB');
                return;
            }

            currentImageFile = file;
            clearFieldFeedback('imagen');

            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagenPreview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="file-preview-image">
                    <div class="mt-2">
                        <button type="button" class="btn danger sm" id="removeImage">
                            <i class="fas fa-times"></i> Remover Imagen
                        </button>
                    </div>
                `;
                imagenPreview.classList.add('show');

                // Event listener para remover imagen
                document.getElementById('removeImage').addEventListener('click', function() {
                    imagenInput.value = '';
                    imagenPreview.innerHTML = '';
                    imagenPreview.classList.remove('show');
                    currentImageFile = null;
                });
            };
            reader.readAsDataURL(file);
        }

        // ===== CRUD OPERATIONS =====
        function createHorario(horarioData) {
            const formData = new FormData();
            
            // Agregar campos al FormData
            Object.keys(horarioData).forEach(key => {
                if (horarioData[key] !== null && horarioData[key] !== undefined) {
                    formData.append(key, horarioData[key]);
                }
            });

            // Agregar imagen si existe
            if (currentImageFile) {
                formData.append('imagen', currentImageFile);
            }

            $.ajax({
                url: '/api/horarios-credencializacion',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Horario creado correctamente');
                        closeModal('horarioModal');
                        resetForm();
                        loadHorarios();
                    } else {
                        showAlert('error', 'Error al crear el horario: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al crear el horario';
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

        function updateHorario(id, horarioData) {
            const formData = new FormData();
            
            // Agregar campos al FormData
            Object.keys(horarioData).forEach(key => {
                if (horarioData[key] !== null && horarioData[key] !== undefined) {
                    formData.append(key, horarioData[key]);
                }
            });

            // Agregar imagen si existe
            if (currentImageFile) {
                formData.append('imagen', currentImageFile);
            }

            // Agregar método PUT para Laravel
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/api/horarios-credencializacion/${id}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Horario actualizado correctamente');
                        closeModal('horarioModal');
                        resetForm();
                        loadHorarios();
                    } else {
                        showAlert('error', 'Error al actualizar el horario: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar el horario';
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

        function deleteHorario(id) {
            $.ajax({
                url: `/api/horarios-credencializacion/${id}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showAlert('success', 'Horario eliminado correctamente');
                        closeModal('confirmModal');
                        loadHorarios();
                    } else {
                        showAlert('error', 'Error al eliminar el horario: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al eliminar el horario';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    showAlert('error', errorMessage);
                }
            });
        }

        // ===== MANEJO DE FORMULARIOS =====
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Nuevo Horario';
            document.getElementById('horarioId').value = '';
            resetForm();
            clearFormFeedback();
            openModal('horarioModal');
        }

        function openEditModal(horario) {
            document.getElementById('modalTitle').textContent = 'Editar Horario';
            document.getElementById('horarioId').value = horario.id;
            document.getElementById('fecha').value = horario.fecha || '';
            document.getElementById('lugar').value = horario.lugar || '';
            document.getElementById('horario').value = horario.horario || '';
            document.getElementById('descripcion').value = horario.descripcion || '';
            
            // Mostrar imagen actual si existe
            if (horario.imagen) {
                imagenPreview.innerHTML = `
                    <img src="${IMAGE_BASE_URL}/${horario.imagen}" alt="Imagen actual" class="file-preview-image">
                    <div class="mt-2">
                        <small>Imagen actual</small>
                    </div>
                `;
                imagenPreview.classList.add('show');
            }

            clearFormFeedback();
            openModal('horarioModal');
        }

        function openDeleteModal(id, fecha) {
            document.getElementById('horarioToDelete').textContent = fecha;
            document.getElementById('confirmMessage').textContent = 
                `¿Estás seguro de que quieres eliminar el horario "${fecha}"?`;
            currentHorarioId = id;
            openModal('confirmModal');
        }

        function handleFormSubmit() {
            const fecha = document.getElementById('fecha').value.trim();
            const lugar = document.getElementById('lugar').value.trim();
            const horario = document.getElementById('horario').value.trim();
            const descripcion = document.getElementById('descripcion').value.trim();
            const id = document.getElementById('horarioId').value;

            // Validación básica
            if (!fecha) {
                showFieldError('fecha', 'La fecha es obligatoria');
                return;
            }

            const horarioData = {
                fecha: fecha,
                lugar: lugar || null,
                horario: horario || null,
                descripcion: descripcion || null
            };

            if (id) {
                updateHorario(id, horarioData);
            } else {
                createHorario(horarioData);
            }
        }

        function resetForm() {
            document.getElementById('fecha').value = '';
            document.getElementById('lugar').value = '';
            document.getElementById('horario').value = '';
            document.getElementById('descripcion').value = '';
            imagenInput.value = '';
            imagenPreview.innerHTML = '';
            imagenPreview.classList.remove('show');
            currentImageFile = null;
        }

        // ===== EVENT LISTENERS =====
        function setupEventListeners() {
            // Botón agregar horario
            document.getElementById('addHorario').addEventListener('click', openCreateModal);
            document.getElementById('addFirstHorario').addEventListener('click', openCreateModal);

            // Botón refrescar
            document.getElementById('refreshHorarios').addEventListener('click', loadHorarios);

            // Guardar horario
            document.getElementById('saveHorario').addEventListener('click', handleFormSubmit);

            // Confirmar eliminación
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (currentHorarioId) {
                    deleteHorario(currentHorarioId);
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
            document.getElementById('horariosTableBody').addEventListener('click', function(e) {
                const target = e.target.closest('button');
                if (!target) return;

                if (target.classList.contains('edit-horario')) {
                    const horario = {
                        id: target.getAttribute('data-id'),
                        fecha: target.getAttribute('data-fecha'),
                        lugar: target.getAttribute('data-lugar'),
                        horario: target.getAttribute('data-horario'),
                        descripcion: target.getAttribute('data-descripcion'),
                        imagen: target.getAttribute('data-imagen')
                    };
                    openEditModal(horario);
                } else if (target.classList.contains('delete-horario')) {
                    const id = target.getAttribute('data-id');
                    const fecha = target.getAttribute('data-fecha');
                    openDeleteModal(id, fecha);
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
            loadingHorarios.style.display = 'block';
            horariosTableBody.innerHTML = '';
            emptyState.style.display = 'none';
        }

        function hideLoading() {
            loadingHorarios.style.display = 'none';
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
            currentHorarioId = null;
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

        function clearFieldFeedback(field) {
            const input = document.getElementById(field);
            const feedback = document.getElementById(field + 'Feedback');
            
            if (input) {
                input.style.borderColor = '';
            }
            if (feedback) {
                feedback.innerHTML = '';
            }
        }

        function clearFormFeedback() {
            ['fecha', 'lugar', 'horario', 'descripcion', 'imagen'].forEach(field => {
                clearFieldFeedback(field);
            });
        }
    });
</script>
@endpush