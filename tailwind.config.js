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
                    "Inter",
                    "ui-sans-serif",
                    "system-ui",
                    "-apple-system",
                    "BlinkMacSystemFont",
                    "Segoe UI",
                    "Roboto",
                    "Helvetica Neue",
                    "Arial",
                    "Noto Sans",
                    "sans-serif",
                ],
            },
        },
    },
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                cemetery: {
                    primary: "#0f766e", // Xanh ngọc đậm trang trọng
                    secondary: "#7c3aed", // Tím violet
                    accent: "#f59e0b", // Vàng amber ấm áp
                    neutral: "#1e293b", // Xám xanh đậm
                    "base-100": "#ffffff", // Nền trắng
                    "base-200": "#f8fafc", // Xám rất nhạt
                    "base-300": "#e2e8f0", // Xám nhạt
                    info: "#06b6d4", // Cyan
                    success: "#059669", // Emerald
                    warning: "#f59e0b", // Amber
                    error: "#dc2626", // Đỏ

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
