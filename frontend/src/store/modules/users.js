import httpClient from '@/http-client'

export const state = {
  users: [],
  editUser: null
}

export const getters = {}

export const mutations = {
  RECEIVE_USERS(state, users) {
    state.users = users.data
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
  }
}
