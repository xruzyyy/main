import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
  ],
  build: {
    outDir: 'public/build', // Adjusted output directory to match Laravel's public directory
    // You can customize further build options if needed
  },
});
