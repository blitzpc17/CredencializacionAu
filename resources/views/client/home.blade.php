@extends('client.layout')

@push('css')
<style>
    /* Slider Principal */
    .slider {
        position: relative;
        height: 500px;
        overflow: hidden;
        margin-top: 80px;
        width: 100%;
        border-radius: 0;
    }

    .slides {
        display: flex;
        width: 300%;
        height: 100%;
        transition: transform 0.5s ease;
    }

    .slide {
        width: 33.333%;
        height: 100%;
        position: relative;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slide-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 2rem;
    }

    .slide-content h2 {
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        animation: fadeInUp 0.8s ease;
    }

    .slide-content p {
        font-size: 1.2rem;
        animation: fadeInUp 1s ease;
    }

    .slider-nav {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
    }

    .slider-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.5);
        cursor: pointer;
        transition: var(--transition);
    }

    .slider-dot.active {
        background-color: white;
    }

    /* Sección Principal: Calendario y Cards */
    .main-section {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 2rem;
        margin: 3rem 0;
        align-items: start;
    }

    .left-column {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .calendar-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .calendar-header h2 {
        color: var(--primary-color);
    }

    .calendar-container {
        position: relative;
    }

    #calendar {
        width: 100%;
    }

    /* Sección flotante de folio - ahora en columna izquierda */
    .folio-section {
        background-color: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        animation: slideInRight 0.5s ease;
        transition: var(--transition);
    }

    .folio-section h3 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-size: 1.2rem;
    }

    .folio-form {
        display: flex;
        flex-direction: column;
    }

    .folio-form input {
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .folio-form button {
        background-color: var(--secondary-color);
        color: white;
        border: none;
        padding: 0.8rem;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }

    .folio-form button:hover {
        background-color: #2980b9;
    }

    /* Cards Section - ahora en columna derecha */
    .cards-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        max-height: 600px;
        overflow-y: auto;
    }

    .cards-section::-webkit-scrollbar {
        width: 6px;
    }

    .cards-section::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    /* Cards estilo Flutter */
    .card {
        display: flex;
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border-left: 5px solid var(--secondary-color);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-img {
        width: 120px;
        height: 120px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .card:hover .card-img img {
        transform: scale(1.05);
    }

    .card-content {
        padding: 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card h3 {
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .card p {
        color: #666;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .card-btn {
        align-self: flex-start;
        background-color: var(--secondary-color);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
    }

    .card-btn:hover {
        background-color: #2980b9;
    }

    /* Contenedor de cards para móviles */
    .cards-container-mobile {
        display: none;
        width: 100%;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .slider {
            height: 400px;
            margin-top: 70px;
        }

        .slide-content h2 {
            font-size: 1.8rem;
        }

        .main-section {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .left-column {
            gap: 1.5rem;
        }

        .cards-section {
            max-height: none;
            overflow-y: visible;
        }
    }

    @media (max-width: 768px) {
        .slider {
            height: 300px;
        }

        .slide-content {
            padding: 1rem;
        }

        .slide-content h2 {
            font-size: 1.5rem;
        }

        .slide-content p {
            font-size: 1rem;
        }

        .card {
            flex-direction: column;
        }

        .card-img {
            width: 100%;
            height: 200px;
        }

        .cards-section {
            display: none;
        }

        .cards-container-mobile {
            display: block;
        }

        .card-mobile {
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-left: 5px solid var(--secondary-color);
        }

        .card-mobile:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-mobile h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .card-mobile p {
            color: #666;
            margin-bottom: 1rem;
        }

        .card-mobile-img {
            width: 100%;
            height: 200px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .card-mobile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .card-mobile:hover .card-mobile-img img {
            transform: scale(1.05);
        }
    }

    @media (max-width: 480px) {
        .slider {
            height: 250px;
        }

        .slide-content h2 {
            font-size: 1.3rem;
        }

        .slide-content p {
            font-size: 0.9rem;
        }

        .calendar-section,
        .folio-section,
        .cards-section {
            padding: 1rem;
        }
    }

    /* Espaciado mejorado */
    .section-spacing {
        margin: 2rem 0;
    }

    /* Mejoras visuales */
    .calendar-section,
    .folio-section,
    .cards-section {
        border: 1px solid #e9ecef;
    }

    .calendar-header h2,
    .folio-section h3 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .calendar-header h2::before {
        content: "📅";
        font-size: 1.5rem;
    }

    .folio-section h3::before {
        content: "📋";
        font-size: 1.5rem;
    }
</style>
@endpush

@section('content')
    <!-- Slider Principal -->
    <section class="slider">
        <div class="slides">
            <div class="slide">
                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="Autobuses">
                <div class="slide-content">
                    <h2>Proceso de Credencialización 2023</h2>
                    <p>Conoce las fechas disponibles para el trámite de credencialización</p>
                </div>
            </div>
            <div class="slide">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="Transporte">
                <div class="slide-content">
                    <h2>Nuevos Requisitos 2023</h2>
                    <p>Actualizamos nuestros requisitos para agilizar el proceso</p>
                </div>
            </div>
            <div class="slide">
                <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="Carretera">
                <div class="slide-content">
                    <h2>Asistencia Personalizada</h2>
                    <p>Contamos con personal capacitado para resolver tus dudas</p>
                </div>
            </div>
        </div>
        <div class="slider-nav">
            <div class="slider-dot active" data-slide="0"></div>
            <div class="slider-dot" data-slide="1"></div>
            <div class="slider-dot" data-slide="2"></div>
        </div>
    </section>

    <!-- Espaciado después del slider -->
    <div class="section-spacing"></div>

    <!-- Sección Principal: Calendario y Cards -->
    <section class="container main-section">
        <!-- Columna Izquierda: Calendario y Folio -->
        <div class="left-column">
            <!-- Sección de Calendario -->
            <div class="calendar-section">
                <div class="calendar-header">
                    <h2>Selecciona una fecha</h2>
                </div>
                <div class="calendar-container">
                    <input type="text" id="calendar" placeholder="Selecciona una fecha para tu cita">
                </div>
            </div>

            <!-- Sección de Folio -->
            <div class="folio-section">
                <h3>Consulta tu folio</h3>
                <p>Si ya cuentas con un folio de solicitud, ingrésalo para ver el estado de tu trámite.</p>
                <form class="folio-form" id="folioForm">
                    <input type="text" placeholder="Ingresa tu folio" id="folioInput" required>
                    <button type="submit">Consultar Estado</button>
                </form>
            </div>
        </div>

        <!-- Columna Derecha: Cards -->
        <div class="cards-section">
            <div class="card">
                <div class="card-img">
                    <img src="https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Terminal Norte">
                </div>
                <div class="card-content">
                    <h3>Terminal Norte</h3>
                    <p>Ubicada en la zona norte de la ciudad, con amplio estacionamiento y facilidades para autobuses de larga distancia.</p>
                    <button class="card-btn">Realizar Solicitud</button>
                </div>
            </div>
            
            <div class="card">
                <div class="card-img">
                    <img src="https://images.unsplash.com/photo-1570125909517-53cb21c89ff2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Terminal Sur">
                </div>
                <div class="card-content">
                    <h3>Terminal Sur</h3>
                    <p>Modernas instalaciones con tecnología de punta para agilizar el proceso de credencialización.</p>
                    <button class="card-btn">Realizar Solicitud</button>
                </div>
            </div>
            
            <div class="card">
                <div class="card-img">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Centro de Verificación">
                </div>
                <div class="card-content">
                    <h3>Centro de Verificación</h3>
                    <p>Especializado en la revisión técnica de autobuses para garantizar el cumplimiento de normas.</p>
                    <button class="card-btn">Realizar Solicitud</button>
                </div>
            </div>
            
            <div class="card">
                <div class="card-img">
                    <img src="https://images.unsplash.com/photo-1511919884226-fd3cad34687c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Oficina Central">
                </div>
                <div class="card-content">
                    <h3>Oficina Central</h3>
                    <p>Sede principal con atención personalizada y trámites especializados para flotas de autobuses.</p>
                    <button class="card-btn">Realizar Solicitud</button>
                </div>
            </div>
        </div>

        <!-- Cards para móviles -->
        <div class="cards-container-mobile">
            <div class="card-mobile">
                <div class="card-mobile-img">
                    <img src="https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Terminal Norte">
                </div>
                <h3>Terminal Norte</h3>
                <p>Ubicada en la zona norte de la ciudad, con amplio estacionamiento y facilidades para autobuses de larga distancia.</p>
                <button class="card-btn">Realizar Solicitud</button>
            </div>
            
            <div class="card-mobile">
                <div class="card-mobile-img">
                    <img src="https://images.unsplash.com/photo-1570125909517-53cb21c89ff2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Terminal Sur">
                </div>
                <h3>Terminal Sur</h3>
                <p>Modernas instalaciones con tecnología de punta para agilizar el proceso de credencialización.</p>
                <button class="card-btn">Realizar Solicitud</button>
            </div>
            
            <div class="card-mobile">
                <div class="card-mobile-img">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Centro de Verificación">
                </div>
                <h3>Centro de Verificación</h3>
                <p>Especializado en la revisión técnica de autobuses para garantizar el cumplimiento de normas.</p>
                <button class="card-btn">Realizar Solicitud</button>
            </div>
            
            <div class="card-mobile">
                <div class="card-mobile-img">
                    <img src="https://images.unsplash.com/photo-1511919884226-fd3cad34687c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Oficina Central">
                </div>
                <h3>Oficina Central</h3>
                <p>Sede principal con atención personalizada y trámites especializados para flotas de autobuses.</p>
                <button class="card-btn">Realizar Solicitud</button>
            </div>
        </div>
    </section>

    <!-- Espaciado antes del footer -->
    <div class="section-spacing"></div>
@endsection

@push('js')
<script>
    // Datos de ejemplo para simular la consulta de folios
    const foliosData = {
        "ABC123": {
            solicitante: "Transportes del Norte S.A. de C.V.",
            fecha: "15/08/2023",
            estado: "En proceso",
            estadoClass: "status-pending",
            proximo: "Revisión de documentación (Fecha estimada: 25/08/2023)"
        },
        "DEF456": {
            solicitante: "Autobuses Sureños",
            fecha: "10/08/2023",
            estado: "Aprobado",
            estadoClass: "status-approved",
            proximo: "Entrega de credenciales (Fecha estimada: 30/08/2023)"
        },
        "GHI789": {
            solicitante: "Líneas Unidas del Pacífico",
            fecha: "05/08/2023",
            estado: "Completado",
            estadoClass: "status-completed",
            proximo: "Proceso finalizado"
        }
    };

    // Elementos del DOM específicos de home
    const folioForm = document.getElementById('folioForm');
    const folioInput = document.getElementById('folioInput');
    const modalFolio = document.getElementById('modalFolio');
    const modalSolicitante = document.getElementById('modalSolicitante');
    const modalFecha = document.getElementById('modalFecha');
    const modalEstado = document.getElementById('modalEstado');
    const modalProximo = document.getElementById('modalProximo');

    // Slider
    const slides = document.querySelector('.slides');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    let slideInterval;

    // Calendario
    const calendar = flatpickr("#calendar", {
        locale: "es",
        minDate: "today",
        dateFormat: "d/m/Y",
        disable: [
            function(date) {
                // Deshabilitar fines de semana
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ],
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                // Aquí podrías mostrar disponibilidad para la fecha seleccionada
                console.log("Fecha seleccionada:", dateStr);
            }
        }
    });

    // Funcionalidad del slider
    function showSlide(n) {
        currentSlide = n;
        slides.style.transform = `translateX(-${currentSlide * 33.333}%)`;
        
        // Actualizar dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }

    // Inicializar dots del slider
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            resetSlideInterval();
        });
    });

    // Auto avanzar slider
    function startSlideInterval() {
        slideInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % 3;
            showSlide(currentSlide);
        }, 5000);
    }

    function resetSlideInterval() {
        clearInterval(slideInterval);
        startSlideInterval();
    }

    startSlideInterval();

    // Manejar el envío del formulario de folio
    folioForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const folio = folioInput.value.trim().toUpperCase();
        
        if (folio) {
            consultarFolio(folio);
        }
    });

    // Función para consultar el folio
    function consultarFolio(folio) {
        if (foliosData[folio]) {
            // Mostrar información del folio en el modal
            const data = foliosData[folio];
            modalFolio.textContent = folio;
            modalSolicitante.textContent = data.solicitante;
            modalFecha.textContent = data.fecha;
            modalEstado.textContent = data.estado;
            modalEstado.className = 'status-badge ' + data.estadoClass;
            modalProximo.textContent = data.proximo;
            
            // Mostrar el modal
            document.getElementById('folioModal').style.display = 'flex';
        } else {
            // Folio no encontrado
            alert('Folio no encontrado. Por favor, verifica el número e intenta nuevamente.');
        }
        
        // Limpiar el campo de entrada
        folioInput.value = '';
    }
</script>
@endpush