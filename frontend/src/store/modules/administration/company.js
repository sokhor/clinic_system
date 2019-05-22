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
  async createCompany(context, data) {
    try {
      if (data.logo instanceof File) {
        let uploadResponse = await companies.uploadLogo(data.logo)
        data.logo = uploadResponse.data
      }

      let response = companies.store(data)

      return Promise.resolve(response)
    } catch (error) {
      return Promise.reject(error.data)
    }
  },
  async editCompany(context, { id, ...data }) {
    try {
      if (data.logo instanceof File) {
        let uploadResponse = await companies.uploadLogo(data.logo)
        data.logo = uploadResponse.data
      }

      let response = companies.update(id, data)

      return Promise.resolve(response)
    } catch (error) {
      return Promise.reject(error.data)
    }
  },
  deleteCompany(context, data) {
    return companies
      .destroy(data.id)
      .then(response => {
        context.commit('DELETE_RESOURCE', data)
        return Promise.resolve(response)
      })
      .catch(error => Promise.reject(error.data))
  }
}
