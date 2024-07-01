<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Legit Businesses</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <!-- MarkerCluster CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <!-- Leaflet Search CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-search@2.9.8/dist/leaflet-search.min.css" />
    <!-- Leaflet Fullscreen CSS -->
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css'
        rel='stylesheet' />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        #map-container {
            display: flex;
            height: 80vh;
            margin: 10px;
        }

        #map {
            flex: 3;
            height: 125%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #search-form {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin: 5px;
        }

        #directions-container {
            position: absolute;
            top:140px;
            left: 10px;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
            margin-left:5px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
            font-size: 1.5em;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            font-size: 0.9em;
        }

        input {
            padding: 8px;
            margin-bottom: 15px;
            width: calc(100% - 16px);
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9em;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            color: #fff;
            background-color: #007bff;
            transition: background-color 0.3s ease-in-out;
            font-size: 1em;
            margin-top: 10px;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .leaflet-popup-content-wrapper {
            padding: 0;
        }

        .custom-popup {
            padding: 15px;
        }

        .custom-popup h3 {
            margin: 0 0 10px 0;
            color: #007bff;
        }

        .custom-popup .status {
            font-weight: bold;
            padding: 5px;
            border-radius: 3px;
            display: inline-block;
        }

        .custom-popup .status.open {
            background-color: #28a745;
            color: white;
        }

        .custom-popup .status.closed {
            background-color: #dc3545;
            color: white;
        }

        .custom-popup .status.expired {
            background-color: #ffc107;
            color: black;
        }

        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
.leaflet-routing-container {
    display: block !important;
    max-height: 300px;
    width: 350px;
    overflow-y: auto;
    background-color: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
    </style>
</head>

<body>
    <div id="map-container">
        <div id="map"></div>

        <div id="search-form">
            <h2>Find Directions</h2>
            <label for="start">From:</label>
            <input type="text" id="start" placeholder="Enter start location">
            <label for="end">To:</label>
            <input type="text" id="end" placeholder="Enter end location">
            <button onclick="useCurrentLocation('start')">Use Current Location</button>
            <button id="start-navigation" onclick="startNavigation()">Start Navigation</button>
        </div>
    </div>

    <div id="directions-container" >

            <img src="{{ asset('images/delete.png') }}" alt="Stop" style="width:25px; height:25px;" onclick="stopNavigation()">

        </div>
    </div>
    {{-- <div class="leaflet-routing-container leaflet-bar leaflet-control" onclick="stopNavigation()"></div> --}}

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine JS -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <!-- MarkerCluster JS -->
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <!-- Leaflet Search JS -->
    <script src="https://unpkg.com/leaflet-search@2.9.8/dist/leaflet-search.min.js"></script>
    <!-- Leaflet Fullscreen JS -->
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <!-- Leaflet EasyButton JS -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var selectedBusiness = @json($selectedBusiness);
        console.log("Selected Business:", selectedBusiness);
        console.log("All Posts:", posts);

        if (selectedBusiness) {
        document.getElementById('end').value = decodeURIComponent(selectedBusiness);
        setTimeout(function() {
        getDirections();
        startNavigation();
        }, 1000); // Delay to ensure map is fully loaded
        }
        });

        function fuzzyMatch(str1, str2) {
        str1 = str1.toLowerCase().replace(/[^a-z0-9]/g, '');
        str2 = str2.toLowerCase().replace(/[^a-z0-9]/g, '');
        return str1.includes(str2) || str2.includes(str1);
        }
        </script>
    <script>
        var posts = @json($posts);
        var selectedBusiness = @json($selectedBusiness);
        var map = L.map("map", {
            fullscreenControl: true,
        }).setView([14.5695, 121.1126], 13);

        L.tileLayer("https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        }).addTo(map);

        var markers = L.markerClusterGroup();
        var userLocationMarker;
        var userLocation = null;
        var routingControl;

        function addCategoryMarkers() {
    posts.forEach(function(post) {
        var isOpen = isBusinessOpen(post.store_hours);
        var markerColor = post.is_active ? (isOpen ? 'green' : 'blue') : 'red';
        var marker = L.marker([post.latitude, post.longitude], {
            icon: coloredIcon(markerColor),
            businessName: post.businessName  // Add this line
        });

        var popupContent = createPopupContent(post, isOpen);
        marker.bindPopup(popupContent);
        markers.addLayer(marker);
    });
    map.addLayer(markers);
}

        function createPopupContent(post, isOpen) {
            var content = `
                <div class="custom-popup">
                    <h3>${post.businessName}</h3>
                    <p>${post.description}</p>
                    ${post.images && post.images.length > 0 ? `<img src="${JSON.parse(post.images)[0]}" width="100">` : '<p>No image available</p>'}
                    <p class="status ${!post.is_active ? 'expired' : (isOpen ? 'open' : 'closed')}">
                        ${!post.is_active ? 'Expired Permit' : (isOpen ? 'Open' : 'Closed')}
                    </p>
                    ${post.store_hours ? `<p>Hours today: ${post.store_hours[new Date().toLocaleString('en-US', { weekday: 'long', timeZone: 'Asia/Manila' }).toLowerCase()]}</p>` : '<p>Hours today: Not available</p>'}
                </div>
            `;
            return content;
        }

        function coloredIcon(color) {
            return L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + color +
                    '.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        }

        function addLegend() {
            var legend = L.control({
                position: 'bottomright'
            });
            legend.onAdd = function(map) {
                var div = L.DomUtil.create('div', 'info legend');
                div.innerHTML += '<i style="background: green"></i> Open<br>';
                div.innerHTML += '<i style="background: blue"></i> Closed<br>';
                div.innerHTML += '<i style="background: red"></i> Expired Permit<br>';
                return div;
            };
            legend.addTo(map);
        }

        function isBusinessOpen(storeHours) {
            if (!storeHours) return false;

            var now = new Date(new Date().toLocaleString("en-US", {
                timeZone: "Asia/Manila"
            }));
            var day = now.toLocaleString('en-US', {
                weekday: 'long'
            }).toLowerCase();
            var currentTime = now.getHours() * 60 + now.getMinutes();

            var hours = storeHours[day];
            if (hours === 'Closed') return false;

            var [openStr, closeStr] = hours.split(' - ');
            var openTime = timeStringToMinutes(openStr);
            var closeTime = timeStringToMinutes(closeStr);

            return currentTime >= openTime && currentTime < closeTime;
        }

        function timeStringToMinutes(timeStr) {
            var [time, period] = timeStr.split(' ');
            var [hours, minutes] = time.split(':').map(Number);
            if (period === 'PM' && hours !== 12) hours += 12;
            if (period === 'AM' && hours === 12) hours = 0;
            return hours * 60 + minutes;
        }

        var userLocation = null;

function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                document.getElementById("start").value = "Current Location";
                updateUserLocationMarker(userLocation);
            },
            function(error) {
                console.error("Error getting user location:", error.message);
            }
        );
    } else {
        console.error("Geolocation is not supported by this browser.");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    getUserLocation();

    var selectedBusiness = @json($selectedBusiness);
    console.log("Selected Business:", selectedBusiness);
    console.log("All Posts:", posts);

    if (selectedBusiness) {
        document.getElementById('end').value = decodeURIComponent(selectedBusiness);
        setTimeout(function() {
            getDirections();
        }, 1000); // Delay to ensure map is fully loaded
    }
});

