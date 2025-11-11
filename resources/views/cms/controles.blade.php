@extends('cms.layout')

@push('css')
<style>
    /* Estilos para controles de formulario */
    .controls-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .section-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .section-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .section-description {
        color: var(--gray);
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .section-content {
        padding: 2rem;
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

    /* Badges */
    .badges-demo {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge.primary { background: var(--primary); color: white; }
    .badge.secondary { background: var(--secondary); color: white; }
    .badge.success { background: var(--success); color: white; }
    .badge.danger { background: var(--danger); color: white; }
    .badge.warning { background: var(--warning); color: var(--dark); }
    .badge.info { background: var(--accent); color: white; }
    .badge.light { background: #e9ecef; color: var(--dark); }
    .badge.dark { background: var(--dark); color: white; }

    .badge.pill {
        border-radius: 50px;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: var(--transition);
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .form-control.sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }

    .form-control:disabled {
        background-color: #f8f9fa;
        color: var(--gray);
        cursor: not-allowed;
    }

    /* Input con Icono */
    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-with-icon i {
        position: absolute;
        left: 1rem;
        color: var(--gray);
        z-index: 1;
    }

    .input-with-icon .form-control {
        padding-left: 2.5rem;
        width: 100%;
    }

    /* Checkboxes y Radios */
    .checkbox-group, .radio-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .checkbox-group.inline {
        flex-direction: row;
        gap: 1.5rem;
    }

    .checkbox, .radio {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .checkbox.disabled, .radio.disabled {
        color: var(--gray);
        cursor: not-allowed;
    }

    .checkbox input, .radio input {
        display: none;
    }

    .checkmark, .radiomark {
        width: 20px;
        height: 20px;
        border: 2px solid #dee2e6;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .radiomark {
        border-radius: 50%;
    }

    .checkbox input:checked + .checkmark {
        background: var(--primary);
        border-color: var(--primary);
    }

    .checkbox input:checked + .checkmark::after {
        content: "✓";
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .radio input:checked + .radiomark {
        border-color: var(--primary);
    }

    .radio input:checked + .radiomark::after {
        content: "";
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
    }

    .checkbox.disabled .checkmark, .radio.disabled .radiomark {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }

    /* Date Time Picker Personalizado */
    .custom-datetime {
        border-top: 1px solid #e9ecef;
        padding-top: 1.5rem;
    }

    .datetime-selector {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .date-selector, .time-selector {
        flex: 1;
        min-width: 200px;
    }

    .date-inputs, .time-inputs {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    /* Tablas */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .table th {
        background: #f8f9fa;
        font-weight: 600;
        color: var(--dark);
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .btn-icon {
        background: none;
        border: none;
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        color: var(--gray);
    }

    .btn-icon:hover {
        background: #e9ecef;
        color: var(--dark);
    }

    .btn-icon.danger {
        color: var(--danger);
    }

    .btn-icon.danger:hover {
        background: rgba(220, 53, 69, 0.1);
    }

    /* DataTables */
    .datatable-controls {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .datatable-search {
        flex: 1;
        min-width: 200px;
    }

    .datatable-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn.primary { background: var(--primary); color: white; }
    .btn.success { background: var(--success); color: white; }
    .btn.danger { background: var(--danger); color: white; }
    .btn.sm { padding: 0.4rem 0.8rem; font-size: 0.75rem; }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .datatable-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding: 1rem 0;
        border-top: 1px solid #e9ecef;
    }

    .datatable-info {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .datatable-pagination {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-btn {
        padding: 0.5rem;
        border: 1px solid #e9ecef;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
    }

    .pagination-btn:hover:not(:disabled) {
        background: #f8f9fa;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-pages {
        display: flex;
        gap: 0.25rem;
    }

    .page-number {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e9ecef;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.8rem;
    }

    .page-number.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .page-number:hover:not(.active) {
        background: #f8f9fa;
    }

    /* Gestor de Archivos */
    .file-manager {
        display: grid;
        grid-template-columns: 1fr 250px;
        gap: 2rem;
    }

    .file-manager-toolbar {
        grid-column: 1 / -1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .file-actions {
        display: flex;
        gap: 0.5rem;
    }

    .file-view-options {
        display: flex;
        gap: 0.25rem;
    }

    .file-manager-content {
        background: white;
        border-radius: 8px;
        padding: 1rem;
    }

    .file-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .breadcrumb-separator {
        color: var(--gray);
    }

    .files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
    }

    .file-item {
        text-align: center;
        padding: 1rem;
        border: 2px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .file-item:hover {
        background: #f8f9fa;
    }

    .file-item.selected {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.05);
    }

    .file-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .file-name {
        font-size: 0.8rem;
        word-break: break-word;
    }

    .file-manager-sidebar {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        height: fit-content;
    }

    .storage-info {
        margin-bottom: 2rem;
    }

    .storage-info h4 {
        margin-bottom: 1rem;
        color: var(--dark);
    }

    .progress-bar {
        background: #e9ecef;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress-fill {
        background: var(--primary);
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .storage-stats {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--gray);
    }

    .quick-actions h4 {
        margin-bottom: 1rem;
        color: var(--dark);
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        padding: 0.75rem;
        border: none;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        margin-bottom: 0.5rem;
    }

    .quick-action-btn:hover {
        background: #e9ecef;
    }

    /* Editor de Texto */
    .rich-editor {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }

    .editor-toolbar {
        display: flex;
        gap: 0.25rem;
        padding: 0.75rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .editor-btn {
        padding: 0.5rem;
        border: none;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        transition: var(--transition);
    }

    .editor-btn:hover {
        background: #e9ecef;
    }

    .toolbar-separator {
        width: 1px;
        background: #e9ecef;
        margin: 0 0.5rem;
    }

    .editor-content {
        padding: 1rem;
        min-height: 200px;
        outline: none;
    }

    /* Sliders */
    .slider-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .slider {
        flex: 1;
        height: 6px;
        border-radius: 3px;
        background: #e9ecef;
        outline: none;
        -webkit-appearance: none;
    }

    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--primary);
        cursor: pointer;
    }

    .slider-value {
        min-width: 40px;
        text-align: center;
        font-weight: 600;
        color: var(--dark);
    }

    .range-slider-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .range-slider {
        position: relative;
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
    }

    .range-min, .range-max {
        position: absolute;
        top: 0;
        width: 100%;
        height: 6px;
        background: transparent;
        pointer-events: none;
        -webkit-appearance: none;
    }

    .range-min::-webkit-slider-thumb,
    .range-max::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--primary);
        cursor: pointer;
        pointer-events: all;
    }

    .range-values {
        text-align: center;
        font-weight: 600;
        color: var(--dark);
    }

    /* Utilidades */
    .mt-3 { margin-top: 1rem; }
    .mt-4 { margin-top: 1.5rem; }

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .file-manager {
            grid-template-columns: 1fr;
        }
        
        .file-manager-toolbar {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .file-actions, .file-view-options {
            justify-content: center;
        }
        
        .datatable-controls {
            flex-direction: column;
            align-items: stretch;
        }
        
        .datatable-search {
            min-width: auto;
        }
        
        .datetime-selector {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-content">
    <h1 class="page-title">Controles de Formulario</h1>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Components</a></li>
                <li class="breadcrumb-item active">Form Controls</li>
            </ol>
        </nav>
    </div>

    <div class="controls-container">
        <!-- Sección de Badges -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Badges</h2>
                <p class="section-description">Etiquetas para mostrar estados y categorías</p>
            </div>
            <div class="section-content">
                <div class="badges-demo">
                    <span class="badge primary">Primary</span>
                    <span class="badge secondary">Secondary</span>
                    <span class="badge success">Success</span>
                    <span class="badge danger">Danger</span>
                    <span class="badge warning">Warning</span>
                    <span class="badge info">Info</span>
                    <span class="badge light">Light</span>
                    <span class="badge dark">Dark</span>
                </div>
                <div class="badges-demo mt-3">
                    <span class="badge primary pill">Pill Primary</span>
                    <span class="badge success pill">Pill Success</span>
                    <span class="badge danger pill">Pill Danger</span>
                </div>
            </div>
        </div>

        <!-- Sección de Inputs -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Inputs</h2>
                <p class="section-description">Diferentes tipos de campos de entrada</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Input Básico</label>
                        <input type="text" class="form-control" placeholder="Escribe algo...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Input con Icono</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-control" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Input Disabled</label>
                        <input type="text" class="form-control" placeholder="Campo deshabilitado" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Input Readonly</label>
                        <input type="text" class="form-control" value="Valor de solo lectura" readonly>
                    </div>
                </div>
                
                <div class="form-grid mt-3">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="correo@ejemplo.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número</label>
                        <input type="number" class="form-control" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" placeholder="+1 (555) 000-0000">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Selects -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Selects</h2>
                <p class="section-description">Listas desplegables y múltiples</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Select Básico</label>
                        <select class="form-control">
                            <option value="">Selecciona una opción</option>
                            <option value="1">Opción 1</option>
                            <option value="2">Opción 2</option>
                            <option value="3">Opción 3</option>
                            <option value="4">Opción 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Select Múltiple</label>
                        <select class="form-control" multiple>
                            <option value="1">Opción 1</option>
                            <option value="2">Opción 2</option>
                            <option value="3">Opción 3</option>
                            <option value="4">Opción 4</option>
                            <option value="5">Opción 5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Select con Grupos</label>
                        <select class="form-control">
                            <option value="">Selecciona una categoría</option>
                            <optgroup label="Frutas">
                                <option value="manzana">Manzana</option>
                                <option value="naranja">Naranja</option>
                                <option value="platano">Plátano</option>
                            </optgroup>
                            <optgroup label="Verduras">
                                <option value="zanahoria">Zanahoria</option>
                                <option value="brocoli">Brócoli</option>
                                <option value="espinaca">Espinaca</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Date Time Picker -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Date & Time Pickers</h2>
                <p class="section-description">Selectores de fecha y hora</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Date Picker</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar"></i>
                            <input type="date" class="form-control" id="datePicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Time Picker</label>
                        <div class="input-with-icon">
                            <i class="fas fa-clock"></i>
                            <input type="time" class="form-control" id="timePicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">DateTime Local</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="datetime-local" class="form-control" id="datetimePicker">
                        </div>
                    </div>
                </div>
                
                <div class="custom-datetime mt-4">
                    <h4>Selector Personalizado</h4>
                    <div class="datetime-selector">
                        <div class="date-selector">
                            <label>Fecha:</label>
                            <div class="date-inputs">
                                <select class="form-control sm" id="daySelect">
                                    <option value="">Día</option>
                                    <!-- Días generados por JS -->
                                </select>
                                <select class="form-control sm" id="monthSelect">
                                    <option value="">Mes</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <select class="form-control sm" id="yearSelect">
                                    <option value="">Año</option>
                                    <!-- Años generados por JS -->
                                </select>
                            </div>
                        </div>
                        <div class="time-selector">
                            <label>Hora:</label>
                            <div class="time-inputs">
                                <select class="form-control sm" id="hourSelect">
                                    <option value="">Hora</option>
                                    <!-- Horas generadas por JS -->
                                </select>
                                <select class="form-control sm" id="minuteSelect">
                                    <option value="">Minutos</option>
                                    <!-- Minutos generados por JS -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Checkboxes y Radios -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Checkboxes & Radio Buttons</h2>
                <p class="section-description">Selecciones múltiples y únicas</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Checkboxes</label>
                        <div class="checkbox-group">
                            <label class="checkbox">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                Opción 1
                            </label>
                            <label class="checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                Opción 2
                            </label>
                            <label class="checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                Opción 3
                            </label>
                            <label class="checkbox disabled">
                                <input type="checkbox" disabled>
                                <span class="checkmark"></span>
                                Opción deshabilitada
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Radio Buttons</label>
                        <div class="radio-group">
                            <label class="radio">
                                <input type="radio" name="radioGroup" checked>
                                <span class="radiomark"></span>
                                Opción A
                            </label>
                            <label class="radio">
                                <input type="radio" name="radioGroup">
                                <span class="radiomark"></span>
                                Opción B
                            </label>
                            <label class="radio">
                                <input type="radio" name="radioGroup">
                                <span class="radiomark"></span>
                                Opción C
                            </label>
                            <label class="radio disabled">
                                <input type="radio" name="radioGroup" disabled>
                                <span class="radiomark"></span>
                                Opción deshabilitada
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Checkboxes Inline</label>
                        <div class="checkbox-group inline">
                            <label class="checkbox">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                Inline 1
                            </label>
                            <label class="checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                Inline 2
                            </label>
                            <label class="checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                Inline 3
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Tablas Básicas -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Tablas Básicas</h2>
                <p class="section-description">Diferentes estilos de tablas</p>
            </div>
            <div class="section-content">
                <div class="table-responsive">
                    <table class="table basic-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Juan Pérez</td>
                                <td>juan@example.com</td>
                                <td><span class="badge success">Activo</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>María García</td>
                                <td>maria@example.com</td>
                                <td><span class="badge warning">Pendiente</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Carlos López</td>
                                <td>carlos@example.com</td>
                                <td><span class="badge danger">Inactivo</span></td>
                                <td>
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección de DataTables -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">DataTables</h2>
                <p class="section-description">Tablas avanzadas con funcionalidades</p>
            </div>
            <div class="section-content">
                <div class="datatable-controls">
                    <div class="datatable-search">
                        <input type="text" class="form-control sm" placeholder="Buscar..." id="datatableSearch">
                    </div>
                    <div class="datatable-actions">
                        <button class="btn primary sm" id="refreshTable">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button class="btn success sm" id="exportTable">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table datatable" id="advancedTable">
                        <thead>
                            <tr>
                                <th data-sortable="true">ID</th>
                                <th data-sortable="true">Nombre</th>
                                <th data-sortable="true">Email</th>
                                <th data-sortable="true">Teléfono</th>
                                <th data-sortable="true">Ciudad</th>
                                <th data-sortable="true">Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Datos generados por JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <div class="datatable-footer">
                    <div class="datatable-info">
                        Mostrando <span id="startRecord">1</span> a <span id="endRecord">10</span> de <span id="totalRecords">50</span> registros
                    </div>
                    <div class="datatable-pagination">
                        <button class="pagination-btn" id="prevPage" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="pagination-pages" id="paginationPages">
                            <!-- Páginas generadas por JavaScript -->
                        </div>
                        <button class="pagination-btn" id="nextPage">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Gestor de Archivos -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Gestor de Archivos</h2>
                <p class="section-description">Explorador y administrador de archivos</p>
            </div>
            <div class="section-content">
                <div class="file-manager">
                    <div class="file-manager-toolbar">
                        <div class="file-actions">
                            <button class="btn primary sm" id="uploadFile">
                                <i class="fas fa-upload"></i> Subir Archivo
                            </button>
                            <button class="btn success sm" id="createFolder">
                                <i class="fas fa-folder-plus"></i> Nueva Carpeta
                            </button>
                            <button class="btn danger sm" id="deleteSelected">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                        <div class="file-view-options">
                            <button class="btn-icon active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="btn-icon" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="file-manager-content">
                        <div class="file-breadcrumb">
                            <span class="breadcrumb-item active">Archivos</span>
                            <span class="breadcrumb-separator">/</span>
                            <span class="breadcrumb-item">Documentos</span>
                        </div>
                        
                        <div class="files-grid" id="filesView">
                            <!-- Archivos generados por JavaScript -->
                        </div>
                    </div>
                    
                    <div class="file-manager-sidebar">
                        <div class="storage-info">
                            <h4>Almacenamiento</h4>
                            <div class="storage-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 65%"></div>
                                </div>
                                <div class="storage-stats">
                                    <span>6.5 GB de 10 GB usados</span>
                                    <span>65%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="quick-actions">
                            <h4>Acciones Rápidas</h4>
                            <button class="quick-action-btn">
                                <i class="fas fa-images"></i>
                                <span>Imágenes</span>
                            </button>
                            <button class="quick-action-btn">
                                <i class="fas fa-file-pdf"></i>
                                <span>Documentos</span>
                            </button>
                            <button class="quick-action-btn">
                                <i class="fas fa-music"></i>
                                <span>Música</span>
                            </button>
                            <button class="quick-action-btn">
                                <i class="fas fa-video"></i>
                                <span>Videos</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Textareas y Editors -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Textareas & Editors</h2>
                <p class="section-description">Campos de texto extendidos y editores</p>
            </div>
            <div class="section-content">
                <div class="form-group">
                    <label class="form-label">Textarea Básico</label>
                    <textarea class="form-control" rows="4" placeholder="Escribe tu mensaje aquí..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Editor de Texto Enriquecido</label>
                    <div class="rich-editor">
                        <div class="editor-toolbar">
                            <button type="button" class="editor-btn" data-command="bold"><i class="fas fa-bold"></i></button>
                            <button type="button" class="editor-btn" data-command="italic"><i class="fas fa-italic"></i></button>
                            <button type="button" class="editor-btn" data-command="underline"><i class="fas fa-underline"></i></button>
                            <div class="toolbar-separator"></div>
                            <button type="button" class="editor-btn" data-command="insertUnorderedList"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="editor-btn" data-command="insertOrderedList"><i class="fas fa-list-ol"></i></button>
                            <div class="toolbar-separator"></div>
                            <button type="button" class="editor-btn" data-command="createLink"><i class="fas fa-link"></i></button>
                            <button type="button" class="editor-btn" data-command="unlink"><i class="fas fa-unlink"></i></button>
                        </div>
                        <div class="editor-content" contenteditable="true">
                            <p>Escribe tu contenido aquí...</p>
                            <p>Puedes usar la barra de herramientas para formatear el texto.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Sliders y Rangos -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Sliders & Rangos</h2>
                <p class="section-description">Controles deslizantes para valores numéricos</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Slider Básico</label>
                        <div class="slider-container">
                            <input type="range" class="slider" min="0" max="100" value="50" id="basicSlider">
                            <div class="slider-value">50</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Slider con Steps</label>
                        <div class="slider-container">
                            <input type="range" class="slider" min="0" max="100" step="10" value="30" id="stepSlider">
                            <div class="slider-value">30</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Rango Doble</label>
                        <div class="range-slider-container">
                            <div class="range-slider">
                                <input type="range" class="range-min" min="0" max="100" value="25">
                                <input type="range" class="range-max" min="0" max="100" value="75">
                            </div>
                            <div class="range-values">
                                <span id="rangeMin">25</span> - <span id="rangeMax">75</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date Time Picker - Generar opciones
        function generateDateTimeOptions() {
            // Días
            const daySelect = document.getElementById('daySelect');
            for (let i = 1; i <= 31; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                daySelect.appendChild(option);
            }

            // Años
            const yearSelect = document.getElementById('yearSelect');
            const currentYear = new Date().getFullYear();
            for (let i = currentYear - 10; i <= currentYear + 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                yearSelect.appendChild(option);
            }

            // Horas
            const hourSelect = document.getElementById('hourSelect');
            for (let i = 0; i < 24; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i.toString().padStart(2, '0');
                hourSelect.appendChild(option);
            }

            // Minutos
            const minuteSelect = document.getElementById('minuteSelect');
            for (let i = 0; i < 60; i += 5) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i.toString().padStart(2, '0');
                minuteSelect.appendChild(option);
            }
        }

        // DataTables - Generar datos de ejemplo
        function generateTableData() {
            const tableBody = document.querySelector('#advancedTable tbody');
            const names = ['Juan Pérez', 'María García', 'Carlos López', 'Ana Martínez', 'Pedro Rodríguez'];
            const cities = ['Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Zaragoza'];
            const statuses = ['Activo', 'Pendiente', 'Inactivo'];

            for (let i = 1; i <= 50; i++) {
                const row = document.createElement('tr');
                const randomName = names[Math.floor(Math.random() * names.length)];
                const randomCity = cities[Math.floor(Math.random() * cities.length)];
                const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
                
                let statusClass = '';
                switch(randomStatus) {
                    case 'Activo': statusClass = 'success'; break;
                    case 'Pendiente': statusClass = 'warning'; break;
                    case 'Inactivo': statusClass = 'danger'; break;
                }

                row.innerHTML = `
                    <td>${i}</td>
                    <td>${randomName}</td>
                    <td>${randomName.toLowerCase().replace(' ', '.')}@example.com</td>
                    <td>+34 600 ${Math.floor(100000 + Math.random() * 900000)}</td>
                    <td>${randomCity}</td>
                    <td><span class="badge ${statusClass}">${randomStatus}</span></td>
                    <td>
                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            }
        }

        // Gestor de Archivos - Generar archivos de ejemplo
        function generateFiles() {
            const filesView = document.getElementById('filesView');
            const fileTypes = [
                { icon: 'fa-file-pdf', color: '#e74c3c', name: 'documento.pdf' },
                { icon: 'fa-file-word', color: '#2b579a', name: 'contrato.docx' },
                { icon: 'fa-file-excel', color: '#217346', name: 'datos.xlsx' },
                { icon: 'fa-file-image', color: '#e67e22', name: 'foto.jpg' },
                { icon: 'fa-file-video', color: '#8e44ad', name: 'video.mp4' },
                { icon: 'fa-file-audio', color: '#f39c12', name: 'audio.mp3' },
                { icon: 'fa-folder', color: '#f1c40f', name: 'Proyectos' },
                { icon: 'fa-folder', color: '#f1c40f', name: 'Documentos' }
            ];

            fileTypes.forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <div class="file-icon" style="color: ${file.color}">
                        <i class="fas ${file.icon}"></i>
                    </div>
                    <div class="file-name">${file.name}</div>
                `;
                filesView.appendChild(fileItem);
            });
        }

        // Sliders
        function initializeSliders() {
            const basicSlider = document.getElementById('basicSlider');
            const basicValue = basicSlider.nextElementSibling;
            
            basicSlider.addEventListener('input', function() {
                basicValue.textContent = this.value;
            });

            const stepSlider = document.getElementById('stepSlider');
            const stepValue = stepSlider.nextElementSibling;
            
            stepSlider.addEventListener('input', function() {
                stepValue.textContent = this.value;
            });

            // Range Slider
            const rangeMin = document.querySelector('.range-min');
            const rangeMax = document.querySelector('.range-max');
            const rangeMinValue = document.getElementById('rangeMin');
            const rangeMaxValue = document.getElementById('rangeMax');

            function updateRangeValues() {
                rangeMinValue.textContent = rangeMin.value;
                rangeMaxValue.textContent = rangeMax.value;
            }

            rangeMin.addEventListener('input', updateRangeValues);
            rangeMax.addEventListener('input', updateRangeValues);
        }

        // Editor de Texto
        function initializeEditor() {
            const editorBtns = document.querySelectorAll('.editor-btn');
            const editorContent = document.querySelector('.editor-content');

            editorBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const command = this.dataset.command;
                    document.execCommand(command, false, null);
                    editorContent.focus();
                });
            });
        }

        // DataTables - Funcionalidad básica
        function initializeDataTable() {
            let currentPage = 1;
            const rowsPerPage = 10;
            const table = document.getElementById('advancedTable');
            const rows = table.querySelectorAll('tbody tr');
            const totalPages = Math.ceil(rows.length / rowsPerPage);

            function showPage(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? '' : 'none';
                });

                updatePagination(page);
            }

            function updatePagination(page) {
                const paginationPages = document.getElementById('paginationPages');
                const startRecord = document.getElementById('startRecord');
                const endRecord = document.getElementById('endRecord');
                const totalRecords = document.getElementById('totalRecords');
                const prevPage = document.getElementById('prevPage');
                const nextPage = document.getElementById('nextPage');

                // Actualizar información
                startRecord.textContent = (page - 1) * rowsPerPage + 1;
                endRecord.textContent = Math.min(page * rowsPerPage, rows.length);
                totalRecords.textContent = rows.length;

                // Actualizar botones
                prevPage.disabled = page === 1;
                nextPage.disabled = page === totalPages;

                // Actualizar números de página
                paginationPages.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `page-number ${i === page ? 'active' : ''}`;
                    pageBtn.textContent = i;
                    pageBtn.addEventListener('click', () => showPage(i));
                    paginationPages.appendChild(pageBtn);
                }
            }

            // Event listeners
            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) showPage(--currentPage);
            });

            document.getElementById('nextPage').addEventListener('click', () => {
                if (currentPage < totalPages) showPage(++currentPage);
            });

            // Búsqueda
            document.getElementById('datatableSearch').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Inicializar
            showPage(currentPage);
        }

        // Gestor de Archivos - Funcionalidad
        function initializeFileManager() {
            const fileItems = document.querySelectorAll('.file-item');
            const viewButtons = document.querySelectorAll('[data-view]');

            // Selección de archivos
            fileItems.forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.toggle('selected');
                });
            });

            // Cambio de vista
            viewButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    viewButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const view = this.dataset.view;
                    const filesView = document.getElementById('filesView');
                    
                    if (view === 'list') {
                        filesView.style.gridTemplateColumns = '1fr';
                        fileItems.forEach(item => {
                            item.style.display = 'flex';
                            item.style.alignItems = 'center';
                            item.style.gap = '1rem';
                            item.style.textAlign = 'left';
                        });
                    } else {
                        filesView.style.gridTemplateColumns = 'repeat(auto-fill, minmax(120px, 1fr))';
                        fileItems.forEach(item => {
                            item.style.display = '';
                            item.style.alignItems = '';
                            item.style.gap = '';
                            item.style.textAlign = 'center';
                        });
                    }
                });
            });

            // Acciones de archivos
            document.getElementById('uploadFile').addEventListener('click', function() {
                alert('Funcionalidad de subir archivo');
            });

            document.getElementById('createFolder').addEventListener('click', function() {
                alert('Funcionalidad de crear carpeta');
            });

            document.getElementById('deleteSelected').addEventListener('click', function() {
                const selected = document.querySelectorAll('.file-item.selected');
                if (selected.length > 0) {
                    if (confirm(`¿Estás seguro de eliminar ${selected.length} archivo(s)?`)) {
                        selected.forEach(item => item.remove());
                    }
                } else {
                    alert('Selecciona al menos un archivo');
                }
            });
        }

        // Inicializar todos los componentes
        generateDateTimeOptions();
        generateTableData();
        generateFiles();
        initializeSliders();
        initializeEditor();
        initializeDataTable();
        initializeFileManager();

        // Botones de DataTable
        document.getElementById('refreshTable').addEventListener('click', function() {
            location.reload();
        });

        document.getElementById('exportTable').addEventListener('click', function() {
            alert('Funcionalidad de exportar datos');
        });
    });
</script>
@endpush