@extends('cms.layout')

@push('css')
<style>
    .usuarios-container {
        padding: 0;
    }  

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid var(--primary);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    .stat-card.total { border-left-color: var(--primary); }
    .stat-card.activos { border-left-color: var(--success); }
    .stat-card.inactivos { border-left-color: var(--danger); }
    .stat-card.administradores { border-left-color: var(--accent); }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray);
        font-weight: 600;
    }

    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .filters-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table th {
        background: #f8f9fa;
        padding: 1rem;
        font-weight: 600;
        color: var(--dark);
        text-align: left;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .usuario-info {
        display: flex;
        flex-direction: column;
    }

    .usuario-nombre {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.2rem;
    }

    .usuario-username {
        font-size: 0.8rem;
        color: var(--gray);
    }

    .estado-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .estado-activo { background: #d4edda; color: #155724; }
    .estado-inactivo { background: #f8d7da; color: #721c24; }

    .perfil-badge {
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .acciones-cell {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }

    .btn-icon {
        background: none;
        border: none;
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        color: var(--gray);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }

    .btn-icon:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .btn-icon.primary { color: var(--primary); }
    .btn-icon.primary:hover { background: rgba(67, 97, 238, 0.1); }

    .btn-icon.warning { color: var(--warning); }
    .btn-icon.warning:hover { background: rgba(255, 193, 7, 0.1); }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .pagination-info {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .page-btn {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e9ecef;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.8rem;
        min-width: 36px;
        text-align: center;
    }

    .page-btn:hover:not(:disabled) {
        background: #f8f9fa;
    }

    .page-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 12px;
    }

    .loading-overlay.show {
        display: flex;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e9ecef;
    }

    .empty-state h4 {
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .acciones-cell {
            flex-direction: column;
        }

        .pagination-container {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .pagination {
            justify-content: center;
        }

        .table-responsive {
            font-size: 0.8rem;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-content usuarios-container">
    <!-- Header de la página -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Usuarios</h1>
            <p class="section-description">Administra los usuarios del sistema y sus permisos</p>
        </div>
        <button class="btn primary" id="btnNuevoUsuario">
            <i class="fas fa-plus"></i> Nuevo Usuario
        </button>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid" id="statsContainer">
        <!-- Las estadísticas se cargarán por JavaScript -->
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <div class="filters-header">
            <h3 class="filters-title">Filtros de Búsqueda</h3>
            <button class="btn light sm" id="clearFilters">
                <i class="fas fa-times"></i> Limpiar Filtros
            </button>
        </div>
        <div class="filters-grid">
            <div class="form-group">
                <label class="form-label">Buscar</label>
                <input type="text" class="form-control" id="filterSearch" placeholder="Nombre, apellido o usuario...">
            </div>
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select class="form-control" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Ordenar por</label>
                <select class="form-control" id="sortField">
                    <option value="created_at">Fecha de creación</option>
                    <option value="nombres">Nombre</option>
                    <option value="apellidos">Apellido</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Dirección</label>
                <select class="form-control" id="sortDirection">
                    <option value="desc">Más reciente primero</option>
                    <option value="asc">Más antiguo primero</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Registros por página</label>
                <select class="form-control" id="perPage">
                    <option value="10">10 registros</option>
                    <option value="15" selected>15 registros</option>
                    <option value="25">25 registros</option>
                    <option value="50">50 registros</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="table-container">
        <div class="loading-overlay" id="tableLoading">
            <div class="spinner"></div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="usuariosTableBody">
                    <!-- Los usuarios se cargarán por JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Estado vacío -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <i class="fas fa-users"></i>
            <h4>No hay usuarios</h4>
            <p>No se encontraron usuarios con los filtros aplicados.</p>
        </div>

        <!-- Paginación -->
        <div class="pagination-container">
            <div class="pagination-info" id="paginationInfo">
                Mostrando 0 a 0 de 0 registros
            </div>
            <div class="pagination" id="pagination">
                <!-- La paginación se generará por JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Modal único para Crear/Editar -->
<div class="modal-overlay" id="userModal">
    <div class="modal" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title" id="userModalTitle">Nuevo Usuario</h3>
            <button class="modal-close" onclick="usuariosManager.closeModal('userModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="userForm">
                @csrf
                <input type="hidden" id="userId" name="id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="nombres">Nombres *</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="apellidos">Apellidos *</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="usuario">Usuario *</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>

            

                    <div class="form-group">
                        <label class="form-label" for="perfilesId">Perfil *</label>
                        <select class="form-control" id="perfilesId" name="perfilesId" required>
                            <option value="">Seleccione un perfil</option>
                            <!-- Las opciones se llenarán dinámicamente con JavaScript -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            Contraseña 
                            <span id="passwordRequired">*</span>
                            <span id="passwordOptional" style="display: none; color: var(--gray); font-weight: normal;">(Opcional - dejar en blanco para mantener la actual)</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="checkbox">
                        <input type="checkbox" id="activo" name="activo" value="1" checked>
                        <span class="checkmark"></span>
                        Usuario activo
                    </label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn light" onclick="usuariosManager.closeModal('userModal')">Cancelar</button>
            <button type="submit" form="userForm" class="btn success" id="userModalSubmit">
                <i class="fas fa-save"></i> Crear Usuario
            </button>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    class UsuariosManager {
        constructor() {
            this.currentPage = 1;
            this.filters = {
                search: '',
                estado: '',
                sort_field: 'created_at',
                sort_direction: 'desc',
                per_page: 15
            };
            this.init();
        }

        async init() {
            await this.loadPerfiles();
            this.bindEvents();
            this.loadStats();
            this.loadUsuarios();
        }

        async loadPerfiles() {
        try {
            const response = await fetch('/api/perfiles');
            const result = await response.json();

            if (result.success) {
                this.perfiles = result.data;
                this.renderPerfilesSelect();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error cargando perfiles:', error);
            this.showAlert('error', 'Error al cargar los perfiles');
        }
    }


     renderPerfilesSelect() {
        const select = document.getElementById('perfilesId');
        
        // Limpiar opciones existentes (excepto la primera)
        while (select.children.length > 1) {
            select.removeChild(select.lastChild);
        }
        
        // Agregar opciones de perfiles
        this.perfiles.forEach(perfil => {
            const option = document.createElement('option');
            option.value = perfil.id;
            option.textContent = perfil.nombre;
            select.appendChild(option);
        });
    }

        bindEvents() {
            // Filtros
            document.getElementById('filterSearch').addEventListener('input', this.debounce(() => {
                this.filters.search = document.getElementById('filterSearch').value;
                this.currentPage = 1;
                this.loadUsuarios();
            }, 500));

            document.getElementById('filterEstado').addEventListener('change', () => {
                this.filters.estado = document.getElementById('filterEstado').value;
                this.currentPage = 1;
                this.loadUsuarios();
            });

            document.getElementById('sortField').addEventListener('change', () => {
                this.filters.sort_field = document.getElementById('sortField').value;
                this.loadUsuarios();
            });

            document.getElementById('sortDirection').addEventListener('change', () => {
                this.filters.sort_direction = document.getElementById('sortDirection').value;
                this.loadUsuarios();
            });

            document.getElementById('perPage').addEventListener('change', () => {
                this.filters.per_page = document.getElementById('perPage').value;
                this.currentPage = 1;
                this.loadUsuarios();
            });

            // Botones
            document.getElementById('btnNuevoUsuario').addEventListener('click', () => {
                this.showUserModal();
            });

            document.getElementById('clearFilters').addEventListener('click', () => {
                this.clearFilters();
            });

            // Formulario
            document.getElementById('userForm').addEventListener('submit', (e) => {
                e.preventDefault();
                this.saveUser();
            });
        }

        async loadStats() {
            try {
                const response = await fetch('/api/usuarios/estadisticas');
                const result = await response.json();

                if (result.success) {
                    this.renderStats(result.data);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error cargando estadísticas:', error);
                this.showAlert('error', 'Error al cargar las estadísticas');
            }
        }

        renderStats(data) {
            const statsContainer = document.getElementById('statsContainer');
            statsContainer.innerHTML = `
                <div class="stat-card total">
                    <div class="stat-value">${data.total}</div>
                    <div class="stat-label">Total Usuarios</div>
                </div>
                <div class="stat-card activos">
                    <div class="stat-value">${data.activos}</div>
                    <div class="stat-label">Usuarios Activos</div>
                </div>
                <div class="stat-card inactivos">
                    <div class="stat-value">${data.inactivos}</div>
                    <div class="stat-label">Usuarios Inactivos</div>
                </div>
                <div class="stat-card administradores">
                    <div class="stat-value">${data.administradores}</div>
                    <div class="stat-label">Administradores</div>
                </div>
            `;
        }

        async loadUsuarios() {
            const tableBody = document.getElementById('usuariosTableBody');
            const loadingOverlay = document.getElementById('tableLoading');
            const emptyState = document.getElementById('emptyState');

            try {
                loadingOverlay.classList.add('show');
                tableBody.innerHTML = '';

                const queryParams = new URLSearchParams({
                    page: this.currentPage,
                    ...this.filters
                });

                const response = await fetch(`/api/usuarios?${queryParams}`);
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message);
                }

                if (result.success) {
                    this.renderUsuarios(result.data);
                    this.renderPagination(result.pagination);
                    
                    // Mostrar/ocultar estado vacío
                    if (result.data.length === 0) {
                        emptyState.style.display = 'block';
                    } else {
                        emptyState.style.display = 'none';
                    }
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error cargando usuarios:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--danger);">
                            <i class="fas fa-exclamation-triangle"></i> Error al cargar los usuarios
                        </td>
                    </tr>
                `;
                this.showAlert('error', 'Error al cargar los usuarios');
            } finally {
                loadingOverlay.classList.remove('show');
            }
        }

        renderUsuarios(usuarios) {
            const tableBody = document.getElementById('usuariosTableBody');
            
            if (usuarios.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--gray);">
                            No se encontraron usuarios
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = usuarios.map(usuario => `
                <tr>
                    <td>${usuario.id}</td>
                    <td>
                        <div class="usuario-info">
                            <span class="usuario-nombre">${usuario.nombres} ${usuario.apellidos}</span>
                            <span class="usuario-username">@${usuario.usuario}</span>
                        </div>
                    </td>
                    <td>
                        <span class="perfil-badge">${usuario.perfil?.nombre || 'N/A'}</span>
                    </td>
                    <td>
                        <span class="estado-badge ${usuario.activo ? 'estado-activo' : 'estado-inactivo'}">
                            ${usuario.activo ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td>${new Date(usuario.created_at).toLocaleDateString('es-MX')}</td>
                    <td>
                        <div class="acciones-cell">
                            <button class="btn-icon primary" onclick="usuariosManager.editUsuario(${usuario.id})" 
                                    title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            ${usuario.id !== {{ /*auth()->id()*/ 0 }} ? `
                                <button class="btn-icon warning" onclick="usuariosManager.toggleStatus(${usuario.id}, ${usuario.activo})" 
                                        title="${usuario.activo ? 'Desactivar' : 'Activar'}">
                                    <i class="fas fa-${usuario.activo ? 'user-slash' : 'user-check'}"></i>
                                </button>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        renderPagination(pagination) {
            const paginationContainer = document.getElementById('pagination');
            const paginationInfo = document.getElementById('paginationInfo');

            // Información de paginación
            paginationInfo.textContent = 
                `Mostrando ${pagination.from || 0} a ${pagination.to || 0} de ${pagination.total} registros`;

            // Botones de paginación
            let paginationHTML = '';

            // Botón anterior
            paginationHTML += `
                <button class="page-btn" ${pagination.current_page === 1 ? 'disabled' : ''} 
                        onclick="usuariosManager.changePage(${pagination.current_page - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;

            // Números de página
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.last_page, pagination.current_page + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <button class="page-btn ${i === pagination.current_page ? 'active' : ''}" 
                            onclick="usuariosManager.changePage(${i})">
                        ${i}
                    </button>
                `;
            }

            // Botón siguiente
            paginationHTML += `
                <button class="page-btn" ${pagination.current_page === pagination.last_page ? 'disabled' : ''} 
                        onclick="usuariosManager.changePage(${pagination.current_page + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;

            paginationContainer.innerHTML = paginationHTML;
        }

        changePage(page) {
            this.currentPage = page;
            this.loadUsuarios();
        }

        showUserModal() {
            // Configurar modal para crear
            document.getElementById('userModalTitle').textContent = 'Nuevo Usuario';
            document.getElementById('userModalSubmit').innerHTML = '<i class="fas fa-save"></i> Crear Usuario';
            
            // Limpiar formulario
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
             document.getElementById('perfilesId').value = ''; 
            
            // Mostrar campos de contraseña como requeridos
            document.getElementById('passwordRequired').style.display = 'inline';
            document.getElementById('passwordOptional').style.display = 'none';
            document.getElementById('password').required = true;
            document.getElementById('password_confirmation').required = true;
            
            this.openModal('userModal');
        }

        async editUsuario(userId) {
            try {
                const response = await fetch(`/api/usuarios/${userId}`);
                const result = await response.json();

                if (result.success) {
                    this.showEditModal(result.data);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error cargando usuario para editar:', error);
                this.showAlert('error', 'Error al cargar el usuario para editar');
            }
        }

        showEditModal(usuario) {
            // Configurar modal para editar
            document.getElementById('userModalTitle').textContent = 'Editar Usuario';
            document.getElementById('userModalSubmit').innerHTML = '<i class="fas fa-save"></i> Actualizar Usuario';
            
            // Llenar formulario con datos del usuario
            document.getElementById('userId').value = usuario.id;
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
            
            this.openModal('userModal');
        }

        async saveUser() {
            const form = document.getElementById('userForm');
            const formData = new FormData(form);
            const userId = document.getElementById('userId').value;
            
            const url = userId ? `/api/usuarios/${userId}` : '/api/usuarios';
            const method = userId ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    this.closeModal('userModal');
                    this.loadUsuarios();
                    this.loadStats();
                    this.showAlert('success', result.message);
                } else {
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat().join('<br>');
                        this.showAlert('error', errorMessages);
                    } else {
                        this.showAlert('error', result.message);
                    }
                }
            } catch (error) {
                console.error('Error guardando usuario:', error);
                this.showAlert('error', 'Error al guardar el usuario');
            }
        }

        async toggleStatus(userId, currentStatus) {
            const accion = currentStatus ? 'desactivar' : 'activar';
            const mensaje = currentStatus ? 
                '¿Estás seguro de que deseas desactivar este usuario? El usuario no podrá acceder al sistema.' :
                '¿Estás seguro de que deseas activar este usuario? El usuario podrá acceder al sistema nuevamente.';
            
            if (confirm(mensaje)) {
                try {
                    const response = await fetch(`/api/usuarios/${userId}/toggle-status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.loadUsuarios();
                        this.loadStats();
                        this.showAlert('success', result.message);
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    console.error('Error cambiando estado:', error);
                    this.showAlert('error', 'Error al cambiar el estado del usuario');
                }
            }
        }

        clearFilters() {
            document.getElementById('filterSearch').value = '';
            document.getElementById('filterEstado').value = '';
            document.getElementById('sortField').value = 'created_at';
            document.getElementById('sortDirection').value = 'desc';
            document.getElementById('perPage').value = '15';

            this.filters = {
                search: '',
                estado: '',
                sort_field: 'created_at',
                sort_direction: 'desc',
                per_page: 15
            };
            this.currentPage = 1;
            this.loadUsuarios();
        }

        openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
        }

        showAlert(type, message) {
            const alertTypes = {
                success: { class: 'success', icon: 'fa-check-circle' },
                error: { class: 'danger', icon: 'fa-times-circle' },
                warning: { class: 'warning', icon: 'fa-exclamation-triangle' },
                info: { class: 'primary', icon: 'fa-info-circle' }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;
            
            // Crear alerta temporal
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertConfig.class}`;
            alertDiv.innerHTML = `
                <i class="fas ${alertConfig.icon} alert-icon"></i>
                <div class="alert-content">
                    <p class="alert-message">${message}</p>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.body.appendChild(alertDiv);
            
            // Auto-remover después de 5 segundos
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    }

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        window.usuariosManager = new UsuariosManager();
    });
</script>
@endpush