import apiClient from '../api-client'

export const get = (options = {}) => {
  return apiClient
    .get('/api/companies', options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = (data, options = {}) => {
  return apiClient
    .post('/api/companies', data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

