import apiClient from '../api-client'

export const store = (data, options = {}) => {
  return apiClient
    .post('/api/companies', data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

