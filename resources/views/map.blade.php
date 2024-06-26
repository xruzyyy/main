<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaflet Map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    body {
      font-family: "Arial", sans-serif;
      margin: 0;
      padding: 0;
    }

    #map-container {
      height: 400px;
      margin: 20px;
    }

    #map {
      height: 100%;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <div id="map-container">
    <div id="map"></div>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    // Initialize Leaflet map
    var map = L.map("map").setView([14.5695, 121.1126], 13);


    // Leaflet map configuration
    L.tileLayer("https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
    attribution: "&copy; Google Maps"
    }).addTo(map);


    // Add a draggable marker
    var marker = L.marker([14.5695, 121.1126], { draggable: true }).addTo(map);

    // Update marker position on dragend event
    marker.on('dragend', function(event) {
      var position = marker.getLatLng();
      console.log(position.lat, position.lng);
      // Ask for confirmation before redirecting
      var confirmation = window.confirm("Are you sure you want to select this location?");
      if (confirmation) {
        // Redirect back to the form page with selected latitude and longitude
        window.location.href = "{{ route('listings.create', ['id' => auth()->user()->id]) }}?latitude=" + position.lat.toFixed(6) + "&longitude=" + position.lng.toFixed(6);
    }
    });
  </script>
</body>

</html>
