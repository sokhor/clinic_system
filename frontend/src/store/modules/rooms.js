import httpClient from '@/http-client'
import { baseState, baseMutations } from './_mixin'

export const state = {
  ...baseState,
  wards: [],
  buildings: []
}

export const getters = {}

export const mutations = {
  ...baseMutations,
  WARDS(state, wards) {
    state.wards = wards
  },
  BUILDINGS(state, buildings) {
    state.buildings = buildings
  }
}

export const actions = {
  list({ commit, state }, { page, per_page } = {}) {
    return httpClient
      .get(
        '/api/rooms',
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
  find({ commit, state }, id) {
    return httpClient
      .get(`/api/rooms/${id}`, {}, { showProgressBar: true })
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  store({ commit }, room) {
    return httpClient
      .post('/api/rooms', room)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update({ commit }, room) {
    return httpClient
      .put(`/api/rooms/${room.id}`, room)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy({ commit }, room) {
    return httpClient
      .delete(`/api/rooms/${room.id}`)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  fetchWards({ commit, state }) {
    if (state.wards.length > 0) return

    return httpClient
      .get('/api/rooms/wards', {}, { showProgressBar: true })
      .then(response => {
        commit('WARDS', response.data.data)
        Promise.resolve(response.data)
      })
      .catch(error => Promise.reject(error.response.data))
  },
  fetchBuildings({ commit, state }) {
    if (state.buildings.length > 0) return

    return httpClient
      .get('/api/rooms/buildings', {}, { showProgressBar: true })
      .then(response => {
        commit('BUILDINGS', response.data.data)
        Promise.resolve(response.data)
      })
      .catch(error => Promise.reject(error.response.data))
  }
}
