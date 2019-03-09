import { map, flatten } from 'lodash'
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
  ADD_NEW_SECTION(state, section) {
    state.sections.push(section)
  },
  ADD_NEW_COUNTER(state, counter) {
    let section = state.sections.find(s => s.id === counter.section_id)

    if (section !== undefined) {
      section.counters.push(counter)
    }
  },
  EDIT_COUNTER(state, counter) {
    let orgCounter = flatten(map(state.sections, s => s.counters)).find(
      c => c.id === counter.id
    )

    if (orgCounter !== undefined) {
      for (let prop in counter) {
        orgCounter[prop] = counter[prop]
      }
    }
  },
  DELETE_COUNTER(state, counter) {
    let section = state.sections.find(s => s.id === counter.section_id)

    if (section !== undefined) {
      section.counters.splice(section.counters.indexOf(counter), 1)
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
  createSection({ commit }, queueSection) {
    return apiSection
      .store(queueSection)
      .then(response => {
        commit('ADD_NEW_SECTION', response.data)
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
  },
  updateCounter({ commit }, queueCounter) {
    return apiCounter
      .update(queueCounter)
      .then(response => {
        commit('EDIT_COUNTER', response.data)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  deleteCounter({ commit }, queueCounter) {
    return apiCounter
      .destroy(queueCounter.id)
      .then(response => {
        commit('DELETE_COUNTER', queueCounter)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  }
}
