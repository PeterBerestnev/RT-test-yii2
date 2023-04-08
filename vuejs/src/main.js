import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import VueCookies from 'vue-cookies'

createApp(App).use(VueCookies, { expires: '30d'}).use(router).mount('#app')
