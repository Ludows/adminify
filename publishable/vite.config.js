import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import useAdminify from './resources/adminify/vite/adminify';
import react from '@vitejs/plugin-react';
import path from 'path';

let { getAliases, getPaths } = useAdminify();
// let urls = adminifyUrls({
//     theme: 'testing'
// });

// console.log('aliases', getAliases());



export default defineConfig({
    plugins: [
        laravel({
            input: [...getPaths()],
            refresh: false,
        }),
        react({ jsxRuntime: 'classic' }),
    ],
    resolve: {
        alias: {
            ...getAliases(__dirname)
        }
    },
});
