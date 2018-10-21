export default [
  {
    path: '/buildings',
    name: 'buildings',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/buildings')
  },
  {
    path: '/buildings/create',
    name: 'buildings-create',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/buildings/create.vue')
  },
  {
    path: '/buildings/:id/edit',
    name: 'buildings-edit',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/buildings/edit.vue'),
    props: route => ({ building: route.params.building })
  },
  {
    path: '/buildings/:id',
    name: 'buildings-show',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/buildings/show.vue'),
    props: route => ({ buildingProp: route.params.buildingProp })
  }
]
