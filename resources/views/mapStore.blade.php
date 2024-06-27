<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Legit Businesses</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

    <link rel="stylesheet" href="map.css">

    <script src="map.js"></script>
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

        .leaflet-control-attribution {
            display: none;
        }

        #map-container {
            flex: 1;
            margin: 10px;
            position: relative;
            /* Add position relative */
        }

        #map {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 50vh;
            /* Adjust height as needed */
        }

        #search-form {
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin: 5px;
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
            /* Adjust width to accommodate padding */
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
            width: 30%;
        }

        button:hover {
            background-color: #0056b3;
        }

        #directions-container {
            display: none;
            /* Hide the directions container by default */
            margin: 10px;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            /* Make it take full width */
        }


        .leaflet-routing-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            /* Set width to match parent */
        }

        /* Media query for larger screens */
        @media screen and (min-width: 768px) {
            #directions-container {
                width: 50%;
                margin: auto;
            }
        }

        .leaflet-routing-alt {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            color: rgb(15, 3, 3);
        }
    </style>
    @vite(['resources/scss/category.scss'])
    @vite(['resources/scss/_section.scss'])
    @vite(['resources/scss/main.scss'])
    @vite(['resources/scss/_businessHome.scss'])
    @vite(['resources/scss/_About.scss'])
    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
</head>

