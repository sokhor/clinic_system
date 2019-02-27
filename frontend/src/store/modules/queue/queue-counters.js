import httpClient from '@/http-client'
import { baseState, baseMutations } from '../_mixin'

export const state = {
  ...baseState
}

export const getters = {}

export const mutations = {
  ...baseMutations
}

export const actions = {
  list({ commit, state }, { page, per_page, search } = {}) {
    commit('RECEIVE_RESOURCES', { data: [] })

    return httpClient
      .get(
        '/api/queue-counters',
        {
          params: {
            page: page !== undefined ? page : state.pagination.current_page,
            per_page:
              per_page !== undefined ? per_page : state.pagination.per_page,
            search
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
      .get(`/api/queue-counters/${id}`, {}, { showProgressBar: true })
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  store({ commit }, queueCounter) {
    return httpClient
      .post('/api/queue-counters', queueCounter)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update({ commit }, queueCounter) {
    return httpClient
      .put(`/api/queue-counters/${queueCounter.id}`, queueCounter)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy({ commit }, queueCounter) {
    return httpClient
      .delete(`/api/queue-counters/${queueCounter.id}`)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
