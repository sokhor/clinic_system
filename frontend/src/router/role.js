import store from '@/store'

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
      import(/* webpackChunkName: "roles-create" */ '@/pages/roles/create.vue'),
    beforeEnter: async (to, from, next) => {
      await store.dispatch('abilities/fetchAbilities')
      next()
    }
  },
  {
    path: '/roles/:id/edit',
    name: 'roles-edit',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "roles-edit" */ '@/pages/roles/edit.vue'),
    props: route => ({ role: route.params.role }),
    beforeEnter: async (to, from, next) => {
      await store.dispatch('abilities/fetchAbilities')
      next()
    }
  }
]
