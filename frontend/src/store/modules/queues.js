import apiSection from '@/api/queue/sections'
import apiCounter from '@/api/queue/counters'

export const state = {
  sections: []
}

export const getters = {}

export const mutations = {
  RECEIVE_RESOURCES(state, sections) {
    state.sections = sections
  },
  ADD_NEW_COUNTER(state, counter) {
    let section = state.sections.find(s => s.id === counter.section_id)

    if (section !== undefined) {
      section.counters.push(counter)
    }
  }
}

export const actions = {
  listSections({ commit }) {
    commit('RECEIVE_RESOURCES', { data: [] })

    return apiSection
      .list()
      .then(response => {
        commit('RECEIVE_RESOURCES', response.data)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  createCounter({ commit }, queueCounter) {
    return apiCounter
      .store(queueCounter)
      .then(response => {
        commit('ADD_NEW_COUNTER', response.data)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  }
}
