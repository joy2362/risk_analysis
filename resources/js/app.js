import './bootstrap'
import { createApp } from 'vue'
import App from './app.vue'

// Plugins
import { registerPlugins } from './user/plugins'
import { registerHelper } from './user/helper'

const app = createApp(App)

app.config.globalProperties.asset = import.meta.env.VITE_APP_URL

app.use(registerPlugins)
app.use(registerHelper)

app.mount('#app')

