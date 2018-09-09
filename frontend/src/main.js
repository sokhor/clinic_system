import './styles/main.css'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import vmodal from 'vue-js-modal'
import App from './components/App.vue'
import router from './router'
import store from './store'
import './components/common'

Vue.config.productionTip = false

Vue.use(Vuelidate)
Vue.use(vmodal, { dynamic: true, injectModalsContainer: true })

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
