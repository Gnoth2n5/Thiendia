/**
 * Search Form - Dynamic Location and Cemetery Filtering
 * Xử lý cập nhật động các dropdown khi người dùng chọn huyện/xã
 */

class SearchForm {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        if (!this.form) return;

        this.districtSelect = this.form.querySelector("#district");
        this.communeSelect = this.form.querySelector("#commune");
        this.cemeterySelect = this.form.querySelector("#cemetery_id");

        this.init();
    }

    init() {
        if (!this.districtSelect || !this.communeSelect) return;

        // Lắng nghe sự kiện thay đổi huyện
        this.districtSelect.addEventListener("change", () => {
            this.handleDistrictChange();
        });

        // Lắng nghe sự kiện thay đổi xã (nếu cần filter cemetery)
        if (this.cemeterySelect) {
            this.communeSelect.addEventListener("change", () => {
                this.handleCommuneChange();
            });
        }

        // Load dữ liệu ban đầu khi trang load
        this.loadInitialData();
    }

    /**
     * Load dữ liệu ban đầu khi trang mới load
     */
    async loadInitialData() {
        const selectedDistrict = this.districtSelect.value;
        const selectedCommune = this.communeSelect.dataset.selected;

        // Load communes nếu đã có district được chọn (khi quay lại từ trang kết quả)
        if (selectedDistrict) {
            await this.loadCommunes(selectedDistrict, selectedCommune);
        }

        // Load cemeteries theo filter hiện tại (hoặc tất cả nếu chưa có filter)
        if (this.cemeterySelect) {
            await this.loadCemeteries(
                selectedDistrict || null,
                selectedCommune || null
            );
        }
    }

    /**
     * Xử lý khi thay đổi huyện
     */
    async handleDistrictChange() {
        const district = this.districtSelect.value;

        // Reset commune
        this.communeSelect.innerHTML =
            '<option value="">Tất cả xã/phường</option>';
        this.communeSelect.disabled = !district;

        if (!district) {
            // Nếu clear district, load lại tất cả cemeteries
            if (this.cemeterySelect) {
                await this.loadCemeteries();
            }
            return;
        }

        // Load communes theo district
        await this.loadCommunes(district);

        // Load cemeteries theo district
        if (this.cemeterySelect) {
            await this.loadCemeteries(district);
        }
    }

    /**
     * Xử lý khi thay đổi xã
     */
    async handleCommuneChange() {
        const district = this.districtSelect.value;
        const commune = this.communeSelect.value;

        if (this.cemeterySelect) {
            await this.loadCemeteries(district, commune);
        }
    }

    /**
     * Load danh sách communes theo district
     */
    async loadCommunes(district, selectedCommune = null) {
        if (!district) return;

        try {
            // Hiển thị loading state
            this.communeSelect.disabled = true;
            this.communeSelect.innerHTML =
                '<option value="">Đang tải...</option>';

            const response = await fetch(
                `/api/communes?district=${encodeURIComponent(district)}`
            );
            const communes = await response.json();

            // Reset và thêm option mặc định
            this.communeSelect.innerHTML =
                '<option value="">Tất cả xã/phường</option>';

            // Thêm các communes
            communes.forEach((commune) => {
                const option = document.createElement("option");
                option.value = commune;
                option.textContent = commune;
                if (selectedCommune && commune === selectedCommune) {
                    option.selected = true;
                }
                this.communeSelect.appendChild(option);
            });

            this.communeSelect.disabled = false;
        } catch (error) {
            console.error("Lỗi khi tải danh sách xã/phường:", error);
            this.communeSelect.innerHTML =
                '<option value="">Lỗi khi tải dữ liệu</option>';
        }
    }

    /**
     * Load danh sách cemeteries theo district và commune
     */
    async loadCemeteries(district = null, commune = null) {
        if (!this.cemeterySelect) return;

        try {
            // Lưu giá trị đã chọn (từ data-selected hoặc value hiện tại)
            const selectedValue =
                this.cemeterySelect.dataset.selected ||
                this.cemeterySelect.value;

            // Hiển thị loading state
            this.cemeterySelect.disabled = true;
            this.cemeterySelect.innerHTML =
                '<option value="">Đang tải...</option>';

            // Build query string
            const params = new URLSearchParams();
            if (district) params.append("district", district);
            if (commune) params.append("commune", commune);

            const url = `/api/cemeteries${
                params.toString() ? "?" + params.toString() : ""
            }`;
            const response = await fetch(url);
            const cemeteries = await response.json();

            // Reset và thêm option mặc định
            this.cemeterySelect.innerHTML =
                '<option value="">Tất cả nghĩa trang</option>';

            // Thêm các cemeteries
            cemeteries.forEach((cemetery) => {
                const option = document.createElement("option");
                option.value = cemetery.id;
                option.textContent = `${cemetery.name} (${cemetery.graves_count} lăng mộ)`;

                // Giữ lại option đã chọn
                if (selectedValue && cemetery.id == selectedValue) {
                    option.selected = true;
                }

                this.cemeterySelect.appendChild(option);
            });

            // Xóa data-selected sau khi đã sử dụng
            if (this.cemeterySelect.dataset.selected) {
                delete this.cemeterySelect.dataset.selected;
            }

            this.cemeterySelect.disabled = false;
        } catch (error) {
            console.error("Lỗi khi tải danh sách nghĩa trang:", error);
            this.cemeterySelect.innerHTML =
                '<option value="">Lỗi khi tải dữ liệu</option>';
        }
    }
}

// Khởi tạo SearchForm khi DOM đã load xong
document.addEventListener("DOMContentLoaded", () => {
    // Tìm tất cả form search trong trang
    const forms = document.querySelectorAll('form[action*="search"]');
    forms.forEach((form) => {
        // Kiểm tra xem form có các trường district và commune không
        if (form.querySelector("#district") && form.querySelector("#commune")) {
            new SearchForm(`form[action="${form.getAttribute("action")}"]`);
        }
    });
});
