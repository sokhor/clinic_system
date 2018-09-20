import store from '@/store'

export default [
  {
    path: '/users',
    name: 'users',
    meta: {
      authRequired: true
    },
    component: () => import(/* webpackChunkName: "users" */ '@/pages/users')
  },
  {
    path: '/users/create',
    name: 'users-create',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-create" */ '@/pages/users/create.vue')
  },
  {
    path: '/users/:id/edit',
    name: 'users-edit',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-edit" */ '@/pages/users/edit.vue'),
    props: route => ({ user: route.params.user })
  },
  {
    path: '/users/:id',
    name: 'users-show',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-show" */ '@/pages/users/show.vue'),
    props: route => ({ user: route.params.user })
  },
  {
    path: '/users/:id/password/reset',
    name: 'users-reset-password',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-reset-password" */ '@/pages/users/form-reset-password.vue'),
    props: route => ({ user: route.params.user })
  },
  {
    path: '/users/:id/attach/roles',
    name: 'users-attach-roles',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "users-attach-roles" */ '@/pages/users/attach-role.vue'),
    props: route => ({ user: route.params.user, roles: route.params.roles }),
    async beforeEnter(to, from, next) {
      let { data: roles } = await store.dispatch('roles/fetchRoles', {
        noPaging: true
      })
      to.params.roles = roles

      if (to.params.user === undefined) {
        let { data: user } = await store.dispatch('users/getUser', to.params.id)
        to.params.user = user
      }
      next()
    }
  }
]
