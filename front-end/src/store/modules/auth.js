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
  // validate({ commit, state }) {
  //   if (!state.currentUser) return Promise.resolve(null)

  //   return httpClient
  //     .get('/api/authenticated')
  //     .then(response => {
  //       const user = response.data
  //       commit('SET_CURRENT_USER', user)
  //       return user
  //     })
  //     .catch(error => {
  //       if (error.response.status === 401) {
  //         commit('SET_CURRENT_USER', null)
  //       }
  //       return null
  //     })
  // },
  logIn({ commit } /*, dispatch, getters */, { username, password } = {}) {
    // if (getters.loggedIn) return dispatch('validate')

    return httpClient
      .post('/api/login', { username, password })
      .then(response => {
        const user = response.data
        commit('SET_CURRENT_USER', user)
        return user
      })
  },
  logOut({ commit }) {
    commit('SET_CURRENT_USER', null)
  }
}

function getSavedState(key) {
  return JSON.parse(window.localStorage.getItem(key))
}

function saveState(key, state) {
  window.localStorage.setItem(key, JSON.stringify(state))
}
