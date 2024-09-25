import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import DataTablesCore from 'datatables.net';
import DataTable from 'datatables.net-vue3';
DataTable.use(DataTablesCore);

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    title: (title) => (title ? `${title} - Projectify` : "Projectify"),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toast, {
                position: 'top-right',
                timeout: 1500,
                closeOnClick: true,
                pauseOnHover: false,
                pauseOnFocusLoss: false,
                draggable: true,
                hideProgressBar: true,
            })
            .mixin({ methods: { route } })
            .mount(el)
    },
})