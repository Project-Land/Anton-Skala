import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    publicDir: false,
    build: {
        manifest: true,
        outDir: "public/build",
    },
    rollupOptions: {
        input: "resources/js/app.js",
    },
    plugins: [
        laravel(["resources/css/app.css", "resources/js/app.js"]),
        {
            name: "blade",
            handleHotUpdate({ file, server }) {
                if (file.endsWith(".blade.php")) {
                    server.ws.send({
                        type: "full-reload",
                        path: "*",
                    });
                }
            },
        },
    ],
});
