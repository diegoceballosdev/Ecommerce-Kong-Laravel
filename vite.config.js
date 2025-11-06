import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    server: {
        host: true, // Esto es lo más importante. Permite la carga desde cualquier host.
        // También puedes usar:
        // hmr: { host: 'tu-dominio-de-ngrok.ngrok-free.app' },
    },
});
