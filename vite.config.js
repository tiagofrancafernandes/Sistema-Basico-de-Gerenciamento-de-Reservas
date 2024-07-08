import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import Components from 'unplugin-vue-components/vite';
import { PrimeVueResolver } from '@primevue/auto-import-resolver';

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [
                PrimeVueResolver(), // https://github.com/primefaces/primevue-examples/blob/main/auto-import/vite.config.js
            ]
        }),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
            '@resources': fileURLToPath(new URL('./resources', import.meta.url)),
            '@base': fileURLToPath(new URL('./', import.meta.url)),
            '@nm': fileURLToPath(new URL('./node_modules', import.meta.url)),
            '@node_modules': fileURLToPath(new URL('./node_modules', import.meta.url)),
            '@asset': fileURLToPath(new URL('./public', import.meta.url)),
            '@public': fileURLToPath(new URL('./public', import.meta.url)),
        }
    }
});
