import { defineConfig } from "tailwindcss";

export default defineConfig({
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
                    primary: "#2d3748",
                    secondary: "#4a5568",
                    accent: "#805ad5",
                    neutral: "#1a202c",
                    "base-100": "#f7fafc",
                    "base-200": "#edf2f7",
                    "base-300": "#e2e8f0",
                    info: "#3182ce",
                    success: "#38a169",
                    warning: "#d69e2e",
                    error: "#e53e3e",
                },
            },
        ],
        darkTheme: "dark",
        base: true,
        styled: true,
        utils: true,
        prefix: "",
        logs: true,
        themeRoot: ":root",
    },
});
