import { defineConfig } from 'vite';
import { resolve } from 'path';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css', 
        'resources/js/app-blade.js'
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
  build: {
    rollupOptions: {
      output: {
        manualChunks: undefined, // Let Vite handle chunking automatically
      }
    }
  },
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
});
