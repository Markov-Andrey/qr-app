import { defineNuxtPlugin } from '#app'
import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

export default defineNuxtPlugin(nuxtApp => {
    nuxtApp.vueApp.use(Buefy)
})
