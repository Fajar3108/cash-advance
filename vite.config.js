import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/manage-item.js',
                'resources/js/manage-ca-usage-item.js',
                'resources/js/manage-reimbursement-item.js',
                'resources/js/stuff-item.js',
            ],
            refresh: true,
        }),
    ],
});
