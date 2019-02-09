import httpClient from '@/http-client'

export default {
  list({ option = {}, config = {} }) {
    return httpClient
      .get('/api/products', option, config)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  find(productId, { option = {}, config = {} }) {
    return httpClient
      .get(`/api/products/${productId}`, option, config)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  store(newProduct, { option = {}, config = {} }) {
    return httpClient
      .post('/api/products', newProduct, option, config)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  update(product, { option = {}, config = {} }) {
    return httpClient
      .put(`/api/products/${product.id}`, product, option, config)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  },
  destroy(product, { option = {}, config = {} }) {
    return httpClient
      .delete(`/api/products/${product.id}`, option, config)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response.data))
  }
}
