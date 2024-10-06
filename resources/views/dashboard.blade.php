<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="">
        <div id='map'></div>
        <div id="side-panel">
            {{-- <h2 id="panel-title">Details</h2>
            <p id="panel-description">Click on a marker to see more details here.</p> --}}
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const BASEURL = window.location.origin
            mapboxgl.accessToken =
                "pk.eyJ1IjoiZmFyaWRtY2RhdG8iLCJhIjoiY20xdXpvZ25wMDU3aTJrc2o4OHV2aTV5aCJ9.Ggdiihpu7EmWS95BSPfF6Q";
            if (navigator.geolocation) {
                // Get the current position
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }

            function showPosition(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log("Latitude: " + latitude);
                console.log("Longitude: " + longitude);
                setupMap([longitude, latitude]);
            }
            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        console.log("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.log("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        console.log("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        console.log("An unknown error occurred.");
                        break;
                }
            }

            function setupMap(center) {
                
                const map = new mapboxgl.Map({
                    container: "map",
                    style: "mapbox://styles/mapbox/streets-v11",
                    center: center,
                    zoom: 15,
                });
                const nav = new mapboxgl.NavigationControl({
                    visualizePitch: true,
                });
                map.addControl(nav, "bottom-right");
                fetch('/api')
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    // Display data in the container
                    
                    data.forEach(element => {
                        console.log(element)
                         // Create a custom marker element for pulsing markers
                        if (element.color_marker === '#fa7a9c' || element.color_marker === '#fc0303') {
                            let pulseMarkerElement = document.createElement('div'); 
                            pulseMarkerElement.className = 'pulse-marker';
                            let imgElement  = document.createElement('img');
                            imgElement .src = `${BASEURL}/images/svgviewer-png-output.png `; 
                            pulseMarkerElement.appendChild(imgElement);
                            const pulsingMarker = new mapboxgl. Marker(pulseMarkerElement)
                                .setLngLat([element.longitude, element.latitude])
                                .addTo(map);

                            // Add popup for the pulsing marker
                            const popup = new mapboxgl.Popup({ offset: 25 })
                                .setHTML(`<div class="popup-content"><strong>${element.first_name} ${element.last_name}</strong></div>`)
                                .on('open', () => showPanel(element));

                            pulsingMarker.setPopup(popup);
                        } else {
                            // Create a default marker for non-pulsing markers
                            const marker = new mapboxgl.Marker({ color: element.color_marker })
                                .setLngLat([element.longitude, element.latitude])
                                .addTo(map);

                            // Add popup for the default marker
                            const popup = new mapboxgl.Popup({ offset: 25 })
                                .setHTML(`<div class="popup-content"><strong>${element.first_name} ${element.last_name}</strong></div>`)
                                .on('open', () => showPanel(element));

                            marker.setPopup(popup);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
                map.on('click', hidePanel);
            }
            // Function to show side panel with details
            function showPanel(data) {
                const sidePanel = document.getElementById('side-panel'); // Ensure side-panel exists

                if (sidePanel) {
                    const htmlx =`<div class="max-w-sm mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                                    <div class="bg-gray-800 text-white text-center py-4">
                                        <div class="inline-block">
                                        <img class="w-32 h-32 rounded-full mx-auto object-cover shadow-md" src="${BASEURL}/storage/${data.photo_path}" alt="Leigh McDaniel" />
                                        </div>
                                    </div>
                                    <div class="px-6 py-4">
                                        <div class="font-bold text-xl text-gray-900 mb-2">${data.first_name} ${data.last_name}</div>
                                        <p class="text-gray-700 text-base">
                                        <span class="font-semibold">Address:</span> ${data.address}
                                        </p>
                                        <p class="text-gray-700 text-base">
                                        <span class="font-semibold">Details:</span> ${data.details}
                                        </p>
                                        <p class="text-gray-700 text-base">
                                        <span class="font-semibold">Expiration date :</span> ${data.expiration_date}
                                        </p>
                                    </div>
                                    </div>`
                    const html = `<div >
                                        <div class="flex justify-center">
                                            <img src="${BASEURL}/storage/${data.photo_path}" style="max-width: 50%;">
                                            </div>
                                        
                                        <div class="py-6">
                                            <div class="flex justify-items-center w-full text-nowrap mb-4">
                                                <label class="p-4">Full Name: </label>
                                                <div class="p-4 border border-sky-500 w-full">
                                                    <h2>${data.first_name} ${data.last_name}</h2>
                                                </div>
                                            </div>
                                            <div class="flex justify-items-center w-full text-nowrap mb-4">
                                                <label class="p-4">Address:</label>
                                                <div class="p-4 border border-sky-500 w-full">
                                                    <p>${data.address}</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-items-center w-full text-nowrap mb-4">
                                                <lable class="p-4">Details:</lable>   
                                                <div class="p-4 border border-sky-500 w-full"> 
                                                <p>${data.details}</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-items-center w-full text-nowrap mb-4">
                                                <lable class="p-4">Expiration Date:</lable>   
                                                <div class="p-4 border border-sky-500 w-full"> 
                                                <p>${data.expiration_date}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;

                    sidePanel.innerHTML = ''

                    sidePanel.innerHTML = htmlx
                    
                    sidePanel.classList.add('active'); // Slide in the side panel
                }
            }
            function hidePanel() {
                const sidePanel = document.getElementById('side-panel');
                sidePanel.classList.remove('active');
            }
            
        });
    </script>
</x-app-layout>
