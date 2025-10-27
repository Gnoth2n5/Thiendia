/**
 * Search Form - Dynamic Location and Cemetery Filtering
 * Xử lý cập nhật động các dropdown khi người dùng chọn xã/phường
 */

class SearchForm {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        if (!this.form) return;

        this.communeSelect = this.form.querySelector("#commune");
        this.cemeterySelect = this.form.querySelector("#cemetery_id");

        this.init();
    }

    async init() {
        if (!this.communeSelect) return;

        // Lắng nghe sự kiện thay đổi xã (nếu cần filter cemetery)
        if (this.cemeterySelect) {
            this.communeSelect.addEventListener("change", () => {
                this.handleCommuneChange();
            });
        }

        // Load dữ liệu ban đầu khi trang load
        await this.loadInitialData();
    }

    /**
     * Load dữ liệu ban đầu khi trang mới load
     */
    async loadInitialData() {
        const selectedCommune = this.communeSelect.dataset.selected;

        // Load tất cả communes từ API
        await this.loadCommunes(selectedCommune);

        // Load cemeteries theo filter hiện tại (hoặc tất cả nếu chưa có filter)
        if (this.cemeterySelect) {
            await this.loadCemeteries(selectedCommune || null);
        }
    }

    /**
     * Xử lý khi thay đổi xã
     */
    async handleCommuneChange() {
        const commune = this.communeSelect.value;

        if (this.cemeterySelect) {
            await this.loadCemeteries(commune);
        }
    }

    /**
     * Load danh sách communes từ API Laravel (đã cache)
     */
    async loadCommunes(selectedCommune = null) {
        try {
            // Hiển thị loading state
            this.communeSelect.disabled = true;
            this.communeSelect.innerHTML =
                '<option value="">Đang tải...</option>';

            // Gọi API Laravel để lấy cached data
            const response = await fetch("/api/wards");
            const result = await response.json();

            // Reset và thêm option mặc định
            this.communeSelect.innerHTML =
                '<option value="">Tất cả xã/phường</option>';

            // API trả về data trong result.data
            if (result.success && result.data) {
                result.data.forEach((ward) => {
                    const option = document.createElement("option");
                    // Giá trị chỉ là tên (không có type)
                    option.value = ward.name;
                    // Hiển thị là type + name
                    option.textContent = `${ward.type} ${ward.name}`;
                    if (selectedCommune && ward.name === selectedCommune) {
                        option.selected = true;
                    }
                    this.communeSelect.appendChild(option);
                });
            }

            this.communeSelect.disabled = false;
        } catch (error) {
            console.error("Lỗi khi tải danh sách xã/phường:", error);
            this.communeSelect.innerHTML =
                '<option value="">Lỗi khi tải dữ liệu</option>';
        }
    }

    /**
     * Load danh sách cemeteries theo commune
     */
    async loadCemeteries(commune = null) {
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
        // Kiểm tra xem form có trường commune không
        if (form.querySelector("#commune")) {
            new SearchForm(`form[action="${form.getAttribute("action")}"]`);
        }
    });
});
