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

    /* Nuevos Componentes - Modals */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1100;
        padding: 1rem;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal {
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow: hidden;
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: var(--gray);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: var(--transition);
    }

    .modal-close:hover {
        background: #f8f9fa;
        color: var(--dark);
    }

    .modal-body {
        padding: 2rem;
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        background: #f8f9fa;
    }

    /* File Inputs Mejorados */
    .file-input-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input {
        position: absolute;
        left: -9999px;
        opacity: 0;
    }

    .file-input-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        background: #f8f9fa;
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
        gap: 1rem;
    }

    .file-input-label:hover {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.05);
    }

    .file-input-label.dragover {
        border-color: var(--primary);
        background: rgba(67, 97, 238, 0.1);
        transform: scale(1.02);
    }

    .file-input-icon {
        font-size: 2.5rem;
        color: var(--primary);
    }

    .file-input-text h4 {
        margin: 0 0 0.5rem 0;
        color: var(--dark);
        font-size: 1.1rem;
    }

    .file-input-text p {
        margin: 0;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .file-preview {
        margin-top: 1rem;
        display: none;
    }

    .file-preview.show {
        display: block;
    }

    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .file-preview-icon {
        font-size: 1.5rem;
        color: var(--primary);
    }

    .file-preview-info {
        flex: 1;
    }

    .file-preview-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .file-preview-size {
        font-size: 0.8rem;
        color: var(--gray);
    }

    .file-preview-remove {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: var(--transition);
    }

    .file-preview-remove:hover {
        background: rgba(220, 53, 69, 0.1);
    }

    /* Alerts */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        border-left: 4px solid transparent;
    }

    .alert-icon {
        font-size: 1.25rem;
        margin-top: 0.1rem;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .alert-message {
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .alert-close {
        background: none;
        border: none;
        color: inherit;
        opacity: 0.7;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .alert-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.1);
    }

    .alert.primary {
        background: rgba(67, 97, 238, 0.1);
        border-left-color: var(--primary);
        color: #2c44c4;
    }

    .alert.success {
        background: rgba(75, 181, 67, 0.1);
        border-left-color: var(--success);
        color: #2e7d32;
    }

    .alert.warning {
        background: rgba(255, 204, 0, 0.1);
        border-left-color: var(--warning);
        color: #b38f00;
    }

    .alert.danger {
        background: rgba(220, 53, 69, 0.1);
        border-left-color: var(--danger);
        color: #c53030;
    }

    /* Textarea con Contador */
    .textarea-container {
        position: relative;
    }

    .textarea-counter {
        position: absolute;
        bottom: 0.75rem;
        right: 0.75rem;
        font-size: 0.8rem;
        color: var(--gray);
        background: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: var(--transition);
    }

    .textarea-counter.warning {
        color: var(--warning);
    }

    .textarea-counter.danger {
        color: var(--danger);
        font-weight: 600;
    }

    /* Validaciones de Formulario */
    .form-group.has-error .form-control {
        border-color: var(--danger);
    }

    .form-group.has-success .form-control {
        border-color: var(--success);
    }

    .form-feedback {
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-feedback.error {
        color: var(--danger);
    }

    .form-feedback.success {
        color: var(--success);
    }

    .form-feedback i {
        font-size: 0.7rem;
    }

    /* Visor de Imágenes */
    .image-viewer-container {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
    }

    .image-viewer-main {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .image-viewer-thumbnails {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .image-thumbnail {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: var(--transition);
        object-fit: cover;
    }

    .image-thumbnail:hover {
        transform: scale(1.05);
    }

    .image-thumbnail.active {
        border-color: var(--primary);
    }

    .image-viewer-controls {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    /* Visor de Archivos */
    .file-viewer-container {
        background: white;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        overflow: hidden;
    }

    .file-viewer-header {
        padding: 1.5rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-viewer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-viewer-icon {
        font-size: 2rem;
        color: var(--primary);
    }

    .file-viewer-details h4 {
        margin: 0 0 0.25rem 0;
        color: var(--dark);
    }

    .file-viewer-details p {
        margin: 0;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .file-viewer-content {
        padding: 2rem;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .file-preview-content {
        text-align: center;
        max-width: 100%;
    }

    .file-preview-image {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .file-preview-text {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        max-height: 400px;
        overflow-y: auto;
        text-align: left;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .file-preview-unsupported {
        text-align: center;
        color: var(--gray);
    }

    .file-preview-unsupported i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--primary);
    }

    /* Utilidades */
    .mt-3 { margin-top: 1rem; }
    .mt-4 { margin-top: 1.5rem; }
    .mb-3 { margin-bottom: 1rem; }

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

        .modal {
            margin: 1rem;
            max-width: calc(100% - 2rem);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            flex-direction: column;
        }

        .modal-footer .btn {
            width: 100%;
        }

        .image-viewer-thumbnails {
            gap: 0.5rem;
        }

        .image-thumbnail {
            width: 60px;
            height: 60px;
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
        <!-- Sección de Visor de Imágenes -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Visor de Imágenes</h2>
                <p class="section-description">Galería interactiva con miniaturas y controles</p>
            </div>
            <div class="section-content">
                <div class="image-viewer-container">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb" 
                         alt="Imagen principal" class="image-viewer-main" id="mainImageViewer">
                    
                    <div class="image-viewer-thumbnails" id="imageThumbnails">
                        <!-- Thumbnails generados por JavaScript -->
                    </div>
                    
                    <div class="image-viewer-controls">
                        <button class="btn primary" id="prevImage">
                            <i class="fas fa-chevron-left"></i> Anterior
                        </button>
                        <button class="btn primary" id="nextImage">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn success" id="downloadImage">
                            <i class="fas fa-download"></i> Descargar
                        </button>
                        <button class="btn danger" id="deleteImage">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Visor de Archivos -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Visor de Archivos</h2>
                <p class="section-description">Previsualización de diferentes tipos de archivos</p>
            </div>
            <div class="section-content">
                <div class="file-viewer-container">
                    <div class="file-viewer-header">
                        <div class="file-viewer-info">
                            <i class="fas fa-file-pdf file-viewer-icon" id="fileViewerIcon"></i>
                            <div class="file-viewer-details">
                                <h4 id="fileName">documento.pdf</h4>
                                <p id="fileDetails">PDF Document • 2.4 MB</p>
                            </div>
                        </div>
                        <div class="file-viewer-actions">
                            <button class="btn-icon" id="fileViewerDownload">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-icon" id="fileViewerPrint">
                                <i class="fas fa-print"></i>
                            </button>
                            <button class="btn-icon danger" id="fileViewerClose">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="file-viewer-content">
                        <div class="file-preview-content" id="filePreviewContent">
                            <!-- Contenido del archivo generado por JavaScript -->
                        </div>
                    </div>
                </div>
                
                <div class="form-grid mt-4">
                    <button class="btn primary" data-file-type="pdf">
                        <i class="fas fa-file-pdf"></i> Ver PDF
                    </button>
                    <button class="btn success" data-file-type="image">
                        <i class="fas fa-file-image"></i> Ver Imagen
                    </button>
                    <button class="btn warning" data-file-type="text">
                        <i class="fas fa-file-text"></i> Ver Texto
                    </button>
                    <button class="btn info" data-file-type="video">
                        <i class="fas fa-file-video"></i> Ver Video
                    </button>
                    <button class="btn dark" data-file-type="unsupported">
                        <i class="fas fa-file"></i> Archivo no soportado
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de Alerts -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Alertas</h2>
                <p class="section-description">Notificaciones y mensajes de feedback</p>
            </div>
            <div class="section-content">
                <div class="alert primary">
                    <i class="fas fa-info-circle alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">Información</h4>
                        <p class="alert-message">Esta es una alerta informativa con un mensaje importante.</p>
                    </div>
                    <button class="alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="alert success">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">Éxito</h4>
                        <p class="alert-message">La operación se completó correctamente.</p>
                    </div>
                    <button class="alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="alert warning">
                    <i class="fas fa-exclamation-triangle alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">Advertencia</h4>
                        <p class="alert-message">Esta acción requiere tu atención inmediata.</p>
                    </div>
                    <button class="alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="alert danger">
                    <i class="fas fa-times-circle alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">Error</h4>
                        <p class="alert-message">Ha ocurrido un error inesperado. Por favor, intenta nuevamente.</p>
                    </div>
                    <button class="alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mt-4">
                    <button class="btn primary" id="showAlertDemo">
                        <i class="fas fa-bell"></i> Mostrar Alerta Dinámica
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de Modals -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Modales</h2>
                <p class="section-description">Ventanas emergentes para contenido adicional</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <button class="btn primary" id="openBasicModal">
                        <i class="fas fa-window-restore"></i> Modal Básico
                    </button>
                    <button class="btn success" id="openFormModal">
                        <i class="fas fa-edit"></i> Modal con Formulario
                    </button>
                    <button class="btn warning" id="openLargeModal">
                        <i class="fas fa-expand"></i> Modal Grande
                    </button>
                    <button class="btn danger" id="openDangerModal">
                        <i class="fas fa-exclamation-triangle"></i> Modal de Confirmación
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de File Inputs Mejorados -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Inputs de Archivo</h2>
                <p class="section-description">Subida de archivos con preview y drag & drop</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Subida Básica</label>
                        <div class="file-input-container">
                            <input type="file" class="file-input" id="basicFileInput" accept="image/*,.pdf,.doc,.docx">
                            <label for="basicFileInput" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt file-input-icon"></i>
                                <div class="file-input-text">
                                    <h4>Subir archivo</h4>
                                    <p>Haz clic o arrastra un archivo aquí</p>
                                </div>
                            </label>
                        </div>
                        <div class="file-preview" id="basicFilePreview"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Múltiples Archivos</label>
                        <div class="file-input-container">
                            <input type="file" class="file-input" id="multipleFileInput" multiple accept="image/*">
                            <label for="multipleFileInput" class="file-input-label">
                                <i class="fas fa-images file-input-icon"></i>
                                <div class="file-input-text">
                                    <h4>Subir múltiples archivos</h4>
                                    <p>Máximo 5 archivos, solo imágenes</p>
                                </div>
                            </label>
                        </div>
                        <div class="file-preview" id="multipleFilePreview"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Textarea con Contador -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Textarea con Contador</h2>
                <p class="section-description">Campos de texto con límite de caracteres</p>
            </div>
            <div class="section-content">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Descripción Corta (Máx. 100 caracteres)</label>
                        <div class="textarea-container">
                            <textarea class="form-control" rows="3" placeholder="Escribe una descripción corta..." 
                                     maxlength="100" id="shortDescription"></textarea>
                            <div class="textarea-counter" id="shortCounter">0/100</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Biografía (Máx. 500 caracteres)</label>
                        <div class="textarea-container">
                            <textarea class="form-control" rows="5" placeholder="Escribe tu biografía..." 
                                     maxlength="500" id="bioTextarea"></textarea>
                            <div class="textarea-counter" id="bioCounter">0/500</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Validaciones de Formulario -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">Validaciones de Formulario</h2>
                <p class="section-description">Ejemplos de validación en tiempo real</p>
            </div>
            <div class="section-content">
                <form id="validationForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="fullName" 
                                   placeholder="Ingresa tu nombre completo" required>
                            <div class="form-feedback" id="nameFeedback"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" 
                                   placeholder="correo@ejemplo.com" required>
                            <div class="form-feedback" id="emailFeedback"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" 
                                   placeholder="Mínimo 8 caracteres" required minlength="8">
                            <div class="form-feedback" id="passwordFeedback"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirmar Contraseña *</label>
                            <input type="password" class="form-control" id="confirmPassword" 
                                   placeholder="Repite tu contraseña" required>
                            <div class="form-feedback" id="confirmPasswordFeedback"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="phone" 
                                   placeholder="+1 (555) 000-0000" pattern="[0-9+\-\s\(\)]+">
                            <div class="form-feedback" id="phoneFeedback"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Edad</label>
                            <input type="number" class="form-control" id="age" 
                                   placeholder="Entre 18 y 100" min="18" max="100">
                            <div class="form-feedback" id="ageFeedback"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn success">
                            <i class="fas fa-check"></i> Validar Formulario
                        </button>
                        <button type="reset" class="btn light">
                            <i class="fas fa-undo"></i> Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>

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

<!-- Modales -->
<div class="modal-overlay" id="basicModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Modal Básico</h3>
            <button class="modal-close" data-modal="basicModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Este es un modal básico de ejemplo. Puedes usar modales para mostrar contenido adicional, formularios, confirmaciones, etc.</p>
            <p>Los modales son útiles para mantener la atención del usuario en una tarea específica sin navegar a otra página.</p>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="basicModal">Cancelar</button>
            <button class="btn primary">Aceptar</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="formModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Formulario de Contacto</h3>
            <button class="modal-close" data-modal="formModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" placeholder="Tu nombre">
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="correo@ejemplo.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Mensaje</label>
                    <textarea class="form-control" rows="4" placeholder="Escribe tu mensaje..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="formModal">Cancelar</button>
            <button class="btn success">Enviar Mensaje</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="largeModal">
    <div class="modal" style="max-width: 800px;">
        <div class="modal-header">
            <h3 class="modal-title">Modal Grande</h3>
            <button class="modal-close" data-modal="largeModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Este es un modal de tamaño grande. Perfecto para contenido extenso como tablas, listas largas o documentación.</p>
            
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Laptop Dell XPS 13</td>
                            <td>$1,299.00</td>
                            <td>15</td>
                            <td><span class="badge success">Disponible</span></td>
                        </tr>
                        <tr>
                            <td>iPhone 14 Pro</td>
                            <td>$999.00</td>
                            <td>8</td>
                            <td><span class="badge warning">Poco Stock</span></td>
                        </tr>
                        <tr>
                            <td>Samsung Galaxy S23</td>
                            <td>$849.00</td>
                            <td>0</td>
                            <td><span class="badge danger">Agotado</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="largeModal">Cerrar</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="dangerModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" style="color: var(--danger);">
                <i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación
            </h3>
            <button class="modal-close" data-modal="dangerModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert danger">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <div class="alert-content">
                    <h4 class="alert-title">¡Atención!</h4>
                    <p class="alert-message">Esta acción no se puede deshacer. ¿Estás seguro de que quieres eliminar este elemento permanentemente?</p>
                </div>
            </div>
            <p>Elemento a eliminar: <strong>Proyecto "Dashboard CMS"</strong></p>
        </div>
        <div class="modal-footer">
            <button class="btn light" data-modal="dangerModal">Cancelar</button>
            <button class="btn danger">
                <i class="fas fa-trash"></i> Eliminar Permanentemente
            </button>
        </div>
    </div>
</div>
@endsection



@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== VISOR DE IMÁGENES =====
        function initializeImageViewer() {
            const images = [
                {
                    url: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb',
                    title: 'Montañas',
                    description: 'Paisaje montañoso al atardecer'
                },
                {
                    url: 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05',
                    title: 'Bosque',
                    description: 'Camino a través del bosque'
                },
                {
                    url: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e',
                    title: 'Naturaleza',
                    description: 'Vista panorámica de la naturaleza'
                },
                {
                    url: 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e',
                    title: 'Lago',
                    description: 'Lago sereno en el bosque'
                },
                {
                    url: 'https://images.unsplash.com/photo-1426604966848-d7adac402bff',
                    title: 'Cascada',
                    description: 'Cascada en el corazón del bosque'
                }
            ];

            let currentImageIndex = 0;
            const mainImage = document.getElementById('mainImageViewer');
            const thumbnailsContainer = document.getElementById('imageThumbnails');
            const prevButton = document.getElementById('prevImage');
            const nextButton = document.getElementById('nextImage');
            const downloadButton = document.getElementById('downloadImage');
            const deleteButton = document.getElementById('deleteImage');

            // Generar thumbnails
            function generateThumbnails() {
                thumbnailsContainer.innerHTML = '';
                images.forEach((image, index) => {
                    const thumbnail = document.createElement('img');
                    thumbnail.src = image.url;
                    thumbnail.alt = image.title;
                    thumbnail.className = `image-thumbnail ${index === currentImageIndex ? 'active' : ''}`;
                    thumbnail.addEventListener('click', () => showImage(index));
                    thumbnailsContainer.appendChild(thumbnail);
                });
            }

            // Mostrar imagen
            function showImage(index) {
                currentImageIndex = index;
                const image = images[index];
                
                mainImage.src = image.url;
                mainImage.alt = image.title;
                
                // Actualizar thumbnails activos
                document.querySelectorAll('.image-thumbnail').forEach((thumb, i) => {
                    thumb.classList.toggle('active', i === index);
                });

                // Actualizar estado de botones
                prevButton.disabled = index === 0;
                nextButton.disabled = index === images.length - 1;
            }

            // Navegación
            prevButton.addEventListener('click', () => {
                if (currentImageIndex > 0) {
                    showImage(currentImageIndex - 1);
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentImageIndex < images.length - 1) {
                    showImage(currentImageIndex + 1);
                }
            });

            // Descargar imagen
            downloadButton.addEventListener('click', () => {
                const link = document.createElement('a');
                link.href = images[currentImageIndex].url;
                link.download = `image-${currentImageIndex + 1}.jpg`;
                link.click();
            });

            // Eliminar imagen (demo)
            deleteButton.addEventListener('click', () => {
                if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
                    images.splice(currentImageIndex, 1);
                    if (images.length === 0) {
                        mainImage.src = '';
                        mainImage.alt = 'No hay imágenes';
                        thumbnailsContainer.innerHTML = '<p>No hay imágenes disponibles</p>';
                        prevButton.disabled = true;
                        nextButton.disabled = true;
                        downloadButton.disabled = true;
                        deleteButton.disabled = true;
                    } else {
                        if (currentImageIndex >= images.length) {
                            currentImageIndex = images.length - 1;
                        }
                        showImage(currentImageIndex);
                        generateThumbnails();
                    }
                    showAlert('success', 'Imagen eliminada correctamente');
                }
            });

            // Inicializar
            generateThumbnails();
            showImage(0);
        }

        // ===== VISOR DE ARCHIVOS =====
        function initializeFileViewer() {
            const fileViewerIcon = document.getElementById('fileViewerIcon');
            const fileName = document.getElementById('fileName');
            const fileDetails = document.getElementById('fileDetails');
            const filePreviewContent = document.getElementById('filePreviewContent');
            const fileViewerDownload = document.getElementById('fileViewerDownload');
            const fileViewerPrint = document.getElementById('fileViewerPrint');
            const fileViewerClose = document.getElementById('fileViewerClose');

            const fileTypes = {
                pdf: {
                    icon: 'fa-file-pdf',
                    name: 'documento.pdf',
                    details: 'PDF Document • 2.4 MB',
                    color: '#e74c3c'
                },
                image: {
                    icon: 'fa-file-image',
                    name: 'imagen.jpg',
                    details: 'JPEG Image • 1.8 MB',
                    color: '#e67e22'
                },
                text: {
                    icon: 'fa-file-text',
                    name: 'documento.txt',
                    details: 'Text File • 15.2 KB',
                    color: '#3498db'
                },
                video: {
                    icon: 'fa-file-video',
                    name: 'video.mp4',
                    details: 'MP4 Video • 45.7 MB',
                    color: '#9b59b6'
                },
                unsupported: {
                    icon: 'fa-file',
                    name: 'archivo.xyz',
                    details: 'Unknown Format • 3.1 MB',
                    color: '#95a5a6'
                }
            };

            // Mostrar archivo
            function showFile(type) {
                const file = fileTypes[type];
                
                // Actualizar header
                fileViewerIcon.className = `fas ${file.icon} file-viewer-icon`;
                fileViewerIcon.style.color = file.color;
                fileName.textContent = file.name;
                fileDetails.textContent = file.details;

                // Actualizar contenido
                filePreviewContent.innerHTML = generateFilePreview(type, file);
            }

            // Generar preview del archivo
            function generateFilePreview(type, file) {
                switch (type) {
                    case 'pdf':
                        return `
                            <div class="file-preview-unsupported">
                                <i class="fas fa-file-pdf"></i>
                                <h4>Vista Previa de PDF</h4>
                                <p>Esta es una simulación de la vista previa de un archivo PDF.</p>
                                <p>En una implementación real, aquí se mostraría el contenido del PDF.</p>
                                <div class="mt-3">
                                    <button class="btn primary">
                                        <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                                    </button>
                                </div>
                            </div>
                        `;
                    
                    case 'image':
                        return `
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb" 
                                 alt="Vista previa" class="file-preview-image">
                        `;
                    
                    case 'text':
                        return `
                            <div class="file-preview-text">
                                <h4>Contenido del archivo de texto:</h4>
                                <pre>
Este es un archivo de texto de ejemplo.

Contenido:
- Línea 1: Información importante
- Línea 2: Datos del usuario
- Línea 3: Configuraciones del sistema

Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Nullam auctor, nisl eget ultricies tincidunt, nisl nisl 
aliquam nisl, eget ultricies nisl nisl eget nisl.

Fecha de creación: 2024-01-15
Última modificación: 2024-01-20
                                </pre>
                            </div>
                        `;
                    
                    case 'video':
                        return `
                            <div class="file-preview-unsupported">
                                <i class="fas fa-file-video"></i>
                                <h4>Reproductor de Video</h4>
                                <p>Esta es una simulación del reproductor de video.</p>
                                <p>En una implementación real, aquí estaría el reproductor de video.</p>
                                <div class="mt-3">
                                    <button class="btn primary">
                                        <i class="fas fa-play"></i> Reproducir Video
                                    </button>
                                </div>
                            </div>
                        `;
                    
                    default:
                        return `
                            <div class="file-preview-unsupported">
                                <i class="fas fa-exclamation-triangle"></i>
                                <h4>Formato no soportado</h4>
                                <p>No se puede previsualizar este tipo de archivo.</p>
                                <p>Formato: ${file.name.split('.').pop()?.toUpperCase()}</p>
                                <div class="mt-3">
                                    <button class="btn primary">
                                        <i class="fas fa-download"></i> Descargar Archivo
                                    </button>
                                </div>
                            </div>
                        `;
                }
            }

            // Event listeners para los botones de tipo de archivo
            document.querySelectorAll('[data-file-type]').forEach(button => {
                button.addEventListener('click', () => {
                    const fileType = button.getAttribute('data-file-type');
                    showFile(fileType);
                });
            });

            // Acciones del visor
            fileViewerDownload.addEventListener('click', () => {
                showAlert('success', 'Descarga iniciada');
            });

            fileViewerPrint.addEventListener('click', () => {
                showAlert('info', 'Preparando para imprimir...');
            });

            fileViewerClose.addEventListener('click', () => {
                showAlert('warning', 'Visor de archivos cerrado');
            });

            // Inicializar con PDF
            showFile('pdf');
        }

        // ===== MODALES =====
        function initializeModals() {
            // Abrir modales
            document.getElementById('openBasicModal').addEventListener('click', () => openModal('basicModal'));
            document.getElementById('openFormModal').addEventListener('click', () => openModal('formModal'));
            document.getElementById('openLargeModal').addEventListener('click', () => openModal('largeModal'));
            document.getElementById('openDangerModal').addEventListener('click', () => openModal('dangerModal'));

            // Cerrar modales
            document.querySelectorAll('.modal-close, .modal-overlay, .btn[data-modal]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal');
                    closeModal(modalId);
                });
            });

            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay.show').forEach(modal => {
                        modal.classList.remove('show');
                    });
                }
            });
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = '';
        }

        // ===== FILE INPUTS MEJORADOS =====
        function initializeFileInputs() {
            // File input básico
            const basicFileInput = document.getElementById('basicFileInput');
            const basicFilePreview = document.getElementById('basicFilePreview');
            
            basicFileInput.addEventListener('change', function(e) {
                handleFileSelection(e.target.files, basicFilePreview, 1);
            });

            // File input múltiple
            const multipleFileInput = document.getElementById('multipleFileInput');
            const multipleFilePreview = document.getElementById('multipleFilePreview');
            
            multipleFileInput.addEventListener('change', function(e) {
                handleFileSelection(e.target.files, multipleFilePreview, 5);
            });

            // Drag and drop
            document.querySelectorAll('.file-input-label').forEach(label => {
                label.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                label.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });

                label.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                    
                    const files = e.dataTransfer.files;
                    const input = this.previousElementSibling;
                    const preview = this.nextElementSibling;
                    const maxFiles = input.id === 'multipleFileInput' ? 5 : 1;
                    
                    input.files = files;
                    handleFileSelection(files, preview, maxFiles);
                });
            });
        }

        function handleFileSelection(files, previewElement, maxFiles) {
            previewElement.innerHTML = '';
            
            if (files.length > maxFiles) {
                showAlert('error', `Solo puedes subir hasta ${maxFiles} archivo${maxFiles > 1 ? 's' : ''}`);
                return;
            }

            for (let i = 0; i < Math.min(files.length, maxFiles); i++) {
                const file = files[i];
                const fileItem = createFilePreviewItem(file);
                previewElement.appendChild(fileItem);
            }

            if (files.length > 0) {
                previewElement.classList.add('show');
            } else {
                previewElement.classList.remove('show');
            }
        }

        function createFilePreviewItem(file) {
            const item = document.createElement('div');
            item.className = 'file-preview-item';
            
            const icon = getFileIcon(file.type);
            const size = formatFileSize(file.size);
            
            item.innerHTML = `
                <i class="fas ${icon} file-preview-icon"></i>
                <div class="file-preview-info">
                    <div class="file-preview-name">${file.name}</div>
                    <div class="file-preview-size">${size}</div>
                </div>
                <button type="button" class="file-preview-remove">
                    <i class="fas fa-times"></i>
                </button>
            `;

            item.querySelector('.file-preview-remove').addEventListener('click', function() {
                item.remove();
                if (item.parentElement.children.length === 0) {
                    item.parentElement.classList.remove('show');
                }
            });

            return item;
        }

        function getFileIcon(fileType) {
            if (fileType.startsWith('image/')) return 'fa-file-image';
            if (fileType.includes('pdf')) return 'fa-file-pdf';
            if (fileType.includes('word') || fileType.includes('document')) return 'fa-file-word';
            if (fileType.includes('excel') || fileType.includes('spreadsheet')) return 'fa-file-excel';
            if (fileType.includes('video')) return 'fa-file-video';
            if (fileType.includes('audio')) return 'fa-file-audio';
            return 'fa-file';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // ===== TEXTAREA CON CONTADOR =====
        function initializeTextareaCounters() {
            const shortTextarea = document.getElementById('shortDescription');
            const shortCounter = document.getElementById('shortCounter');
            const bioTextarea = document.getElementById('bioTextarea');
            const bioCounter = document.getElementById('bioCounter');

            function updateCounter(textarea, counter, maxLength) {
                const length = textarea.value.length;
                counter.textContent = `${length}/${maxLength}`;
                
                counter.classList.remove('warning', 'danger');
                if (length > maxLength * 0.8) {
                    counter.classList.add('warning');
                }
                if (length > maxLength * 0.95) {
                    counter.classList.add('danger');
                }
            }

            shortTextarea.addEventListener('input', () => updateCounter(shortTextarea, shortCounter, 100));
            bioTextarea.addEventListener('input', () => updateCounter(bioTextarea, bioCounter, 500));

            // Inicializar contadores
            updateCounter(shortTextarea, shortCounter, 100);
            updateCounter(bioTextarea, bioCounter, 500);
        }

        // ===== VALIDACIONES DE FORMULARIO =====
        function initializeFormValidation() {
            const form = document.getElementById('validationForm');
            const fields = {
                fullName: document.getElementById('fullName'),
                email: document.getElementById('email'),
                password: document.getElementById('password'),
                confirmPassword: document.getElementById('confirmPassword'),
                phone: document.getElementById('phone'),
                age: document.getElementById('age')
            };

            const feedbacks = {
                fullName: document.getElementById('nameFeedback'),
                email: document.getElementById('emailFeedback'),
                password: document.getElementById('passwordFeedback'),
                confirmPassword: document.getElementById('confirmPasswordFeedback'),
                phone: document.getElementById('phoneFeedback'),
                age: document.getElementById('ageFeedback')
            };

            // Validaciones en tiempo real
            fields.fullName.addEventListener('blur', () => validateName());
            fields.email.addEventListener('blur', () => validateEmail());
            fields.password.addEventListener('blur', () => validatePassword());
            fields.confirmPassword.addEventListener('blur', () => validateConfirmPassword());
            fields.phone.addEventListener('blur', () => validatePhone());
            fields.age.addEventListener('blur', () => validateAge());

            // Envío del formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const isNameValid = validateName();
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                const isConfirmPasswordValid = validateConfirmPassword();
                const isPhoneValid = validatePhone();
                const isAgeValid = validateAge();

                if (isNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid && isPhoneValid && isAgeValid) {
                    showAlert('success', '¡Formulario válido! Los datos están listos para ser enviados.');
                    // Aquí iría el envío real del formulario
                } else {
                    showAlert('error', 'Por favor, corrige los errores en el formulario.');
                }
            });

            // Reset del formulario
            form.addEventListener('reset', function() {
                Object.values(feedbacks).forEach(feedback => {
                    feedback.innerHTML = '';
                    feedback.className = 'form-feedback';
                });
                
                Object.values(fields).forEach(field => {
                    field.parentElement.classList.remove('has-error', 'has-success');
                });
            });

            // Funciones de validación
            function validateName() {
                const value = fields.fullName.value.trim();
                const parent = fields.fullName.parentElement;
                
                if (!value) {
                    showFieldError('name', 'El nombre es obligatorio');
                    return false;
                } else if (value.length < 2) {
                    showFieldError('name', 'El nombre debe tener al menos 2 caracteres');
                    return false;
                } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                    showFieldError('name', 'El nombre solo puede contener letras y espacios');
                    return false;
                } else {
                    showFieldSuccess('name', 'Nombre válido');
                    return true;
                }
            }

            function validateEmail() {
                const value = fields.email.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!value) {
                    showFieldError('email', 'El email es obligatorio');
                    return false;
                } else if (!emailRegex.test(value)) {
                    showFieldError('email', 'Ingresa un email válido');
                    return false;
                } else {
                    showFieldSuccess('email', 'Email válido');
                    return true;
                }
            }

            function validatePassword() {
                const value = fields.password.value;
                
                if (!value) {
                    showFieldError('password', 'La contraseña es obligatoria');
                    return false;
                } else if (value.length < 8) {
                    showFieldError('password', 'La contraseña debe tener al menos 8 caracteres');
                    return false;
                } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) {
                    showFieldError('password', 'Debe contener mayúsculas, minúsculas y números');
                    return false;
                } else {
                    showFieldSuccess('password', 'Contraseña segura');
                    return true;
                }
            }

            function validateConfirmPassword() {
                const value = fields.confirmPassword.value;
                const passwordValue = fields.password.value;
                
                if (!value) {
                    showFieldError('confirmPassword', 'Confirma tu contraseña');
                    return false;
                } else if (value !== passwordValue) {
                    showFieldError('confirmPassword', 'Las contraseñas no coinciden');
                    return false;
                } else {
                    showFieldSuccess('confirmPassword', 'Contraseñas coinciden');
                    return true;
                }
            }

            function validatePhone() {
                const value = fields.phone.value.trim();
                const phoneRegex = /^[\d\s\-\+\(\)]+$/;
                
                if (value && !phoneRegex.test(value)) {
                    showFieldError('phone', 'Formato de teléfono inválido');
                    return false;
                } else if (value && value.replace(/\D/g, '').length < 10) {
                    showFieldError('phone', 'El teléfono debe tener al menos 10 dígitos');
                    return false;
                } else if (value) {
                    showFieldSuccess('phone', 'Teléfono válido');
                    return true;
                } else {
                    clearFieldFeedback('phone');
                    return true;
                }
            }

            function validateAge() {
                const value = parseInt(fields.age.value);
                
                if (fields.age.value && (isNaN(value) || value < 18 || value > 100)) {
                    showFieldError('age', 'La edad debe estar entre 18 y 100 años');
                    return false;
                } else if (fields.age.value) {
                    showFieldSuccess('age', 'Edad válida');
                    return true;
                } else {
                    clearFieldFeedback('age');
                    return true;
                }
            }

            function showFieldError(field, message) {
                const parent = fields[field].parentElement;
                parent.classList.add('has-error');
                parent.classList.remove('has-success');
                
                feedbacks[field].className = 'form-feedback error';
                feedbacks[field].innerHTML = `<i class="fas fa-times-circle"></i> ${message}`;
            }

            function showFieldSuccess(field, message) {
                const parent = fields[field].parentElement;
                parent.classList.add('has-success');
                parent.classList.remove('has-error');
                
                feedbacks[field].className = 'form-feedback success';
                feedbacks[field].innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            }

            function clearFieldFeedback(field) {
                const parent = fields[field].parentElement;
                parent.classList.remove('has-error', 'has-success');
                feedbacks[field].innerHTML = '';
            }
        }

        // ===== ALERTAS =====
        function initializeAlerts() {
            // Cerrar alertas
            document.querySelectorAll('.alert-close').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.alert').style.display = 'none';
                });
            });

            // Demo de alerta dinámica
            document.getElementById('showAlertDemo').addEventListener('click', function() {
                showAlert('info', 'Esta es una alerta dinámica que se muestra mediante JavaScript.');
            });
        }

        function showAlert(type, message, title = null) {
            const alertTypes = {
                info: { class: 'primary', icon: 'fa-info-circle', defaultTitle: 'Información' },
                success: { class: 'success', icon: 'fa-check-circle', defaultTitle: 'Éxito' },
                warning: { class: 'warning', icon: 'fa-exclamation-triangle', defaultTitle: 'Advertencia' },
                error: { class: 'danger', icon: 'fa-times-circle', defaultTitle: 'Error' }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;
            const alertTitle = title || alertConfig.defaultTitle;

            const alertHTML = `
                <div class="alert ${alertConfig.class}">
                    <i class="fas ${alertConfig.icon} alert-icon"></i>
                    <div class="alert-content">
                        <h4 class="alert-title">${alertTitle}</h4>
                        <p class="alert-message">${message}</p>
                    </div>
                    <button class="alert-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            // Insertar al inicio de la sección de alerts
            const alertsSection = document.querySelector('.section-card:nth-child(3) .section-content');
            const existingAlert = alertsSection.querySelector('.alert');
            if (existingAlert) {
                existingAlert.insertAdjacentHTML('beforebegin', alertHTML);
            } else {
                alertsSection.insertAdjacentHTML('afterbegin', alertHTML);
            }

            // Agregar evento al botón de cerrar
            alertsSection.querySelector('.alert:first-child .alert-close').addEventListener('click', function() {
                this.closest('.alert').style.display = 'none';
            });

            // Auto-remover después de 5 segundos
            setTimeout(() => {
                const alert = alertsSection.querySelector('.alert:first-child');
                if (alert && !alert.querySelector('.alert-close').clicked) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(-100%)';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        }

        // ===== COMPONENTES EXISTENTES =====
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

        // ===== INICIALIZACIÓN COMPLETA =====
        initializeImageViewer();
        initializeFileViewer();
        initializeModals();
        initializeFileInputs();
        initializeTextareaCounters();
        initializeFormValidation();
        initializeAlerts();
        
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