import httpClient from '@/http-client'

export const state = {}

export const getters = {}

export const mutations = {}

export const actions = {
  createUser({ commit }, data) {
    return httpClient.post('/api/users', data).then(response => {
      return response.data
    })
  }
}
