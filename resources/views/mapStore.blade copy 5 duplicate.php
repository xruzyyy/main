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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            top:30px;
            left: 120px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
            margin-left:10px;
            background-color:rgb(255, 255, 255);
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
    width: 300px;
    overflow-y: auto;
    background-color: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.home-button {
    display: inline-block;
    margin: 10px; /* Adjust margins as needed */
    padding: 5px;
    background-color: #007bff; /* Button background color */
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.home-button a {
    display: block;
    color: white;
    text-decoration: none;
    text-align: center;
}

.home-button:hover {
    background-color: #0056b3; /* Darker color on hover */
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
            <div class="home-button">
                <a href="{{ route('business.home') }}" class="nav-link" title="Home">
                    <i class="fas fa-home fa-3x"></i>
                </a>
            </div>

        </div>
    </div>

    <div id="directions-container" >
        <div class="leaflet-routing-container leaflet-bar leaflet-control">
            <img class="stop" src="{{ asset('images/delete.png') }}" alt="Stop" style="width:25px; height:25px; " onclick="stopNavigation()">
        </div>
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
var speechCount = 0;
var routingContainer;

function updateRouting(waypoints) {
    if (!routingControl) {
        routingControl = L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: false,
            showAlternatives: true,
            fitSelectedRoutes: false,
            show: true  // Don't show the default container
        }).addTo(map);

        // // Create a custom container for directions
        // routingContainer = L.DomUtil.create('div', 'custom-routing-container');
        // document.getElementById('directions-container').appendChild(routingContainer);
    } else {
        routingControl.setWaypoints(waypoints);
    }

    routingControl.on('routesfound', function(e) {
        handleRoutesFound(e);
        updateDirectionsContainer(e.routes[0]);
    });
}

