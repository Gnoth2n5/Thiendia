/**
 * Tribute Memorial JavaScript
 * Handles the "Thắp hương tưởng nhớ" (Light Incense Memorial) feature
 */

// Global variables
let currentGraveId = null;
let currentMartyrName = null;

/**
 * Initialize tribute functionality when DOM is loaded
 */
document.addEventListener("DOMContentLoaded", function () {
    // Get grave ID from the tribute button
    const tributeBtn = document.getElementById("tributeBtn");
    if (tributeBtn) {
        const onclick = tributeBtn.getAttribute("onclick");
        const match = onclick.match(/openTributeModal\((\d+),/);
        if (match) {
            currentGraveId = parseInt(match[1]);
            loadTributeData();
        }
    }

    // Setup character counter for message field
    setupCharacterCounter();
});

/**
 * Setup character counter for the message textarea
 */
function setupCharacterCounter() {
    const messageField = document.getElementById("tributeMessage");
    const charCount = document.getElementById("charCount");

    if (messageField && charCount) {
        messageField.addEventListener("input", function () {
            charCount.textContent = this.value.length;
        });
    }
}

/**
 * Load tribute data (count and recent tributes)
 */
async function loadTributeData() {
    if (!currentGraveId) return;

    try {
        // Load tribute count
        const countResponse = await fetch(
            `/api/tributes/count/${currentGraveId}`
        );
        const countData = await countResponse.json();

        if (countData.success) {
            document.getElementById("tributeCountNumber").textContent =
                countData.count;
        }

        // Load recent tributes
        const recentResponse = await fetch(
            `/api/tributes/recent/${currentGraveId}`
        );
        const recentData = await recentResponse.json();

        if (recentData.success) {
            renderRecentTributes(recentData.tributes);
        }

        // Check if user has already tributed today
        checkTributeStatus();
    } catch (error) {
        console.error("Error loading tribute data:", error);
    }
}

/**
 * Render recent tributes in the sidebar
 * @param {Array} tributes - Array of tribute objects
 */
function renderRecentTributes(tributes) {
    const container = document.getElementById("recentTributes");
    if (!container) return;

    if (tributes.length === 0) {
        container.innerHTML =
            '<div class="text-center text-gray-500 py-4">Chưa có lời tưởng niệm nào</div>';
        return;
    }

    container.innerHTML = tributes
        .map(
            (tribute) => `
        <div class="bg-white/50 border border-gray-200 p-3 rounded">
            <div class="flex items-start justify-between mb-2">
                <span class="font-medium text-sm text-gray-800">${
                    tribute.display_name
                }</span>
                <span class="text-xs text-gray-500">${
                    tribute.formatted_date
                }</span>
            </div>
            ${
                tribute.message
                    ? `<p class="text-sm text-gray-700">${tribute.message}</p>`
                    : ""
            }
        </div>
    `
        )
        .join("");
}

/**
 * Open the tribute modal
 * @param {number} graveId - The grave ID
 * @param {string} martyrName - The name of the deceased person
 */
window.openTributeModal = function (graveId, martyrName) {
    currentGraveId = graveId;
    currentMartyrName = martyrName;

    // Update modal title
    document.getElementById(
        "tributeModalTitle"
    ).textContent = `Thắp hương tưởng nhớ ${martyrName}`;

    // Reset form
    document.getElementById("tributeForm").reset();
    document.getElementById("charCount").textContent = "0";
    document.getElementById("tributeError").style.display = "none";

    // Show modal
    document.getElementById("tributeModal").style.display = "flex";
    document.body.style.overflow = "hidden";
};

/**
 * Close the tribute modal
 */
window.closeTributeModal = function () {
    document.getElementById("tributeModal").style.display = "none";
    document.body.style.overflow = "auto";
};

/**
 * Submit tribute form
 * @param {Event} event - Form submit event
 */
window.submitTribute = async function (event) {
    event.preventDefault();

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
            // Success - close modal and show effects
            closeTributeModal();

            // Update tribute count
            document.getElementById("tributeCountNumber").textContent =
                data.tribute_count;

            // Update recent tributes
            renderRecentTributes(data.recent_tributes);

            // Change button state
            updateTributeButtonState(true);

            // Show smoke animation
            showSmokeAnimation();

            // Play sound if enabled
            if (document.getElementById("soundToggle").checked) {
                playTempleSound();
            }

            // Show success notification
            showSuccessNotification(data.message);
        } else {
            // Handle errors
            if (response.status === 429) {
                errorDiv.textContent = data.message;
                errorDiv.style.display = "block";

                // Close modal and update button state
                setTimeout(() => {
                    closeTributeModal();
                    updateTributeButtonState(true);
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
 * Check if user has already tributed today
 */
async function checkTributeStatus() {
    if (!currentGraveId) return;

    try {
        const response = await fetch(`/api/tributes/status/${currentGraveId}`);
        const data = await response.json();

        if (data.success) {
            updateTributeButtonState(data.has_tributed_today);
        }
    } catch (error) {
        console.error("Error checking tribute status:", error);
    }
}

/**
 * Update tribute button state based on whether user has tributed today
 * @param {boolean} hasTributed - Whether user has already tributed today
 */
function updateTributeButtonState(hasTributed) {
    const tributeBtn = document.getElementById("tributeBtn");
    const tributeBtnText = document.getElementById("tributeBtnText");

    if (hasTributed) {
        tributeBtn.disabled = true;
        tributeBtn.classList.add("opacity-75", "cursor-not-allowed");
        tributeBtnText.textContent = "Đã thắp hương hôm nay ✅";
    } else {
        tributeBtn.disabled = false;
        tributeBtn.classList.remove("opacity-75", "cursor-not-allowed");
        tributeBtnText.textContent = "Thắp hương tưởng nhớ";
    }
}

/**
 * Show smoke animation effect
 */
function showSmokeAnimation() {
    const smokeElement = document.getElementById("smokeAnimation");
    if (!smokeElement) return;

    const particle = smokeElement.querySelector(".smoke-particle");
    if (!particle) return;

    // Reset animation by removing and re-adding the class
    particle.classList.remove("smoke-rising");

    // Force reflow to restart animation
    void particle.offsetWidth;

    // Show the smoke element
    smokeElement.style.display = "block";

    // Add animation class
    particle.classList.add("smoke-rising");

    // Hide after animation completes
    setTimeout(() => {
        smokeElement.style.display = "none";
        particle.classList.remove("smoke-rising");
    }, 4000);
}

/**
 * Play temple bell sound
 */
function playTempleSound() {
    try {
        const audio = new Audio("/sounds/temple_bell.mp3");
        audio.volume = 0.5;
        audio.play().catch((error) => {
            console.log("Could not play sound:", error);
            // Silently fail - sound is optional
        });
    } catch (error) {
        console.log("Sound file not found or error playing:", error);
        // Silently fail - sound is optional
    }
}

/**
 * Show success notification
 * @param {string} message - Success message to display
 */
function showSuccessNotification(message) {
    // Create a simple toast notification
    const notification = document.createElement("div");
    notification.className =
        "fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-[10001]";
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

/**
 * Share to Facebook
 * @param {string} martyrName - Name of the deceased person
 * @param {string} graveUrl - URL to the grave detail page
 */
window.shareToFacebook = function (martyrName, graveUrl) {
    const message = `Tôi đã thắp hương tưởng nhớ ${martyrName} – hãy cùng tri ân tại ${graveUrl}`;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
        graveUrl
    )}&quote=${encodeURIComponent(message)}`;
    window.open(shareUrl, "_blank", "width=600,height=400");
};

/**
 * Share to Twitter
 * @param {string} martyrName - Name of the deceased person
 * @param {string} graveUrl - URL to the grave detail page
 */
window.shareToTwitter = function (martyrName, graveUrl) {
    const message = `Tôi đã thắp hương tưởng nhớ ${martyrName} – hãy cùng tri ân tại ${graveUrl}`;
    const shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(
        message
    )}&url=${encodeURIComponent(graveUrl)}`;
    window.open(shareUrl, "_blank", "width=600,height=400");
};

// Close modal when clicking outside
document.addEventListener("click", function (event) {
    const modal = document.getElementById("tributeModal");
    if (event.target === modal) {
        window.closeTributeModal();
    }
});

// Close modal with Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        window.closeTributeModal();
    }
});
