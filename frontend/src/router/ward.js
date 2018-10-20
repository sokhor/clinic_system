export default [
  {
    path: '/wards',
    name: 'wards',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/wards')
  },
  {
    path: '/wards/create',
    name: 'wards-create',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/wards/create.vue')
  },
  {
    path: '/wards/:id/edit',
    name: 'wards-edit',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/wards/edit.vue'),
    props: route => ({ ward: route.params.ward })
  }
]
