<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Sistema de Credencialización</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f1a30, #1a365d, #2d3748);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .background-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(37, 99, 235, 0.1) 0%, transparent 55%),
                radial-gradient(circle at 75% 75%, rgba(79, 70, 229, 0.1) 0%, transparent 55%);
            z-index: -1;
        }

        .container {
            display: flex;
            width: 1000px;
            height: 600px;
            background: rgba(15, 23, 42, 0.8);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .left-panel {
            flex: 1.2;
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.9)), 
                        url('https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 40px;
            left: 40px;
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 700;
            color: white;
        }

        .logo i {
            margin-right: 10px;
            font-size: 28px;
            color: #3b82f6;
        }

        .image-caption {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-top: 10px;
            line-height: 1.5;
        }

        .right-panel {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(15, 23, 42, 0.7);
        }

        .login-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .login-header h1 {
            color: #f8fafc;
            font-size: 32px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .login-header p {
            color: #94a3b8;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            border: 1px solid #334155;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background: rgba(30, 41, 59, 0.6);
            color: #f1f5f9;
        }

        .form-group input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
            background: rgba(30, 41, 59, 0.8);
        }

        .form-group input::placeholder {
            color: #64748b;
        }

        .icon {
            position: absolute;
            left: 16px;
            top: 42px;
            color: #64748b;
            font-size: 18px;
        }

        .login-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
            width: 100%;
        }

        .login-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .bus-animation {
            position: absolute;
            bottom: 20px;
            left: -120px;
            width: 120px;
            height: 60px;
            background: linear-gradient(to right, #1e40af, #3b82f6);
            border-radius: 30px 30px 0 0;
            animation: drive 20s linear infinite;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .bus-animation:before,
        .bus-animation:after {
            content: '';
            position: absolute;
            width: 35px;
            height: 35px;
            background: #0f172a;
            border-radius: 50%;
            top: 45px;
        }

        .bus-animation:before {
            left: 20px;
        }

        .bus-animation:after {
            right: 20px;
        }

        .bus-window {
            position: absolute;
            width: 40px;
            height: 25px;
            background: rgba(173, 216, 230, 0.7);
            border-radius: 5px;
            top: 15px;
            left: 40px;
        }

        @keyframes drive {
            0% {
                left: -120px;
            }
            100% {
                left: 100%;
            }
        }

        /* Media Queries para Responsive */
        @media (max-width: 1050px) {
            .container {
                width: 95%;
            }
        }

        @media (max-width: 850px) {
            .container {
                flex-direction: column;
                height: auto;
                margin: 20px;
                width: 90%;
                max-width: 500px;
            }
            
            .left-panel {
                display: none; /* Ocultar panel izquierdo en móviles */
            }
            
            .right-panel {
                padding: 50px 40px;
                width: 100%;
                justify-content: center;
                align-items: center;
            }
            
            .login-header {
                text-align: center;
                width: 100%;
            }
            
            form {
                width: 100%;
                max-width: 350px;
            }
        }

        @media (max-width: 480px) {
            .right-panel {
                padding: 40px 30px;
            }
            
            .login-header h1 {
                font-size: 28px;
            }
            
            .login-header p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="background-pattern"></div>
    <div class="bus-animation">
        <div class="bus-window"></div>
    </div>
    
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <i class="fas fa-bus"></i> Sistema de credencialización
            </div>            
            <div class="image-caption">
                <!-- Nuestro equipo de profesionales está listo para brindarte la mejor experiencia de viaje.-->
            </div>
        </div>
        
        <div class="right-panel">
            <div class="login-header">
                <h1>Acceso al Sistema</h1>
                <p>Ingresa tus credenciales para acceder a tu cuenta</p>
            </div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <i class="fas fa-user icon"></i>
                    <input type="text" id="username" placeholder="Ingresa tu usuario" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <i class="fas fa-lock icon"></i>
                    <input type="password" id="password" placeholder="Ingresa tu contraseña" required>
                </div>
                
                <button type="submit" class="login-btn">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Simulación de validación
            if(username && password) {
                // Efecto visual de éxito
                const loginBtn = document.querySelector('.login-btn');
                loginBtn.innerHTML = '<i class="fas fa-check"></i> Acceso concedido';
                loginBtn.style.background = '#10b981';
                
                setTimeout(function() {
                    alert('¡Acceso exitoso! Redirigiendo al panel de control...');
                    // Aquí normalmente redirigiríamos al usuario a su dashboard
                }, 1000);
            } else {
                alert('Por favor, completa todos los campos requeridos.');
            }
        });
    </script>
</body>
</html>