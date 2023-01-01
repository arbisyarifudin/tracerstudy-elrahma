import { createApp } from 'vue/dist/vue.esm-bundler'
import { createPinia } from 'pinia'

import AppComponent from './App.vue'
import router from './router/index'

/* ICONSET */
import PhosphorVue from 'phosphor-vue'

/* SNACKBAR */
import Toast, { POSITION } from 'vue-toastification'
// Import the CSS or use your own!
import 'vue-toastification/dist/index.css'
const toastOptions = {
  // You can set your default options here
  position: POSITION.TOP_RIGHT,
  timeout: 3000,
  maxToasts: 5,
  newestOnTop: true
}

/* AXIOS */
import VueAxios from 'vue-axios'
import axiosInstance from './services/api'

const pinia = createPinia()
const app = createApp({
  components: {
    AppComponent
  }
})

/* RECAPTCHA V3 */
import { VueReCaptcha } from 'vue-recaptcha-v3'

app.use(pinia)
app.use(router)
app.use(PhosphorVue)
app.use(Toast, toastOptions)
app.use(VueAxios, axiosInstance)
app.use(VueReCaptcha, {
  siteKey: '6LcpB1ojAAAAACg0Yo_1LKmmcDW2BQLQ965BjgKi',
  loaderOptions: {
    useRecaptchaNet: true,
    autoHideBadge: false
  }
})

app.directive('click-outside', {
  beforeMount: (el, binding) => {
    el.clickOutsideEvent = (event) => {
      // here I check that click was outside the el and his children
      if (!(el == event.target || el.contains(event.target))) {
        // and if it did, call method provided in attribute value
        binding.value()
      }
    }
    document.addEventListener('click', el.clickOutsideEvent)
  },
  unmounted: (el) => {
    document.removeEventListener('click', el.clickOutsideEvent)
  }
})

import setupInterceptor from './services/interceptor'
import { useAuthStore } from './store/auth'

const authStore = useAuthStore()
setupInterceptor(authStore, router)

app.provide('axios', app.config.globalProperties.axios) // provide 'axios'
app.mount('#app')
