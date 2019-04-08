import apiClient from './api-client'

export const list = params => {
  return apiClient
    .get('/api/employees', { params })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, params) => {
  return apiClient
    .get(`/api/employees/${id}`, { params })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = data => {
  return apiClient
    .post('/api/employees', data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data) => {
  return apiClient
    .put(`/api/employees/${id}`, data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = id => {
  return apiClient
    .delete(`/api/employees/${id}`)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { list, store, update, destroy }
