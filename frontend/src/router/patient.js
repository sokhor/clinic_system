import store from '@/store'

export default [
  {
    path: '/patients',
    name: 'patients',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/patients')
  },
  {
    path: '/patients/create',
    name: 'patients-create',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/patients/create.vue')
  },
  {
    path: '/patients/:id/edit',
    name: 'patients-edit',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/patients/edit.vue'),
    props: route => ({ patient: route.params.patient }),
    beforeEnter: async (to, from, next) => {
      if (to.params.patient === undefined) {
        await store
          .dispatch('patients/find', to.params.id)
          .then(({ data }) => (to.params.patient = data))
      }

      next()
    }
  },
  {
    path: '/patients/:id',
    name: 'patients-show',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/patients/show.vue')
  }
]
