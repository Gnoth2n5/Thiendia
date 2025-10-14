<!-- Simple Map Picker for Filament -->
<div class="space-y-4">
    <!-- Instructions -->
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Click vào bản đồ để chọn vị trí của lăng mộ. Tọa độ sẽ tự động cập nhật vào các trường bên dưới.
    </p>
    
    <!-- Filament will render its own inputs for latitude/longitude in the form section -->
    
    <!-- Map Container -->
    <div id="map" style="height: 400px; width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem;"></div>
    
    <!-- Coordinates Display -->
    <div id="coords" style="margin-top: 10px; padding: 10px; background: #f0f0f0; border-radius: 5px;">
        Click vào bản đồ để chọn vị trí và lấy tọa độ.
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Leaflet to be available
    if (typeof L === 'undefined') {
        setTimeout(initializeMap, 100);
        return;
    }
    
    initializeMap();
});

function initializeMap() {
    const mapContainer = document.getElementById('map');
    if (!mapContainer) return;

    // Check if already initialized
    if (mapContainer._leaflet_id) {
        return;
    }

    try {
        // Initialize map
        const map = L.map('map').setView([20.2506, 105.9745], 13);
        
        // Add tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        let currentMarker = null;
        
        // Filament inputs (prefer id attributes like id="data.latitude")
        const latInput = document.getElementById('data.latitude') 
            || document.querySelector('#data\\.latitude') 
            || document.querySelector('input[name="data.latitude"]') 
            || document.querySelector('input[name="latitude"]');
        const lngInput = document.getElementById('data.longitude') 
            || document.querySelector('#data\\.longitude') 
            || document.querySelector('input[name="data.longitude"]') 
            || document.querySelector('input[name="longitude"]');

        // Load existing values
        if (latInput && lngInput && latInput.value && lngInput.value) {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            
            if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                map.setView([lat, lng], 15);
                currentMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup('Vị trí hiện tại: ' + lat.toFixed(6) + ', ' + lng.toFixed(6))
                    .openPopup();
                    
                // Ensure inputs have normalized precision
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);
            }
        }
        
        // Add click event
        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(8);
            const lng = e.latlng.lng.toFixed(8);
            
            // Update display
            document.getElementById('coords').innerHTML = 
                'Vị trí đã chọn: Latitude = ' + lat + ', Longitude = ' + lng;
            
            // Update Filament inputs and trigger client-side model update (deferred)
            if (latInput) {
                latInput.value = lat;
                latInput.dispatchEvent(new Event('input', { bubbles: true }));
                latInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            if (lngInput) {
                lngInput.value = lng;
                lngInput.dispatchEvent(new Event('input', { bubbles: true }));
                lngInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Update marker
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }
            
            currentMarker = L.marker(e.latlng).addTo(map)
                .bindPopup('Tọa độ: ' + lat + ', ' + lng)
                .openPopup();
                
            console.log('Updated coordinates:', lat, lng);
        });
        
        console.log('Map initialized successfully');
        
    } catch (error) {
        console.error('Error initializing map:', error);
    }
}
</script>

