import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import adminifyUrls from './resources/adminify/vite/adminify';

let urls = adminifyUrls({
    theme: 'testing'
});

export default defineConfig({
    plugins: [
        laravel({
            input: [...urls],
            refresh: true,
        }),
    ],
});
