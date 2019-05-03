import api from '@/api/role'
import { baseState, baseMutations } from './_mixin'

export const state = {
  ...baseState
}

export const getters = {}

export const mutations = {
  ...baseMutations
}

export const actions = {
  get(context, { page, per_page, search } = {}) {
    return api
      .get({ page, per_page, search })
      .then(response => {
        context.commit('RECEIVE_RESOURCES', response)
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  store(context, role) {
    return api
      .store(role)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  update(context, role) {
    return api
      .update(role.id, role)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  destroy(context, role) {
    return api
      .destroy(role.id)
      .then(response => {
        context.commit('DELETE_RESOURCE', role)
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  }
}
