export default [
  {
    path: '/appointments',
    name: 'appointments',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/appointments')
  }
]
