function setPaging({
  current_page = 1,
  from = null,
  to = null,
  last_page = 0,
  per_page = 15,
  total = 0
} = {}) {
  return {
    current_page,
    from,
    to,
    last_page,
    per_page,
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

    state.pagination = setPaging(meta)
  },
  DELETE_RESOURCE(state, resource) {
    state.resources.splice(state.resources.indexOf(resource), 1)
  },
  SET_SEARCH(state, search) {
    state.search = search
  },
  RESET_CURRENT_PAGE(state) {
    state.pagination.current_page = 1
  }
}
