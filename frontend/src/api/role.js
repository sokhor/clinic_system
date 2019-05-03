import apiClient from './api-client'

export const get = params => {
  return apiClient
    .get('/api/roles', { params })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, params) => {
  return apiClient
    .get(`/api/roles/${id}`, { params })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = data => {
  return apiClient
    .post('/api/roles', data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data) => {
  return apiClient
    .put(`/api/roles/${id}`, data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = id => {
  return apiClient
    .delete(`/api/roles/${id}`)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, store, update, destroy }