function getDirections() {
    var startName = document.getElementById("start").value;
    var endName = decodeURIComponent(document.getElementById("end").value);
    console.log("Searching for end location:", endName);

    var waypoints = [];

    if (startName.toLowerCase() === "current location") {
        if (userLocation) {
            waypoints.push(L.latLng(userLocation.lat, userLocation.lng));
            var endLocation = findLocationByName(endName);

            if (endLocation !== null) {
                waypoints.push(L.latLng(endLocation.lat, endLocation.lng));
                routingControl.setWaypoints(waypoints);
            } else {
                console.error("Unable to find end location:", endName);
                alert("Unable to find end location: " + endName);
            }
        } else {
            alert("Unable to get current location. Please try again.");
        }
    } else {
        // ... rest of the function for non-current location starts ...
    }
}

function updateUserLocationMarker(location) {
    if (!userLocationMarker) {
        userLocationMarker = L.marker(location).addTo(map);
        userLocationMarker.bindPopup("Your Location").openPopup();
    } else {
        userLocationMarker.setLatLng(location);
    }
}

        function useCurrentLocation(field) {
            getUserLocation();
            document.getElementById(field).value = "Current Location";
        }

        function startNavigation() {
    var startName = document.getElementById("start").value;
    var endName = document.getElementById("end").value;

    console.log("Start:", startName);
    console.log("End:", endName);

    if (startName && endName) {
        document.getElementById("search-form").style.display = "none";
        document.getElementById("directions-container").style.display = 'block';
        getDirections();
    } else {
        alert("Please fill both the start and end locations.");
    }
}

        function stopNavigation() {
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }
            document.getElementById("search-form").style.display = "block";
            document.getElementById("directions-container").style.display = 'none';
        }

        function getDirections() {
    var startName = document.getElementById("start").value;
    var endName = document.getElementById("end").value;

    var waypoints = [];

    if (startName.toLowerCase() === "current location") {
        if (userLocation) {
            waypoints.push(L.latLng(userLocation.lat, userLocation.lng));
        } else {
            alert("Unable to get current location. Please try again.");
            return;
        }
    } else {
        var startLocation = findLocationByName(startName);
        if (startLocation) {
            waypoints.push(L.latLng(startLocation.lat, startLocation.lng));
        } else {
            alert("Unable to find start location: " + startName);
            return;
        }
    }

    var endLocation = findLocationByName(endName);
    if (endLocation) {
        waypoints.push(L.latLng(endLocation.lat, endLocation.lng));
    } else {
        alert("Unable to find end location: " + endName);
        return;
    }

    if (routingControl) {
        map.removeControl(routingControl);
    }

    routingControl = L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: true,
        showAlternatives: true,
        fitSelectedRoutes: true,
        show: true
    }).addTo(map);

    // Ensure the directions container is visible
    document.getElementById("directions-container").style.display = 'block';
}

        function findLocationByName(name) {
            name = decodeURIComponent(name).toLowerCase().trim();
            for (var i = 0; i < posts.length; i++) {
                if (posts[i].businessName.toLowerCase().trim() === name) {
                    return {
                        lat: posts[i].latitude,
                        lng: posts[i].longitude
                    };
                }
            }
            return null;
        }

        function fuzzyMatch(str1, str2) {
    str1 = str1.toLowerCase().replace(/[^a-z0-9]/g, '');
    str2 = str2.toLowerCase().replace(/[^a-z0-9]/g, '');
    return str1.includes(str2) || str2.includes(str1);
}

        var startInput = document.getElementById("start");
        var endInput = document.getElementById("end");

        startInput.addEventListener("input", function() {
            showSuggestions(this, this.value);
        });

        endInput.addEventListener("input", function() {
            showSuggestions(this, this.value);
        });

        function showSuggestions(inputField, inputValue) {
            var suggestions = posts.filter(function(post) {
                return fuzzyMatch(post.businessName, inputValue);
            });

            var autocompleteList = document.createElement("div");
            autocompleteList.setAttribute("class", "autocomplete-items");
            inputField.parentNode.appendChild(autocompleteList);

            suggestions.forEach(function(suggestion) {
                var div = document.createElement("div");
                div.innerHTML = suggestion.businessName;
                div.addEventListener("click", function() {
                    inputField.value = suggestion.businessName;
                    removeSuggestions();
                });
                autocompleteList.appendChild(div);
            });
        }

        function removeSuggestions() {
            var suggestions = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < suggestions.length; i++) {
                suggestions[i].parentNode.removeChild(suggestions[i]);
            }
        }

        document.addEventListener("click", function(e) {
            if (!e.target.matches('.autocomplete-items') && !e.target.matches('#start') && !e.target.matches(
                '#end')) {
                removeSuggestions();
            }
        });

        // Initialize map features
        addCategoryMarkers();
        addLegend();

        // Add search control
        var searchControl = new L.Control.Search({
    layer: markers,
    propertyName: 'businessName',
    marker: false,
    moveToLocation: function(latlng, title, map) {
        map.setView(latlng, 17);
        var foundMarker = findMarkerByBusinessName(title);
        if (foundMarker) {
            foundMarker.openPopup();
        }
    }
});
map.addControl(searchControl);

function findMarkerByBusinessName(name) {
    var result = null;
    markers.eachLayer(function(layer) {
        if (layer.options.businessName === name) {
            result = layer;
        }
    });
    return result;
}

document.addEventListener('DOMContentLoaded', function() {
    getUserLocation();

    if (selectedBusiness) {
        var decodedBusiness = decodeURIComponent(selectedBusiness);
        document.getElementById('end').value = decodedBusiness;

        // Set start location to user's current location
        document.getElementById('start').value = 'Current Location';

        setTimeout(function() {
            var endLocation = findLocationByName(decodedBusiness);
            if (endLocation) {
                map.setView([endLocation.lat, endLocation.lng], 15);
                var popup = L.popup()
                    .setLatLng([endLocation.lat, endLocation.lng])
                    .setContent('<b>' + decodedBusiness + '</b>')
                    .openOn(map);

                // Automatically start navigation
                startNavigation();
            }
        }, 1000);
    }
});
    </script>
</body>

</html>
