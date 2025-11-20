<!DOCTYPE html>
<html>
<head>
    <title>Mapa de Calor Google Maps</title>
    <style>
        #map {
            height: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        // Tu array de datos
        const datosCalor = [
    // Zona Metropolitana CDMX
    [19.4326, -99.1332, 50],  // Zócalo
    [19.4345, -99.1402, 22],  // Alameda Central
    [19.4280, -99.1280, 20],  // Bellas Artes
    [19.4419, -99.1270, 18],  // Tlatelolco
    [19.4200, -99.1600, 16],  // Polanco
    [19.3574, -99.1391, 15],  // Coyoacán
    [19.3950, -99.1444, 14],  // Roma
    [19.4090, -99.1670, 12],  // Condesa
    
    // Área Metropolitana Guadalajara
    [20.6597, -103.3496, 18], // Centro
    [20.6668, -103.3552, 16], // Zapopan
    [20.6523, -103.3431, 14], // Tlaquepaque
    [20.6800, -103.4500, 12], // Tesistán
    
    // Zona Monterrey
    [25.6866, -100.3161, 20], // Macroplaza
    [25.6810, -100.3095, 18], // Barrio Antiguo
    [25.6912, -100.3228, 16], // San Pedro
    [25.6750, -100.3000, 14], // Guadalupe
    
    // Playas
    [21.1619, -86.8515, 22],  // Cancún hotel zone
    [20.6534, -105.2253, 20], // Puerto Vallarta
    [16.8531, -99.8237, 18],  // Acapulco
    [20.6296, -87.0750, 16]   // Playa del Carmen
];

        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: { lat: 19.4326, lng: -99.1332 },
                mapTypeId: 'satellite'
            });

            // Convertir datos al formato de Google Maps
            const puntosCalor = datosCalor.map(punto => ({
                location: new google.maps.LatLng(punto[0], punto[1]),
                weight: punto[2]
            }));

            // Crear mapa de calor
            const heatmap = new google.maps.visualization.HeatmapLayer({
                data: puntosCalor,
                map: map,
                radius: 30,        // Radio más grande para mejor visibilidad
                opacity: 0.7,
                dissipating: true, // Permite que el calor se disipe
                gradient: [
                    'rgba(0, 255, 255, 0)',
                    'rgba(0, 255, 255, 1)',
                    'rgba(0, 191, 255, 1)',
                    'rgba(0, 127, 255, 1)',
                    'rgba(0, 63, 255, 1)',
                    'rgba(0, 0, 255, 1)',
                    'rgba(0, 0, 223, 1)',
                    'rgba(0, 0, 191, 1)',
                    'rgba(0, 0, 159, 1)',
                    'rgba(0, 0, 127, 1)',
                    'rgba(63, 0, 91, 1)',
                    'rgba(127, 0, 63, 1)',
                    'rgba(191, 0, 31, 1)',
                    'rgba(255, 0, 0, 1)'
                ]
            });

            // Controles para ajustar el mapa de calor
            const controlDiv = document.createElement('div');
            controlDiv.style.cssText = `
                background: white;
                padding: 10px;
                border-radius: 5px;
                margin: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            `;
            
            controlDiv.innerHTML = `
                <label>Radio: <input type="range" id="radiusSlider" min="10" max="50" value="30"></label>
                <label>Opacidad: <input type="range" id="opacitySlider" min="0" max="1" step="0.1" value="0.7"></label>
            `;
            
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlDiv);

            // Event listeners para los controles
            document.getElementById('radiusSlider').addEventListener('input', (e) => {
                heatmap.set('radius', parseInt(e.target.value));
            });

            document.getElementById('opacitySlider').addEventListener('input', (e) => {
                heatmap.set('opacity', parseFloat(e.target.value));
            });
        }

        // Función para añadir nuevos datos
        function agregarDatosCalor(heatmap, nuevosDatos) {
            const nuevosPuntos = nuevosDatos.map(punto => ({
                location: new google.maps.LatLng(punto[0], punto[1]),
                weight: punto[2]
            }));
            
            const datosActuales = heatmap.getData();
            const arrayDatos = datosActuales.getArray();
            nuevosPuntos.forEach(punto => arrayDatos.push(punto));
            
            heatmap.setData(datosActuales);
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0cx8BMVl0EeeYI1tU11IXjVviHq0mZdU&libraries=visualization&callback=initMap">
    </script>
</body>
</html>