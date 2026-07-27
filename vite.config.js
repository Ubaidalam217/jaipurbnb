import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //css
                'resources/scss/main.scss',


                //js
                'resources/js/main.js'
            ],
            refresh: true,
        }),
    ],
    esbuild: {
        logOverride: { 'css-syntax-error': 'silent' }
    },
     build: {
        chunkSizeWarningLimit: 1000,
    }
});