import httpClient from '@/http-client'

export const state = {
  clients: []
}

export const getters = {}

export const mutations = {
  RECEIVE_CLIENTS(state, clients) {
    state.clients = []
    clients.forEach(client => {
      state.clients.push(Object.assign(client, { _deleting: false }))
    })
  },
  ADD_NEW_CLIENT(state, newClient) {
    state.clients.push(Object.assign(newClient, { _deleting: false }))
  },
  UPDATE_CLIENT(state, updatedClient) {
    let client = state.clients.find(c => c.id == updatedClient.id)

    if (client === undefined) return

    client = Object.assign(client, updatedClient, { _deleting: false })
  },
  DELETE_CLIENT(state, deletedClient) {
    let client = state.clients.find(c => c.id == deletedClient.id)

    if (client === undefined) return

    state.clients.splice(state.clients.indexOf(client), 1)
  }
}

export const actions = {
  fetchClients({ commit }) {
    return httpClient
      .get('/oauth/clients', {}, { showProgressBar: true })
      .then(response => {
        commit('RECEIVE_CLIENTS', response.data)
        return response.data
      })
  },
  createClient({ commit }, newClient) {
    return httpClient
      .post('/oauth/clients', newClient)
      .then(response => {
        commit('ADD_NEW_CLIENT', response.data)
        return Promise.resolve(response.data)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  updateClient({ commit }, client) {
    return httpClient
      .put(`/oauth/clients/${client.id}`, client)
      .then(response => {
        commit('UPDATE_CLIENT', response.data)
        return Promise.resolve(response.data)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  deleteClient({ commit }, client) {
    return httpClient
      .delete(`/oauth/clients/${client.id}`)
      .then(response => {
        commit('DELETE_CLIENT', client)
        return Promise.resolve(client)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  }
}
