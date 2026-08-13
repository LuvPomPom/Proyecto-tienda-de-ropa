import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/styles.css',
                'resources/css/admin.css',
                'resources/js/main.js',
                'resources/js/admin.js',
                'resources/js/api.js',
                'resources/js/cart.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        host: 'localhost',
        port: 5173,

        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});