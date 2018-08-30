import './assets/styles/main.css'
import Vue from 'vue'
import Vuelidate from 'vuelidate'
import App from './components/App.vue'
import router from './router'
import store from './store'
import './components/common'

Vue.use(Vuelidate)

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
