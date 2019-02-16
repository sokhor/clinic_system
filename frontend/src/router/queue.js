import store from '@/store'

export default [
  {
    path: '/queue-sections',
    name: 'queue-sections',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/queues/section')
  },
  {
    path: '/queue-sections/create',
    name: 'queue-sections-create',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/queues/section/create.vue')
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
