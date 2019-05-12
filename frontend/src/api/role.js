import apiClient from './api-client'

export const get = (options = {}) => {
  return apiClient
    .get('/api/roles', options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, options = {}) => {
  return apiClient
    .get(`/api/roles/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = (data, options = {}) => {
  return apiClient
    .post('/api/roles', data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data, options = {}) => {
  return apiClient
    .put(`/api/roles/${id}`, data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = (id, options = {}) => {
  return apiClient
    .delete(`/api/roles/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, store, update, destroy }
