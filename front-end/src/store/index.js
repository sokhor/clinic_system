import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    drawer: true,
    auth: {
      tokenType: "",
      accessToken: "",
      refreshToken: "",
      expiresIn: "",
      authenticated: false
    }
  },
  getters: {
    isAuthenticated: state => {
      return state.auth.authenticated;
    }
  },
  mutations: {
    toggleNavigation(state) {
      state.drawer = !state.drawer;
    },
    SET_AUTHENTICATION(state, auth) {
      state.auth.tokenType = auth.token_type;
      state.auth.accessToken = auth.access_token;
      state.auth.refreshToken = auth.refresh_token;
      state.auth.expiresIn = auth.expires_in;
      state.auth.authenticated = true;
    }
  },
  actions: {},
  plugins: [createPersistedState()]
});
