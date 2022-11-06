import { createApp } from 'vue/dist/vue.esm-bundler'
import { createPinia } from 'pinia'

import AppComponent from './App.vue'
import router from './router/index'

/* ICONSET */
import PhosphorVue from 'phosphor-vue'

/* AXIOS */
import axios from 'axios'
import VueAxios from 'vue-axios'
axios.defaults.baseURL = import.meta.env.VITE_APP_URL

const pinia = createPinia()
const app = createApp({
  components: {
    AppComponent
  }
})

app.use(pinia)
app.use(router)
app.use(PhosphorVue)
app.use(VueAxios, axios)

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

app.provide('axios', app.config.globalProperties.axios) // provide 'axios'
app.mount('#app')
