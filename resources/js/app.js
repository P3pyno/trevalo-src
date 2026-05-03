import '../css/app.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createI18n } from 'vue-i18n'
import axios from 'axios'
import router from './router'
import App from './App.vue'
import en from './locales/en.json'

// Axios defaults
axios.defaults.baseURL = '/api'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

const csrfToken = document.querySelector('meta[name="csrf-token"]')
if (csrfToken) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content')
}

const i18n = createI18n({
  locale: 'en',
  fallbackLocale: 'en',
  legacy: false,
  messages: { en },
})

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(createPinia())
app.use(router)
app.use(i18n)
app.mount('#app')
