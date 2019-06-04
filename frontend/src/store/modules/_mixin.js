import { mapKeys, camelCase } from 'lodash'

class Pagination {
  constructor(paging = {}) {
    this.currentPage = paging.currentPage ? parseInt(paging.currentPage) : 1
    this.lastPage = paging.lastPage ? parseInt(paging.lastPage) : 0
    this.perPage = paging.perPage ? parseInt(paging.perPage) : 15
    this.total = paging.total ? parseInt(paging.total) : 0
    this.from = this.perPage * (this.currentPage - 1) + 1
    this.to = this.perPage * this.currentPage
  }
}

export const baseState = {
  resources: [],
  search: '',
  pagination: new Pagination()
}

export const baseMutations = {
  RECEIVE_RESOURCES(state, { data, meta }) {
    state.resources = []
    data.forEach(resource => {
      state.resources.push(Object.assign(resource, { _deleting: false }))
    })

    state.pagination = new Pagination(mapKeys(meta, (v, k) => camelCase(k)))
  },
  DELETE_RESOURCE(state, resource) {
    state.resources.splice(state.resources.indexOf(resource), 1)
  },
  SET_SEARCH(state, search) {
    state.search = search
  },
  RESET_CURRENT_PAGE(state) {
    state.pagination.currentPage = 1
  }
}
