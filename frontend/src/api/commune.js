import apiClient from './api-client'

export const get = (options = {}) => {
  return apiClient
    .get('/api/communes', options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, options = {}) => {
  return apiClient
    .get(`/api/communes/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, find }
