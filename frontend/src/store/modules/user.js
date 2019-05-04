import api from '@/api/user'
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
  store(context, user) {
    return api
      .store(user)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  update(context, user) {
    return api
      .update(user.id, user)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  destroy(context, user) {
    return api
      .destroy(user.id)
      .then(response => {
        context.commit('DELETE_RESOURCE', user)
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  resetPassword(context, { id, ...passwordData }) {
    return api
      .resetPassword(id, passwordData)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  attachRoles(context, { id, roles }) {
    return api
      .attachRoles(id, roles)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  dettachRoles(context, { id, roles }) {
    return api
      .dettachRoles(id, roles)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  }
}
