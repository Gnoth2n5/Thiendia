// Map Picker Script - Đơn giản như HTML mẫu
document.addEventListener("DOMContentLoaded", function () {
    // Khởi tạo bản đồ
    var map = L.map("map").setView([20.2506, 105.9745], 13); // Ninh Bình, zoom level 13

    // Thêm tile layer từ OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    let currentMarker = null;

    // Load existing coordinates - Try multiple selectors
    let latInput = document.querySelector('input[name="data.latitude"]');
    let lngInput = document.querySelector('input[name="data.longitude"]');

    // Fallback selectors if first ones don't work
    if (!latInput) {
        latInput = document.querySelector('input[name="latitude"]');
    }
    if (!lngInput) {
        lngInput = document.querySelector('input[name="longitude"]');
    }

    // Another fallback - by placeholder text
    if (!latInput) {
        const inputs = document.querySelectorAll('input[type="number"]');
        inputs.forEach((input) => {
            if (input.placeholder && input.placeholder.includes("20.250600")) {
                latInput = input;
            }
        });
    }
    if (!lngInput) {
        const inputs = document.querySelectorAll('input[type="number"]');
        inputs.forEach((input) => {
            if (input.placeholder && input.placeholder.includes("105.974500")) {
                lngInput = input;
            }
        });
    }

    console.log("Found inputs:", { latInput, lngInput });

    if (latInput && lngInput && latInput.value && lngInput.value) {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);

        if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
            map.setView([lat, lng], 15);

            // Add marker at existing coordinates
            currentMarker = L.marker([lat, lng])
                .addTo(map)
                .bindPopup(
                    "Vị trí hiện tại: " + lat.toFixed(6) + ", " + lng.toFixed(6)
                )
                .openPopup();
        }
    }

    // Event listener cho click: Lấy tọa độ và hiển thị
    map.on("click", function (e) {
        var lat = e.latlng.lat.toFixed(8); // Latitude
        var lng = e.latlng.lng.toFixed(8); // Longitude

        // Update display
        const coordsDiv = document.getElementById("coords");
        if (coordsDiv) {
            coordsDiv.innerHTML =
                "Vị trí đã chọn: Latitude = " + lat + ", Longitude = " + lng;
        }

        // Set flag to prevent infinite loop
        if (window.setMapUpdatingFlag) {
            window.setMapUpdatingFlag(true);
        }

        // Update form inputs
        if (latInput) {
            latInput.value = lat;
            console.log("Updated latitude input:", latInput.value);

            // Trigger multiple events for Filament compatibility
            latInput.dispatchEvent(new Event("input", { bubbles: true }));
            latInput.dispatchEvent(new Event("change", { bubbles: true }));
            latInput.dispatchEvent(new Event("blur", { bubbles: true }));

            // Try Livewire update if available
            if (window.Livewire) {
                latInput.dispatchEvent(
                    new Event("livewire:input", { bubbles: true })
                );

                // Try to find Livewire component and update directly
                const wireComponent = latInput.closest("[wire\\:id]");
                if (wireComponent) {
                    const wireId = wireComponent.getAttribute("wire:id");
                    if (wireId && window.Livewire.find(wireId)) {
                        window.Livewire.find(wireId).set("data.latitude", lat);
                    }
                }
            }
        } else {
            console.log("Latitude input not found!");
        }

        if (lngInput) {
            lngInput.value = lng;
            console.log("Updated longitude input:", lngInput.value);

            // Trigger multiple events for Filament compatibility
            lngInput.dispatchEvent(new Event("input", { bubbles: true }));
            lngInput.dispatchEvent(new Event("change", { bubbles: true }));
            lngInput.dispatchEvent(new Event("blur", { bubbles: true }));

            // Try Livewire update if available
            if (window.Livewire) {
                lngInput.dispatchEvent(
                    new Event("livewire:input", { bubbles: true })
                );

                // Try to find Livewire component and update directly
                const wireComponent = lngInput.closest("[wire\\:id]");
                if (wireComponent) {
                    const wireId = wireComponent.getAttribute("wire:id");
                    if (wireId && window.Livewire.find(wireId)) {
                        window.Livewire.find(wireId).set("data.longitude", lng);
                    }
                }
            }
        } else {
            console.log("Longitude input not found!");
        }

        // Reset flag after updating
        setTimeout(() => {
            if (window.setMapUpdatingFlag) {
                window.setMapUpdatingFlag(false);
            }
        }, 100);

        // Remove old marker and add new one
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }

        currentMarker = L.marker(e.latlng)
            .addTo(map)
            .bindPopup("Tọa độ: " + lat + ", " + lng)
            .openPopup();
    });

    // Watch for changes in input fields to update map
    if (latInput && lngInput) {
        let isUpdatingFromMap = false; // Flag to prevent infinite loop

        latInput.addEventListener("input", function () {
            if (isUpdatingFromMap) return; // Skip if update is from map click

            const newLat = parseFloat(latInput.value);
            const newLng = parseFloat(lngInput.value);
            if (
                !isNaN(newLat) &&
                !isNaN(newLng) &&
                newLat !== 0 &&
                newLng !== 0
            ) {
                const newLatLng = [newLat, newLng];

                if (currentMarker) {
                    currentMarker.setLatLng(newLatLng);
                    currentMarker.bindPopup(
                        "Tọa độ: " +
                            newLat.toFixed(8) +
                            ", " +
                            newLng.toFixed(8)
                    );
                } else {
                    currentMarker = L.marker(newLatLng)
                        .addTo(map)
                        .bindPopup(
                            "Tọa độ: " +
                                newLat.toFixed(8) +
                                ", " +
                                newLng.toFixed(8)
                        );
                }

                map.setView(newLatLng, map.getZoom());
            }
        });

        lngInput.addEventListener("input", function () {
            if (isUpdatingFromMap) return; // Skip if update is from map click

            const newLat = parseFloat(latInput.value);
            const newLng = parseFloat(lngInput.value);
            if (
                !isNaN(newLat) &&
                !isNaN(newLng) &&
                newLat !== 0 &&
                newLng !== 0
            ) {
                const newLatLng = [newLat, newLng];

                if (currentMarker) {
                    currentMarker.setLatLng(newLatLng);
                    currentMarker.bindPopup(
                        "Tọa độ: " +
                            newLat.toFixed(8) +
                            ", " +
                            newLng.toFixed(8)
                    );
                } else {
                    currentMarker = L.marker(newLatLng)
                        .addTo(map)
                        .bindPopup(
                            "Tọa độ: " +
                                newLat.toFixed(8) +
                                ", " +
                                newLng.toFixed(8)
                        );
                }

                map.setView(newLatLng, map.getZoom());
            }
        });

        // Set flag when updating from map
        window.setMapUpdatingFlag = function (updating) {
            isUpdatingFromMap = updating;
        };
    }
});
