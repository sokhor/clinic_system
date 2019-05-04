import apiClient from './api-client'

export const get = params => {
  return apiClient
    .get('/api/users', { params })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, params) => {
  return apiClient
    .get(`/api/users/${id}`, { params })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = data => {
  return apiClient
    .post('/api/users', data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data) => {
  return apiClient
    .put(`/api/users/${id}`, data)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = id => {
  return apiClient
    .delete(`/api/users/${id}`)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const resetPassword = (id, { password, password_confirmation }) => {
  return apiClient
    .put(`/api/users/${id}/password/reset`, { password, password_confirmation })
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const attachRoles = (id, roles) => {
  return apiClient
    .post(`/api/users/${id}/roles`, roles)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const dettachRoles = (id, roles) => {
  return apiClient
    .put(`/api/users/${id}/roles`, roles)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, store, update, destroy }
