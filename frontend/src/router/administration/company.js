export default [
  {
    path: '/companies',
    name: 'companies',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "companies" */ '@/pages/administration/company')
  },
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
