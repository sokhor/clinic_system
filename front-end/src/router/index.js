import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
import routes from './routes'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if (to.path != '/login') {
    if (store.getters['auth/isAuthenticated']) {
      next()
    } else {
      next('login')
    }
  } else {
    if (store.getters['auth/isAuthenticated']) {
      next(from.path)
    } else {
      next()
    }
  }
})

export default router
