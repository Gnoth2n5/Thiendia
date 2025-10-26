/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#f7fafc",
                    100: "#edf2f7",
                    200: "#e2e8f0",
                    300: "#cbd5e0",
                    400: "#a0aec0",
                    500: "#718096",
                    600: "#4a5568",
                    700: "#2d3748",
                    800: "#1a202c",
                    900: "#171923",
                },
                accent: {
                    50: "#faf5ff",
                    100: "#f3e8ff",
                    200: "#e9d5ff",
                    300: "#d8b4fe",
                    400: "#c084fc",
                    500: "#a855f7",
                    600: "#9333ea",
                    700: "#7c3aed",
                    800: "#6b21a8",
                    900: "#581c87",
                },
            },
            fontFamily: {
                sans: [
                    "Merriweather",
                    "ui-serif",
                    "Georgia",
                    "Cambria",
                    "serif",
                ],
            },
        },
    },
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                cemetery: {
                    primary: "#8b0000", // Đỏ trầm
                    secondary: "#2b2b2b", // Đen nâu
                    accent: "#d4d0c8", // Xám be
                    neutral: "#2b2b2b", // Đen nâu
                    "base-100": "#fafaf8", // Trắng ngà
                    "base-200": "#f5f3e7", // Be vàng nhạt
                    "base-300": "#d4d0c8", // Xám be
                    info: "#2b2b2b", // Đen nâu
                    success: "#8b0000", // Đỏ trầm
                    warning: "#8b0000", // Đỏ trầm
                    error: "#8b0000", // Đỏ trầm

                    "--rounded-box": "1rem",
                    "--rounded-btn": "0.5rem",
                    "--rounded-badge": "0.5rem",
                    "--animation-btn": "0.25s",
                    "--animation-input": "0.2s",
                    "--btn-focus-scale": "0.95",
                },
            },
        ],
        darkTheme: false,
        base: true,
        styled: true,
        utils: true,
        prefix: "",
        logs: false,
        themeRoot: ":root",
    },
};
