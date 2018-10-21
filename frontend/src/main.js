import './styles/main.css'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import Vmodal from 'vue-js-modal'
import App from './components/App.vue'
import router from './router'
import store from './store'
import './components/common'
import { ModalDialog, Toast } from './plugins'

Vue.config.productionTip = false

Vue.use(Vuelidate)
Vue.use(Vmodal, { dynamic: true, injectModalsContainer: true })
Vue.use(ModalDialog)
Vue.use(Toast, { position: 'bottom-center', duration: 3000 })

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
