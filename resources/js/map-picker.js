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

    // Load existing coordinates
    const latInput = document.querySelector('input[name="data.latitude"]');
    const lngInput = document.querySelector('input[name="data.longitude"]');

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

        // Update form inputs
        if (latInput) {
            latInput.value = lat;
            // Trigger change event for Filament
            latInput.dispatchEvent(new Event("input", { bubbles: true }));
            latInput.dispatchEvent(new Event("change", { bubbles: true }));
        }

        if (lngInput) {
            lngInput.value = lng;
            // Trigger change event for Filament
            lngInput.dispatchEvent(new Event("input", { bubbles: true }));
            lngInput.dispatchEvent(new Event("change", { bubbles: true }));
        }

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
        latInput.addEventListener("input", function () {
            const newLat = parseFloat(latInput.value);
            const newLng = parseFloat(lngInput.value);
            if (!isNaN(newLat) && !isNaN(newLng)) {
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
            const newLat = parseFloat(latInput.value);
            const newLng = parseFloat(lngInput.value);
            if (!isNaN(newLat) && !isNaN(newLng)) {
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
    }
});