function updateDirectionsContainer(route) {
    if (!routingContainer) return;

    // Clear existing content
    routingContainer.innerHTML = '';

    // Append new directions
    var ol = L.DomUtil.create('ol', 'directions-list', routingContainer);
    route.instructions.forEach(function(instruction) {
        var li = L.DomUtil.create('li', '', ol);
        li.innerHTML = instruction.text;
    });
}
function addCategoryMarkers() {
    posts.forEach(function(post) {
        var isOpen = isBusinessOpen(post.store_hours);
        var markerColor = post.is_active ? (isOpen ? 'green' : 'blue') : 'red';
        var marker = L.marker([post.latitude, post.longitude], {
            icon: coloredIcon(markerColor),
            businessName: post.businessName
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
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + color + '.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
}

function addLegend() {
    var legend = L.control({
        position: 'topleft'
    });
    legend.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML += '<i style="background: green"></i> Open<br>';
        div.innerHTML += '<i style="background: blue"></i> Closed<br>';
        div.innerHTML += '<i style="background: red"></i> Expired <br> Permit<br>';
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
                map.setView([userLocation.lat, userLocation.lng], 15);
            },
            function(error) {
                console.error("Error getting user location:", error.message);
                Swal.fire({
                    icon: 'error',
                    title: 'Location Error',
                    text: 'Unable to get your location. Please enable location services and try again.',
                });
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        console.error("Geolocation is not supported by this browser.");
        Swal.fire({
            icon: 'error',
            title: 'Browser Error',
            text: 'Geolocation is not supported by your browser.',
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    getUserLocation();

    if (selectedBusiness) {
        var decodedBusiness = decodeURIComponent(selectedBusiness);
        document.getElementById('end').value = decodedBusiness;
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

var directionIntervalId;

function startNavigation() {
    var startName = document.getElementById("start").value;
    var endName = document.getElementById("end").value;

    if (startName && endName) {
        document.getElementById("search-form").style.display = "none";
        document.getElementById("directions-container").style.display = 'block';

        var waypoints = [];
        if (startName.toLowerCase() === "current location" && userLocation) {
            waypoints.push(L.latLng(userLocation.lat, userLocation.lng));
        } else {
            var startLocation = findLocationByName(startName);
            if (startLocation) waypoints.push(L.latLng(startLocation.lat, startLocation.lng));
        }

        var endLocation = findLocationByName(endName);
        if (endLocation) waypoints.push(L.latLng(endLocation.lat, endLocation.lng));

        if (waypoints.length === 2) {
            updateRouting(waypoints);
            speak("Starting navigation. Please follow the route on your screen.");

            // Initial call to getDirections
            getDirectionsWithoutRefresh();

            // Set up interval to call getDirections every 5 seconds without refreshing
            directionIntervalId = setInterval(function() {
                console.log("Calling getDirections (5-second interval)");
                getDirectionsWithoutRefresh();
            }, 5000);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Unable to find one or both locations.',
            });
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please fill both the start and end locations.',
        });
    }
}

function getDirectionsWithoutRefresh() {
    if (routingControl) {
        routingControl.route();
    }
}

function updateRouting(waypoints) {
    if (!routingControl) {
        routingControl = L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: false,
            showAlternatives: true,
            fitSelectedRoutes: false,
            show: false
        }).addTo(map);

        routingControl.on('routesfound', function(e) {
            updateDirectionsContainer(e.routes[0]);
        });
    } else {
        routingControl.setWaypoints(waypoints);
    }
}

function updateDirectionsContainer(route) {
    var container = document.getElementById('directions-container');
    if (!container) return;

    // Update only if there are changes
    var newDirections = route.instructions.map(instruction => instruction.text).join('<br>');
    if (container.innerHTML !== newDirections) {
        container.innerHTML = newDirections;
    }
}

function stopNavigation() {
    if (routingControl) {
        map.removeControl(routingControl);
        routingControl = null;
    }
    if (routingContainer) {
        routingContainer.innerHTML = '';
    }
    document.getElementById("search-form").style.display = "block";
    document.getElementById("directions-container").style.display = 'none';
    speechSynthesis.cancel();
    speak("Navigation ended.");

    if (directionIntervalId) {
        clearInterval(directionIntervalId);
    }
}


function getDirections() {
    var startName = document.getElementById("start").value;
    var endName = document.getElementById("end").value;

    if (!startName || !endName) {
        Swal.fire({
            icon: 'error',
            title: 'Input Error',
            text: 'Please fill both start and end locations.',
        });
        return;
    }

    var waypoints = [];

    if (startName.toLowerCase() === "current location") {
        if (!userLocation) {
            Swal.fire({
                icon: 'error',
                title: 'Location Error',
                text: 'Current location not available. Please try again or enter a specific start location.',
            });
            return;
        }
        waypoints.push(L.latLng(userLocation.lat, userLocation.lng));
    } else {
        var startLocation = findLocationByName(startName);
        if (!startLocation) {
            Swal.fire({
                icon: 'error',
                title: 'Location Error',
                text: 'Unable to find start location: ' + startName,
            });
            return;
        }
        waypoints.push(L.latLng(startLocation.lat, startLocation.lng));
    }

    var endLocation = findLocationByName(endName);
    if (!endLocation) {
        Swal.fire({
            icon: 'error',
            title: 'Location Error',
            text: 'Unable to find end location: ' + endName,
        });
        return;
    }
    waypoints.push(L.latLng(endLocation.lat, endLocation.lng));

    if (routingControl) {
        map.removeControl(routingControl);
    }

    routingControl = L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: false,
        showAlternatives: true,
        fitSelectedRoutes: false,
        show: true
    }).addTo(map);

    routingControl.on('routesfound', handleRoutesFound);
    routingControl.on('routingerror', handleRoutingError);
}

function handleRoutesFound(e) {
    console.log("Routes found:", e.routes);
    var routes = e.routes;
    var summary = routes[0].summary;

    var businessName = document.getElementById("end").value;

    var routeSummary = `Route to ${businessName} found. `;
    routeSummary += `The trip is approximately ${Math.round(summary.totalDistance / 1000)} kilometers `;
    routeSummary += `and will take about ${Math.round(summary.totalTime / 60)} minutes.`;

    console.log("Route summary:", routeSummary);
    speak(routeSummary);

    if (routes[0].instructions.length > 0) {
        console.log("First instruction:", routes[0].instructions[0].text);
        speak(routes[0].instructions[0].text);
    }

    startLocationTracking();
}

function handleRoutingError(e) {
    console.error("Routing error:", e.error);
    Swal.fire({
        icon: 'error',
        title: 'Routing Error',
        text: 'Unable to calculate route. Please check your locations and try again.',
    });
}

function speak(text) {
    if ('speechSynthesis' in window) {
        var utterance = new SpeechSynthesisUtterance(text);
        var voices = speechSynthesis.getVoices();
        var desiredVoice = voices.find(voice => voice.name === "Google UK English Female");

        utterance.voice = desiredVoice || voices[2]; // Fallback to the third available voice if desiredVoice is not found
        utterance.pitch = 1;
        utterance.rate = 1;
        utterance.volume = 1;

        // Always speak "Navigation ended." regardless of speechCount
        if (text === "Navigation ended." || speechCount < 4) {
            speechSynthesis.speak(utterance);
            if (text !== "Navigation ended.") {
                speechCount++;
            }
            console.log("Speech count:", speechCount);
        }
    }
}

function startLocationTracking() {
    var lastAnnouncedInstruction = -1;
    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function updatePosition(position) {
        var latlng = L.latLng(position.coords.latitude, position.coords.longitude);
        updateUserLocationMarker(latlng);

        if (routingControl) {
            var routes = routingControl.getRouter().route();
            if (routes.length > 0) {
                var route = routes[0];
                var closestIndex = L.GeometryUtil.closest(map, route.coordinates, latlng);

                var nextInstructionIndex = route.instructions.findIndex((instruction, index) =>
                    index > lastAnnouncedInstruction && instruction.index > closestIndex
                );

                if (nextInstructionIndex !== -1) {
                    var nextInstruction = route.instructions[nextInstructionIndex];
                    var distanceToInstruction = L.GeometryUtil.length(
                        route.coordinates.slice(closestIndex, nextInstruction.index)
                    );

                    if (distanceToInstruction <= 50) {
                        speak(nextInstruction.text);
                        lastAnnouncedInstruction = nextInstructionIndex;
                    }
                }
            }
        }
    }

    function errorHandler(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
        Swal.fire({
            icon: 'error',
            title: 'Location Tracking Error',
            text: 'Unable to track your location: ' + err.message,
        });
    }

    navigator.geolocation.watchPosition(updatePosition, errorHandler, options);
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
    if (!e.target.matches('.autocomplete-items') && !e.target.matches('#start') && !e.target.matches('#end')) {
        removeSuggestions();
    }
});

