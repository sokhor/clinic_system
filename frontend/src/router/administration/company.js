export default [
  {
    path: '/companies/create',
    name: 'companies-create',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "companies-create" */ '@/pages/administration/company/create.vue')
  },
  }
]
