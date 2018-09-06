import httpClient from '@/http-client'

export const state = {
  users: [],
  editUser: null
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
      .put(`/api/users/${id}/password/reset`, { password, password_confirmation })
      .then(response => {
        return response.data
      })
  }
}
