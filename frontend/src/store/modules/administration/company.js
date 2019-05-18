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
  createCompany(context, data) {
    return companies
      .store(data)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error.data))
  },
