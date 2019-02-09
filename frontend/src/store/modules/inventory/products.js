import qs from 'qs'
import Api from '@/api/inventory/products'
import { baseState, baseMutations } from '../_mixin'

export const state = {
  ...baseState
}

export const getters = {}

export const mutations = {
  ...baseMutations
}

export const actions = {
  list({ commit, state }, { page, per_page, filter } = {}) {
    commit('RECEIVE_RESOURCES', { data: [] })

    let response = Api.list({
      option: {
        params: {
          page: page !== undefined ? page : state.pagination.current_page,
          per_page:
            per_page !== undefined ? per_page : state.pagination.per_page,
          filter
        },
        paramsSerializer: function(params) {
          return qs.stringify(params, { arrayFormat: 'brackets' })
        }
      },
      config: { showProgressBar: true }
    })

    response.then(data => {
      commit('RECEIVE_RESOURCES', data)
    })

    return response
  },
  find({ commit }, productId) {
    return Api.find(productId, { config: { showProgressBar: true } })
  },
  store({ commit }, product) {
    return Api.store(product)
  },
  update({ commit }, product) {
    return Api.update(product)
  },
  destroy({ commit }, product) {
    return Api.destroy(product)
  }
}
