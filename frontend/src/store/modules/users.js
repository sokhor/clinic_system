import httpClient from '@/http-client'

export const state = {
  users: []
}

export const getters = {}

export const mutations = {
  RECEIVE_USERS(state, users) {
    state.users = []
    users.data.forEach(user => {
      state.users.push(Object.assign(user, { _deleting: false }))
    })
  }
}

export const actions = {
  fetchUsers({ commit }) {
    return httpClient
      .get('/api/users', {}, { showProgressBar: true })
      .then(response => {
        commit('RECEIVE_USERS', response.data)
      })
  },
  getUser({}, id) {
    return httpClient
      .get(`/api/users/${id}`, {}, { showProgressBar: true })
      .then(response => response.data)
  },
  createUser({}, user) {
    return httpClient.post('/api/users', user).then(response => {
      return response.data
    })
  },
  updateUser({}, user) {
    return httpClient.put(`/api/users/${user.id}`, user).then(response => {
      return response.data
    })
  },
  deleteUser({}, user) {
    return httpClient.delete(`/api/users/${user.id}`).then(response => {
      return response.data
    })
  },
  resetUserPassword({}, { id, password, password_confirmation }) {
    return httpClient
      .put(`/api/users/${id}/password/reset`, {
        password,
        password_confirmation
      })
      .then(response => {
        return response.data
      })
  },
  attachRoles({}, { user, roles }) {
    return httpClient
      .post(`/api/users/${user.id}/roles`, { roles })
      .then(response => {
        return response.data
      })
  },
  detachRoles({}, { userId, roles }) {
    return httpClient
      .put(`/api/users/${userId}/roles`, { roles })
      .then(response => {
        return response.data
      })
  }
}
