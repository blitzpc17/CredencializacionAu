<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($tipoEmail === 'confirmacion')
            Confirmación de Recepción - {{ $solicitud->folio }}
        @else
            Estado de Solicitud - {{ $solicitud->folio }}
        @endif
    </title>
    <style>
        /* Mantener el mismo CSS que tenías anteriormente */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .email-header .folio {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        .email-body {
            padding: 2rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            background-color: {{ $estadoColor }};
            color: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-item {
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }

        .info-item label {
            display: block;
            font-weight: bold;
            color: #2c3e50;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .info-item span {
            color: #555;
        }

        .next-steps {
            background-color: #e8f4fd;
            padding: 1.5rem;
            border-radius: 5px;
            border-left: 4px solid #3498db;
            margin-bottom: 2rem;
        }

        .next-steps h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .contact-info {
            background-color: #fff3cd;
            padding: 1rem;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            text-align: center;
            font-size: 0.9rem;
        }

        .email-footer {
            background-color: #2c3e50;
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.8rem;
        }

        .email-footer a {
            color: #3498db;
            text-decoration: none;
        }

        .confirmation-message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #28a745;
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .email-body {
                padding: 1rem;
            }
            
            .email-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>
                @if($tipoEmail === 'confirmacion')
                    ✅ Confirmación de Recepción
                @else
                    📋 Estado de Solicitud
                @endif
            </h1>
            <div class="folio">Folio: {{ $solicitud->folio }}</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            @if($tipoEmail === 'confirmacion')
            <div class="confirmation-message">
                <strong>¡Gracias por tu solicitud!</strong><br>
                Hemos recibido correctamente tu solicitud de credencialización. 
                A continuación encontrarás los detalles de tu trámite.
            </div>
            @endif

            <!-- Badge de Estado -->
            <div class="status-badge">
                Estado: {{ $estadoTexto }}
            </div>

            <!-- Información de la Solicitud -->
            <div class="info-grid">
                <div class="info-item">
                    <label>Solicitante:</label>
                    <span>{{ $solicitud->nombres }} {{ $solicitud->apellidos }}</span>
                </div>

                <div class="info-item">
                    <label>Fecha de Solicitud:</label>
                    <span>{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y H:i') }}</span>
                </div>

                <div class="info-item">
                    <label>Correo Electrónico:</label>
                    <span>{{ $solicitud->correo }}</span>
                </div>

                <div class="info-item">
                    <label>Teléfono:</label>
                    <span>{{ $solicitud->telefono }}</span>
                </div>

                <div class="info-item">
                    <label>Escuela de Procedencia:</label>
                    <span>{{ $solicitud->escuela_procedencia }}</span>
                </div>

                <div class="info-item">
                    <label>Lugar de Residencia:</label>
                    <span>{{ $solicitud->lugar_residencia }}</span>
                </div>

                <div class="info-item">
                    <label>Terminal Asignada:</label>
                    <span>{{ $solicitud->terminal->nombre ?? 'Por asignar' }}</span>
                </div>

                <div class="info-item">
                    <label>Forma de Pago:</label>
                    <span>
                        @switch($solicitud->formaPago)
                            @case(1) Transferencia @break
                            @case(2) Pago en Taquilla @break
                            @case(3) Tarjeta Crédito/Débito @break
                            @case(4) Efectivo @break
                            @default No especificado
                        @endswitch
                    </span>
                </div>
            </div>

            <!-- Próximos Pasos -->
            <div class="next-steps">
                <h3>📋 Próximos Pasos</h3>
                <p>
                    @if($tipoEmail === 'confirmacion')
                        Tu solicitud ha sido registrada exitosamente. En los próximos días recibirás actualizaciones sobre el estado de tu trámite. 
                        <strong>Conserva tu folio: {{ $solicitud->folio }}</strong> para cualquier consulta.
                    @else
                        @switch($solicitud->solicitudes_estadosId)
                            @case(1)
                                Tu solicitud está en revisión inicial. Te notificaremos cuando avance al siguiente paso.
                                @break
                            @case(2)
                                Estamos verificando tu documentación. Este proceso puede tomar de 3 a 5 días hábiles.
                                @break
                            @case(3)
                                ¡Felicidades! Tu solicitud ha sido aprobada. Pronto recibirás instrucciones para recoger tu credencial.
                                @break
                            @case(4)
                                Tu credencial está lista para ser recogida en la terminal asignada.
                                @break
                            @case(5)
                                Lamentablemente tu solicitud no pudo ser procesada. Por favor contacta a soporte para más información.
                                @break
                            @default
                                Tu solicitud está siendo procesada. Te mantendremos informado sobre cualquier actualización.
                        @endswitch
                    @endif
                </p>
            </div>

            <!-- Información de Contacto -->
            <div class="contact-info">
                <strong>¿Tienes dudas?</strong><br>
                Contáctanos en: soporte@tuinstitucion.edu.mx | Teléfono: (123) 456-7890
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>
                &copy; {{ date('Y') }} Sistema de Credencialización. Todos los derechos reservados.<br>
                <a href="{{ config('app.url') }}">Visita nuestro sitio web</a>
            </p>
        </div>
    </div>
</body>
</html>