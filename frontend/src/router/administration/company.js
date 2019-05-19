import companies from '@/api/administration/companies'

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
  {
    path: '/companies/:id/edit',
    name: 'companies-edit',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "companies-edit" */ '@/pages/administration/company/edit.vue'),
    props: route => ({ companyProp: route.params.companyProp }),
    beforeEnter: async (to, from, next) => {
      let response = await companies.find(to.params.id)
      to.params.companyProp = response.data
      next()
    }
  },
  {
    path: '/companies/:id',
    name: 'companies-show',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "companies-show" */ '@/pages/administration/company/show.vue'),
    props: route => ({ companyProp: route.params.companyProp }),
    beforeEnter: async (to, from, next) => {
      let response = await companies.find(to.params.id)
      to.params.companyProp = response.data
      next()
    }
  }
]
