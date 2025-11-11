<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Responsivo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
            --warning: #ffcc00;
            --danger: #dc3545;
            --gray: #6c757d;
            --sidebar-width: 250px;
            --sidebar-collapsed: 70px;
            --header-height: 70px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Layout principal con flexbox */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar estilo AdminLTE */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            color: white;
            transition: var(--transition);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .logo-container {
            padding: 0 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            height: var(--header-height);
            min-height: var(--header-height);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            white-space: nowrap;
            padding: 15px 0;
        }

        .logo-img {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            object-fit: cover;
            background: linear-gradient(45deg, #4cc9f0, #4361ee);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }

        .logo-text {
            transition: var(--transition);
            opacity: 1;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            padding: 8px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--accent);
        }

        .sidebar-menu {
            padding: 10px 0;
            list-style: none;
            overflow-y: auto;
            height: calc(100vh - var(--header-height));
        }

        .menu-item {
            position: relative;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            gap: 12px;
            white-space: nowrap;
            overflow: hidden;
            border-left: 3px solid transparent;
        }

        .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .menu-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 3px solid var(--accent);
        }

        .menu-icon {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu-text {
            transition: var(--transition);
            opacity: 1;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        .dropdown-arrow {
            margin-left: auto;
            transition: var(--transition);
            flex-shrink: 0;
            font-size: 0.8rem;
        }

        .sidebar.collapsed .dropdown-arrow {
            display: none;
        }

        .dropdown-menu {
            list-style: none;
            background-color: rgba(0, 0, 0, 0.2);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .dropdown-menu.show {
            max-height: 500px;
        }

        .dropdown-menu .menu-link {
            padding-left: 45px;
            font-size: 0.9rem;
        }

        .sidebar.collapsed .dropdown-menu .menu-link {
            padding-left: 15px;
        }

        .menu-header {
            padding: 10px 15px;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 10px;
        }

        .sidebar.collapsed .menu-header {
            display: none;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Header estilo AdminLTE */
        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--dark);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: #f0f2f5;
            border-radius: 20px;
            padding: 8px 15px;
            width: 300px;
        }

        .search-bar input {
            border: none;
            background: none;
            outline: none;
            margin-left: 10px;
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon, .user-profile {
            position: relative;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .user-name {
            font-weight: 600;
        }

        .dropdown-profile {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 200px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition);
            z-index: 100;
        }

        .dropdown-profile.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--dark);
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 5px 0;
        }

        /* Contenido del dashboard */
        .dashboard-content {
            padding: 20px;
        }

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

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .nav-toggle {
                display: block;
            }

            .search-bar {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .cards-container, .charts-container {
                flex-direction: column;
            }
            
            .card, .chart-card {
                min-width: 100%;
            }
            
            .search-bar {
                width: 150px;
            }
            
            .user-name {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .header {
                padding: 0 15px;
            }
            
            .dashboard-content {
                padding: 15px;
            }
            
            .search-bar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-img">DP</div>
                    <span class="logo-text">DashboardPro</span>
                </div>
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <ul class="sidebar-menu">
                <li class="menu-header">Navegación Principal</li>
                <li class="menu-item">
                    <a href="#" class="menu-link active">
                        <i class="fas fa-home menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-chart-bar menu-icon"></i>
                        <span class="menu-text">Analytics</span>
                    </a>
                </li>
                
                <li class="menu-header">E-commerce</li>
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link dropdown-toggle">
                        <i class="fas fa-shopping-cart menu-icon"></i>
                        <span class="menu-text">Tienda</span>
                        <i class="fas fa-angle-left dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Productos</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Pedidos</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Clientes</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-envelope menu-icon"></i>
                        <span class="menu-text">Mensajes</span>
                        <span class="notification-badge">5</span>
                    </a>
                </li>
                
                <li class="menu-header">Configuración</li>
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link dropdown-toggle">
                        <i class="fas fa-cog menu-icon"></i>
                        <span class="menu-text">Ajustes</span>
                        <i class="fas fa-angle-left dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Perfil</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Seguridad</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <span class="menu-text">Notificaciones</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <button class="nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar...">
                </div>
                
                <div class="header-actions">
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    
                    <div class="user-profile">
                        <div class="user-avatar">JD</div>
                        <span class="user-name">John Doe</span>
                        <i class="fas fa-chevron-down"></i>
                        
                        <div class="dropdown-profile">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Mi Perfil</span>
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Configuración</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido del dashboard -->
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
        </main>
    </div>

    <script>
        // Funcionalidad del botón hamburguesa al estilo AdminLTE
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const navToggle = document.getElementById('navToggle');
            
            // Toggle sidebar desde el botón interno
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
            
            // Toggle sidebar desde el botón del header (para móviles)
            navToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
            
            // Cerrar sidebar al hacer clic fuera en móviles
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    if (!e.target.closest('.sidebar') && !e.target.closest('#navToggle')) {
                        sidebar.classList.remove('show');
                    }
                }
            });
            
            // Dropdowns del menú
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('show');
                    
                    // Rotar la flecha
                    const arrow = this.querySelector('.dropdown-arrow');
                    arrow.classList.toggle('fa-angle-left');
                    arrow.classList.toggle('fa-angle-down');
                });
            });
            
            // Dropdown del perfil
            document.querySelector('.user-profile').addEventListener('click', function() {
                document.querySelector('.dropdown-profile').classList.toggle('show');
            });
            
            // Cerrar dropdowns al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.user-profile')) {
                    document.querySelector('.dropdown-profile').classList.remove('show');
                }
                
                if (!e.target.closest('.dropdown-toggle')) {
                    dropdownToggles.forEach(toggle => {
                        const dropdownMenu = toggle.nextElementSibling;
                        dropdownMenu.classList.remove('show');
                        
                        const arrow = toggle.querySelector('.dropdown-arrow');
                        arrow.classList.add('fa-angle-left');
                        arrow.classList.remove('fa-angle-down');
                    });
                }
            });
            
            // Gráficas con Chart.js
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
</body>
</html>