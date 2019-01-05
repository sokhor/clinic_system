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
        '/api/appointments',
        {
          params: {
            page: page !== undefined ? page : state.pagination.current_page,
            per_page:
              per_page !== undefined ? per_page : state.pagination.per_page,
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
      .get(`/api/appointments/${id}`, {}, { showProgressBar: true })
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  store({ commit }, appointment) {
    return httpClient
      .post('/api/appointments', appointment)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update({ commit }, appointment) {
    return httpClient
      .put(`/api/appointments/${appointment.id}`, appointment)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy({ commit }, appointment) {
    return httpClient
      .delete(`/api/appointments/${appointment.id}`)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
