<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Solicitud</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .folio {
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
        }
        .timeline {
            position: relative;
            margin: 30px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 30px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e0e0e0;
        }
        .timeline-item {
            display: flex;
            margin-bottom: 30px;
            position: relative;
        }
        .timeline-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            z-index: 2;
            border: 3px solid #e0e0e0;
            flex-shrink: 0;
        }
        .timeline-icon.active {
            border-color: #4361ee;
            background: #4361ee;
        }
        .timeline-icon.completed {
            border-color: #4bb543;
            background: #4bb543;
        }
        .timeline-icon.cancelled {
            border-color: #dc3545;
            background: #dc3545;
        }
        .timeline-icon img {
            width: 30px;
            height: 30px;
        }
        .timeline-content {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #e0e0e0;
        }
        .timeline-content.active {
            background: #e8f4ff;
            border-left-color: #4361ee;
        }
        .timeline-content.completed {
            background: #f0fff0;
            border-left-color: #4bb543;
        }
        .timeline-content.cancelled {
            background: #fff0f0;
            border-left-color: #dc3545;
        }
        .timeline-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .timeline-message {
            color: #666;
            margin-bottom: 10px;
        }
        .timeline-instructions {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid #4361ee;
            font-size: 14px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .badge.active {
            background: #4361ee;
            color: white;
        }
        .badge.completed {
            background: #4bb543;
            color: white;
        }
        .contact-info {
            background: #e8f4ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚍 Actualización de Credencialización</h1>
            <div class="folio">Folio: {{ $solicitud->folio }}</div>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $solicitud->nombres }} {{ $solicitud->apellidos }}</strong>,</p>
            <p>Te informamos el estado actual de tu solicitud de credencial:</p>
            
            <div class="timeline">
                @foreach($timelineData as $estado => $data)

                    @if($estado != $solicitud->solicitudes_estadosId)
                        @continue
                    @endif

                    @if($estado != 8 || $estadoId == 8) {{-- Solo mostrar cancelado si es el estado actual --}}
                    <div class="timeline-item">
                        <div class="timeline-icon 
                            {{ $data['paso_actual'] && $estadoId != 8 ? 'active' : '' }}
                            {{ $data['completado'] && $estadoId != 8 ? 'completed' : '' }}
                            {{ $estadoId == 8 ? 'cancelled' : '' }}">
                            <img src="{{ $data['imagen'] }}" alt="{{ $data['titulo'] }}">
                        </div>
                        <div class="timeline-content 
                            {{ $data['paso_actual'] && $estadoId != 8 ? 'active' : '' }}
                            {{ $data['completado'] && $estadoId != 8 ? 'completed' : '' }}
                            {{ $estadoId == 8 ? 'cancelled' : '' }}">
                            <div class="timeline-title">
                                {{ $data['titulo'] }}
                                @if($data['paso_actual'])
                                    <span class="badge active">ACTUAL</span>
                                @elseif($data['completado'])
                                    <span class="badge completed">COMPLETADO</span>
                                @endif
                            </div>
                            <div class="timeline-message">{{ $data['mensaje'] }}</div>
                            <div class="timeline-instructions">
                                {!! $data['instrucciones'] !!}
                            </div>
                        </div>
                    </div>
                    @endif

                @endforeach
            </div>

            @if($estadoId == 1)
            <div class="contact-info">
                <strong>💡 Recordatorio importante:</strong><br>
                Realiza tu pago en cualquiera de nuestras terminales autorizadas o mediante transferencia bancaria. 
                Una vez realizado, sube tu comprobante en nuestro sistema usando tu folio: <strong>{{ $solicitud->folio }}</strong>
            </div>
            @endif

            @if($estadoId == 9)
            <div class="contact-info">
                <strong>📍 Punto de entrega:</strong><br>
                Terminal: <strong>{{ $solicitud->terminal->nombre ?? 'Por asignar' }}</strong><br>
                Horario: <strong>Lunes a Viernes de 8:00 AM a 6:00 PM</strong><br>
                Documentación requerida: <strong>Identificación oficial</strong>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
            <p>Si tienes alguna duda, contacta a nuestro equipo de soporte.</p>
            <p>© {{ date('Y') }} Sistema de Credencialización. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>