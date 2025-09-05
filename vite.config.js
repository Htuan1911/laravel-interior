import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

<<<<<<< HEAD
import tailwindcss from '@tailwindcss/vite';

=======
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
<<<<<<< HEAD

        tailwindcss(),
=======
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
    ],
});
