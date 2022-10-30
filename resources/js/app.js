import { createApp } from 'vue/dist/vue.esm-bundler'
import AppComponent from './App.vue'
import router from './router/index'

const app = createApp({
  components: {
    AppComponent
  }
})

app.use(router)
app.mount('#app')
