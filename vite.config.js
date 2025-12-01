import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/map-picker.js",
                "resources/css/filament/theme.css",
                "resources/css/frontend.css",
            ],
            refresh: true,
        }),
    ],
});
