import apiClient from '../api-client'

export const list = () => {
  return apiClient
    .get('/api/queue-counters')
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = data => {
  return apiClient
    .post('/api/queue-counters', data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data) => {
  return apiClient
    .put(`/api/queue-counters/${id}`, data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = id => {
  return apiClient
    .delete(`/api/queue-counters/${id}`)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { list, store, update, destroy }
