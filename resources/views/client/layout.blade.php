<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencialización de Autobuses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    @stack('css')
    
    <style>
        /* Variables CSS */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Loader */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--primary-color);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .bus-loader {
            width: 100px;
            height: 60px;
            position: relative;
            margin-bottom: 20px;
        }

        .bus-body {
            width: 100px;
            height: 40px;
            background-color: #3498db;
            border-radius: 10px 10px 0 0;
            position: relative;
            overflow: hidden;
        }

        .bus-window {
            width: 80px;
            height: 20px;
            background-color: #a5d8ff;
            position: absolute;
            top: 5px;
            left: 10px;
            border-radius: 5px;
        }

        .bus-wheels {
            display: flex;
            justify-content: space-between;
            padding: 0 15px;
            margin-top: -5px;
        }

        .wheel {
            width: 20px;
            height: 20px;
            background-color: #333;
            border-radius: 50%;
            position: relative;
            animation: rotate 1s linear infinite;
        }

        .road {
            width: 120px;
            height: 5px;
            background-color: #7f8c8d;
            border-radius: 5px;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .road::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #ecf0f1, transparent);
            animation: road-line 1.5s linear infinite;
        }

        .loader-text {
            color: white;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes road-line {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Header y Navegación */
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 80px;
        }

        header.hidden {
            transform: translateY(-100%);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .logo i {
            font-size: 2rem;
            color: var(--secondary-color);
        }

        .logo h1 {
            font-size: 1.5rem;
            white-space: nowrap;
        }

        /* Menú Hamburguesa */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            z-index: 1001;
            padding: 5px;
            margin-left: auto;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 3px 0;
            transition: var(--transition);
            border-radius: 2px;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin-left: 1.5rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 0;
            position: relative;
            white-space: nowrap;
        }

        nav ul li a:hover {
            color: var(--secondary-color);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary-color);
            transition: var(--transition);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--secondary-color);
        }

        .footer-column p, .footer-column a {
            color: #bbb;
            margin-bottom: 0.8rem;
            display: block;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-column a:hover {
            color: var(--secondary-color);
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons a {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: var(--transition);
        }

        .social-icons a:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
            font-size: 0.9rem;
        }

        

        /* Botón flotante de WhatsApp */
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 999;
            transition: var(--transition);
            animation: pulse 2s infinite;
            text-decoration: none;
        }

        .whatsapp-tooltip {
            position: absolute;
            bottom: 70px;
            right: 0;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: var(--transition);
        }

        .whatsapp-btn:hover .whatsapp-tooltip {
            opacity: 1;
            bottom: 75px;
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .header-content {
                position: relative;
            }

            .menu-toggle {
                display: flex;
            }

            nav ul {
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                max-width: 300px;
                height: 100vh;
                background-color: var(--primary-color);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: var(--transition);
                z-index: 1000;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
                padding: 2rem 0;
            }

            nav ul.active {
                right: 0;
            }

            nav ul li {
                margin: 1rem 0;
                width: 100%;
                text-align: center;
            }

            nav ul li a {
                display: block;
                padding: 1rem;
                width: 100%;
            }

            nav ul li a:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-wrap: nowrap;
                justify-content: space-between;
            }

            .logo {
                flex: 1;
            }

            .logo h1 {
                font-size: 1.3rem;
            }

            .menu-toggle {
                margin-left: 1rem;
            }

            .whatsapp-btn {
                bottom:10px;
                right:10px;
            }
        }

        @media (max-width: 576px) {
            .logo h1 {
                font-size: 1.1rem;
            }

            .logo i {
                font-size: 1.5rem;
            }

            .menu-toggle {
                margin-left: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                width: 95%;
            }

            .logo h1 {
                font-size: 1rem;
            }

            header {
                padding: 0.8rem 0;
            }
        }

        @media (max-width: 360px) {
            .logo h1 {
                font-size: 0.9rem;
            }

            .logo i {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="loader" id="loader">
        <div class="bus-loader">
            <div class="bus-body">
                <div class="bus-window"></div>
            </div>
            <div class="bus-wheels">
                <div class="wheel"></div>
                <div class="wheel"></div>
            </div>
            <div class="road"></div>
        </div>
        <div class="loader-text">Cargando sistema de credencialización...</div>
    </div>

    <!-- Header con navegación -->
    <header id="header">
        <div class="container header-content">
            <div class="logo">
                <i class="fas fa-bus"></i>
                <h1>Sistema de Credencialización</h1>
            </div>
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav>
                <ul id="navMenu">
                    <li><a href="{{route('client.home')}}">Inicio</a></li>
                    <li><a href="#">Requisitos</a></li>
                    <li><a href="{{route('client.solicitud')}}">Realizar solicitud</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    @yield('content')

    <!-- Botón flotante de WhatsApp -->
    <a href="https://wa.me/5215512345678" class="whatsapp-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
        <div class="whatsapp-tooltip">¿Tienes dudas?</div>
    </a>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <p><i class="fas fa-phone"></i> Tel: (55) 1234-5678</p>
                    <p><i class="fas fa-envelope"></i> Email: info@credencializacion.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Dirección: Av. Principal #123, Ciudad de México</p>
                </div>
                <div class="footer-column">
                    <h3>Enlaces Rápidos</h3>
                    <a href="index.html">Inicio</a>
                    <a href="calendarizacion.html">Calendarización</a>
                    <a href="requisitos.html">Requisitos</a>
                    <a href="contacto.html">Contacto</a>
                </div>
                <div class="footer-column">
                    <h3>Síguenos</h3>
                    <p>Mantente informado sobre novedades y actualizaciones.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Sistema de Credencialización de Autobuses. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

   

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    
    @stack('js')
    
    <script>
        // Elementos del DOM
        const loader = document.getElementById('loader');
        const header = document.getElementById('header');
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
     
        // Ocultar loader después de 2 segundos
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 2000);

        // Menú hamburguesa
        menuToggle.addEventListener('click', function() {
            menuToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
            
            // Prevenir scroll del body cuando el menú está abierto
            if (navMenu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        });

        // Cerrar menú al hacer clic en un enlace
        const navLinks = document.querySelectorAll('nav ul li a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });

        // Cerrar menú al hacer clic fuera de él
        document.addEventListener('click', (e) => {
            if (!header.contains(e.target) && navMenu.classList.contains('active')) {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Ocultar/mostrar header al hacer scroll
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                header.classList.add('hidden');
            } else {
                // Scrolling up
                header.classList.remove('hidden');
            }
            
            lastScrollTop = scrollTop;
        });

      
    </script>
</body>
</html>