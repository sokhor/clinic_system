import qs from 'qs'
import api from '@/api/patient'
import { baseState, baseMutations } from './_mixin'

export const state = {
  ...baseState
}

export const getters = {}

export const mutations = {
  ...baseMutations
}

export const actions = {
  list({ commit, state }, { page, perPage, filter } = {}) {
    commit('RECEIVE_RESOURCES', { data: [] })

    return api
      .list({
        params: {
          page: page !== undefined ? page : state.pagination.current_page,
          perPage: perPage !== undefined ? perPage : state.pagination.perPage,
          filter
        },
        paramsSerializer: function(params) {
          return qs.stringify(params, { arrayFormat: 'brackets' })
        }
      })
      .then(response => {
        commit('RECEIVE_RESOURCES', response)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error)
      })
  },
  find(context, id) {
    return api
      .find(id)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  store(context, patient) {
    return api
      .store(patient)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update(context, patient) {
    return api
      .update(patient.id, patient)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy(context, patient) {
    return api
      .destroy(patient.id)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
