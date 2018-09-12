import httpClient from '@/http-client'

export const state = {
  clients: [],
  tokens: [],
  personalTokens: []
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
  },
  RECEIVE_TOKENS(state, tokens) {
    state.tokens = []
    tokens.forEach(token => {
      state.tokens.push(Object.assign(token, { _revoking: false }))
    })
  },
  RECEIVE_PERSONAL_TOKENS(state, personalTokens) {
    state.personalTokens = []
    personalTokens.forEach(personalToken => {
      state.personalTokens.push(Object.assign(personalToken, { _revoking: false }))
    })
  },
  ADD_NEW_PERSONAL_TOKEN(state, personalToken) {
    state.personalTokens.push(Object.assign(personalToken, { _revoking: false }))
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
  },
  fetchTokens({ commit }) {
    return httpClient
      .get('/oauth/tokens')
      .then(response => {
        commit('RECEIVE_TOKENS', response.data)
        return response.data
      });
  },
  revokeAuthorizedToken(token) {
    return httpClient
      .delete('/oauth/tokens/' + token.id)
      .then(response => {
          return response.data
      })
  },
  fetchPersonalTokens({ commit }) {
    return httpClient
    .get('/oauth/personal-access-tokens')
                        .then(response => {
                            commit('RECEIVE_PERSONAL_TOKENS', response.data)
        return response.data
                        })
  },
  createPersonalToken({ commit }, form) {
    return httpClient
    .post('/oauth/personal-access-tokens', form)
                        .then(response => {
                            commit('ADD_NEW_PERSONAL_TOKEN', response.data.token)
                            return response.data
                        })
  }
}
