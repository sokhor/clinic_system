import httpClient from '../../http-client'

export const state = {
  user: getSavedState('auth.user')
}

export const getters = {
  isAuthenticated(state) {
    return !!state.user
  },
  accessToken(state) {
    return state.user !== null ? state.user.access_token : ''
  }
}

export const mutations = {
  SET_CURRENT_USER(state, newValue) {
    state.user = newValue
    saveState('auth.user', newValue)
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
      .catch(error => Promise.reject(error.response.data))
  },
  logOut({ commit }) {
    return httpClient
      .post('/api/logout', {}, {}, { showProgressBar: true })
      .then(response => {
        commit('SET_CURRENT_USER', null)
        return response.data
      })
      .catch(error => Promise.reject(error.response.data))
  }
}

function getSavedState(key) {
  return JSON.parse(window.localStorage.getItem(key))
}

function saveState(key, state) {
  window.localStorage.setItem(key, JSON.stringify(state))
}
