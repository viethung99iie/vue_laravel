import './assets/backend/main.css'

import { createApp } from 'vue'
import { store } from '@/store'

import App from './App.vue'
import router from './router'
import 'uikit/dist/css/uikit.min.css'
import 'uikit/dist/js/uikit.min.js'
import 'boxicons/css/boxicons.min.css'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';



const app = createApp(App)

app.use(store)
app.use(router)

app.mount('#app')

