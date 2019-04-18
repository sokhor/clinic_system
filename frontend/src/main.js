import './styles/main.sass'
import moment from 'moment'
import Vue from 'vue'
import VueRx from 'vue-rx'
import Vuelidate from 'vuelidate'
import Vmodal from 'vue-js-modal'
import 'simplebar/dist/simplebar.min.css'
import VTooltip from 'v-tooltip'
import App from './components/App.vue'
import router from './router'
import store from './store'
import './components/common'
import { ModalDialog, Toast } from './plugins'

moment.locale('kh', {
  week: {
    dow: 1
  }
})

Vue.use(VueRx)
Vue.use(Vuelidate)
Vue.use(Vmodal, { dynamic: true, injectModalsContainer: true })
Vue.use(ModalDialog)
Vue.use(Toast, { position: 'bottom-center', duration: 3000 })
Vue.use(VTooltip)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

Object.defineProperties(Vue.prototype, {
  $moment: {
    get() {
      return moment
    }
  }
})
