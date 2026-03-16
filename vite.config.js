import { defineConfig } from 'vite';
import { resolve } from 'path';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        resolve('resources/css/app.css'), 
        resolve('resources/js/app.js'),
        resolve('resources/js/login.js')
      ],
      refresh: true,
    }),
    tailwindcss(),
    vue(),
  ],
  server: {
    watch: {
      ignored: ['**/storage/framework/views/**'],
    },
  },
  build: {
    rollupOptions: {
      input: {
        'app': resolve('resources/js/app.js'),
        'login': resolve('resources/js/login.js'),
        'css': resolve('resources/css/app.css')
      }
    }
  }
});
