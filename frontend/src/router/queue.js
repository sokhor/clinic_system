import store from '@/store'

export default [
  {
    path: '/queue-setup',
    name: 'queue-setup',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/queues/setup')
  },
  {
    path: '/queues',
    name: 'queues',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/queues')
  }
]
