@extends('cms.layout')

@push('css')
<style>
    .solicitudes-container {
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
    .stat-card.pendientes { border-left-color: var(--warning); }
    .stat-card.proceso { border-left-color: var(--accent); }
    .stat-card.aprobadas { border-left-color: var(--success); }
    .stat-card.completadas { border-left-color: var(--gray); }
    .stat-card.rechazadas { border-left-color: var(--danger); }

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

    .folio-badge {
        background: var(--primary);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'Courier New', monospace;
    }

    .solicitante-info {
        display: flex;
        flex-direction: column;
    }

    .solicitante-nombre {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.2rem;
    }

    .solicitante-email {
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

    .estado-pendiente { background: #fff3cd; color: #856404; }
    .estado-proceso { background: #cce7ff; color: #004085; }
    .estado-aprobado { background: #d4edda; color: #155724; }
    .estado-completado { background: #d1ecf1; color: #0c5460; }
    .estado-rechazado { background: #f8d7da; color: #721c24; }

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

    .btn-icon.success { color: var(--success); }
    .btn-icon.success:hover { background: rgba(75, 181, 67, 0.1); }

    .btn-icon.danger { color: var(--danger); }
    .btn-icon.danger:hover { background: rgba(220, 53, 69, 0.1); }

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
<div class="dashboard-content ">
    <!-- Header de la página -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Solicitudes</h1>
            <p class="section-description">Administra y da seguimiento a todas las solicitudes de credencialización</p>
        </div>
        <button class="btn primary" id="refreshData">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid" id="statsContainer">
        <!-- Las estadísticas se cargarán por JavaScript -->
    </div>

    <!-- Filtros -->
     
    <div class="section-card">
        
        <div class="section-header">
            <h3 class="filters-title">Filtros de Búsqueda</h3>
            <button class="btn light sm" id="clearFilters">
                <i class="fas fa-times"></i> Limpiar Filtros
            </button>
        </div>
        <div class="filters-grid">
            <div class="form-group">
                <label class="form-label">Folio</label>
                <input type="text" class="form-control" id="filterFolio" placeholder="Buscar por folio...">
            </div>
            <div class="form-group">
                <label class="form-label">Solicitante</label>
                <input type="text" class="form-control" id="filterSolicitante" placeholder="Nombre o apellidos...">
            </div>
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select class="form-control" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="1">Pendiente</option>
                    <option value="2">En proceso</option>
                    <option value="3">Aprobado</option>
                    <option value="4">Completado</option>
                    <option value="5">Rechazado</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Ordenar por</label>
                <select class="form-control" id="sortField">
                    <option value="created_at">Fecha de creación</option>
                    <option value="folio">Folio</option>
                    <option value="nombres">Solicitante</option>
                    <option value="solicitudes_estadosId">Estado</option>
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
                    <option value="50">50 registcios</option>
                </select>
            </div>
        </div>

    </div>


    <!-- Tabla de solicitudes -->
    <div class="table-container">
        <div class="loading-overlay" id="tableLoading">
            <div class="spinner"></div>
        </div>

        <div class="table-responsive">
            <table class="table">
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
                    <!-- Las solicitudes se cargarán por JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Estado vacío -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <i class="fas fa-inbox"></i>
            <h4>No hay solicitudes</h4>
            <p>No se encontraron solicitudes con los filtros aplicados.</p>
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
                <!-- Contenido del modal se cargará por JavaScript -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="detailModal">Cerrar</button>
            <button class="btn primary" id="sendEmailBtn">
                <i class="fas fa-envelope"></i> Enviar Email
            </button>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    class SolicitudesManager {
        constructor() {
            this.currentPage = 1;
            this.filters = {
                folio: '',
                solicitante: '',
                estado: '',
                sort_field: 'created_at',
                sort_direction: 'desc',
                per_page: 15
            };
            this.init();
        }

        init() {
            this.bindEvents();
            this.loadStats();
            this.loadSolicitudes();
        }

        bindEvents() {
            // Filtros
            document.getElementById('filterFolio').addEventListener('input', this.debounce(() => {
                this.filters.folio = document.getElementById('filterFolio').value;
                this.currentPage = 1;
                this.loadSolicitudes();
            }, 500));

            document.getElementById('filterSolicitante').addEventListener('input', this.debounce(() => {
                this.filters.solicitante = document.getElementById('filterSolicitante').value;
                this.currentPage = 1;
                this.loadSolicitudes();
            }, 500));

            document.getElementById('filterEstado').addEventListener('change', () => {
                this.filters.estado = document.getElementById('filterEstado').value;
                this.currentPage = 1;
                this.loadSolicitudes();
            });

            document.getElementById('sortField').addEventListener('change', () => {
                this.filters.sort_field = document.getElementById('sortField').value;
                this.loadSolicitudes();
            });

            document.getElementById('sortDirection').addEventListener('change', () => {
                this.filters.sort_direction = document.getElementById('sortDirection').value;
                this.loadSolicitudes();
            });

            document.getElementById('perPage').addEventListener('change', () => {
                this.filters.per_page = document.getElementById('perPage').value;
                this.currentPage = 1;
                this.loadSolicitudes();
            });

            // Botones
            document.getElementById('refreshData').addEventListener('click', () => {
                this.loadStats();
                this.loadSolicitudes();
            });

            document.getElementById('clearFilters').addEventListener('click', () => {
                this.clearFilters();
            });

            // Modal
            document.getElementById('sendEmailBtn').addEventListener('click', () => {
                this.sendEmail();
            });
        }

        async loadStats() {
            try {
                const response = await fetch('/api/solicitudes-estadisticas/estadisticas');
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
                    <div class="stat-label">Total Solicitudes</div>
                </div>
                <div class="stat-card pendientes">
                    <div class="stat-value">${data.pendientes}</div>
                    <div class="stat-label">Pendientes</div>
                </div>
                <div class="stat-card proceso">
                    <div class="stat-value">${data.proceso}</div>
                    <div class="stat-label">En Proceso</div>
                </div>
                <div class="stat-card aprobadas">
                    <div class="stat-value">${data.aprobadas}</div>
                    <div class="stat-label">Aprobadas</div>
                </div>
                <div class="stat-card completadas">
                    <div class="stat-value">${data.completadas}</div>
                    <div class="stat-label">Completadas</div>
                </div>
                <div class="stat-card rechazadas">
                    <div class="stat-value">${data.rechazadas}</div>
                    <div class="stat-label">Rechazadas</div>
                </div>
            `;
        }

        async loadSolicitudes() {
            const tableBody = document.getElementById('solicitudesTableBody');
            const loadingOverlay = document.getElementById('tableLoading');
            const emptyState = document.getElementById('emptyState');

            try {
                loadingOverlay.classList.add('show');
                tableBody.innerHTML = '';

                const queryParams = new URLSearchParams({
                    page: this.currentPage,
                    ...this.filters
                });

                const response = await fetch(`/api/solicitudes?${queryParams}`);
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message);
                }

                if (result.success) {
                    this.renderSolicitudes(result.data);
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
                console.error('Error cargando solicitudes:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--danger);">
                            <i class="fas fa-exclamation-triangle"></i> Error al cargar las solicitudes
                        </td>
                    </tr>
                `;
                this.showAlert('error', 'Error al cargar las solicitudes');
            } finally {
                loadingOverlay.classList.remove('show');
            }
        }

        renderSolicitudes(solicitudes) {
            const tableBody = document.getElementById('solicitudesTableBody');
            
            if (solicitudes.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--gray);">
                            No se encontraron solicitudes
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = solicitudes.map(solicitud => `
                <tr>
                    <td>
                        <span class="folio-badge">${solicitud.folio}</span>
                    </td>
                    <td>
                        <div class="solicitante-info">
                            <span class="solicitante-nombre">${solicitud.nombres} ${solicitud.apellidos}</span>
                            <span class="solicitante-email">${solicitud.correo}</span>
                        </div>
                    </td>
                    <td>${this.truncateText(solicitud.escuela_procedencia, 30)}</td>
                    <td>${solicitud.terminal?.nombre || 'N/A'}</td>
                    <td>
                        <span class="estado-badge ${this.getEstadoClass(solicitud.solicitudes_estadosId)}">
                            ${solicitud.estado?.nombre || 'Pendiente'}
                        </span>
                    </td>
                    <td>${new Date(solicitud.created_at).toLocaleDateString('es-MX')}</td>
                    <td>
                        <div class="acciones-cell">
                            <button class="btn-icon primary" onclick="solicitudesManager.viewDetails('${solicitud.folio}')" 
                                    title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon success" onclick="solicitudesManager.sendEmailToSolicitante('${solicitud.folio}')" 
                                    title="Enviar email">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <button class="btn-icon danger" onclick="solicitudesManager.deleteSolicitud('${solicitud.folio}')" 
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
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
                        onclick="solicitudesManager.changePage(${pagination.current_page - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;

            // Números de página
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.last_page, pagination.current_page + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <button class="page-btn ${i === pagination.current_page ? 'active' : ''}" 
                            onclick="solicitudesManager.changePage(${i})">
                        ${i}
                    </button>
                `;
            }

            // Botón siguiente
            paginationHTML += `
                <button class="page-btn" ${pagination.current_page === pagination.last_page ? 'disabled' : ''} 
                        onclick="solicitudesManager.changePage(${pagination.current_page + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;

            paginationContainer.innerHTML = paginationHTML;
        }

        changePage(page) {
            this.currentPage = page;
            this.loadSolicitudes();
        }

        async viewDetails(folio) {
            try {
                const response = await fetch(`/api/solicitudes/${folio}`);
                const result = await response.json();

                if (result.success) {
                    this.showDetailsModal(result.data);
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error cargando detalles:', error);
                this.showAlert('error', 'Error al cargar los detalles de la solicitud');
            }
        }

        showDetailsModal(solicitud) {
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
                            <span class="estado-badge ${this.getEstadoClass(solicitud.solicitudes_estadosId)}">
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
                        <label class="form-label">Email</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.correo}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.telefono}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Escuela</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.escuela_procedencia}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Terminal</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${solicitud.terminal?.nombre || 'No asignada'}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha de Solicitud</label>
                        <div class="form-control" style="background: #f8f9fa;">
                            ${new Date(solicitud.created_at).toLocaleString('es-MX')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lugar de Residencia</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.lugar_residencia}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lugar de Origen</label>
                        <div class="form-control" style="background: #f8f9fa;">${solicitud.lugar_origen}</div>
                    </div>
                </div>
            `;

            // Guardar el folio actual para el envío de email
            this.currentFolio = solicitud.folio;

            // Mostrar modal
            this.openModal('detailModal');
        }

        async sendEmailToSolicitante(folio) {
            if (confirm(`¿Enviar email de estado al solicitante con folio ${folio}?`)) {
                try {
                    const response = await fetch(`/api/solicitudes/${folio}/enviar-email`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.showAlert('success', result.message);
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    console.error('Error enviando email:', error);
                    this.showAlert('error', 'Error al enviar el email');
                }
            }
        }

        async deleteSolicitud(folio) {
            if (confirm(`¿Estás seguro de eliminar la solicitud ${folio}? Esta acción no se puede deshacer.`)) {
                try {
                    // Aquí iría la llamada API para eliminar
                    // Por ahora solo mostramos un mensaje
                    this.showAlert('warning', `Función de eliminar solicitud ${folio} (pendiente de implementar)`);
                } catch (error) {
                    console.error('Error eliminando solicitud:', error);
                    this.showAlert('error', 'Error al eliminar la solicitud');
                }
            }
        }

        clearFilters() {
            document.getElementById('filterFolio').value = '';
            document.getElementById('filterSolicitante').value = '';
            document.getElementById('filterEstado').value = '';
            document.getElementById('sortField').value = 'created_at';
            document.getElementById('sortDirection').value = 'desc';
            document.getElementById('perPage').value = '15';

            this.filters = {
                folio: '',
                solicitante: '',
                estado: '',
                sort_field: 'created_at',
                sort_direction: 'desc',
                per_page: 15
            };
            this.currentPage = 1;
            this.loadSolicitudes();
        }

        getEstadoClass(estadoId) {
            const clases = {
                1: 'estado-pendiente',
                2: 'estado-proceso',
                3: 'estado-aprobado',
                4: 'estado-completado',
                5: 'estado-rechazado'
            };
            return clases[estadoId] || 'estado-pendiente';
        }

        truncateText(text, maxLength) {
            if (text.length <= maxLength) return text;
            return text.substring(0, maxLength) + '...';
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
            // Usar el sistema de alertas que ya tienes implementado
            const alertTypes = {
                success: { class: 'success', icon: 'fa-check-circle' },
                error: { class: 'danger', icon: 'fa-times-circle' },
                warning: { class: 'warning', icon: 'fa-exclamation-triangle' },
                info: { class: 'primary', icon: 'fa-info-circle' }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;
            
            // Implementar según tu sistema de alertas existente
            console.log(`[${type.toUpperCase()}] ${message}`);
            alert(message); // Temporal - reemplazar con tu sistema de alertas
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
        window.solicitudesManager = new SolicitudesManager();
    });
</script>
@endpush