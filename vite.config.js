// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: [
//                 'resources/css/app.css',
//                 'resources/js/app.js',
//             ],
//             refresh: true,
//         }),
//     ],
// });
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/assets/scss/app.scss', // Assurez-vous que le chemin est correct
                'resources/js/app.js',
                'resources/css/login.css',
                'resources/js/login.js',
                'resources/css/app.css',
                'resources/css/register.css',
                'resources/js/register.js',
            ],
            refresh: true,
        }),
    ],
});