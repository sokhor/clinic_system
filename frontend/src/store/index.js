import Vue from 'vue'
import Vuex from 'vuex'
// import createPersistedState from 'vuex-persistedstate'
import modules from './modules'
import apiProvince from '@/api/province'
import apiDistrict from '@/api/district'
import apiCommune from '@/api/commune'
import apiVillage from '@/api/village'

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
    },
    provinces: [],
    districts: [],
    communes: [],
    villages: []
  },
  getters: {
    gender: state => gender => {
      if (gender === 'F') return 'Female'

      if (gender === 'M') return 'Male'

      return ''
    },
    districtsByProvince: state => provinceCode => {
      return state.districts.filter(
        district => district.province_code === provinceCode
      )
    },
    communesByDistict: state => districtId => {
      return state.communes.filter(
        commune => commune.district_id === districtId
      )
    },
    villagesByCommune: state => communeId => {
      return state.villages.filter(village => village.commune_id === communeId)
    }
  },
  mutations: {
    toggleNavigation(state) {
      state.drawer = !state.drawer
    },
    SET_PROVINCES(state, provinces) {
      state.provinces = provinces
    },
    SET_DISTRICTS(state, districts) {
      state.districts = districts
    },
    SET_COMMUNES(state, communes) {
      state.communes = communes
    },
    SET_VILLAGES(state, villages) {
      state.villages = villages
    }
  },
  actions: {
    fetchLocations({ commit, state }) {
      if (
        state.provinces.length > 0 &&
        state.districts.length > 0 &&
        state.communes.length > 0 &&
        state.villages.length > 0
      )
        return

      Promise.all([
        apiProvince.get(),
        apiDistrict.get(),
        apiCommune.get(),
        apiVillage.get()
      ]).then(responses => {
        commit('SET_PROVINCES', responses[0].data)
        commit('SET_DISTRICTS', responses[1].data)
        commit('SET_COMMUNES', responses[2].data)
        commit('SET_VILLAGES', responses[3].data)
      })
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
