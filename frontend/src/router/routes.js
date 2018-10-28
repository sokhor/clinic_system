import user from './user'
import role from './role'
import ward from './ward'
import building from './building'
import room from './room'
import patient from './patient'

export default [
  {
    path: '/login',
    name: 'login',
    component: () => import('@/pages/login.vue')
  },
  {
    path: '/',
    name: 'dashboard',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/Dashboard.vue')
  },
  ...role,
  ...user,
  ...ward,
  ...building,
  ...room,
  ...patient
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
