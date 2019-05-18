import companies from '@/api/administration/companies'
import { baseState, baseMutations } from '../_mixin'

export const state = {
  ...baseState
}

export const getters = {}

export const mutations = {
  ...baseMutations
}

export const actions = {
  fetchCompanies(context, { page, perPage, search } = {}) {
    return companies
      .get({ params: { page, perPage, search } })
      .then(response => {
        context.commit('RECEIVE_RESOURCES', response)
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  findCompanyById(context, id) {
    return companies
      .find(id)
      .then(response => {
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  },
  createCompany(context, data) {
    return companies
      .store(data)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
}