addCategoryMarkers();
addLegend();

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
    // Initialize map
    map = L.map('map').setView([initialLat, initialLng], initialZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Initialize routing control without waypoints
    routingControl = L.Routing.control({
        routeWhileDragging: true,
        showAlternatives: true,
        fitSelectedRoutes: true,
        show: true
    }).addTo(map);

    routingControl.on('routesfound', handleRoutesFound);
    routingControl.on('routingerror', handleRoutingError);

    getUserLocation();

    if (selectedBusiness) {
        var decodedBusiness = decodeURIComponent(selectedBusiness);
        document.getElementById('end').value = decodedBusiness;
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

var leafletTopRight = document.querySelector('.leaflet-top.leaflet-right');
if (leafletTopRight) {
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(node) {
                    if (node.classList && node.classList.contains('leaflet-routing-container')) {
                        leafletTopRight.remove(); // Remove the entire element
                        observer.disconnect();
                    }
                });
            }
        });
    });

    observer.observe(leafletTopRight, { childList: true, subtree: true });
}

map.on('locationfound', function(e) {
    if (routingControl) {
        var routes = routingControl.getRouter().route();
        if (routes.length > 0) {
            var nextInstruction = routes[0].instructions.find(function(instruction) {
                return instruction.distance > 0;
            });
            if (nextInstruction) {
                speak(nextInstruction.text);
            }
        }
    }
});
    </script>
</body>

</html>
