import { flatten } from 'lodash'
import httpClient from '@/http-client'
import { baseState, baseMutations } from './_mixin'

export const state = {
  ...baseState,
  wards: []
}

export const getters = {}

export const mutations = {
  ...baseMutations,
  WARDS(state, wards) {
    state.wards = wards
  }
}

export const actions = {
  fetchResources({ commit, state }, { page, per_page } = {}) {
    return httpClient
      .get(
        '/api/buildings',
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
  store({ commit }, building) {
    return httpClient
      .post('/api/buildings', building)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update({ commit }, building) {
    return httpClient
      .put(`/api/buildings/${building.id}`, building)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy({ commit }, building) {
    return httpClient
      .delete(`/api/buildings/${building.id}`)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  fetchWards({ commit }) {
    return httpClient
      .get('/api/buildings/wards')
      .then(response => {
        commit('WARDS', response.data.data)
        Promise.resolve(response.data)
      })
      .catch(error => Promise.reject(error.response.data))
  },
  syncWards({ commit }, { id, wards }) {
    return httpClient
      .put(`/api/buildings/${id}/wards`, flatten(wards.map(ward => ward.id)))
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
