import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
import routes from './routes'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  },
  routes
})

router.beforeEach((routeTo, routeFrom, next) => {
  const authRequired = routeTo.matched.some(route => route.meta.authRequired)

  if (!authRequired) return next()

  if (store.getters['auth/isAuthenticated']) {
    // store.dispatch('auth/validate').then(validUser => {
    //   // validUser ? next() : redirectToLogin()
    // })

    return next()
  }

  redirectToLogin()

  function redirectToLogin() {
    next({ name: 'login', query: { redirectFrom: routeTo.fullPath } })
  }
})

export default router
