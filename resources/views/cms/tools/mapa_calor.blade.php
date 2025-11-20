<!DOCTYPE html>
<html>
<head>
    <title>Mapa de Calor</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 500px; width: 100%; }
    </style>
</head>
<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script >


        // Inicializar el mapa
        const map = L.map('map').setView([40.4168, -3.7038], 6); // Centro en España

        // Añadir capa base
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Datos de ejemplo - coordenadas con intensidad (frecuencia)
        const heatData = [
            [40.4168, -3.7038, 0.8],  // [lat, lng, intensidad]
            [41.3888, 2.1590, 1.0],
            [37.3891, -5.9845, 0.6],
            [43.2630, -2.9350, 0.4],
            [39.4699, -0.3763, 0.7],
            [40.4168, -3.7038, 0.9],  // Punto duplicado para mayor frecuencia
            [41.3888, 2.1590, 0.8],   // Punto duplicado
        ];

        // Crear mapa de calor
        const heatLayer = L.heatLayer(heatData, {
            radius: 25,
            blur: 15,
            maxZoom: 17,
            gradient: {
                0.4: 'blue',
                0.6: 'cyan',
                0.7: 'lime',
                0.8: 'yellow',
                1.0: 'red'
            }
        }).addTo(map);

        // Función para procesar datos y calcular frecuencia
        function procesarDatos(datosCrudos) {
            const frecuencia = {};
            
            // Contar frecuencia por coordenada
            datosCrudos.forEach(punto => {
                const clave = `${punto[0]},${punto[1]}`;
                frecuencia[clave] = (frecuencia[clave] || 0) + 1;
            });
            
            // Convertir a formato heatmap
            const heatData = [];
            Object.keys(frecuencia).forEach(clave => {
                const [lat, lng] = clave.split(',').map(Number);
                const freq = frecuencia[clave];
                // Normalizar la frecuencia (0-1)
                const maxFreq = Math.max(...Object.values(frecuencia));
                const intensidad = freq / maxFreq;
                
                heatData.push([lat, lng, intensidad]);
            });
            
            return heatData;
        }

        // Ejemplo con datos reales procesados
        const datosEjemplo = [
            [40.4168, -3.7038],
            [40.4168, -3.7038],
            [40.4168, -3.7038], // Múltiples ocurrencias
            [41.3888, 2.1590],
            [41.3888, 2.1590],
            [37.3891, -5.9845],
        ];

        const datosProcesados = procesarDatos(datosEjemplo);
        console.log('Datos procesados:', datosProcesados);



    </script>
</body>
</html>