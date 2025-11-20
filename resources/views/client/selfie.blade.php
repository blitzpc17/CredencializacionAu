<!DOCTYPE html>
<html>
<head>
    <title>Foto para Credencial</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.15.0/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/blazeface@0.0.7/dist/blazeface.min.js"></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            text-align: center; 
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
        }
        input[type="file"] { 
            margin: 20px 0; 
            padding: 10px;
        }
        .preview { 
            margin: 20px 0; 
        }
        .credential-preview { 
            background: white;
            border: 2px solid #333;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .credential-photo {
            border: 1px solid #ccc;
            background: #f0f0f0;
        }
        button { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            margin: 5px; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        button:hover { 
            background: #0056b3; 
        }
        .specs {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📷 Foto para Credencial</h1>
        
        <div class="specs">
            <h3>📏 Especificaciones estándar para credencial:</h3>
            <ul>
                <li><strong>Tamaño:</strong> 3x3 cm a 300 DPI</li>
                <li><strong>Formato:</strong> Fondo blanco o claro</li>
                <li><strong>Orientación:</strong> Frontal, rostro completo</li>
                <li><strong>Resolución:</strong> Mínimo 354x472 pixels</li>
            </ul>
        </div>

        <input type="file" id="photoInput" accept="image/*">
        <div id="results"></div>
    </div>

    <script>
        let model = null;

        // Dimensiones estándar para credencial (3x3 cm a 300 DPI = 354x354 pixels)
        const CREDENTIAL_SIZE = {
            width: 354,
            height: 472,  // Un poco más alto para incluir hombros
            dpi: 300
        };

        async function init() {
            console.log('Cargando modelo de detección facial...');
            model = await blazeface.load();
            console.log('✅ Modelo cargado correctamente');
        }

        document.getElementById('photoInput').addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const img = new Image();
            img.onload = async () => {
                if (!model) await init();
                
                try {
                    const predictions = await model.estimateFaces(img);
                    document.getElementById('results').innerHTML = 
                        `<h3>👤 Rostros detectados: ${predictions.length}</h3>`;
                    
                    if (predictions.length === 0) {
                        document.getElementById('results').innerHTML += 
                            '<p style="color: red;">❌ No se detectaron rostros. Intenta con otra foto.</p>';
                        return;
                    }
                    
                    // Procesar cada rostro detectado
                    predictions.forEach((pred, i) => {
                        createCredentialPhoto(img, pred, i);
                    });
                    
                } catch (error) {
                    console.error('Error:', error);
                    document.getElementById('results').innerHTML = 
                        '<p style="color: red;">❌ Error procesando la imagen</p>';
                }
            };
            img.src = URL.createObjectURL(file);
        });

        function createCredentialPhoto(originalImg, prediction, index) {
            const [x1, y1] = prediction.topLeft;
            const [x2, y2] = prediction.bottomRight;
            const faceWidth = x2 - x1;
            const faceHeight = y2 - y1;
            
            // Calcular área expandida para incluir hombros y cabello
            const expansionFactor = 2.5; // Incluir más área alrededor del rostro
            const expandedWidth = faceWidth * expansionFactor;
            const expandedHeight = faceHeight * expansionFactor;
            
            // Centro del rostro
            const faceCenterX = x1 + faceWidth / 2;
            const faceCenterY = y1 + faceHeight / 2;
            
            // Calcular nueva área de recorte centrada en el rostro
            let cropX = faceCenterX - expandedWidth / 2;
            let cropY = faceCenterY - expandedHeight / 2;
            let cropWidth = expandedWidth;
            let cropHeight = expandedHeight;
            
            // Ajustar para no salirse de los límites de la imagen
            cropX = Math.max(0, cropX);
            cropY = Math.max(0, cropY);
            cropWidth = Math.min(cropWidth, originalImg.width - cropX);
            cropHeight = Math.min(cropHeight, originalImg.height - cropY);
            
            // Crear canvas para la foto de credencial
            const credentialCanvas = document.createElement('canvas');
            credentialCanvas.width = CREDENTIAL_SIZE.width;
            credentialCanvas.height = CREDENTIAL_SIZE.height;
            const ctx = credentialCanvas.getContext('2d');
            
            // Fondo blanco
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, credentialCanvas.width, credentialCanvas.height);
            
            // Dibujar el rostro recortado y redimensionado
            ctx.drawImage(
                originalImg,
                cropX, cropY, cropWidth, cropHeight, // Área de origen
                0, 0, CREDENTIAL_SIZE.width, CREDENTIAL_SIZE.height // Área de destino
            );
            
            // Crear contenedor para previsualización
            const previewDiv = document.createElement('div');
            previewDiv.className = 'credential-preview';
            previewDiv.innerHTML = `
                <h3>Foto Credencial ${index + 1}</h3>
                <div style="display: inline-block; border: 2px solid #333; padding: 5px; background: white;">
                    <canvas class="credential-photo" width="${CREDENTIAL_SIZE.width}" height="${CREDENTIAL_SIZE.height}"></canvas>
                </div>
                <br><br>
                <button onclick="downloadCredentialPhoto(${index})">💾 Descargar Foto ${index + 1}</button>
                <button onclick="applyPassportStyle(${index})">🎨 Estilo Pasaporte</button>
            `;
            
            // Dibujar en el canvas de previsualización
            const previewCanvas = previewDiv.querySelector('.credential-photo');
            const previewCtx = previewCanvas.getContext('2d');
            previewCtx.drawImage(credentialCanvas, 0, 0);
            
            // Almacenar para descarga
            if (!window.credentialPhotos) window.credentialPhotos = [];
            window.credentialPhotos[index] = credentialCanvas;
            
            document.getElementById('results').appendChild(previewDiv);
        }

        // Función para descargar la foto de credencial
        window.downloadCredentialPhoto = function(index) {
            const canvas = window.credentialPhotos[index];
            if (canvas) {
                canvas.toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = `foto_credencial_${index + 1}.jpg`;
                    link.href = url;
                    link.click();
                    URL.revokeObjectURL(url);
                    
                    // Mostrar mensaje de éxito
                    alert(`✅ Foto ${index + 1} descargada correctamente\n📏 Tamaño: ${CREDENTIAL_SIZE.width}x${CREDENTIAL_SIZE.height} pixels\n🎯 Ideal para credenciales`);
                }, 'image/jpeg', 0.95);
            }
        };

        // Función para aplicar estilo tipo pasaporte (blanco y negro con fondo blanco)
        window.applyPassportStyle = function(index) {
            const originalCanvas = window.credentialPhotos[index];
            if (!originalCanvas) return;
            
            const bwCanvas = document.createElement('canvas');
            bwCanvas.width = originalCanvas.width;
            bwCanvas.height = originalCanvas.height;
            const bwCtx = bwCanvas.getContext('2d');
            
            // Dibujar imagen original
            bwCtx.drawImage(originalCanvas, 0, 0);
            
            // Aplicar filtro blanco y negro
            const imageData = bwCtx.getImageData(0, 0, bwCanvas.width, bwCanvas.height);
            const data = imageData.data;
            
            for (let i = 0; i < data.length; i += 4) {
                const brightness = (data[i] + data[i + 1] + data[i + 2]) / 3;
                data[i] = brightness;     // rojo
                data[i + 1] = brightness; // verde
                data[i + 2] = brightness; // azul
            }
            
            bwCtx.putImageData(imageData, 0, 0);
            
            // Reemplazar la foto original con la versión blanco y negro
            window.credentialPhotos[index] = bwCanvas;
            
            // Actualizar la previsualización
            const previews = document.querySelectorAll('.credential-photo');
            if (previews[index]) {
                const previewCtx = previews[index].getContext('2d');
                previewCtx.drawImage(bwCanvas, 0, 0);
            }
            
            alert('🎨 Filtro blanco y negro aplicado (estilo pasaporte)');
        };

        // Inicializar cuando cargue la página
        window.onload = init;

        // Mensajes informativos
        console.log('🔄 Inicializando detector facial para credenciales...');
    </script>
</body>
</html>