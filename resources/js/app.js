import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import { Quasar, Notify, Dialog } from 'quasar';

// Import icon libraries
import '@quasar/extras/roboto-font/roboto-font.css'
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

import apiRequest from "./helper/apiRequests";

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });
    app.config.globalProperties.$router = router;
    app.config.globalProperties.$api = apiRequest;
    app.use(plugin)
    .use(Quasar,{
      plugins: {
        Notify,
        Dialog
      }
    })
    .mount(el)
  },
})
