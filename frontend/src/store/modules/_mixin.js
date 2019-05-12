import { camelCase } from 'lodash'

function setPaging({
  currentPage = 1,
  from = null,
  to = null,
  lastPage = 0,
  perPage = 15,
  total = 0
} = {}) {
  return {
    currentPage,
    from,
    to,
    lastPage,
    perPage,
    total
  }
}

export const baseState = {
  resources: [],
  search: '',
  pagination: {}
}

export const baseMutations = {
  RECEIVE_RESOURCES(state, { data, meta }) {
    state.resources = []
    data.forEach(resource => {
      state.resources.push(Object.assign(resource, { _deleting: false }))
    })

    state.pagination = setPaging(camelCase(meta))
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
