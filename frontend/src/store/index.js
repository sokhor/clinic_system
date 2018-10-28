import Vue from 'vue'
import Vuex from 'vuex'
// import createPersistedState from 'vuex-persistedstate'
import modules from './modules'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    drawer: true,
    floors: {
      1: 'Ground Floor',
      2: '1st Floor',
      3: '2nd Floor',
      4: '3rd Floor'
    },
    roomStatuses: {
      1: 'Available',
      2: 'Incomplete',
      3: 'Reserved',
      4: 'Full'
    }
  },
  getters: {
    gender: state => gender => {
      if (gender === 'F') return 'Female'

      if (gender === 'M') return 'Male'

      return ''
    }
  },
  mutations: {
    toggleNavigation(state) {
      state.drawer = !state.drawer
    }
  },
  modules
  // plugins: [createPersistedState()]
})

// Automatically run the `init` action for every module, if one exists.
for (const moduleName of Object.keys(modules)) {
  if (modules[moduleName].actions && modules[moduleName].actions.init) {
    store.dispatch(`${moduleName}/init`)
  }
}

export default store
