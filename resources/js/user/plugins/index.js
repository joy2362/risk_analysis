/**
 * plugins/index.js
 *
 * Automatically included in `./src/Admin.js`
 */

// Plugins
import vuetify from './vuetify'
import {userRouter} from '../routes/router'
import {createPinia, mapActions} from 'pinia'
import {loadFonts} from './webfontloader'
import Toaster from '@meforma/vue-toaster'
import {useGlobalStore} from '../stores/global'
import { useUserAuthStore} from '../stores/auth'


const pinia = createPinia()

export function registerPlugins(app) {
    loadFonts()
    app
        .use(vuetify)
        .use(pinia)
        .use(userRouter)
        .use(Toaster)
    useGlobalStore()
    useUserAuthStore()
}
