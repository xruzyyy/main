import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/main.scss',
                'resources/scss/_header.scss','resources/scss/category.scss','resources/scss/latest-listing.scss','resources/scss/_servicesMain.scss',
                'resources/scss/_section.scss','resources/scss/_About.scss','resources/scss/_ManageAllBusiness.scss','resources/scss/_bootstrap.scss',
                'resources/scss/_businessHome.scss','resources/scss/_servicesMain.scss',

                
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
