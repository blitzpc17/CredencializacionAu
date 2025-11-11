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
</style>
@endpush


@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Dashboard</h1>
    
    <!-- Cards -->
    <div class="cards-container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ingresos Totales</div>
                <div class="card-icon blue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="card-value">$24,580</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>12.5%</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Nuevos Usuarios</div>
                <div class="card-icon green">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="card-value">1,254</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>5.2%</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tasa de Conversión</div>
                <div class="card-icon orange">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
            <div class="card-value">4.7%</div>
            <div class="card-change negative">
                <i class="fas fa-arrow-down"></i>
                <span>1.8%</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Pedidos Pendientes</div>
                <div class="card-icon red">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="card-value">56</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-down"></i>
                <span>2.3%</span>
            </div>
        </div>
    </div>
    
    <!-- Gráficas -->
    <div class="charts-container">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Ventas Mensuales</div>
                <div class="chart-actions">
                    <button class="chart-action-btn"><i class="fas fa-download"></i></button>
                    <button class="chart-action-btn"><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Tráfico por Fuente</div>
                <div class="chart-actions">
                    <button class="chart-action-btn"><i class="fas fa-download"></i></button>
                    <button class="chart-action-btn"><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Tabla -->
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">Usuarios Recientes</div>
            <div class="table-actions">
                <button class="chart-action-btn"><i class="fas fa-sync"></i></button>
                <button class="chart-action-btn"><i class="fas fa-filter"></i></button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>Administrador</td>
                    <td><span class="status active">Activo</span></td>
                    <td>
                        <button class="chart-action-btn"><i class="fas fa-edit"></i></button>
                        <button class="chart-action-btn"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td>Editor</td>
                    <td><span class="status active">Activo</span></td>
                    <td>
                        <button class="chart-action-btn"><i class="fas fa-edit"></i></button>
                        <button class="chart-action-btn"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Robert Johnson</td>
                    <td>robert@example.com</td>
                    <td>Usuario</td>
                    <td><span class="status pending">Pendiente</span></td>
                    <td>
                        <button class="chart-action-btn"><i class="fas fa-edit"></i></button>
                        <button class="chart-action-btn"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Sarah Williams</td>
                    <td>sarah@example.com</td>
                    <td>Usuario</td>
                    <td><span class="status inactive">Inactivo</span></td>
                    <td>
                        <button class="chart-action-btn"><i class="fas fa-edit"></i></button>
                        <button class="chart-action-btn"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection



@push('js')
<script>
    // Gráficas con Chart.js
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfica de ventas
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ventas 2023',
                    data: [6500, 5900, 8000, 8100, 5600, 5500, 7000, 7500, 8200, 7800, 9000, 9500],
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
        
        // Gráfica de tráfico
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(trafficCtx, {
            type: 'doughnut',
            data: {
                labels: ['Directo', 'Social', 'Email', 'Búsqueda'],
                datasets: [{
                    data: [40, 25, 20, 15],
                    backgroundColor: [
                        '#4361ee',
                        '#3f37c9',
                        '#4cc9f0',
                        '#4895ef'
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
                cutout: '70%'
            }
        });
        
        // Animación de entrada para las cards
        const cards = document.querySelectorAll('.card, .chart-card, .table-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => {
            card.style.animationPlayState = 'paused';
            observer.observe(card);
        });
    });
</script>
@endpush