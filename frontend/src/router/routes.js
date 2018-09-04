export default [
  {
    path: '/login',
    name: 'login',
    component: () =>
      lazyLoadView(import(/* webpackChunkName: "login" */ '@/pages/login.vue'))
  },
  {
    path: '/',
    name: 'dashboard',
    meta: {
      authRequired: true
    },
    component: () =>
      lazyLoadView(
        import(/* webpackChunkName: "dashboard" */ '@/pages/Dashboard.vue')
      )
  },
  {
    path: '/users',
    name: 'users',
    meta: {
      authRequired: true
    },
    component: () => import(/* webpackChunkName: "users" */ '@/pages/users')
  },
  {
    path: '/users/create',
    name: 'users-create',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-create" */ '@/pages/users/form.vue')
  }
]

function lazyLoadView(AsyncView) {
  const AsyncHandler = () => ({
    component: AsyncView,
    loading: require('@/pages/loading.vue').default,
    error: require('@/pages/timeout.vue').default,
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
