import httpClient from '@/http-client'

export const state = {
  abilities: []
}

export const getters = {}

export const mutations = {
  RECEIVE_ABILITIES(state, abilities) {
    state.abilities = []
    abilities.forEach(ability => {
      state.abilities.push(ability)
    })
  }
}

export const actions = {
  fetchAbilities({ commit, state }) {
    if (state.abilities.length > 0) return

    httpClient
      .get('/api/abilities', {}, { showProgressBar: true })
      .then(response => {
        commit('RECEIVE_ABILITIES', response.data)
      })
  }
}
