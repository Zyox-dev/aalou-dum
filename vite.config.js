import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // server: {
    //     host: "0.0.0.0",
    //     port: 5173,
    //     hmr: {
    //         host: "https://7422-2401-4900-1c1a-1b3a-cc98-23c0-a5fe-b4f8.ngrok-free.app/", // <- change this to your ngrok URL for full fix
    //     },
    // },
});
