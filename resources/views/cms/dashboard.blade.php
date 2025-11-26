@extends('cms.layout')

@push('css')
<style>
    /* Contenido del dashboard */
    .page-title {
        margin-bottom: 20px;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark);
    }

    /* Cards */
    .cards-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        flex: 1;
        min-width: 250px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: var(--transition);
        animation: fadeIn 0.5s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .card-title {
        font-size: 0.9rem;
        color: var(--gray);
        font-weight: 600;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .card-icon.blue {
        background-color: var(--primary);
    }

    .card-icon.green {
        background-color: var(--success);
    }

    .card-icon.orange {
        background-color: var(--warning);
    }

    .card-icon.red {
        background-color: var(--danger);
    }

    .card-icon.purple {
        background-color: #6f42c1;
    }

    .card-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .card-change {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-change.positive {
        color: var(--success);
    }

    .card-change.negative {
        color: var(--danger);
    }

    /* Gráficas */
    .charts-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card {
        flex: 1;
        min-width: 300px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 20px;
        animation: fadeIn 0.8s ease;
    }

    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .chart-actions {
        display: flex;
        gap: 10px;
    }

    .chart-action-btn {
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        transition: var(--transition);
    }

    .chart-action-btn:hover {
        color: var(--primary);
    }

    .chart-container {
        position: relative;
        height: 250px;
    }

    /* Mapa de Calor */
    .map-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 30px;
        animation: fadeIn 1s ease;
    }

    #heatMap {
        height: 400px;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }

    .map-controls {
        background: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .map-controls label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
        color: var(--gray);
    }

    .map-controls input[type="range"] {
        width: 100px;
    }

    /* Tabla */
    .table-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 20px;
        animation: fadeIn 1s ease;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .table-actions {
        display: flex;
        gap: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .table th {
        font-weight: 600;
        color: var(--gray);
    }

    .table tbody tr {
        transition: var(--transition);
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status.active {
        background-color: rgba(75, 181, 67, 0.1);
        color: var(--success);
    }

    .status.pending {
        background-color: rgba(255, 204, 0, 0.1);
        color: var(--warning);
    }

    .status.inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color: var(--danger);
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estadísticas rápidas */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--gray);
    }

    /* Estilos para paginación */
    .pagination-controls-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .pagination-container {
        margin-top: 1.5rem;
        padding: 1rem 0;
        border-top: 1px solid #e9ecef;
    }

    .pagination-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: var(--gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .pagination-buttons {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .pagination-numbers {
        display: flex;
        gap: 0.25rem;
        margin: 0 0.5rem;
    }

    .pagination-size {
        min-width: 150px;
    }

    .pagination-size .form-control.sm {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
    }

    /* Responsive para paginación */
    @media (max-width: 768px) {
        .pagination-controls {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }
        
        .pagination-controls-top {
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }
        
        .pagination-buttons {
            justify-content: center;
            order: 2;
        }
        
        .pagination-info {
            text-align: center;
            order: 1;
        }
        
        .pagination-size {
            order: 3;
            align-self: center;
        }
        
        .pagination-numbers {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    .pagination-ellipsis {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        color: var(--gray);
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Dashboard de Credencialización</h1>
    
    <!-- Cards Principales -->
    <div class="cards-container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Total Solicitudes</div>
                <div class="card-icon blue">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div class="card-value" id="totalSolicitudes">0</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span id="cambioSolicitudes">0%</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Solicitudes Activas</div>
                <div class="card-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="card-value" id="solicitudesActivas">0</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>Este mes</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Terminales Activas</div>
                <div class="card-icon orange">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
            <div class="card-value" id="totalTerminales">0</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>En operación</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Por Vencer</div>
                <div class="card-icon red">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="card-value" id="porVencer">0</div>
            <div class="card-change negative">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Próximo mes</span>
            </div>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="quick-stats">
        <div class="stat-item">
            <div class="stat-value" id="estadoPendiente">0</div>
            <div class="stat-label">Pendientes</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" id="estadoPagado">0</div>
            <div class="stat-label">Pagadas</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" id="estadoImpreso">0</div>
            <div class="stat-label">Impresas</div>
        </div>
        <div class="stat-item">
            <div class="stat-value" id="estadoFinalizado">0</div>
            <div class="stat-label">Finalizadas</div>
        </div>
    </div>
    
    <!-- Gráficas -->
    <div class="charts-container">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Solicitudes por Estado</div>
                <div class="chart-actions">
                    <button class="chart-action-btn" onclick="refreshCharts()"><i class="fas fa-sync"></i></button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="estadosChart"></canvas>
            </div>
        </div>
        
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Solicitudes por Terminal</div>
                <div class="chart-actions">
                    <button class="chart-action-btn" onclick="refreshCharts()"><i class="fas fa-sync"></i></button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="terminalesChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Evolución Mensual</div>
                <div class="chart-actions">
                    <button class="chart-action-btn" onclick="refreshCharts()"><i class="fas fa-sync"></i></button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="mensualChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Mapa de Calor -->
    <div class="map-card">
        <div class="chart-header">
            <div class="chart-title">Mapa de Calor - Distribución de Solicitudes</div>
            <div class="chart-actions">
                <button class="chart-action-btn" onclick="refreshHeatMap()"><i class="fas fa-sync"></i></button>
            </div>
        </div>
        
        <div class="map-controls">
            <label>
                Radio: <input type="range" id="radiusSlider" min="10" max="50" value="25">
                <span id="radiusValue">25</span>
            </label>
            <label>
                Opacidad: <input type="range" id="opacitySlider" min="0" max="1" step="0.1" value="0.7">
                <span id="opacityValue">0.7</span>
            </label>
            <label>
                Intensidad: <input type="range" id="intensitySlider" min="1" max="5" step="0.5" value="2">
                <span id="intensityValue">2</span>
            </label>
        </div>
        
        <div id="heatMap"></div>
    </div>
    
    <!-- Tabla de Solicitudes Recientes -->
    <!-- Tabla de Solicitudes Recientes -->
<div class="table-card">
    <div class="table-header">
        <div class="table-title">Solicitudes Recientes</div>
        <div class="table-actions">
            <button class="chart-action-btn" onclick="loadRecentSolicitudes()"><i class="fas fa-sync"></i></button>
            <a href="{{ route('cms.solicitudes.index') }}" class="chart-action-btn">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
    </div>
    
    <!-- Controles de paginación superior -->
    <div class="pagination-controls-top" style="margin-bottom: 15px;">
        <div class="pagination-info">
            Mostrando <span id="paginationFrom">0</span>-<span id="paginationTo">0</span> de <span id="paginationTotal">0</span> registros
        </div>
        <div class="pagination-size">
            <select class="form-control sm" id="perPageSelect" onchange="changePerPage(this.value)">
                <option value="5">5 por página</option>
                <option value="10" selected>10 por página</option>
                <option value="25">25 por página</option>
                <option value="50">50 por página</option>
            </select>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Solicitante</th>
                <th>Terminal</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody id="recentSolicitudesBody">
            <!-- Los datos se cargan via AJAX -->
        </tbody>
    </table>
    
    <!-- Paginación inferior -->
    <div class="pagination-container">
        <div class="pagination-controls">
            <div class="pagination-info">
                Mostrando <span id="paginationFromBottom">0</span>-<span id="paginationToBottom">0</span> de <span id="paginationTotalBottom">0</span> registros
            </div>
            <div class="pagination-buttons">
                <button class="btn sm light" id="firstPage" onclick="goToPage(1)" disabled>
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button class="btn sm light" id="prevPage" onclick="goToPage(currentPage - 1)" disabled>
                    <i class="fas fa-angle-left"></i>
                </button>
                <span class="pagination-numbers" id="paginationNumbers"></span>
                <button class="btn sm light" id="nextPage" onclick="goToPage(currentPage + 1)" disabled>
                    <i class="fas fa-angle-right"></i>
                </button>
                <button class="btn sm light" id="lastPage" onclick="goToPage(totalPages)" disabled>
                    <i class="fas fa-angle-double-right"></i>
                </button>
            </div>
            <div class="pagination-size">
                <select class="form-control sm" id="perPageSelectBottom" onchange="changePerPage(this.value)">
                    <option value="5">5 por página</option>
                    <option value="10" selected>10 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>
        </div>
    </div>



</div>
@endsection

@push('js')
<!-- Incluir Google Maps -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{$apimapas}}&libraries=visualization&callback=initMap">
</script>

// Reemplaza todo el código JavaScript con esta versión corregida:

<script>
    // Variables globales
    let dashboardData = {};
    let heatmap = null;
    let map = null;
    
    // Variables para las gráficas
    let estadosChart = null;
    let terminalesChart = null;
    let mensualChart = null;

    // Variables globales para paginación
    let currentPage = 1;
    let perPage = 10;
    let totalPages = 1;
    let totalSolicitudes = 0;
    let allSolicitudes = [];

    // Gráficas con Chart.js
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();
        setupMapControls();
    });

    function loadDashboardData() {
        // Mostrar loading
        showLoadingState();
        
        $.ajax({
            url: '/api/solicitudes/dashboard/stats',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    dashboardData = response.data;
                    updateDashboardCards();
                    renderCharts();
                    updateHeatMap();
                    loadRecentSolicitudes(); // Esta función ahora incluye paginación
                } else {
                    console.error('Error al cargar datos del dashboard:', response.message);
                    showErrorState();
                }
            },
            error: function(xhr) {
                console.error('Error en la petición AJAX:', xhr);
                showErrorState();
            }
        });
    }

    function showLoadingState() {
        // Puedes agregar un indicador de carga aquí si lo deseas
        console.log('Cargando datos del dashboard...');
    }

    function showErrorState() {
        // Puedes mostrar un mensaje de error al usuario
        console.error('Error al cargar los datos del dashboard');
    }

    function updateDashboardCards() {
        // Actualizar cards principales con valores por defecto si no existen
        document.getElementById('totalSolicitudes').textContent = dashboardData.total_solicitudes || 0;
        document.getElementById('solicitudesActivas').textContent = dashboardData.solicitudes_activas || 0;
        document.getElementById('totalTerminales').textContent = dashboardData.total_terminales || 0;
        document.getElementById('porVencer').textContent = dashboardData.por_vencer || 0;

        // Actualizar estadísticas rápidas con valores por defecto
        console.log(dashboardData)
        if (dashboardData.estados) {
            document.getElementById('estadoPendiente').textContent = dashboardData.estados.pendiente || 0;
            document.getElementById('estadoPagado').textContent = dashboardData.estados.pagado || 0;
            document.getElementById('estadoImpreso').textContent = dashboardData.estados.impreso || 0;
            document.getElementById('estadoFinalizado').textContent = dashboardData.estados.finalizado || 0;
        } else {
            // Valores por defecto si no hay datos
            document.getElementById('estadoPendiente').textContent = 0;
            document.getElementById('estadoPagado').textContent = 0;
            document.getElementById('estadoImpreso').textContent = 0;
            document.getElementById('estadoFinalizado').textContent = 0;
        }
    }

    function renderCharts() {
        // Gráfica de estados
        renderEstadosChart();
        
        // Gráfica de terminales
        renderTerminalesChart();
        
        // Gráfica mensual
        renderMensualChart();
    }

    function renderEstadosChart() {
        const estadosCtx = document.getElementById('estadosChart');
        if (!estadosCtx) return;
        
        // Destruir gráfica anterior si existe
        if (estadosChart) {
            estadosChart.destroy();
        }
        
        // Datos por defecto si no hay datos
        const labels = dashboardData.estados_labels || ['Pendiente', 'Pagado', 'Impreso', 'Finalizado'];
        const data = dashboardData.estados_data || [1, 1, 1, 1];
        
        estadosChart = new Chart(estadosCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#4361ee', '#3f37c9', '#4cc9f0', '#4895ef', 
                        '#560bad', '#7209b7', '#b5179e', '#f72585'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '60%'
            }
        });
    }

    function renderTerminalesChart() {
        const terminalesCtx = document.getElementById('terminalesChart');
        if (!terminalesCtx) return;
        
        // Destruir gráfica anterior si existe
        if (terminalesChart) {
            terminalesChart.destroy();
        }
        
        // Datos por defecto si no hay datos
        const labels = dashboardData.terminales_labels || ['Terminal 1', 'Terminal 2', 'Terminal 3'];
        const data = dashboardData.terminales_data || [1, 1, 1];
        
        terminalesChart = new Chart(terminalesCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Solicitudes',
                    data: data,
                    backgroundColor: '#4361ee',
                    borderColor: '#3f37c9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function renderMensualChart() {
        const mensualCtx = document.getElementById('mensualChart');
        if (!mensualCtx) return;
        
        // Destruir gráfica anterior si existe
        if (mensualChart) {
            mensualChart.destroy();
        }
        
        // Datos por defecto si no hay datos
        const labels = dashboardData.mensual_labels || ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
        const data = dashboardData.mensual_data || [1, 1, 1, 1, 1, 1];
        
        mensualChart = new Chart(mensualCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Solicitudes Mensuales',
                    data: data,
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function initMap() {
        const mapElement = document.getElementById('heatMap');
        if (!mapElement) return;
        
        try {
            map = new google.maps.Map(mapElement, {
                zoom: 6,
                center: { lat: 19.4326, lng: -99.1332 },
                mapTypeId: 'roadmap'
            });

            // Inicializar heatmap con datos vacíos
            heatmap = new google.maps.visualization.HeatmapLayer({
                map: map,
                radius: 25,
                opacity: 0.7
            });
        } catch (error) {
            console.error('Error al inicializar el mapa:', error);
        }
    }

    function updateHeatMap() {
        if (!heatmap || !dashboardData.heatmap_data) return;

        try {
            const puntosCalor = dashboardData.heatmap_data.map(punto => ({
                location: new google.maps.LatLng(punto.latitud, punto.longitud),
                weight: punto.intensidad || 1
            }));

            heatmap.setData(puntosCalor);
        } catch (error) {
            console.error('Error al actualizar el mapa de calor:', error);
        }
    }

    function setupMapControls() {
        // Configurar controles del mapa
        const radiusSlider = document.getElementById('radiusSlider');
        const opacitySlider = document.getElementById('opacitySlider');
        const intensitySlider = document.getElementById('intensitySlider');

        if (radiusSlider) {
            radiusSlider.addEventListener('input', function(e) {
                const value = parseInt(e.target.value);
                const radiusValue = document.getElementById('radiusValue');
                if (radiusValue) radiusValue.textContent = value;
                if (heatmap) heatmap.set('radius', value);
            });
        }

        if (opacitySlider) {
            opacitySlider.addEventListener('input', function(e) {
                const value = parseFloat(e.target.value);
                const opacityValue = document.getElementById('opacityValue');
                if (opacityValue) opacityValue.textContent = value;
                if (heatmap) heatmap.set('opacity', value);
            });
        }

        if (intensitySlider) {
            intensitySlider.addEventListener('input', function(e) {
                const value = parseFloat(e.target.value);
                const intensityValue = document.getElementById('intensityValue');
                if (intensityValue) intensityValue.textContent = value;
            });
        }
    }

    function loadRecentSolicitudes() {
        $.ajax({
            url: '/api/solicitudes/recent/stats',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    allSolicitudes = response.data;
                    totalSolicitudes = allSolicitudes.length;
                    currentPage = 1;
                    renderPagination();
                    renderCurrentPage();
                } else {
                    console.error('Error al cargar solicitudes recientes:', response.message);
                    renderRecentSolicitudes([]);
                }
            },
            error: function(xhr) {
                console.error('Error al cargar solicitudes recientes:', xhr);
                renderRecentSolicitudes([]);
            }
        });
    }

    function renderRecentSolicitudes(solicitudes) {
        const tbody = document.getElementById('recentSolicitudesBody');
        if (!tbody) return;
        
        if (!solicitudes || solicitudes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay solicitudes recientes</td></tr>';
            return;
        }

        const html = solicitudes.map(solicitud => `
            <tr>
                <td>
                    <span class="folio-badge">${solicitud.folio || 'N/A'}</span>
                </td>
                <td>
                    <strong>${solicitud.nombres || ''} ${solicitud.apellidos || ''}</strong><br>
                    <small class="text-muted">${solicitud.correo || ''}</small>
                </td>
                <td>${solicitud.terminal?.nombre || 'N/A'}</td>
                <td>
                    <span class="status ${getStatusClass(solicitud.estado?.nombre)}">
                        ${solicitud.estado?.nombre || 'Pendiente'}
                    </span>
                </td>
                <td>${formatDate(solicitud.created_at)}</td>            
            </tr>
        `).join('');

        tbody.innerHTML = html;
    }

    function getStatusClass(estadoNombre) {
        if (!estadoNombre) return 'pending';
        
        const estado = estadoNombre.toLowerCase();
        if (estado.includes('pendiente')) return 'pending';
        if (estado.includes('aprob') || estado.includes('pag')) return 'active';
        if (estado.includes('final') || estado.includes('comp')) return 'active';
        if (estado.includes('rech') || estado.includes('canc')) return 'inactive';
        return 'pending';
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES');
        } catch (error) {
            return '-';
        }
    }

    function refreshCharts() {
        loadDashboardData();
    }

    function refreshHeatMap() {
        loadDashboardData();
    }

    // Manejar errores globales de Google Maps
    window.gm_authFailure = function() {
        console.error('Error de autenticación de Google Maps');
        alert('Error al cargar Google Maps. Verifica tu API key.');
    };

    // Animación de entrada para las cards
    const cards = document.querySelectorAll('.card, .chart-card, .table-card, .map-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => {
        if (card.style) {
            card.style.animationPlayState = 'paused';
            observer.observe(card);
        }
    });


    ////PAGINACION/////////////
    // Función para cambiar items por página
    function changePerPage(value) {
        perPage = parseInt(value);
        currentPage = 1;
        
        // Sincronizar ambos selects
        document.getElementById('perPageSelect').value = value;
        document.getElementById('perPageSelectBottom').value = value;
        
        renderPagination();
        renderCurrentPage();
    }

    // Función para ir a una página específica
    function goToPage(page) {
        if (page < 1 || page > totalPages) {
            return;
        }
        
        currentPage = page;
        renderPagination();
        renderCurrentPage();
        
        // Scroll suave hacia la tabla
        document.querySelector('.table-card').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }

    // Función para renderizar la paginación
    function renderPagination() {
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, totalSolicitudes);
        
        // Actualizar información de paginación
        updatePaginationInfo(startIndex, endIndex, totalSolicitudes);
        
        // Calcular total de páginas
        totalPages = Math.ceil(totalSolicitudes / perPage);
        
        // Actualizar botones
        updatePaginationButtons();
        
        // Actualizar números de página
        updatePageNumbers();
    }

    // Función para actualizar la información de paginación
    function updatePaginationInfo(startIndex, endIndex, total) {
        const from = total > 0 ? startIndex + 1 : 0;
        const to = endIndex;
        
        // Actualizar información superior
        document.getElementById('paginationFrom').textContent = from;
        document.getElementById('paginationTo').textContent = to;
        document.getElementById('paginationTotal').textContent = total;
        
        // Actualizar información inferior
        document.getElementById('paginationFromBottom').textContent = from;
        document.getElementById('paginationToBottom').textContent = to;
        document.getElementById('paginationTotalBottom').textContent = total;
    }

    // Función para actualizar botones de paginación
    function updatePaginationButtons() {
        const firstPageBtn = document.getElementById('firstPage');
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        const lastPageBtn = document.getElementById('lastPage');
        
        if (firstPageBtn) firstPageBtn.disabled = (currentPage === 1);
        if (prevPageBtn) prevPageBtn.disabled = (currentPage === 1);
        if (nextPageBtn) nextPageBtn.disabled = (currentPage === totalPages || totalPages === 0);
        if (lastPageBtn) lastPageBtn.disabled = (currentPage === totalPages || totalPages === 0);
    }

    // Función para actualizar números de página
    function updatePageNumbers() {
        const paginationNumbers = document.getElementById('paginationNumbers');
        if (!paginationNumbers) return;
        
        paginationNumbers.innerHTML = '';
        
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        // Ajustar si no hay suficientes páginas visibles
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        // Botón para primera página si es necesario
        if (startPage > 1) {
            const firstBtn = createPageButton(1, false);
            paginationNumbers.appendChild(firstBtn);
            
            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'pagination-ellipsis';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
        }
        
        // Botones de páginas
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = createPageButton(i, i === currentPage);
            paginationNumbers.appendChild(pageBtn);
        }
        
        // Botón para última página si es necesario
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'pagination-ellipsis';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
            
            const lastBtn = createPageButton(totalPages, false);
            paginationNumbers.appendChild(lastBtn);
        }
    }

    // Función auxiliar para crear botones de página
    function createPageButton(pageNumber, isActive) {
        const pageBtn = document.createElement('button');
        pageBtn.className = `btn sm ${isActive ? 'primary' : 'light'}`;
        pageBtn.textContent = pageNumber;
        pageBtn.addEventListener('click', function() {
            goToPage(pageNumber);
        });
        return pageBtn;
    }

    // Función para renderizar la página actual
    function renderCurrentPage() {
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, totalSolicitudes);
        const pageData = allSolicitudes.slice(startIndex, endIndex);
        
        renderRecentSolicitudes(pageData);
    }
</script>
@endpush