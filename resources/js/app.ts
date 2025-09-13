import '../css/app.css';
import './bootstrap';

import { createInertiaApp, Link } from '@inertiajs/vue3'; 
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h, onMounted } from 'vue'; // <-- Tambahkan 'onMounted'
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// --- TAMBAHAN UNTUK ANIMASI (AOS) ---
import AOS from 'aos';
import 'aos/dist/aos.css';
// --- AKHIR TAMBAHAN ---

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => title ? `${title} - ${appName}` : appName,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // Penyesuaian agar bisa menjalankan onMounted
        const vueApp = createApp({ 
            setup() {
                onMounted(() => {
                    // --- TAMBAHAN UNTUK ANIMASI (AOS) ---
                    AOS.init({
                        duration: 800, // Durasi animasi dalam milidetik
                        once: true,    // Animasi hanya berjalan sekali saat scroll
                    });
                    // --- AKHIR TAMBAHAN ---
                });
                return () => h(App, props);
            }
        });

        vueApp.use(plugin)
              .use(ZiggyVue)
              .component('Link', Link) 
              .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});