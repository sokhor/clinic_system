import { map, flatten } from 'lodash'
import Vue from 'vue'
import apiSection from '@/api/queues/sections'
import apiCounter from '@/api/queues/counters'
import apiQueue from '@/api/queues'

export const state = {
  sections: [],
  queues: []
}

export const getters = {}

export const mutations = {
  RECEIVE_SECTIONS(state, sections) {
    state.sections = sections
  },
  ADD_NEW_SECTION(state, section) {
    state.sections.push(section)
  },
  EDIT_SECTION(state, section) {
    let orgSection = state.sections.find(s => s.id === section.id)

    if (orgSection !== undefined) {
      for (let prop in section) {
        orgSection[prop] = section[prop]
      }
    }
  },
  DELETE_SECTION(state, section) {
    state.sections.splice(state.sections.indexOf(section), 1)
  },
  ADD_NEW_COUNTER(state, counter) {
    let section = state.sections.find(s => s.id === counter.section_id)

    if (section !== undefined) {
      if (section.counters === undefined) {
        Vue.set(section, 'counters', [])
      }

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
  },
  RECEIVE_QUEUES(state, queues) {
    state.queues = queues
  },
  ADD_NEW_QUEUE(state, queue) {
    state.queues.push(queue)
  }
}

export const actions = {
  listSections({ commit }) {
    commit('RECEIVE_SECTIONS', [])

    return apiSection
      .list()
      .then(response => {
        commit('RECEIVE_SECTIONS', response.data)
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
  updateSection({ commit }, { id, ...data }) {
    return apiSection
      .update(id, data)
      .then(response => {
        commit('EDIT_SECTION', response.data)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  deleteSection({ commit }, queueSection) {
    return apiSection
      .destroy(queueSection.id)
      .then(response => {
        commit('DELETE_SECTION', queueSection)
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
  updateCounter({ commit }, { id, ...data }) {
    return apiCounter
      .update(id, data)
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
  },
  list({ commit }) {
    commit('RECEIVE_QUEUES', { data: [] })

    return apiQueue
      .list()
      .then(response => {
        commit('RECEIVE_QUEUES', response.data)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  },
  store({ commit }, sectionId) {
    return apiQueue
      .store({ section_id: sectionId })
      .then(response => {
        commit('ADD_NEW_QUEUE', response.data)
        return Promise.resolve(response)
      })
      .catch(error => {
        return Promise.reject(error.response.data)
      })
  }
}
