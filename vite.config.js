import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
        ],
        build: {
            outDir: 'public/build',
            manifest: true,
            rollupOptions: {
                output: {
                    // Para desarrollo, mantener nombres consistentes
                    // Para producción, usar hash solo si es necesario
                    entryFileNames: mode === 'development' ? 'assets/[name].js' : 'assets/[name].[hash].js',
                    chunkFileNames: mode === 'development' ? 'assets/[name].js' : 'assets/[name].[hash].js',
                    assetFileNames: mode === 'development' ? 'assets/[name].[ext]' : 'assets/[name].[hash].[ext]'
                }
            }
        }
    };
});
