import apiClient from '../api-client'

export const list = () => {
  return apiClient
    .get('/api/queue-sections')
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = data => {
  return apiClient
    .post('/api/queue-sections', data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data) => {
  return apiClient
    .put(`/api/queue-sections/${id}`, data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = id => {
  return apiClient
    .delete(`/api/queue-sections/${id}`)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { list, store, update, destroy }
