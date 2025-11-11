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

    /* Responsive */
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
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 1rem;
        }

        .form-section {
            padding: 1rem;
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
        <form id="registroForm" class="form-container">
            <!-- Información Personal -->
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Información Personal</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" id="nombre" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fechaNacimiento">Fecha de Nacimiento</label>
                        <input type="text" id="fechaNacimiento" class="form-control" placeholder="Seleccione una fecha" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select id="genero" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otro">Otro</option>
                            <option value="prefiero-no-decir">Prefiero no decir</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Información del Autobús -->
            <div class="form-section">
                <h3><i class="fas fa-bus"></i> Información del Autobús</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" id="marca" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" id="modelo" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ano">Año</label>
                        <input type="number" id="ano" class="form-control" min="1990" max="2023" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="placa">Placa</label>
                        <input type="text" id="placa" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="capacidad">Capacidad de Pasajeros</label>
                        <select id="capacidad" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="20-30">20-30 pasajeros</option>
                            <option value="31-40">31-40 pasajeros</option>
                            <option value="41-50">41-50 pasajeros</option>
                            <option value="51-60">51-60 pasajeros</option>
                            <option value="61+">Más de 60 pasajeros</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo">Tipo de Autobús</label>
                        <select id="tipo" class="form-control form-select" required>
                            <option value="">Seleccione una opción</option>
                            <option value="urbano">Urbano</option>
                            <option value="suburbano">Suburbano</option>
                            <option value="turismo">Turismo</option>
                            <option value="escolar">Escolar</option>
                            <option value="ejecutivo">Ejecutivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Preguntas de Opción Múltiple -->
            <div class="form-section">
                <h3><i class="fas fa-question-circle"></i> Preguntas de Seguridad</h3>
                
                <div class="form-group">
                    <label>¿Cuántos años de experiencia tiene manejando autobuses?</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="exp1" name="experiencia" value="menos-2" required>
                            <label for="exp1">Menos de 2 años</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="exp2" name="experiencia" value="2-5">
                            <label for="exp2">2 a 5 años</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="exp3" name="experiencia" value="5-10">
                            <label for="exp3">5 a 10 años</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="exp4" name="experiencia" value="mas-10">
                            <label for="exp4">Más de 10 años</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>¿Qué tipo de rutas maneja principalmente?</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="ruta1" name="rutas" value="urbanas">
                            <label for="ruta1">Urbanas</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="ruta2" name="rutas" value="interurbanas">
                            <label for="ruta2">Interurbanas</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="ruta3" name="rutas" value="larga-distancia">
                            <label for="ruta3">Larga distancia</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="ruta4" name="rutas" value="turismo">
                            <label for="ruta4">Turismo</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="seguridad">¿Qué medidas de seguridad implementa en su autobús?</label>
                    <select id="seguridad" class="form-control form-select" multiple>
                        <option value="extintor">Extintor</option>
                        <option value="botiquin">Botiquín de primeros auxilios</option>
                        <option value="salidas-emergencia">Salidas de emergencia</option>
                        <option value="cinturones">Cinturones de seguridad</option>
                        <option value="camaras">Cámaras de seguridad</option>
                        <option value="gps">Sistema de GPS</option>
                    </select>
                    <small class="form-text">Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones</small>
                </div>
            </div>

            <!-- Subida de Archivos -->
            <div class="form-section">
                <h3><i class="fas fa-file-upload"></i> Documentación Requerida</h3>
                
                <div class="form-group">
                    <label>Fotografía del Solicitante</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-camera"></i> Seleccionar Imagen
                        </div>
                        <input type="file" id="fotoSolicitante" accept="image/*" required>
                    </div>
                    <div class="file-preview" id="fotoPreview"></div>
                </div>
                
                <div class="form-group">
                    <label>Licencia de Conducir</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-file-pdf"></i> Subir PDF o Imagen
                        </div>
                        <input type="file" id="licencia" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="file-preview" id="licenciaPreview"></div>
                </div>
                
                <div class="form-group">
                    <label>Tarjeta de Circulación</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-file-pdf"></i> Subir PDF o Imagen
                        </div>
                        <input type="file" id="tarjetaCirculacion" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="file-preview" id="tarjetaPreview"></div>
                </div>
                
                <div class="form-group">
                    <label>Seguro del Autobús (Opcional)</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">
                            <i class="fas fa-file-pdf"></i> Subir PDF o Imagen
                        </div>
                        <input type="file" id="seguro" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div class="file-preview" id="seguroPreview"></div>
                </div>
            </div>

            <!-- Términos y Condiciones -->
            <div class="form-section">
                <h3><i class="fas fa-file-contract"></i> Términos y Condiciones</h3>
                
                <div class="form-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="terminos" required>
                        <label for="terminos">Acepto los términos y condiciones del servicio</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="privacidad" required>
                        <label for="privacidad">Autorizo el tratamiento de mis datos personales de acuerdo con la política de privacidad</label>
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
@endsection

@push('js')
<script>
    // Inicializar datepicker para fecha de nacimiento
    flatpickr("#fechaNacimiento", {
        locale: "es",
        dateFormat: "d/m/Y",
        maxDate: "today",
        disable: [
            function(date) {
                // Deshabilitar fechas futuras
                return date > new Date();
            }
        ]
    });

    // Manejar la vista previa de archivos
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
                    
                    // Si es una imagen, mostrar vista previa
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        previewItem.appendChild(img);
                    } else {
                        // Para PDFs, mostrar un icono
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
    setupFilePreview('seguro', 'seguroPreview');

    // Manejar el envío del formulario
    document.getElementById('registroForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Mostrar loader
        document.getElementById('loader').classList.remove('hidden');
        
        // Simular envío de formulario
        setTimeout(() => {
            alert('¡Formulario enviado con éxito! Recibirá un correo de confirmación en breve.');
            document.getElementById('loader').classList.add('hidden');
            this.reset();
            
            // Limpiar vistas previas
            document.querySelectorAll('.file-preview').forEach(preview => {
                preview.innerHTML = '';
            });
        }, 2000);
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

    // Observar todas las secciones del formulario
    document.querySelectorAll('.form-section').forEach(section => {
        observer.observe(section);
    });
</script>
@endpush