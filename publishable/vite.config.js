import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import adminifyUrls from './resources/adminify/vite/adminify';
import react from '@vitejs/plugin-react';
import path from 'path';

let urls = adminifyUrls({
    theme: 'testing'
});


export default defineConfig({
    plugins: [
        laravel({
            input: [...urls],
            refresh: false,
        }),
        react({ jsxRuntime: 'classic' }),
    ],
    resolve: {
        alias: {
          '@' : path.resolve(__dirname, 'resources/adminify'),
          '~choices': path.resolve(__dirname, 'node_modules/choices.js'),
          '~dropzone': path.resolve(__dirname, 'node_modules/dropzone'),
          '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
          '~bootstrap-icons': path.resolve(__dirname, 'node_modules/bootstrap-icons'),
        }
    },
});
