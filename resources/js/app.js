import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import LaraCustom from '@/primevue/presets/LaraCustom'; //import preset
import ToastService from 'primevue/toastservice';
import Lara from '@primevue/themes/lara';
import Aura from '@primevue/themes/aura';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                // unstyled: true,/*
                // unstyled: false, /**/
                // pt: LaraCustom, //apply preset
                // pt: {
                //     ...Lara,
                //     ...LaraCustom,
                // }, //apply preset

                theme: {
                    // preset: Aura,
                    preset: Lara,
                    // preset: {
                    //     ...Lara,
                    //     ...LaraCustom,
                    // },
                }
            })
            .use(ToastService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
