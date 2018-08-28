import Vue from 'vue'
import Vuex from 'vuex'
// import createPersistedState from 'vuex-persistedstate'
import modules from './modules'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    drawer: true
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
