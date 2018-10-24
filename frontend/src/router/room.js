import store from '@/store'

const loadInputData = () => {
  return Promise.all([
    store.dispatch('rooms/fetchWards'),
    store.dispatch('rooms/fetchBuildings')
  ])
}

export default [
  {
    path: '/rooms',
    name: 'rooms',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/rooms')
  },
  {
    path: '/rooms/create',
    name: 'rooms-create',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/rooms/create.vue'),
    beforeEnter: async (to, from, next) => {
      await loadInputData()
      next()
    }
  },
  {
    path: '/rooms/:id/edit',
    name: 'rooms-edit',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/rooms/edit.vue'),
    props: route => ({ room: route.params.room }),
    beforeEnter: async (to, from, next) => {
      let tasks = [loadInputData()]

      if (to.params.room === undefined) {
        tasks.push(
          store
            .dispatch('rooms/find', to.params.id)
            .then(({ data }) => (to.params.room = data))
        )
      }

      await Promise.all(tasks)

      next()
    }
  },
  {
    path: '/rooms/:id',
    name: 'rooms-show',
    meta: {
      authRequired: true
    },
    component: () => import('@/pages/rooms/show.vue'),
    props: route => ({ roomProp: route.params.roomProp }),
    beforeEnter: async (to, from, next) => {
      let tasks = [loadInputData()]

      if (to.params.roomProp === undefined) {
        tasks.push(
          store.dispatch('rooms/find', to.params.id).then(
            ({ data }) =>
              (to.params.roomProp = Object.assign({}, data, {
                _deleting: false
              }))
          )
        )
      }

      await Promise.all(tasks)

      next()
    }
  }
]