<body>
    {{-- @if (Auth::user()->type === 'business')
        @include('partials.header')
    @else
        @include('partials.userHeader')
    @endif --}}
    <div id="map-container">
        <div id="map"></div>

        <div id="directions-container">
            <button id="stop-navigation" onclick="stopNavigation()">Stop Navigation</button>

            <div class="leaflet-routing-container leaflet-bar leaflet-control">
                <!-- Routing controls and directions information will be placed here -->
            </div>
        </div>
    </div>

    <div id="search-form">
        <h2>Find Directions</h2>
        <label for="start">From:</label>
        <input type="text" id="start" placeholder="Enter start location">
        <label for="end">To:</label>
        <input type="text" id="end" placeholder="Enter end location">
        <button onclick="useCurrentLocation('start')">Use Current Location</button>
        <!-- Updated the button id to "search-button" -->
        {{-- <button id="search-button" onclick="getDirections()">Get Directions</button> --}}
        <button id="start-navigation" onclick="startNavigation()">Start Navigation</button>

    </div>


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <script>
        // Assuming you have already fetched the posts data from your database in PHP
        var posts = {!! json_encode($posts) !!};

        var map = L.map("map").setView([14.5695, 121.1126], 13);

        L.tileLayer("https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        }).addTo(map);

        function addCategoryMarkers() {
            var posts = {!! json_encode($posts) !!};

            posts.forEach(function(post) {
                var markerColor = post.is_active ? 'blue' : 'red'; // Set marker color based on is_active value
                var marker = L.marker([post.latitude, post.longitude], {
                    icon: coloredIcon(markerColor)
                }).addTo(map);

                // Check if the images property is defined and not empty
                if (post.images && post.images.length > 0) {
                    // Parse the JSON-encoded images string
                    var images = JSON.parse(post.images);

                    // Get the first image from the array
                    var firstImage = images[0];

                    marker.bindPopup("<b>" + post.businessName + "</b><br>" + post.description + "<br><img src='" +
                        firstImage + "' width='100'>" + (post.is_active ? "" :
                            "<br><strong>Expired Permit</strong>"));
                } else {
                    // If no image is available, display a default message
                    marker.bindPopup("<b>" + post.businessName + "</b><br>" + post.description +
                        "<br>No image available" + (post.is_active ? "" : "<br><strong>Expired Permit</strong>")
                    );
                }
            });
        }

        // Define a function to create colored markers
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

        addCategoryMarkers();

        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLatLng = L.latLng(
                            position.coords.latitude,
                            position.coords.longitude
                        );
                        map.setView(userLatLng, 13);
                        updateUserLocationMarker(userLatLng);
                        document.getElementById("start").value = "Current Location";
                    },
                    function(error) {
                        console.error("Error getting user location:", error.message);
                    }, {
                        maximumAge: 60000,
                        timeout: 5000,
                        enableHighAccuracy: true
                    }
                );
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        getUserLocation();

        var userLocationMarker;

        function updateUserLocationMarker(userLatLng) {
            if (!userLocationMarker) {
                userLocationMarker = L.marker(userLatLng).addTo(map);
                userLocationMarker.bindPopup("Your Location").openPopup();
                userLocationMarker.on("click", function() {
                    showStreetView(userLocationMarker.getLatLng());
                });
            } else {
                userLocationMarker.setLatLng(userLatLng);
            }

            document.getElementById("latitude").innerText = userLatLng.lat.toFixed(6);
            document.getElementById("longitude").innerText = userLatLng.lng.toFixed(6);
        }

        function useCurrentLocation(field) {
            getUserLocation();
            document.getElementById(field).value = "Current Location";
        }

        var routingControl = L.Routing.control({
            routeWhileDragging: true,
            waypoints: [],
            createMarker: function(i, waypoint, n) {
                if (i === 0) {
                    var marker = L.marker(waypoint.latLng);
                    map.addLayer(marker);
                    return marker;
                }
                return null;
            },
            addWaypoints: true,
            draggableWaypoints: false,
            fitSelectedRoutes: false, // Prevent the map from adjusting its view to fit the route
            show: true // Hide the routing control directions panel
        }).addTo(map);

        var intervalId; // Variable to store interval ID
        var routingContainer = document.querySelector('.leaflet-routing-container');

        // Hide the routing container initially
        routingContainer.style.display = 'none';

        function startNavigation() {
            var startName = document.getElementById("start").value;
            var endName = document.getElementById("end").value;

            if (startName && endName) { // Check if both fields are filled
                // Hide the search form
                document.getElementById("search-form").style.display = "none";

                document.getElementById("directions-container").style.display = 'block'; // Show the directions container
                routingContainer.style.display = 'block'; // Show the routing container
                intervalId = setInterval(() => {
                    getDirections();
                    console.log("Directions updated");
                }, 2000);
            } else {
                alert("Please fill both the start and end locations.");
            }
        }

        function stopNavigation() {
            clearInterval(intervalId); // Clear the interval to stop updating directions
            routingContainer.style.display = 'none'; // Hide the routing container
            console.log("Navigation stopped");

            // Display the search form again
            document.getElementById("search-form").style.display = "block";

            // Hide the directions container
            document.getElementById("directions-container").style.display = 'none';
        }



        function getDirections() {
            var startName = document.getElementById("start").value;
            var endName = document.getElementById("end").value;
            var waypoints = [];

            if (startName.toLowerCase().includes("current")) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLatLng = [position.coords.latitude, position.coords.longitude];
                        waypoints.push(L.latLng(userLatLng[0], userLatLng[1]));
                        var endLocation = findLocationByName(endName);
                        let alertShown = false;

                        if (endLocation !== null) {
                            waypoints.push(L.latLng(endLocation.lat, endLocation.lng));
                            routingControl.setWaypoints(waypoints);
                        } else {
                            if (!alertShown) {
                                alert("Unable to find end location.");
                                alertShown = true; // Set flag to true after showing the alert
                                setTimeout(function() {
                                    window.history.back(); // Navigate back in history after 1 second
                                }, 1000); // 1000 milliseconds = 1 second
                            }
                        }

                    },
                    function(error) {
                        console.error("Error getting user location:", error.message);
                    }
                );
            } else {
                var startLocation = findLocationByName(startName);
                if (startLocation !== null) {
                    waypoints.push(L.latLng(startLocation.lat, startLocation.lng));
                    var endLocation = findLocationByName(endName);
                    if (endLocation !== null) {
                        waypoints.push(L.latLng(endLocation.lat, endLocation.lng));
                        routingControl.setWaypoints(waypoints);
                    } else {
                        alert("Unable to find end location.");
                    }
                } else {
                    alert("Unable to find start location.");
                }
            }
        }

        function findLocationByName(name) {
            for (var i = 0; i < posts.length; i++) {
                if (posts[i].businessName.toLowerCase() === name.toLowerCase()) {
                    return {
                        lat: posts[i].latitude,
                        lng: posts[i].longitude
                    };
                }
            }
            return null;
        }

        function clearMarkers() {
            routingControl.getPlan().setWaypoints([]);
        }

        // Append Leaflet Routing Machine control to #directions-container
        function appendRoutingControl() {
            var directionsContainer = document.getElementById("directions-container");
            var control = routingControl.onAdd(map);
            directionsContainer.appendChild(control);
        }

        // Call the function to append the control
        appendRoutingControl();



        function findMarkerByBusinessName(name) {
            for (var i = 0; i < map._layers.length; i++) {
                var layer = map._layers[i];
                if (layer instanceof L.Marker && layer.businessName === name) {
                    return layer;
                }
            }
            return null;
        }

        var startInput = document.getElementById("start");
        var endInput = document.getElementById("end");

        startInput.addEventListener("input", function() {
            var inputValue = this.value.toLowerCase();
            var suggestions = posts.filter(function(category) {
                return category.businessName.toLowerCase().includes(inputValue);
            });

            var suggestedNames = suggestions.map(function(category) {
                return category.businessName;
            });

            showSuggestions(startInput, suggestedNames);
        });

        endInput.addEventListener("input", function() {
            var inputValue = this.value.toLowerCase();
            var suggestions = posts.filter(function(category) {
                return category.businessName.toLowerCase().includes(inputValue);
            });

            var suggestedNames = suggestions.map(function(category) {
                return category.businessName;
            });

            showSuggestions(endInput, suggestedNames);
        });

        function showSuggestions(inputField, suggestions) {
            var autocompleteList = document.createElement("div");
            autocompleteList.setAttribute("class", "autocomplete-items");
            removePreviousSuggestions();

            for (var i = 0; i < suggestions.length; i++) {
                var suggestion = document.createElement("div");
                suggestion.innerHTML =
                    "<strong>" +
                    suggestions[i].substr(0, inputField.value.length) +
                    "</strong>";
                suggestion.innerHTML += suggestions[i].substr(inputField.value.length);
                suggestion.innerHTML +=
                    "<input type='hidden' value='" + suggestions[i] + "'>";
                suggestion.addEventListener("click", function() {
                    inputField.value = this.getElementsByTagName("input")[0].value;
                    removePreviousSuggestions();
                });
                autocompleteList.appendChild(suggestion);
            }

            inputField.parentNode.appendChild(autocompleteList);

            document.addEventListener("click", function(event) {
                if (event.target !== inputField) {
                    removePreviousSuggestions();
                }
            });
        }

        function removePreviousSuggestions() {
            var autocompleteItems = document.querySelectorAll(".autocomplete-items");
            for (var i = 0; i < autocompleteItems.length; i++) {
                autocompleteItems[i].parentNode.removeChild(autocompleteItems[i]);
            }
        }
    </script>
</body>

</html>
