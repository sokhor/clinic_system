import httpClient from '../../http-client'

export const state = {
  currentUser: getSavedState('auth.currentUser')
}

export const getters = {
  isAuthenticated(state) {
    return !!state.currentUser
  },
  accessToken(state) {
    return state.currentUser !== null ? state.currentUser.access_token : ''
  }
}

export const mutations = {
  SET_CURRENT_USER(state, newValue) {
    state.currentUser = newValue
    saveState('auth.currentUser', newValue)
  }
}

export const actions = {
  init(/* { dispatch } */) {
    // dispatch('validate')
  },
  validate({ commit, state }) {
    return httpClient
      .get('/api/authenticated')
      .then(response => {
        return response.data
      })
      .catch(error => {
        if (error.response.status === 401) {
          commit('SET_CURRENT_USER', null)
        }

        return Promise.reject(error.response)
      })
  },
  logIn({ commit }, { username, password } = {}) {
    return httpClient
      .post('/api/login', { username, password })
      .then(response => {
        const user = response.data.data
        commit('SET_CURRENT_USER', user)
        return user
      })
  },
  logOut({ commit }) {
    return httpClient
      .post('/api/logout', {}, {}, { showProgressBar: true })
      .then(response => {
        commit('SET_CURRENT_USER', null)
        return response.data
      })
  }
}

function getSavedState(key) {
  return JSON.parse(window.localStorage.getItem(key))
}

function saveState(key, state) {
  window.localStorage.setItem(key, JSON.stringify(state))
}
