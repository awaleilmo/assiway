import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import 'flowbite';
import 'vue-good-table-next/dist/vue-good-table-next.css'
import { Cropper } from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css';
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
    faCircleUser,
    faBook,
    faPencil,
    faSearch,
    faAdd,
    faClose,
    faReceipt,
    faChartPie,
    faUserGroup,
    faPhone,
    faEnvelope,
    faCartShopping
} from '@fortawesome/free-solid-svg-icons'
library.add(
    faCircleUser,
    faBook,
    faPencil,
    faSearch,
    faAdd,
    faClose,
    faReceipt,
    faChartPie,
    faUserGroup,
    faPhone,
    faEnvelope,
    faCartShopping
)

import { MotionPlugin } from '@vueuse/motion'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(MotionPlugin)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('cropper', Cropper)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
