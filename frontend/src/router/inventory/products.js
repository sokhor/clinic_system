import store from '@/store'

export default [
  {
    path: '/products',
    name: 'products',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/inventory/products')
  },
  {
    path: '/products/create',
    name: 'products-create',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/inventory/products/create.vue')
  },
  {
    path: '/products/:id/edit',
    name: 'products-edit',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/inventory/products/edit.vue'),
    props: route => ({ patient: route.params.patient }),
    beforeEnter: async (to, from, next) => {
      if (to.params.patient === undefined) {
        await store
          .dispatch('products/find', to.params.id)
          .then(({ data }) => (to.params.patient = data))
      }

      next()
    }
  },
  {
    path: '/products/:id',
    name: 'products-show',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/inventory/products/_id.vue')
  }
]
