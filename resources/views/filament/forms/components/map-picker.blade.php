<!-- Simple Map Picker for Filament -->
<div class="space-y-4" x-data="mapPicker()" x-init="initMap()">
    <!-- Instructions -->
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Tìm kiếm địa điểm hoặc click vào bản đồ để chọn vị trí của lăng mộ. Tọa độ sẽ tự động cập nhật vào các trường bên dưới.
    </p>
    
    <!-- Search Bar -->
    <div style="margin-bottom: 16px;">
        <div style="display: flex; gap: 8px;">
            <div style="flex: 1; position: relative;">
                <input 
                    x-model="searchQuery" 
                    @keyup.enter="searchLocation()"
                    type="text" 
                    placeholder="Nhập địa điểm để tìm kiếm (ví dụ: Nghĩa trang, Địa chỉ cụ thể...)"
                    style="width: 100%; padding: 12px 16px; padding-right: 48px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: white; color: #111827;"
                >
                <!-- Search Icon inside input -->
                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px; color: #9ca3af;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
            </div>
            
            <!-- Search Button -->
            <button 
                @click="searchLocation()"
                :disabled="!searchQuery.trim() || isSearching"
                style="padding: 12px 24px; background: #2563eb; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 500; font-size: 14px; transition: background-color 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                onmouseover="this.style.background='#1d4ed8'"
                onmouseout="this.style.background='#2563eb'"
            >
                <!-- Search Icon -->
                <svg x-show="!isSearching" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 20px; height: 20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                
                <!-- Loading Spinner -->
                <svg x-show="isSearching" style="animation: spin 1s linear infinite; width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                
                <!-- Button Text -->
                <span x-text="isSearching ? 'Đang tìm...' : 'Tìm kiếm'"></span>
            </button>
        </div>
        
        <!-- Quick Search Tips -->
        <div style="margin-top: 8px; font-size: 12px; color: #6b7280;">
            💡 Gợi ý: "Nghĩa trang Ninh Bình", "Chùa Bái Đính", "Nhà thờ Phát Diệm"
        </div>
    </div>
    
    <!-- Search Results -->
    <div x-show="searchResults.length > 0" class="mb-4 max-h-40 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700">
        <template x-for="result in searchResults" :key="result.place_id">
            <div 
                @click="selectSearchResult(result)"
                class="p-3 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-b-0"
            >
                <p class="font-medium text-sm" x-text="result.display_name"></p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="`Lat: ${result.lat.toFixed(6)}, Lng: ${result.lon.toFixed(6)}`"></p>
            </div>
        </template>
    </div>
    
    <!-- Map Container with wire:ignore to prevent Livewire from re-rendering -->
    <div wire:ignore>
        <div x-ref="mapContainer" style="height: 400px; width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem;"></div>
    </div>
    
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
        searchQuery: '',
        searchResults: [],
        isSearching: false,
        watchersInitialized: false,
        
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
                
                // Setup watchers for coordinate input changes
                this.setupInputWatchers();
                
                // Listen for Livewire updates
                this.setupLivewireListeners();
                
                console.log('Map initialized successfully');
                
            } catch (error) {
                console.error('Error initializing map:', error);
            }
        },
        
        setupInputWatchers() {
            if (this.watchersInitialized) return;
            
            const checkAndWatch = () => {
                const latInput = this.getLatInput();
                const lngInput = this.getLngInput();
                
                if (latInput && lngInput) {
                    // Watch for manual input changes
                    latInput.addEventListener('change', () => this.syncFromInputs());
                    lngInput.addEventListener('change', () => this.syncFromInputs());
                    
                    this.watchersInitialized = true;
                    console.log('Input watchers initialized');
                } else {
                    // Retry if inputs not found yet
                    setTimeout(checkAndWatch, 100);
                }
            };
            
            checkAndWatch();
        },
        
        setupLivewireListeners() {
            // Listen for Livewire finished updating
            document.addEventListener('livewire:init', () => {
                Livewire.hook('morph.updated', () => {
                    // Re-sync coordinates after Livewire updates
                    setTimeout(() => this.syncFromInputs(), 100);
                });
            });
            
            // Also listen for commit event (after save)
            document.addEventListener('livewire:commit', () => {
                setTimeout(() => this.syncFromInputs(), 100);
            });
        },
        
        syncFromInputs() {
            const latInput = this.getLatInput();
            const lngInput = this.getLngInput();
            
            if (latInput && lngInput && latInput.value && lngInput.value) {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                
                if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                    // Update map without triggering input updates (prevent loop)
                    this.coordsDisplay = `Vị trí đã chọn: Latitude = ${lat.toFixed(8)}, Longitude = ${lng.toFixed(8)}`;
                    
                    if (this.map) {
                        this.map.setView([lat, lng], 15);
                        this.addMarker(lat, lng);
                    }
                }
            }
        },
        
        getLatInput() {
            return document.getElementById('data.latitude') 
                || document.querySelector('#data\\.latitude') 
                || document.querySelector('input[name="data.latitude"]') 
                || document.querySelector('input[name="latitude"]');
        },
        
        getLngInput() {
            return document.getElementById('data.longitude') 
                || document.querySelector('#data\\.longitude') 
                || document.querySelector('input[name="data.longitude"]') 
                || document.querySelector('input[name="longitude"]');
        },
        
        loadExistingCoordinates() {
            const latInput = this.getLatInput();
            const lngInput = this.getLngInput();
            
            if (latInput && lngInput && latInput.value && lngInput.value) {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                
                if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                    this.map.setView([lat, lng], 15);
                    this.addMarker(lat, lng);
                    this.coordsDisplay = `Vị trí đã chọn: Latitude = ${lat.toFixed(8)}, Longitude = ${lng.toFixed(8)}`;
                }
            }
        },
        
        updateCoordinates(lat, lng) {
            const latStr = lat.toFixed(8);
            const lngStr = lng.toFixed(8);
            
            // Update display
            this.coordsDisplay = `Vị trí đã chọn: Latitude = ${latStr}, Longitude = ${lngStr}`;
            
            // Update Filament inputs
            const latInput = this.getLatInput();
            const lngInput = this.getLngInput();
            
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
        },
        
        async searchLocation() {
            if (!this.searchQuery.trim()) return;
            
            this.isSearching = true;
            this.searchResults = [];
            
            try {
                // Sử dụng Nominatim API (OpenStreetMap geocoding)
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=5&countrycodes=vn&addressdetails=1`
                );
                
                const results = await response.json();
                
                this.searchResults = results.map(result => ({
                    place_id: result.place_id,
                    display_name: result.display_name,
                    lat: parseFloat(result.lat),
                    lon: parseFloat(result.lon)
                }));
                
                console.log('Search results:', this.searchResults);
                
            } catch (error) {
                console.error('Search error:', error);
                this.searchResults = [];
            } finally {
                this.isSearching = false;
            }
        },
        
        selectSearchResult(result) {
            console.log('Selected result:', result);
            
            // Update coordinates
            this.updateCoordinates(result.lat, result.lon);
            
            // Center map on selected location
            this.map.setView([result.lat, result.lon], 15);
            
            // Clear search
            this.searchQuery = '';
            this.searchResults = [];
            
            // Update display with location name
            this.coordsDisplay = `Đã chọn: ${result.display_name}`;
        }
    }
}
</script>

