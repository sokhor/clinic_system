import apiClient from './api-client'

export const get = (options = {}) => {
  return apiClient
    .get('/api/users', options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const find = (id, options = {}) => {
  return apiClient
    .get(`/api/users/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const store = (data, options = {}) => {
  return apiClient
    .post('/api/users', data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const update = (id, data, options = {}) => {
  return apiClient
    .put(`/api/users/${id}`, data, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const destroy = (id, options = {}) => {
  return apiClient
    .delete(`/api/users/${id}`, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const resetPassword = (
  id,
  { password, password_confirmation },
  options = {}
) => {
  return apiClient
    .put(
      `/api/users/${id}/password/reset`,
      { password, password_confirmation },
      options
    )
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const attachRoles = (id, roles, options = {}) => {
  return apiClient
    .post(`/api/users/${id}/roles`, { roles }, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export const detachRoles = (id, { roles }, options = {}) => {
  return apiClient
    .put(`/api/users/${id}/roles`, roles, options)
    .then(response => Promise.resolve(response.data))
    .catch(error => Promise.reject(error.response))
}

export default { get, find, store, update, destroy, attachRoles, detachRoles }
