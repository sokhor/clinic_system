export default [
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '@/pages/login.vue')
  },
  {
    path: '/',
    name: 'dashboard',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "dashboard" */ '@/pages/Dashboard.vue')
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
  },
  {
    path: '/users/:id/edit',
    name: 'users-edit',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-edit" */ '@/pages/users/form.vue'),
    props: route => ({ user: route.params.user })
  },
  {
    path: '/users/:id/password/reset',
    name: 'users-reset-password',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-edit" */ '@/pages/users/form-reset-password.vue'),
    props: route => ({ user: route.params.user })
  }
]

// function lazyLoadView(AsyncView) {
//   const AsyncHandler = () => ({
//     component: AsyncView,
//     loading: require('@/pages/loading.vue').default,
//     error: require('@/pages/timeout.vue').default,
//     delay: 200,
//     timeout: 10000
//   })

//   return Promise.resolve({
//     functional: true,
//     render(h, { data, children }) {
//       return h(AsyncHandler, data, children)
//     }
//   })
// }
