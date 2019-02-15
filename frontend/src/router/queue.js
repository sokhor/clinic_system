import store from '@/store'

export default [
  {
    path: '/queues',
    name: 'queues',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/queues')
  }
]
