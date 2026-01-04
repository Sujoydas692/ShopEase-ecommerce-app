import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import Vue3Toastify from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';

const pinia = createPinia();
createApp(App)
    .use(Vue3Toastify, { autoClose: 2000, position: "top-right", theme: "light", })
    .use(router)
    .use(pinia)
    .mount('#app')