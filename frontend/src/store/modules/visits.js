import qs from 'qs'
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
  list({ commit, state }, { page, per_page, filter } = {}) {
    commit('RECEIVE_RESOURCES', { data: [] })

    return httpClient
      .get(
        '/api/visits',
        {
          params: {
            page: page !== undefined ? page : state.pagination.current_page,
            per_page:
              per_page !== undefined ? per_page : state.pagination.per_page,
            search: state.search !== '' ? state.search : null,
            filter
          },
          paramsSerializer: function(params) {
            return qs.stringify(params, { arrayFormat: 'brackets' })
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
  find({ commit }, id) {
    return httpClient
      .get(`/api/visits/${id}`, {}, { showProgressBar: true })
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  store({ commit }, patient) {
    return httpClient
      .post('/api/visits', patient)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update({ commit }, patient) {
    return httpClient
      .put(`/api/visits/${patient.id}`, patient)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy({ commit }, patient) {
    return httpClient
      .delete(`/api/visits/${patient.id}`)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
