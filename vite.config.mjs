import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],
    // Prevents Vite from recursively copying the public/ folder into public/build/
    publicDir: false,
    server: {
        // Ensures CodeIgniter serves dev assets correctly from Vite's local dev server
        origin: 'http://localhost:5173',
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        cssCodeSplit: false, // Forces all CSS into a single static file
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
            },
        },
    },
});