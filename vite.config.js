import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import svgr from 'vite-plugin-svgr';

export default defineConfig({
    plugins: [
        laravel({
            input: [ 'resources/css/app.css', 'resources/js/app.tsx' ],
            refresh: true,
        }),
        react(),
        svgr({
            include: '**/*.svg?react',
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: '5173',
        hmr: {
            host: 'localhost',
        },
    },
});
