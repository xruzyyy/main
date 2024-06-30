<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaflet Map</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Bootstrap CSS for modal -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Arial", sans-serif;
      margin: 0;
      padding: 0;
      overflow: hidden; /* Prevent scrollbars */
    }

    #map-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh; /* Full viewport height */
    }

    #map {
      height: 100%;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .confirmation-button {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      padding: 10px 20px;
      background-color: #007BFF;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div id="map-container">
    <div id="map"></div>
  </div>

  <!-- Bootstrap Modal for confirmation -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirm Location Selection</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to select this location?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmLocationBtn">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <button class="confirmation-button" id="openModalBtn">Confirm Location</button>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script>
    // Initialize Leaflet map
    var map = L.map("map").setView([14.5695, 121.1126], 13);

    // Leaflet map configuration
    L.tileLayer("https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
      maxZoom: 20,
      subdomains: ["mt0", "mt1", "mt2", "mt3"],
      attribution: "&copy; Google Maps"
    }).addTo(map);

    // Define custom icon options
    var storeIcon = L.icon({
      iconUrl: '{{ asset("images/pointer.png") }}',
      iconSize: [64, 64], // size of the icon
      iconAnchor: [16, 32], // point of the icon which will correspond to marker's location
      popupAnchor: [0, -32] // point from which the popup should open relative to the iconAnchor
    });

    // Add a draggable marker with custom icon
    var marker = L.marker([14.5695, 121.1126], { draggable: true, icon: storeIcon }).addTo(map);

    // Update marker position on dragend event
    marker.on('dragend', function(event) {
      var position = marker.getLatLng();
      console.log(position.lat, position.lng);
    });

    // Open modal when button is clicked
    document.getElementById('openModalBtn').addEventListener('click', function() {
      $('#confirmModal').modal('show');
    });

    // Handle confirmation button click
    document.getElementById('confirmLocationBtn').addEventListener('click', function() {
      var position = marker.getLatLng();
      // Redirect to create or update route based on user's posts
      @if(auth()->user()->posts->isEmpty())
          window.location.href = "{{ route('listings.create', ['id' => auth()->user()->id]) }}?latitude=" + position.lat.toFixed(6) + "&longitude=" + position.lng.toFixed(6);
      @else
          // Assuming you want to update the first post, you may need to adjust this logic based on your requirements
          window.location.href = "{{ route('listings.update', ['id' => auth()->user()->posts->first()->id]) }}?latitude=" + position.lat.toFixed(6) + "&longitude=" + position.lng.toFixed(6);
      @endif
    });
  </script>
</body>

</html>
