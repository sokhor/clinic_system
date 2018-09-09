import user from './user'
import passport from './passport'

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
  ...user,
  ...passport
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
