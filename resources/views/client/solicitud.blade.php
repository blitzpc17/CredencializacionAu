@extends('client.layout')

@push('css')
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 3rem 0;
        text-align: center;
        margin-bottom: 2rem;
        margin-top: 80px;
    }

    .hero h2 {
        font-size: 2.2rem;
        margin-bottom: 1rem;
        animation: fadeInDown 1s ease;
    }

    .hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeInUp 1s ease;
    }

    /* Formulario */
    .form-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-bottom: 3rem;
        animation: fadeIn 1s ease;
    }

    .form-title {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary-color);
        display: inline-block;
    }

    .form-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        border-radius: 8px;
        background-color: #f8f9fa;
        border-left: 4px solid var(--secondary-color);
        animation: slideInRight 0.5s ease;
    }

    .form-section h3 {
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section h3 i {
        color: var(--secondary-color);
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        flex: 1 1 300px;
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'><path fill='%23333' d='M2 0L0 2h4zm0 5L0 3h4z'/></svg>");
        background-repeat: no-repeat;
        background-position: right 0.7rem top 50%;
        background-size: 0.65rem auto;
        padding-right: 2.5rem;
    }

    /* Checkbox y Radio Buttons */
    .checkbox-group, .radio-group {
        margin-bottom: 1rem;
    }

    .checkbox-item, .radio-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .checkbox-item input, .radio-item input {
        margin-right: 0.5rem;
    }

    .checkbox-item label, .radio-item label {
        margin-bottom: 0;
        font-weight: normal;
    }

    /* File Upload */
    .file-upload {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-upload-btn {
        background-color: var(--secondary-color);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: var(--transition);
        width: 100%;
        justify-content: center;
    }

    .file-upload-btn:hover {
        background-color: #2980b9;
    }

    .file-upload input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-preview {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .file-preview-item {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .file-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-preview-item .file-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.3rem;
        font-size: 0.8rem;
        text-align: center;
    }

    .file-preview-item .remove-file {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: var(--accent-color);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        font-size: 0.8rem;
    }

    /* Botones */
    .btn {
        display: inline-block;
        background-color: var(--secondary-color);
        color: white;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
    }

    .btn:hover {
        background-color: #2980b9;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-block {
        display: block;
        width: 100%;
    }

    .btn-success {
        background-color: var(--success-color);
    }

    .btn-success:hover {
        background-color: #219653;
    }

    .btn-accent {
        background-color: var(--accent-color);
    }

    .btn-accent:hover {
        background-color: #c0392b;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    /* Animaciones específicas */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Modal de Términos y Condiciones - MEJORADO */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1001;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
        padding: 20px;
        
    }

    .modal-content{
        background-color: white;
        border-radius: 15px;
        max-width:  1000px;
        /*width: 100%;*/
        max-height: 90vh;        
        overflow: hidden;
        position: relative;
        animation: slideInUp 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.5rem;
        cursor: pointer;
        color: #777;
        transition: var(--transition);
        z-index: 10;
        background: rgba(255, 255, 255, 0.8);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .close-modal:hover {
        color: var(--accent-color);
        background: rgba(255, 255, 255, 1);
        transform: rotate(90deg);
    }

    .terms-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 0.85rem;/*30px;*/
        text-align: center;
        border-radius: 0; /*15px 15px 0 0;*/
        flex-shrink: 0;
    }

    .terms-header h1 {
        font-size: 1.65rem;
        margin-bottom: 5px;
    }

    .last-updated {
        font-style: italic;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    /* Contenedor principal mejorado */
    .terms-container {
        display: flex;
        height: 60vh;
        overflow: hidden;
        flex: 1;
    }

    /* Navegación lateral */
    .terms-nav {
        width: 280px;
        background: #f8f9fa;
        border-right: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        flex-shrink: 0;
    }

    .nav-header {
        padding: 15px 20px;
        background: #e9ecef;
        font-weight: 600;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .nav-links {
        list-style: none;
        padding: 0;
        margin: 0;
        flex: 1;
        overflow-y: auto;
    }

    .nav-link {
        display: block;
        padding: 12px 20px;
        color: #495057;
        text-decoration: none;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .nav-link:hover {
        background: #e9ecef;
        color: #1e3c72;
    }

    .nav-link.active {
        background: #1e3c72;
        color: white;
        border-left: 4px solid #2a5298;
    }

    .nav-progress {
        padding: 15px 20px;
        background: white;
        border-top: 1px solid #e9ecef;
    }

    .progress-bar {
        width: 100%;
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #1e3c72, #2a5298);
        width: 0%;
        transition: width 0.3s ease;
    }

    .progress-text {
        font-size: 0.8rem;
        color: #6c757d;
        text-align: center;
        display: block;
    }

    /* Contenido principal */
    .terms-content-wrapper {
        flex: 1;
        overflow-y: auto;
        position: relative;
    }

    .terms-content {
        padding: 25px;
        max-height: none;
    }

    .section {
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
        scroll-margin-top: 10px;
    }

    .section:last-child {
        border-bottom: none;
    }

    h2 {
        color: #1e3c72;
        margin-bottom: 15px;
        font-size: 1.5rem;
    }

    h3 {
        color: #2a5298;
        margin: 15px 0 10px;
        font-size: 1.2rem;
    }

    p {
        margin-bottom: 15px;
        text-align: justify;
    }

    ul, ol {
        margin: 15px 0;
        padding-left: 30px;
    }

    li {
        margin-bottom: 8px;
    }

    .highlight {
        background-color: #f0f5ff;
        padding: 15px;
        border-left: 4px solid #2a5298;
        margin: 15px 0;
        border-radius: 0 5px 5px 0;
        position: relative;
    }

    .highlight:before {
        content: "💡";
        position: absolute;
        left: -30px;
        top: 15px;
        font-size: 1.2rem;
    }

    /* Sección de aceptación mejorada */
    .acceptance-section {
        min-height: auto; /* Quitar altura fija */
        padding: 20px; /* Menos padding */
        margin-top: 20px;

        background: #f9f9f9;
        /*padding: 25px;*/
        border-radius: 10px;
        /*margin-top: 30px;*/
        text-align: center;
        border: 2px dashed #ddd;
        position: relative;
        bottom: 0;
        background: white;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px 0;
    }

    .checkbox-container input {
        margin-right: 10px;
        transform: scale(1.2);
    }

    #acceptTermsBtn {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 15px;
    }

    #acceptTermsBtn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
    }

    #acceptTermsBtn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .terms-footer {
        padding: 10px;
        background: #f5f5f5;
        color: #666;
        font-size: 0.85rem;
        border-radius: 0 0 15px 15px;
        display:flex;
        justify-content:center;

    }

    .terms-footer p{
        margin:0;
    }

    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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

    /* Responsive mejorado */
    @media (max-width: 768px) {
        .hero {
            margin-top: 70px;
            padding: 2rem 0;
        }

        .hero h2 {
            font-size: 1.8rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .form-container {
            padding: 1rem;
        }

        .form-section {
            padding: 1rem;
        }

        .modal-content {
            max-height: 95vh;
        }
        
        .terms-header h1 {
            font-size: 1.5rem;
        }
        
        .terms-container {
            flex-direction: column;
            height: 70vh;
        }
        
        .terms-nav {
            width: 100%;
            height: 150px;
            border-right: none;
            border-bottom: 1px solid #e9ecef;
        }
        
        .nav-links {
            display: flex;
            overflow-x: auto;
            flex-wrap: nowrap;
        }
        
        .nav-link {
            white-space: nowrap;
            border-bottom: none;
            border-right: 1px solid #e9ecef;
            min-width: max-content;
        }
        
        .terms-content {
            padding: 20px;
            max-height: 65vh;
        }
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 1rem;
        }

        .form-section {
            padding: 1rem;
        }

        .terms-header {
            padding: 20px;
        }
        
        .terms-content {
            padding: 15px;
        }
        
        .section {
            margin-bottom: 20px;
            padding-bottom: 15px;
        }
        
        h2 {
            font-size: 1.3rem;
        }
        
        h3 {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Formulario de Registro</h2>
            <p>Complete la siguiente información para solicitar la credencialización de su autobús</p>
        </div>
    </section>

    <!-- Formulario -->
    <section class="container">
        <form id="registroForm" class="form-container" enctype="multipart/form-data">
            <!-- Información Personal -->
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Información Personal</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombres">NOMBRE(S): *</label>
                        <input type="text" id="nombres" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="apellidos">APELLIDOS: *</label>
                        <input type="text" id="apellidos" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="perfil_academico">PERFIL ACADÉMICO: *</label>
                         <select id="perfil_academico" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="1">ESTUDIANTE</option>
                            <option value="2">DOCENTE</option>
                        </select>
                    </div>                    
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="escuela_procedencia">NOMBRE DE LA ESCUELA DE PROCEDENCIA: ESPECIFICAR EL NOMBRE COMPLETO DE LA INSTITUCION EDUCATIVA EN LA QUE PERTENECES: *</label>
                        <input type="text" id="escuela_procedencia" class="form-control" placeholder="Ej. INSTITUTO TECNOLOGICO DE TEHUACAN" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lugar_residencia">LUGAR DE RESIDENCIA: ESPECIFICA EL LUGAR DE RESIDENCIA DE LOCALIDAD: *</label>
                        <input type="text" id="lugar_residencia" class="form-control" placeholder="Ej. TEHUACAN, PUEBLA" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lugar_origen">LUGAR DE ORIGEN: *</label>
                        <input type="text" id="lugar_origen" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono">NUMERO TELEFONICO, EJEMPLO: A 10 DIGITOS *</label>
                        <input type="tel" id="telefono" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="correo">CORREO ELECTRÓNICO:</label>
                        <input type="email" id="correo" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Información de viajes -->
            <div class="form-section">
                <h3><i class="fas fa-bus"></i> Información de viaje</h3>

                 <div class="form-row">
                    <div class="form-group">
                        <label for="lugar_viaja_frecuente">LUGAR AL QUE VIAJA FRECUENTEMENTE: *</label>
                        <input type="text" id="lugar_viaja_frecuente" class="form-control"  required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="terminalesId">TERMINAL DE AUTOBUSES AU MAS CERCANA. NOTA: PARA RECOGER SU CREDENCIAL *</label>
                         <select id="terminalesId" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="1">ESTUDIANTE</option>
                            <option value="2">DOCENTE</option>                           
                        </select>
                    </div>   
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="veces_semana">¿CUANTAS VECES ESTIMA VIAJAR POR SEMANA?</label>
                        <input type="text" id="veces_semana" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="dia_semana_viaja">¿QUE DIAS DE LA SEMANA VIAJA?</label>
                        <select id="dia_semana_viaja" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="1">LUNES</option>
                            <option value="2">MARTES</option>                           
                            <option value="3">MIÉRCOLES</option>
                            <option value="4">JUEVES</option>
                            <option value="5">VIERNES</option>
                            <option value="6">SÁBADO</option>
                            <option value="7">DOMINGO</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="formaPago">FORMA DE PAGO:</label>
                        <select id="formaPago" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="1">TRANSFERENCIA</option>
                            <option value="2">PAGO EN TAQUILLA</option>
                            <option value="3">TARJETA CRÉDITO/DÉBITO</option>
                            <option value="4">EFECTIVO</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Subida de Archivos -->
            <div class="form-section">
                <h3><i class="fas fa-file-upload"></i> Documentación Requerida</h3>

                <div class="form-group">
                    <label>ADJUNTE CURP. LA CURP DEBE SER ACTUALIZADA</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-file-pdf"></i> Subir PDF o Imagen
                        </div>
                        <input type="file" id="licencia" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="file-preview" id="licenciaPreview"></div>
                </div>

                 <div class="form-group">
                    <label>ADJUNTE CREDENCIAL VIGENTE Y/O KARDEX VIGENTE, EN CASO DE SER MAESTRO ADJUNTE CREDENCIAL DE SEP VIGENTE O ULTIMO RECIBO DE PAGO Y/O CARTA DE ASIGNACION.</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-file-pdf"></i> Subir PDF o Imagen
                        </div>
                        <input type="file" id="tarjetaCirculacion" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="file-preview" id="tarjetaPreview"></div>
                </div>

                
                <div class="form-group">
                    <label>12.- ADJUNTE FOTOGRAFIA TAMAÑO INFANTIL A COLOR, CON FONDO BLANCO:</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-camera"></i> Seleccionar Imagen
                        </div>
                        <input type="file" id="fotoSolicitante" accept="image/*" required>
                    </div>
                    <div class="file-preview" id="fotoPreview"></div>
                </div>                         
               
            </div>

            <!-- Términos y Condiciones -->
            <div class="form-section">
                <h3><i class="fas fa-file-contract"></i> Términos y Condiciones</h3>
                
                <div class="form-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="terminos" required>
                        <label for="terminos">Acepto los <a href="#" id="openTermsModal">términos y condiciones</a> del servicio</label>
                    </div>
                </div>               
                
            </div>

            <!-- Botones de Acción -->
            <div class="form-actions">
                <button type="reset" class="btn btn-accent">
                    <i class="fas fa-redo"></i> Limpiar Formulario
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> Enviar Solicitud
                </button>
            </div>
        </form>
    </section>

    <!-- Modal de Términos y Condiciones - MEJORADO -->
    <div class="modal" id="termsModal">
        <div class="modal-content">
            <span class="close-modal" id="closeTermsModal">&times;</span>
            
            <div class="terms-header">
                <h1>Términos y Condiciones del Servicio</h1>
            </div>

            <div class="terms-container">
                <!-- Navegación lateral para secciones -->
                <div class="terms-nav">
                    <div class="nav-header">
                        <i class="fas fa-list"></i>
                        <span>Contenido</span>
                    </div>
                    <ul class="nav-links">
                        <li><a href="#section1" class="nav-link active">1. Aceptación</a></li>
                        <li><a href="#section2" class="nav-link">2. Descripción</a></li>
                        <li><a href="#section3" class="nav-link">3. Requisitos</a></li>
                        <li><a href="#section4" class="nav-link">4. Registro</a></li>
                        <li><a href="#section5" class="nav-link">5. Uso Aceptable</a></li>
                        <li><a href="#section6" class="nav-link">6. Privacidad</a></li>
                        <li><a href="#section7" class="nav-link">7. Tarifas</a></li>
                        <li><a href="#section8" class="nav-link">8. Vigencia</a></li>
                        <li><a href="#section9" class="nav-link">9. Responsabilidad</a></li>
                        <li><a href="#section10" class="nav-link">10. Modificaciones</a></li>
                        <li><a href="#section11" class="nav-link">11. Terminación</a></li>
                        <li><a href="#acceptance" class="nav-link">Aceptación</a></li>
                    </ul>
                    <div class="nav-progress">
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                        <span class="progress-text">0% leído</span>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="terms-content-wrapper" id="termsContent">
                    <div class="terms-content" >
                        <div class="section" id="section1">
                            <h2>1. Aceptación de los Términos</h2>
                            <p>Al utilizar nuestro servicio de credencialización para pasajeros, usted acepta cumplir y estar sujeto a los siguientes términos y condiciones. Si no está de acuerdo con alguna parte de estos términos, no podrá utilizar nuestro servicio.</p>
                        </div>

                        <div class="section" id="section2">
                            <h2>2. Descripción del Servicio</h2>
                            <p>El servicio de credencialización para pasajeros permite la emisión, gestión y verificación de credenciales digitales para pasajeros con el fin de agilizar procesos de identificación en terminales de transporte, aeropuertos y otros puntos de control.</p>
                            
                            <h3>2.1 Servicios Incluidos</h3>
                            <ul>
                                <li>Emisión de credenciales digitales para pasajeros</li>
                                <li>Verificación de identidad mediante procesos establecidos</li>
                                <li>Gestión y renovación de credenciales</li>
                                <li>Soporte técnico para problemas relacionados con las credenciales</li>
                                <li>Integración con sistemas de transporte autorizados</li>
                            </ul>
                        </div>

                        <div class="section" id="section3">
                            <h2>3. Requisitos de Elegibilidad</h2>
                            <p>Para utilizar nuestro servicio, debe cumplir con los siguientes requisitos:</p>
                            <ul>
                                <li>Ser mayor de 18 años o contar con autorización de un tutor legal</li>
                                <li>Proporcionar información veraz y completa durante el registro</li>
                                <li>Contar con identificación oficial vigente</li>
                                <li>Aceptar los procesos de verificación de identidad establecidos</li>
                                <li>No estar sujeto a restricciones legales que impidan la utilización del servicio</li>
                            </ul>
                        </div>

                        <div class="section" id="section4">
                            <h2>4. Proceso de Registro y Verificación</h2>
                            <p>El registro para obtener una credencial de pasajero implica los siguientes pasos:</p>
                            <ol>
                                <li>Completar el formulario de solicitud en línea con información personal precisa</li>
                                <li>Proporcionar documentación de identificación válida</li>
                                <li>Someterse a los procesos de verificación de identidad</li>
                                <li>Esperar la aprobación de la solicitud</li>
                                <li>Recibir la credencial digital una vez aprobada</li>
                            </ol>
                            
                            <div class="highlight">
                                <p><strong>Nota importante:</strong> La aprobación de las credenciales está sujeta a la verificación exitosa de la información proporcionada y puede tomar hasta 5 días hábiles.</p>
                            </div>
                        </div>

                        <div class="section" id="section5">
                            <h2>5. Uso Aceptable de la Credencial</h2>
                            <p>La credencial emitida debe utilizarse exclusivamente para los fines establecidos:</p>
                            <ul>
                                <li>Identificación en puntos de control de transporte</li>
                                <li>Agilización de procesos de embarque</li>
                                <li>Acceso a servicios relacionados con viajes</li>
                            </ul>
                            
                            <p><strong>Está estrictamente prohibido:</strong></p>
                            <ul>
                                <li>Alterar, falsificar o duplicar la credencial</li>
                                <li>Utilizar la credencial de otra persona</li>
                                <li>Utilizar la credencial para fines fraudulentos o ilegales</li>
                                <li>Transferir o vender la credencial a terceros</li>
                            </ul>
                        </div>

                        <div class="section" id="section6">
                            <h2>6. Privacidad y Protección de Datos</h2>
                            <p>Nos comprometemos a proteger su información personal de acuerdo con la legislación aplicable en materia de protección de datos. Toda la información recopilada durante el proceso de credencialización se utilizará exclusivamente para:</p>
                            <ul>
                                <li>Verificar su identidad</li>
                                <li>Emitir y gestionar su credencial</li>
                                <li>Mejorar nuestros servicios</li>
                                <li>Cumplir con obligaciones legales</li>
                            </ul>
                        </div>

                        <div class="section" id="section7">
                            <h2>7. Tarifas y Pagos</h2>
                            <p>El servicio de credencialización puede estar sujeto a tarifas que serán comunicadas claramente durante el proceso de solicitud. Las tarifas cubren:</p>
                            <ul>
                                <li>Procesamiento de la solicitud</li>
                                <li>Emisión de la credencial</li>
                                <li>Mantenimiento del sistema de verificación</li>
                                <li>Soporte técnico durante la vigencia de la credencial</li>
                            </ul>
                            
                            <p>Las tarifas son no reembolsables una vez iniciado el proceso de verificación.</p>
                        </div>

                        <div class="section" id="section8">
                            <h2>8. Vigencia y Renovación</h2>
                            <p>La credencial de pasajero tiene una vigencia determinada que será indicada al momento de su emisión. Los usuarios recibirán notificaciones previas a la expiración con instrucciones para la renovación.</p>
                            
                            <p>Es responsabilidad del usuario mantener su credencial vigente. El uso de una credencial expirada puede resultar en la denegación de servicios de transporte.</p>
                        </div>

                        <div class="section" id="section9">
                            <h2>9. Limitación de Responsabilidad</h2>
                            <p>El servicio de credencialización se proporciona "tal cual" y según disponibilidad. No nos hacemos responsables por:</p>
                            <ul>
                                <li>Retrasos o denegaciones de embarque por parte de las compañías de transporte</li>
                                <li>Pérdida o hurto de la credencial</li>
                                <li>Uso no autorizado de la credencial debido a negligencia del usuario</li>
                                <li>Interrupciones temporales del servicio por mantenimiento o causas fuera de nuestro control</li>
                            </ul>
                        </div>

                        <div class="section" id="section10">
                            <h2>10. Modificaciones a los Términos</h2>
                            <p>Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Los cambios entrarán en vigor tras su publicación en nuestra plataforma. El uso continuado del servicio después de dichos cambios constituye la aceptación de los términos modificados.</p>
                        </div>

                        <div class="section" id="section11">
                            <h2>11. Terminación del Servicio</h2>
                            <p>Podemos suspender o cancelar su credencial y acceso al servicio si:</p>
                            <ul>
                                <li>Se detecta información falsa durante el registro o verificación</li>
                                <li>Se hace un uso indebido de la credencial</li>
                                <li>Se violan estos términos y condiciones</li>
                                <li>Existe una orden judicial o requerimiento legal</li>
                            </ul>
                        </div>

                        <div class="acceptance-section" id="acceptance">
                            <h2>Aceptación de Términos y Condiciones</h2>
                            <p>Para proceder con la solicitud de credencialización, debe leer y aceptar nuestros términos y condiciones.</p>
                            
                            <div class="checkbox-container">
                                <input type="checkbox" id="acceptTermsModal">
                                <label for="acceptTermsModal">He leído y acepto los Términos y Condiciones del servicio <br>de credencialización para pasajeros</label>
                            </div>
                            
                            <button id="acceptTermsBtn" disabled>Aceptar y Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="terms-footer">
                <p>&copy; {{date('Y')}} Servicio de Credencialización para Pasajeros. Todos los derechos reservados.</p>               
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Función mejorada con estado de carga
    async function cargarTerminales() {
        const select = document.getElementById('terminalesId');
        
        // Mostrar estado de carga
        select.innerHTML = '<option value="">Cargando terminales...</option>';
        select.disabled = true;

        try {
            const response = await fetch('/api/terminales', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();

            if (result.success && Array.isArray(result.data)) {
                llenarSelectTerminales(result.data);
                select.disabled = false;
            } else {
                throw new Error(result.message || 'Formato de respuesta inválido');
            }
        } catch (error) {
            console.error('Error cargando terminales:', error);
            select.innerHTML = '<option value="">Error al cargar terminales</option>';
            mostrarErrorTerminales('No se pudieron cargar las terminales. Por favor, recargue la página.');
        }
    }

    // Función para llenar el select
    function llenarSelectTerminales(terminales) {
        const select = document.getElementById('terminalesId');
        
        select.innerHTML = '<option value="">Seleccione una terminal</option>';
        
        terminales.forEach(terminal => {
            const option = document.createElement('option');
            option.value = terminal.id;
            // Ajusta estos campos según tu modelo Terminal
            option.textContent = terminal.nombre || terminal.descripcion || `Terminal ${terminal.id}`;
            option.setAttribute('data-terminal', JSON.stringify(terminal));
            select.appendChild(option);
        });
    }

    // Cargar al iniciar
    document.addEventListener('DOMContentLoaded', cargarTerminales);

    // También puedes recargar si hay un error
    function recargarTerminales() {
        const select = document.getElementById('terminalesId');
        const errorDiv = select.parentNode.querySelector('.alert-danger');
        
        if (errorDiv) {
            errorDiv.remove();
        }
        
        cargarTerminales();
    }

    function setupFilePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        input.addEventListener('change', function(e) {
            preview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'file-preview-item';
                    
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        previewItem.appendChild(img);
                    } else {
                        const icon = document.createElement('div');
                        icon.style.width = '100%';
                        icon.style.height = '100%';
                        icon.style.display = 'flex';
                        icon.style.justifyContent = 'center';
                        icon.style.alignItems = 'center';
                        icon.style.backgroundColor = '#f8f9fa';
                        icon.innerHTML = `<i class="fas fa-file-pdf" style="font-size: 2rem; color: #e74c3c;"></i>`;
                        previewItem.appendChild(icon);
                    }
                    
                    const fileInfo = document.createElement('div');
                    fileInfo.className = 'file-info';
                    fileInfo.textContent = file.name;
                    previewItem.appendChild(fileInfo);
                    
                    const removeBtn = document.createElement('div');
                    removeBtn.className = 'remove-file';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.addEventListener('click', function() {
                        previewItem.remove();
                        input.value = '';
                    });
                    previewItem.appendChild(removeBtn);
                    
                    preview.appendChild(previewItem);
                }
                
                reader.readAsDataURL(file);
            }
        });
    }

    // Configurar vista previa para todos los campos de archivo
    setupFilePreview('fotoSolicitante', 'fotoPreview');
    setupFilePreview('licencia', 'licenciaPreview');
    setupFilePreview('tarjetaCirculacion', 'tarjetaPreview');

    // Manejar el envío del formulario
    document.getElementById('registroForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar términos y condiciones
        const terminosCheckbox = document.getElementById('terminos');
        
        if (!terminosCheckbox.checked) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Debe aceptar los términos y condiciones de la política de credenzializaicones.',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        
        // Crear FormData para enviar archivos
        const formData = new FormData();
        
        // Agregar datos del formulario
        formData.append('nombres', document.getElementById('nombres').value);
        formData.append('apellidos', document.getElementById('apellidos').value);
        formData.append('perfil_academico', document.getElementById('perfil_academico').value);
        formData.append('escuela_procedencia', document.getElementById('escuela_procedencia').value);
        formData.append('lugar_residencia', document.getElementById('lugar_residencia').value);
        formData.append('lugar_origen', document.getElementById('lugar_origen').value);
        formData.append('lugar_viaja_frecuente', document.getElementById('lugar_viaja_frecuente').value);
        formData.append('terminalesId', document.getElementById('terminalesId').value);
        formData.append('veces_semana', document.getElementById('veces_semana').value);
        formData.append('dia_semana_viaja', document.getElementById('dia_semana_viaja').value);
        formData.append('correo', document.getElementById('correo').value);
        formData.append('telefono', document.getElementById('telefono').value);
        formData.append('formaPago', document.getElementById('formaPago').value);
        
        // Agregar archivos
        formData.append('curp', document.getElementById('licencia').files[0]);
        formData.append('credencial', document.getElementById('tarjetaCirculacion').files[0]);
        formData.append('fotografia', document.getElementById('fotoSolicitante').files[0]);

        // Enviar datos via AJAX
        fetch('/api/solicitudes', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Error del servidor');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Mostrar folio generado
                Swal.fire({
                    icon: 'success',
                    title: '¡Solicitud enviada!',
                    html: `Su solicitud ha sido registrada exitosamente.<br><strong>Folio: ${data.folio}</strong>`,
                    confirmButtonText: 'Aceptar'
                });
                
                // Limpiar formulario
                document.getElementById('registroForm').reset();
                document.querySelectorAll('.file-preview').forEach(preview => {
                    preview.innerHTML = '';
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al enviar la solicitud. Por favor, intente nuevamente.',
                confirmButtonText: 'Aceptar'
            });
        });
    });

    // Animación para las secciones del formulario al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInRight 0.5s ease forwards';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.form-section').forEach(section => {
        observer.observe(section);
    });

    // Modal de Términos y Condiciones - FUNCIONALIDAD MEJORADA
    const termsModal = document.getElementById('termsModal');
    const selfieModal = document.getElementById('selfieModal');
    const openTermsModal = document.getElementById('openTermsModal');
    const closeTermsModal = document.getElementById('closeTermsModal');
    const acceptTermsModal = document.getElementById('acceptTermsModal');
    const acceptTermsBtn = document.getElementById('acceptTermsBtn');
    const mainCheckbox = document.getElementById('terminos');

    // Abrir modal de términos
    openTermsModal.addEventListener('click', function(e) {
        e.preventDefault();
        termsModal.style.display = 'flex'
        
        document.body.style.overflow = 'hidden';
    });

    // Cerrar modal de términos
    closeTermsModal.addEventListener('click', function() {
        termsModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    // Cerrar modal al hacer clic fuera
    window.addEventListener('click', function(e) {
        if (e.target === termsModal) {
            termsModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Habilitar botón de aceptar cuando se marca el checkbox
    acceptTermsModal.addEventListener('change', function() {
        acceptTermsBtn.disabled = !this.checked;
    });

    // Aceptar términos y cerrar modal
    acceptTermsBtn.addEventListener('click', function() {
        if (!this.disabled) {
            // Marcar el checkbox principal
            mainCheckbox.checked = true;
            
            // Cerrar modal
            termsModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Mostrar mensaje de confirmación
            Swal.fire({
                icon: 'success',
                title: 'Términos aceptados',
                text: 'Has aceptado los términos y condiciones correctamente.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });

    // Navegación y seguimiento de progreso en el modal de términos - NUEVA FUNCIONALIDAD
    document.addEventListener('DOMContentLoaded', function() {
    const termsContent = document.getElementById('termsContent');
    const navLinks = document.querySelectorAll('.nav-link');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');
    const sections = document.querySelectorAll('.section');

    // Función para actualizar la navegación activa
    function updateActiveNav() {
        let currentSection = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop - termsContent.offsetTop;
            const sectionHeight = section.clientHeight;
            
            // Verificar si la sección está visible en el viewport del contenedor
            if (termsContent.scrollTop >= sectionTop - 100 && 
                termsContent.scrollTop <= sectionTop + sectionHeight - 100) {
                currentSection = section.id;
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === `#${currentSection}`) {
                link.classList.add('active');
            }
        });
    }

    // Función para actualizar el progreso de lectura
    function updateReadingProgress() {
        const contentHeight = termsContent.scrollHeight - termsContent.clientHeight;
        const scrollPosition = termsContent.scrollTop;
        const scrollPercentage = contentHeight > 0 ? (scrollPosition / contentHeight) * 100 : 0;
        
        progressFill.style.width = `${Math.min(scrollPercentage, 100)}%`;
        progressText.textContent = `${Math.min(Math.round(scrollPercentage), 100)}% leído`;
    }

    // Event listeners para navegación (click en menú)
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);

            console.log(targetSection)
            
            if (targetSection) {
                const targetOffset = targetSection.offsetTop - termsContent.offsetTop;
                termsContent.scrollTo({
                    top: targetOffset,
                    behavior: 'smooth'
                });
                
                // Actualizar navegación activa después del scroll
                setTimeout(updateActiveNav, 300);
            }
        });
    });

    // Event listener para scroll
    termsContent.addEventListener('scroll', function() {
        updateActiveNav();
        updateReadingProgress();
    });

    // Inicializar
    updateActiveNav();
    updateReadingProgress();
});
</script>
@endpush