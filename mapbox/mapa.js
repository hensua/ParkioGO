mapboxgl.accessToken = 'pk.eyJ1IjoiaGVuc3VhIiwiYSI6ImNsaHowcW93YjA5eHQzZG9jdHl3ZGZ1Y2QifQ.8M8RLEjTHxXlOOZ9W-dJiQ';

var map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/navigation-day-v1', // style URL
    center: [-75.51444, 10.39972], // starting position [lng, lat]
    zoom: 13, // starting zoom
    });

    document
    .getElementById('listing-group')
    .addEventListener('change', function(e)
    {
    var handler = e.target.id;
    if(e.target.checked){
        map[handler].enable();
    } else {
        map[handler].disable();
    }
    });   

    var customData = {
        'features': [
        {
            'type': 'Feature',
            'properties': {
                'title': 'Parque la Florida'
            },
        'geometry': {
            'coordinates': [-74.14476235609635,4.730750597247051],
            'type': 'Point'
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'title': 'Parque del Café'
            },
        'geometry': {
            'coordinates': [-75.77064810284882,4.540568666186622],
            'type': 'Point'
            }
        },
        {
            'type': 'Feature',
            'properties': {
                'title': 'Parque Arqueologico San Agustin'
            },
        'geometry': {
            'coordinates': [-76.29526180284667,1.8879367358700043],
            'type': 'Point'
            }
        }
        ],
        'type': 'FeatureCollection'
    };
     
    function forwardGeocoder(query) {
        var matchingFeatures = [];
        for (var i = 0; i < customData.features.length; i++) {
            var feature = customData.features[i];
            // Handle queries with different capitalization
            // than the source data by calling toLowerCase().
            if (
                feature.properties.title
                    .toLowerCase()
                    .search(query.toLowerCase()) !== -1
            ) {
                // Add a tree emoji as a prefix for custom
                // data results using carmen geojson format:
                // https://github.com/mapbox/carmen/blob/master/carmen-geojson.md
                feature['place_name'] = '🌲 ' + feature.properties.title;
                feature['center'] = feature.geometry.coordinates;
                feature['place_type'] = ['park'];
                matchingFeatures.push(feature);
                }
        }
        return matchingFeatures;
    }
     
    // Add the control to the map.
    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            localGeocoder: forwardGeocoder,
            zoom: 14,
            placeholder: 'Ingrese un lugar a buscar',
            mapboxgl: mapboxgl
        })
    );

    
    //Ubicaiones geolocalizadas con coordenadas de los parqueaderos 

var customMarkerImg = document.createElement('img');
    customMarkerImg.src = '../mapbox/LOGO.svg'; // Reemplaza "URL_DE_TU_IMAGEN" con la URL de tu imagen personalizada
    customMarkerImg.style.width = '40px'; // Ajusta el ancho de la imagen según tus necesidades
    customMarkerImg.style.height = '40px'; // Ajusta la altura de la imagen según tus necesidades
    // Crear un marcador personalizado utilizando la imagen personalizada
var marker = new mapboxgl.Marker({
    element: customMarkerImg,
    })
    .setLngLat([-75.55464053356573, 10.403744084469167]) // Coordenadas de la ubicación
    .addTo(map);
  // Contenido HTML para el panel de información detallada, incluyendo el botón de redirección
  var popupContent = '<h3>Título</h3>' +
    '<p>Información detallada del lugar.</p>' +
    '<a href="../Login/vista_general.php"><button>Acceder</button></a>';
    
  // Crear un popup con el contenido deseado
  var popup = new mapboxgl.Popup({ offset: 25 })
    .setHTML(popupContent);

  // Asignar el popup al marcador para que se muestre al hacer clic
  marker.setPopup(popup);    

















    //Segunda ubicacion 
var customMarkerImg = document.createElement('img');
        customMarkerImg.src = '../mapbox/LOGO.svg'; // Reemplaza "URL_DE_TU_IMAGEN" con la URL de tu imagen personalizada
        customMarkerImg.style.width = '40px'; // Ajusta el ancho de la imagen según tus necesidades
        customMarkerImg.style.height = '40px'; // Ajusta la altura de la imagen según tus necesidades
        // Crear un marcador personalizado utilizando la imagen personalizada
var marker = new mapboxgl.Marker({
        element: customMarkerImg,
        })
          .setLngLat([-75.53455281660233,10.410430226868442]) // Coordenadas de la ubicación
        .addTo(map);
        
  // Contenido HTML para el panel de información detallada
  var popupContent = '<h3>Parqueadero Manga1</h3>' +
    '<p>Amplio. </p>' + 
    '<p>Con techo.</p>';
    

  // Crear un popup con el contenido deseado
  var popup = new mapboxgl.Popup({ offset: 25 })
    .setHTML(popupContent);

  // Asignar el popup al marcador para que se muestre al hacer clic
  marker.setPopup(popup);        