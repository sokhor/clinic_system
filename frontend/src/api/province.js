import apiClient from './api-client'

export const get = (options = {}) => {
  return apiClient
    .get('/api/provinces', options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (provinceCode, options = {}) => {
  return apiClient
    .get(`/api/provinces/${provinceCode}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, find }
