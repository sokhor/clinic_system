import apiClient from '../api-client'

export const get = (options = {}) => {
  return apiClient
    .get('/api/companies', options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, options = {}) => {
  return apiClient
    .get(`/api/companies/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = (data, options = {}) => {
  return apiClient
    .post('/api/companies', data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data, options = {}) => {
  return apiClient
    .put(`/api/companies/${id}`, data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = (id, options = {}) => {
  return apiClient
    .delete(`/api/companies/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, find, store, update, destroy }
