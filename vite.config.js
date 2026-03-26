import { defineConfig } from 'vite';
import { resolve } from 'path';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        resolve('resources/css/app.css'), 
        resolve('resources/js/app-blade.js')
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          vendor: ['vue'],
          app: ['resources/js/app-blade.js']
        }
      }
    }
  },
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
});
