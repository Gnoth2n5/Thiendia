<!-- Simple Map Picker for Filament -->
<div class="space-y-4" x-data="mapPicker()" x-init="initMap()">
    <!-- Instructions -->
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Click vào bản đồ để chọn vị trí của lăng mộ. Tọa độ sẽ tự động cập nhật vào các trường bên dưới.
    </p>
    
    <!-- Filament will render its own inputs for latitude/longitude in the form section -->
    
    <!-- Map Container -->
    <div x-ref="mapContainer" style="height: 400px; width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem;"></div>
    
    <!-- Coordinates Display -->
    <div x-text="coordsDisplay" style="margin-top: 10px; padding: 10px; background: #f0f0f0; border-radius: 5px;">
        Click vào bản đồ để chọn vị trí và lấy tọa độ.
    </div>
</div>

<script>
function mapPicker() {
    return {
        map: null,
        marker: null,
        coordsDisplay: 'Click vào bản đồ để chọn vị trí và lấy tọa độ.',
        
        initMap() {
            // Wait for Leaflet to be available
            if (typeof L === 'undefined') {
                setTimeout(() => this.initMap(), 100);
                return;
            }
            
            // Check if already initialized
            if (this.map) return;
            
            try {
                // Initialize map
                this.map = L.map(this.$refs.mapContainer).setView([20.2506, 105.9745], 13);
                
                // Add tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.map);
                
                // Load existing coordinates
                this.loadExistingCoordinates();
                
                // Add click event
                this.map.on('click', (e) => {
                    this.updateCoordinates(e.latlng.lat, e.latlng.lng);
                });
                
                console.log('Map initialized successfully');
                
            } catch (error) {
                console.error('Error initializing map:', error);
            }
        },
        
        loadExistingCoordinates() {
            const latInput = document.getElementById('data.latitude') 
                || document.querySelector('#data\\.latitude') 
                || document.querySelector('input[name="data.latitude"]') 
                || document.querySelector('input[name="latitude"]');
            const lngInput = document.getElementById('data.longitude') 
                || document.querySelector('#data\\.longitude') 
                || document.querySelector('input[name="data.longitude"]') 
                || document.querySelector('input[name="longitude"]');
            
            if (latInput && lngInput && latInput.value && lngInput.value) {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                
                if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                    this.map.setView([lat, lng], 15);
                    this.addMarker(lat, lng);
                }
            }
        },
        
        updateCoordinates(lat, lng) {
            const latStr = lat.toFixed(8);
            const lngStr = lng.toFixed(8);
            
            // Update display
            this.coordsDisplay = `Vị trí đã chọn: Latitude = ${latStr}, Longitude = ${lngStr}`;
            
            // Update Filament inputs
            const latInput = document.getElementById('data.latitude') 
                || document.querySelector('#data\\.latitude') 
                || document.querySelector('input[name="data.latitude"]') 
                || document.querySelector('input[name="latitude"]');
            const lngInput = document.getElementById('data.longitude') 
                || document.querySelector('#data\\.longitude') 
                || document.querySelector('input[name="data.longitude"]') 
                || document.querySelector('input[name="longitude"]');
            
            if (latInput) {
                latInput.value = latStr;
                latInput.dispatchEvent(new Event('input', { bubbles: true }));
                latInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            if (lngInput) {
                lngInput.value = lngStr;
                lngInput.dispatchEvent(new Event('input', { bubbles: true }));
                lngInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Update marker
            this.addMarker(lat, lng);
        },
        
        addMarker(lat, lng) {
            if (this.marker) {
                this.map.removeLayer(this.marker);
            }
            
            this.marker = L.marker([lat, lng])
                .addTo(this.map)
                .bindPopup(`Tọa độ: ${lat.toFixed(8)}, ${lng.toFixed(8)}`)
                .openPopup();
        }
    }
}
</script>

