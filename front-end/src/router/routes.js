export default [
  {
    path: '/login',
    name: 'login',
    component: () =>
      lazyLoadView(import(/* webpackChunkName: "login" */ '../pages/login.vue'))
  },
  {
    path: '/',
    name: 'dashboard',
    meta: {
      authRequired: true
    },
    component: () =>
      lazyLoadView(
        import(/* webpackChunkName: "dashboard" */ '../pages/Dashboard.vue')
      )
  },
  {
    path: '/user',
    name: 'user',
    meta: {
      authRequired: true
    },
    component: () => import(/* webpackChunkName: "user" */ '../pages/user')
  }
]

function lazyLoadView(AsyncView) {
  const AsyncHandler = () => ({
    component: AsyncView,
    loading: require('./views/loading.vue').default,
    error: require('./views/timeout.vue').default,
    delay: 400,
    timeout: 10000
  })

  return Promise.resolve({
    functional: true,
    render(h, { data, children }) {
      return h(AsyncHandler, data, children)
    }
  })
}
