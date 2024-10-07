import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import {resolve} from "node:dns";
import {fileURLToPath, URL} from "node:url";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': fileURLToPath(new URL('./resources', import.meta.url))
        },
    },
    server : {
        port: 8080,
        host: '0.0.0.0'
    }
})
