import httpClient from '@/http-client'

export default {
  list() {
    return httpClient
      .get('/api/queues')
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response))
  },
  store(data) {
    return httpClient
      .post('/api/queues', data)
      .then(response => Promise.resolve(response.data))
      .catch(error => Promise.reject(error.response))
  }
}
