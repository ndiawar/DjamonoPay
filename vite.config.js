import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/assets/scss/app.scss', // Assurez-vous que le chemin est correct
                'resources/js/app.js',
                'resources/css/style.css',
                'resources/js/login.js',
            ],
            refresh: true,
        }),
    ],
});
