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

    .month-select {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        background-color: white;
        cursor: pointer;
        transition: var(--transition);
    }

    .month-select:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
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
        height: 600px;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .cards-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .cards-header h3 {
        color: var(--primary-color);
        margin: 0;
        font-size: 1.3rem;
    }

    .cards-content {
        flex: 1;
        overflow-y: auto;
        position: relative;
    }

    .cards-content::-webkit-scrollbar {
        width: 6px;
    }

    .cards-content::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    /* Loader para cards */
    .cards-loader {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 10;
    }

    .cards-loader.active {
        display: block;
    }

    .cards-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--secondary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    .cards-loader p {
        color: #666;
        font-size: 0.9rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.5s ease forwards;
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

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        font-size: 0.8rem;
        color: #888;
    }

    .card-date {
        display: flex;
        align-items: center;
        gap: 0.3rem;
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

    .card-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .no-cards {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .no-cards i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #ddd;
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
            height: 500px;
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
            display: flex;
            height: 500px;
        }

        .cards-container-mobile {
            display: none;
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

        .cards-section {
            height: 450px;
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
    .folio-section h3,
    .cards-header h3 {
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

    .cards-header h3::before {
        content: "🚍";
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
                    <h2>Selecciona un mes</h2>
                </div>
                <div class="calendar-container">
                    <select id="monthSelect" class="month-select">
                        <option value="">Selecciona un mes</option>
                        <option value="01">Enero 2024</option>
                        <option value="02">Febrero 2024</option>
                        <option value="03">Marzo 2024</option>
                        <option value="04">Abril 2024</option>
                        <option value="05">Mayo 2024</option>
                        <option value="06">Junio 2024</option>
                        <option value="07">Julio 2024</option>
                        <option value="08">Agosto 2024</option>
                        <option value="09">Septiembre 2024</option>
                        <option value="10">Octubre 2024</option>
                        <option value="11">Noviembre 2024</option>
                        <option value="12">Diciembre 2024</option>
                    </select>
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
            <div class="cards-header">
                <h3>Calendario de credencialización</h3>
            </div>
            <div class="cards-content" id="cardsContent">
                <!-- Loader para cards -->
                <div class="cards-loader" id="cardsLoader">
                    <div class="cards-spinner"></div>
                    <p>Cargando disponibilidad...</p>
                </div>

                <!-- Cards se cargarán aquí dinámicamente -->
                <div id="cardsContainer"></div>

                <!-- Estado cuando no hay cards -->
                <div class="no-cards" id="noCards" style="display: none;">
                    <i class="fas fa-calendar-times"></i>
                    <h4>No hay citas disponibles</h4>
                    <p>Selecciona otro mes para ver la disponibilidad</p>
                </div>
            </div>
        </div>

        <!-- Cards para móviles (oculto en desktop) -->
        <div class="cards-container-mobile">
            <!-- Contenido móvil se cargará dinámicamente -->
        </div>
    </section>

    <!-- Espaciado antes del footer -->
    <div class="section-spacing"></div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Datos de ejemplo para simular la consulta de folios
    // Función para consultar el folio via API
async function consultarFolio(folio) {
    try {
        // Mostrar loading
        mostrarLoadingFolio(true);
        
        const response = await fetch(`/api/solicitudes/${folio}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Error en la consulta');
        }

        if (result.success) {
            mostrarResultadoFolio(result.data);
        } else {
            throw new Error(result.message);
        }

    } catch (error) {
        console.error('Error consultando folio:', error);
        mostrarErrorFolio(error.message);
    } finally {
        mostrarLoadingFolio(false);
    }
}

// Función para mostrar el resultado de la consulta
function mostrarResultadoFolio(solicitud) {
    // Crear o actualizar el modal de resultados
    let modal = document.getElementById('folioResultModal');
    
    if (!modal) {
        crearModalResultados();
        modal = document.getElementById('folioResultModal');
    }

    // Llenar el modal con los datos
    document.getElementById('modalFolio').textContent = solicitud.folio;
    document.getElementById('modalSolicitante').textContent = `${solicitud.nombres} ${solicitud.apellidos}`;
    document.getElementById('modalFecha').textContent = new Date(solicitud.created_at).toLocaleDateString('es-MX');
    document.getElementById('modalEstado').textContent = solicitud.estado?.nombre || 'Pendiente';
    document.getElementById('modalProximo').textContent = obtenerProximoPaso(solicitud.solicitudes_estadosId);
    
    // Aplicar clase de estado
    const estadoElement = document.getElementById('modalEstado');
    estadoElement.className = 'status-badge ' + obtenerClaseEstado(solicitud.solicitudes_estadosId);

    // Mostrar información adicional
    document.getElementById('modalEscuela').textContent = solicitud.escuela_procedencia;
    document.getElementById('modalCorreo').textContent = solicitud.correo;
    document.getElementById('modalTelefono').textContent = solicitud.telefono;
    document.getElementById('modalTerminal').textContent = solicitud.terminal?.nombre || 'No asignada';

    // Mostrar el modal
    modal.style.display = 'flex';
}

// Función para crear el modal de resultados (si no existe)
function crearModalResultados() {
    const modalHTML = `
        <div id="folioResultModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Estado de tu Solicitud</h3>
                    <span class="close-modal" onclick="cerrarModalFolio()">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="folio-info-grid">
                        <div class="info-item">
                            <label>Folio:</label>
                            <span id="modalFolio" class="folio-number"></span>
                        </div>
                        <div class="info-item">
                            <label>Solicitante:</label>
                            <span id="modalSolicitante"></span>
                        </div>
                        <div class="info-item">
                            <label>Fecha de solicitud:</label>
                            <span id="modalFecha"></span>
                        </div>
                        <div class="info-item">
                            <label>Estado:</label>
                            <span id="modalEstado" class="status-badge"></span>
                        </div>
                        <div class="info-item">
                            <label>Escuela:</label>
                            <span id="modalEscuela"></span>
                        </div>
                        <div class="info-item">
                            <label>Correo:</label>
                            <span id="modalCorreo"></span>
                        </div>
                        <div class="info-item">
                            <label>Teléfono:</label>
                            <span id="modalTelefono"></span>
                        </div>
                        <div class="info-item">
                            <label>Terminal asignada:</label>
                            <span id="modalTerminal"></span>
                        </div>
                    </div>
                    <div class="proximo-paso">
                        <h4>Próximo paso:</h4>
                        <p id="modalProximo"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="cerrarModalFolio()">Aceptar</button>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Agregar CSS para el modal
    agregarCSSModal();
}

// Función auxiliar para obtener la clase del estado
function obtenerClaseEstado(estadoId) {
    const clases = {
        1: 'status-pending',     // Pendiente
        2: 'status-processing',  // En proceso
        3: 'status-approved',    // Aprobado
        4: 'status-completed',   // Completado
        5: 'status-rejected'     // Rechazado
    };
    return clases[estadoId] || 'status-pending';
}

// Función auxiliar para obtener el próximo paso
function obtenerProximoPaso(estadoId) {
    const pasos = {
        1: 'Revisión inicial de documentación (2-3 días hábiles)',
        2: 'Verificación de requisitos académicos (3-5 días hábiles)',
        3: 'Generación de credencial (5-7 días hábiles)',
        4: 'Recolección en terminal asignada',
        5: 'Proceso finalizado'
    };
    return pasos[estadoId] || 'Proceso en revisión';
}

// Función para mostrar/ocultar loading
function mostrarLoadingFolio(mostrar) {
    const button = document.querySelector('#folioForm button[type="submit"]');
    
    if (mostrar) {
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Consultando...';
        button.disabled = true;
    } else {
        button.innerHTML = 'Consultar Estado';
        button.disabled = false;
    }
}

// Función para mostrar error
function mostrarErrorFolio(mensaje) {
    // Puedes usar SweetAlert o un modal de error
    Swal.fire({
        icon: 'error',
        title: 'Folio no encontrado',
        text: mensaje,
        confirmButtonText: 'Aceptar'
    });
    
    // O usar alert simple:
    // alert('Error: ' + mensaje);
}

// Función para cerrar el modal
function cerrarModalFolio() {
    const modal = document.getElementById('folioResultModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Cerrar modal al hacer click fuera
window.addEventListener('click', function(event) {
    const modal = document.getElementById('folioResultModal');
    if (modal && event.target === modal) {
        cerrarModalFolio();
    }
});

// Manejar el envío del formulario de folio
document.getElementById('folioForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const folio = document.getElementById('folioInput').value.trim().toUpperCase();
    
    if (folio) {
        consultarFolio(folio);
    } else {
        mostrarErrorFolio('Por favor, ingresa un folio válido');
    }
});

// CSS para el modal de resultados
function agregarCSSModal() {
    const css = `
        <style>
            .modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }

            .modal-content {
                background: white;
                border-radius: 10px;
                width: 90%;
                max-width: 600px;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }

            .modal-header {
                padding: 1.5rem;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: var(--primary-color);
                color: white;
                border-radius: 10px 10px 0 0;
            }

            .modal-header h3 {
                margin: 0;
                font-size: 1.3rem;
            }

            .close-modal {
                font-size: 1.5rem;
                cursor: pointer;
                background: rgba(255,255,255,0.2);
                width: 30px;
                height: 30px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: var(--transition);
            }

            .close-modal:hover {
                background: rgba(255,255,255,0.3);
            }

            .modal-body {
                padding: 1.5rem;
            }

            .folio-info-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }

            .info-item {
                display: flex;
                flex-direction: column;
                gap: 0.3rem;
            }

            .info-item label {
                font-weight: 600;
                color: var(--primary-color);
                font-size: 0.9rem;
            }

            .folio-number {
                font-weight: bold;
                color: var(--secondary-color);
                font-size: 1.1rem;
            }

            .status-badge {
                padding: 0.3rem 0.8rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                display: inline-block;
            }

            .status-pending {
                background-color: #fff3cd;
                color: #856404;
            }

            .status-processing {
                background-color: #cce7ff;
                color: #004085;
            }

            .status-approved {
                background-color: #d4edda;
                color: #155724;
            }

            .status-completed {
                background-color: #d1ecf1;
                color: #0c5460;
            }

            .status-rejected {
                background-color: #f8d7da;
                color: #721c24;
            }

            .proximo-paso {
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 5px;
                border-left: 4px solid var(--secondary-color);
            }

            .proximo-paso h4 {
                margin: 0 0 0.5rem 0;
                color: var(--primary-color);
            }

            .proximo-paso p {
                margin: 0;
                color: #666;
            }

            .modal-footer {
                padding: 1rem 1.5rem;
                border-top: 1px solid #eee;
                text-align: right;
            }

            @media (max-width: 768px) {
                .folio-info-grid {
                    grid-template-columns: 1fr;
                }
                
                .modal-content {
                    width: 95%;
                    margin: 1rem;
                }
            }
        </style>
    `;

    document.head.insertAdjacentHTML('beforeend', css);
}  

    // Elementos del DOM
    const folioForm = document.getElementById('folioForm');
    const folioInput = document.getElementById('folioInput');
    const modalFolio = document.getElementById('modalFolio');
    const modalSolicitante = document.getElementById('modalSolicitante');
    const modalFecha = document.getElementById('modalFecha');
    const modalEstado = document.getElementById('modalEstado');
    const modalProximo = document.getElementById('modalProximo');
    const monthSelect = document.getElementById('monthSelect');
    const cardsLoader = document.getElementById('cardsLoader');
    const cardsContainer = document.getElementById('cardsContainer');
    const noCards = document.getElementById('noCards');

     const IMAGE_BASE_URL = "{{ route('tools.getimagen', ['path' => '']) }}";

    // Slider
    const slides = document.querySelector('.slides');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 0;
    let slideInterval;

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

    // Manejar cambio de mes
    monthSelect.addEventListener('change', function() {
        const mesSeleccionado = this.value;
        if (mesSeleccionado) {
            cargarCitasPorMes(mesSeleccionado);
        } else {
            limpiarCards();
        }
    });

    // Función para cargar citas por mes
    async function cargarCitasPorMes(mes) {
    // Mostrar loader
    cardsLoader.classList.add('active');
    cardsContainer.innerHTML = '';
    noCards.style.display = 'none';

    try {
        // Consumir API real en lugar de datos simulados
        const response = await fetch('/api/horarios-credencializacion');
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        const data = await response.json();

        if (data.success) {
            const citas = data.data || [];

            // Filtrar citas por mes si es necesario
            // (asumiendo que la fecha está en formato que permite filtrar por mes)
            const citasFiltradas = filtrarCitasPorMes(citas, mes);

            if (citasFiltradas.length === 0) {
                // Mostrar estado de no hay citas
                noCards.style.display = 'block';
            } else {
                // Generar cards
                citasFiltradas.forEach((cita, index) => {
                    const card = crearCard(cita, index);
                    cardsContainer.appendChild(card);
                });
            }
        } else {
            throw new Error(data.message || 'Error en la respuesta del servidor');
        }
    } catch (error) {
        console.error('Error al cargar citas:', error);
        cardsContainer.innerHTML = `
            <div class="no-cards">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Error al cargar</h4>
                <p>${error.message || 'Intenta nuevamente más tarde'}</p>
                <button class="btn primary mt-2" onclick="cargarCitasPorMes('${mes}')">
                    <i class="fas fa-redo"></i> Reintentar
                </button>
            </div>
        `;
    } finally {
        // Ocultar loader
        cardsLoader.classList.remove('active');
    }
}

// Función auxiliar para filtrar citas por mes
function filtrarCitasPorMes(citas, mes) {
    if (!mes || mes === 'todos') {
        return citas;
    }

    return citas.filter(cita => {
        if (!cita.fecha) return false;
        
        // Convertir el mes a número (asumiendo que 'mes' es un string como "01", "02", etc.)
        const mesNumero = parseInt(mes);
        const fechaCita = new Date(cita.fecha);
        
        // +1 porque getMonth() retorna 0-11
        return fechaCita.getMonth() + 1 === mesNumero;
    });
}

    // Función para crear card
    function crearCard(cita, index) {
        const card = document.createElement('div');
        card.className = 'card';
        card.style.animationDelay = `${index * 0.1}s`;

        card.innerHTML = `
            <div class="card-img">
                <img src="${IMAGE_BASE_URL}/${cita.imagen}" alt="${cita.lugar}">
            </div>
            <div class="card-content">
                <h3>${cita.lugar}</h3>
                <p>${cita.descripcion??""}</p>
                <div class="card-meta">
                    <div class="card-date">
                        <i class="fas fa-calendar"></i>
                        ${cita.fecha}
                    </div>
                    <span>Horario: ${cita.horario}</span>
                </div>
                <button class="card-btn" ${cita.disponibles === 0 ? 'disabled' : ''}>
                    ${cita.disponibles === 0 ? 'Agotado' : 'Realizar Solicitud'}
                </button>
            </div>
        `;

        // Agregar evento al botón
        const btn = card.querySelector('.card-btn');
        if (!btn.disabled) {
            btn.addEventListener('click', () => {
                solicitarCita(cita);
            });
        }

        return card;
    }

    // Función para solicitar cita
    function solicitarCita(cita) {
        // Aquí puedes redirigir al formulario de solicitud o mostrar un modal
        alert(`Solicitando cita para: ${cita.titulo}\nFecha: ${cita.fecha}`);
        
        // Simular reducción de cupos
        cita.disponibles--;
        const mesActual = monthSelect.value;
        cargarCitasPorMes(mesActual);
    }

    // Función para limpiar cards
    function limpiarCards() {
        cardsContainer.innerHTML = '';
        noCards.style.display = 'none';
    }

    // Manejar el envío del formulario de folio
    folioForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const folio = folioInput.value.trim().toUpperCase();
        
        if (folio) {
            consultarFolio(folio);
        }
    });


    // Cargar citas del mes actual al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        const mesActual = new Date().getMonth() + 1;
        const mesActualStr = mesActual.toString().padStart(2, '0');
        monthSelect.value = mesActualStr;
        cargarCitasPorMes(mesActualStr);
    });
</script>
@endpush