import store from '@/store'

export default [
  {
    path: '/visits',
    name: 'visits',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/visits')
  },
  // {
  //   path: '/visits/create',
  //   name: 'visits-create',
  //   meta: {
  //     authRequired: true
  //   },
  //   component: () => import('@/pages/visits/create.vue')
  // },
  // {
  //   path: '/visits/:id/edit',
  //   name: 'visits-edit',
  //   meta: {
  //     authRequired: true
  //   },
  //   component: () => import('@/pages/visits/edit.vue'),
  //   props: route => ({ patient: route.params.patient }),
  //   beforeEnter: async (to, from, next) => {
  //     if (to.params.patient === undefined) {
  //       await store
  //         .dispatch('visits/find', to.params.id)
  //         .then(({ data }) => (to.params.patient = data))
  //     }

  //     next()
  //   }
  // },
  {
    path: '/visits/:id',
    name: 'visits-show',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/visits/show.vue'),
    props: route => ({ patient: route.params.patient }),
    beforeEnter: async (to, from, next) => {
      if (to.params.patient === undefined) {
        await store
          .dispatch('visits/find', to.params.id)
          .then(({ data }) => (to.params.patient = data))
      }

      next()
    }
  }
]
