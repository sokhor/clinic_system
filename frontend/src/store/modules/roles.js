import httpClient from '@/http-client'

export const state = {
  roles: []
}

export const getters = {}

export const mutations = {
  RECEIVE_ROLES(state, roles) {
    state.roles = []
    roles.data.forEach(role => {
      state.roles.push(Object.assign(role, { _deleting: false }))
    })
  }
}

export const actions = {
  fetchRoles({ commit }) {
    return httpClient
      .get('/api/roles', {}, { showProgressBar: true })
      .then(response => {
        commit('RECEIVE_ROLES', response.data)
      })
  },
  createRole({}, role) {
    return httpClient.post('/api/roles', role).then(response => {
      return response.data
    })
  },
  updateRole({}, role) {
    return httpClient.put(`/api/roles/${role.id}`, role).then(response => {
      return response.data
    })
  },
  deleteRole({}, role) {
    return httpClient.delete(`/api/roles/${role.id}`).then(response => {
      return response.data
    })
  }
}
