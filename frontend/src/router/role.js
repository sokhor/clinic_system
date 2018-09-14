export default [
  {
    path: '/roles',
    name: 'roles',
    meta: {
      authRequired: true
    },
    component: () => import(/* webpackChunkName: "roles" */ '@/pages/roles')
  },
  {
    path: '/roles/create',
    name: 'roles-create',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "roles-create" */ '@/pages/roles/form.vue')
  },
  {
    path: '/roles/:id/edit',
    name: 'roles-edit',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "roles-edit" */ '@/pages/roles/form.vue'),
    props: route => ({ role: route.params.role })
  }
]
