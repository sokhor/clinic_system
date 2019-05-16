import api from '@/api/user'
import { baseState, baseMutations } from './_mixin'

export const state = {
  ...baseState,
  user: {}
}

export const getters = {}

export const mutations = {
  ...baseMutations,
  SET_USER(state, { roles, ...data }) {
    state.user = Object.assign({}, state.user, {
      ...data,
      roles: roles.map(role => Object.assign({}, role, { _deleting: false }))
    })
  }
}

export const actions = {
  fetchUsers(context, { page, perPage, search } = {}) {
    return api
      .get({ params: { page, perPage, search } })
      .then(response => {
        context.commit('RECEIVE_RESOURCES', response)
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  findUserById(context, id) {
    return api
      .find(id)
      .then(response => {
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  createUser(context, user) {
    return api
      .store(user)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
  editUser(context, { id, ...user }) {
    return api
      .update(id, user)
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
      .then(response => {
        context.commit('SET_USER', { roles: response.data })
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  detachRoles(context, { id, roles }) {
    return api
      .detachRoles(id, roles)
      .then(response => {
        context.commit('SET_USER', { roles: response.data })
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  }
}
