/**
 * Anniversary Page JavaScript
 * Handles search functionality and tribute modal integration
 */

// Global variables
let currentGraveId = null;

// Search functionality
document.addEventListener("DOMContentLoaded", function () {
    // Setup character counter for message field
    const messageField = document.getElementById("tributeMessage");
    const charCount = document.getElementById("charCount");

    if (messageField && charCount) {
        messageField.addEventListener("input", function () {
            charCount.textContent = this.value.length;
        });
    }

    // Setup search input listener
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            filterMartyrs(this.value);
        });
    }
});

/**
 * Filter martyrs based on search input
 */
function filterMartyrs(searchTerm) {
    const searchLower = searchTerm.toLowerCase();
    const rows = document.querySelectorAll(".martyr-row");

    let visibleCount = 0;

    rows.forEach((row) => {
        const name = row.dataset.name || "";
        const hometown = row.dataset.hometown || "";
        const cemetery = row.dataset.cemetery || "";

        const matches =
            name.includes(searchLower) ||
            hometown.includes(searchLower) ||
            cemetery.includes(searchLower);

        if (matches) {
            row.style.display = "";
            visibleCount++;
        } else {
            row.style.display = "none";
        }
    });
}

/**
 * Open tribute modal
 */
window.openTributeModal = function (graveId, martyrName) {
    currentGraveId = graveId;

    // Update modal title
    const modalTitle = document.getElementById("tributeModalTitle");
    if (modalTitle) {
        modalTitle.textContent = `Thắp hương tưởng nhớ ${martyrName}`;
    }

    // Reset form
    const form = document.getElementById("tributeForm");
    if (form) {
        form.reset();
        document.getElementById("charCount").textContent = "0";
        document.getElementById("tributeError").style.display = "none";
    }

    // Show modal
    const modal = document.getElementById("tributeModal");
    if (modal) {
        modal.style.display = "flex";
        document.body.style.overflow = "hidden";
    }
};

/**
 * Close tribute modal
 */
window.closeTributeModal = function () {
    const modal = document.getElementById("tributeModal");
    if (modal) {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    }
};

/**
 * Submit tribute form
 */
window.submitTribute = async function (event) {
    event.preventDefault();

    if (!currentGraveId) {
        return;
    }

    const submitBtn = document.getElementById("submitTributeBtn");
    const errorDiv = document.getElementById("tributeError");

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = "Đang thắp hương...";
    errorDiv.style.display = "none";

    try {
        const formData = new FormData(event.target);
        formData.append("grave_id", currentGraveId);

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const headers = {};

        if (csrfToken) {
            headers["X-CSRF-TOKEN"] = csrfToken.getAttribute("content");
        }

        const response = await fetch("/api/tributes/add", {
            method: "POST",
            body: formData,
            headers: headers,
        });

        const data = await response.json();

        if (data.success) {
            // Success - close modal and update count
            closeTributeModal();

            // Update tribute count for this grave
            const countElement = document.getElementById(
                "tribute-count-" + currentGraveId
            );
            if (countElement) {
                countElement.textContent = data.tribute_count;
            }

            // Disable button
            const tributeBtn = document.getElementById(
                "tribute-btn-" + currentGraveId
            );
            if (tributeBtn) {
                tributeBtn.disabled = true;
                tributeBtn.textContent = "Đã thắp hương hôm nay ✅";
                tributeBtn.classList.add("disabled");
            }

            // Show smoke animation
            showSmokeAnimation();

            // Show success notification
            showSuccessNotification(
                data.message || "Cảm ơn bạn đã thắp hương tưởng nhớ"
            );
        } else {
            // Handle errors
            if (response.status === 429) {
                errorDiv.textContent = data.message;
                errorDiv.style.display = "block";

                // Close modal after delay
                setTimeout(() => {
                    closeTributeModal();
                    const tributeBtn = document.getElementById(
                        "tribute-btn-" + currentGraveId
                    );
                    if (tributeBtn) {
                        tributeBtn.disabled = true;
                        tributeBtn.textContent = "Đã thắp hương hôm nay ✅";
                        tributeBtn.classList.add("disabled");
                    }
                }, 2000);
            } else {
                errorDiv.textContent =
                    data.message || "Có lỗi xảy ra, vui lòng thử lại";
                errorDiv.style.display = "block";
            }
        }
    } catch (error) {
        console.error("Error submitting tribute:", error);
        errorDiv.textContent = "Có lỗi xảy ra, vui lòng thử lại";
        errorDiv.style.display = "block";
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.textContent = "Thắp hương";
    }
};

/**
 * Show smoke animation effect
 */
function showSmokeAnimation() {
    // Create temporary smoke element
    const smoke = document.createElement("div");
    smoke.style.position = "fixed";
    smoke.style.top = "50%";
    smoke.style.left = "50%";
    smoke.style.transform = "translate(-50%, -50%)";
    smoke.style.width = "100px";
    smoke.style.height = "100px";
    smoke.style.background =
        "radial-gradient(circle, rgba(200,200,200,0.8) 0%, rgba(150,150,150,0.4) 100%)";
    smoke.style.borderRadius = "50%";
    smoke.style.animation = "smokeRise 3s ease-out forwards";
    smoke.style.zIndex = "9999";
    smoke.style.pointerEvents = "none";

    document.body.appendChild(smoke);

    // Remove after animation
    setTimeout(() => {
        document.body.removeChild(smoke);
    }, 3000);
}

/**
 * Show success notification
 */
function showSuccessNotification(message) {
    const notification = document.createElement("div");
    notification.className =
        "fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-[10001]";
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Close modal when clicking outside
document.addEventListener("click", function (event) {
    const modal = document.getElementById("tributeModal");
    if (event.target === modal) {
        closeTributeModal();
    }
});

// Close modal with Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeTributeModal();
    }
});

// Add CSS animation for smoke effect
if (!document.getElementById("smokeStyles")) {
    const style = document.createElement("style");
    style.id = "smokeStyles";
    style.textContent = `
        @keyframes smokeRise {
            0% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(0.5);
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -150%) scale(2);
            }
        }
    `;
    document.head.appendChild(style);
}
