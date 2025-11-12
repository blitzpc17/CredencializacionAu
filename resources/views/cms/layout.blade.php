<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Responsivo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Styles -->
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

        .dashboard-content {
            padding: 20px;
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

        /* Breadcrumb */
        .breadcrumb {
            margin-bottom: 2rem;
            padding: 1rem 0;
        }

        .breadcrumb-list {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.5rem;
        }

        .breadcrumb-item {
            color: var(--gray);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--dark);
        }

        .breadcrumb-item:not(:last-child)::after {
            content: "/";
            margin-left: 0.5rem;
            color: var(--gray);
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
            width: calc(100% - var(--sidebar-collapsed));
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
            top: 1px;
            left: 1px;
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

        /* Overlay para móviles */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                z-index: 1000;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .sidebar.collapsed.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .nav-toggle {
                display: block;
            }

            .search-bar {
                width: 200px;
            }

            /* Prevenir scroll horizontal */
            body {
                overflow-x: hidden;
            }
            
            .dashboard-content {
                width: 100%;
                overflow-x: hidden;
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
            
            .sidebar {
                width: 280px;
            }
        }
    </style>
    
    @stack('css')
</head>
<body>
    <div class="dashboard-container">
        <!-- Overlay para móviles -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <div class="logo-img">DA</div>
                    <span class="logo-text">Dashboard Au</span>
                </div>
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <ul class="sidebar-menu">
                <li class="menu-header">Navegación Principal</li>
                <li class="menu-item">
                    <a href="{{route('cms.dash')}}" class="menu-link active">
                        <i class="fas fa-home menu-icon"></i>
                        <span class="menu-text">Inicio</span>
                    </a>
                </li>            
                
                <li class="menu-header">CREDENCIALIZACIÓN</li>
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

                 <li class="menu-item">
                    <a href="{{route('cms.horarios-credencializacion.index')}}" class="menu-link">
                        <i class="fas fa-clock menu-icon"></i>
                        <span class="menu-text">Horarios</span>
                    </a>
                </li>
                
                <li class="menu-header">SISTEMA</li>
                <li class="menu-item">
                    <a href="{{route('cms.controles')}}" class="menu-link">
                        <i class="fas fa-chart-bar menu-icon"></i>
                        <span class="menu-text">Controles</span>
                    </a>
                </li>
                <li class="menu-item dropdown">
                    <a href="#" class="menu-link dropdown-toggle">
                        <i class="fas fa-cog menu-icon"></i>
                        <span class="menu-text">Catálogos</span>
                        <i class="fas fa-angle-left dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="menu-item">
                            <a href="{{route('cms.perfiles.index')}}" class="menu-link">
                                <span class="menu-text">Perfiles</span>
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
            @yield('content')
        </main>
    </div>

    <script>
        // Funcionalidad del botón hamburguesa al estilo AdminLTE
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const navToggle = document.getElementById('navToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Toggle sidebar desde el botón interno
            toggleBtn.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                } else {
                    sidebar.classList.toggle('collapsed');
                }
            });
            
            // Toggle sidebar desde el botón del header (para móviles)
            navToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                
                // Prevenir scroll del body cuando el sidebar está abierto
                if (sidebar.classList.contains('show')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
            
            // Cerrar sidebar al hacer clic en el overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            });

            // Dropdowns del menú - SOLUCIÓN CORREGIDA
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('show');
                    
                    const arrow = this.querySelector('.dropdown-arrow');
                    arrow.classList.toggle('fa-angle-left');
                    arrow.classList.toggle('fa-angle-down');
                });
            });
            
            // Cerrar sidebar al hacer clic en un enlace (en móviles)
            /*
            document.querySelectorAll('.menu-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            });*/

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
            
            // Cerrar sidebar al redimensionar la ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
    
    @stack('js')
</body>
</html>