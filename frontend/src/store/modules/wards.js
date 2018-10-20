import httpClient from '@/http-client'
import { baseState, baseMutations } from './_mixin'

export const state = {
  ...baseState
}

export const getters = {}

export const mutations = {
  ...baseMutations
}

export const actions = {
  fetchResources({ commit, state }, { page, per_page } = {}) {
    return httpClient
      .get(
        '/api/wards',
        {
          params: {
            page: page !== undefined ? page : state.pagination.current_page,
            per_page:
              per_page !== undefined ? per_page : state.pagination.per_page,
            search: state.search !== '' ? state.search : null
          }
        },
        { showProgressBar: true }
      )
      .then(response => {
        commit('RECEIVE_RESOURCES', response.data)
        return Promise.resolve(response.data)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  store({ commit }, ward) {
    return httpClient
      .post('/api/wards', ward)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update({ commit }, ward) {
    return httpClient
      .put(`/api/wards/${ward.id}`, ward)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy({ commit }, ward) {
    return httpClient
      .delete(`/api/wards/${ward.id}`)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
