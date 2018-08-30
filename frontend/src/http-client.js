import axios from 'axios'
// import sentry from '@sentry/browser';
import store from './store'

const getClient = (baseUrl = null) => {
  const options = {
    baseURL: baseUrl,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  }

  if (store && store.getters['auth/isAuthenticated']) {
    options.headers = {
      Authorization: `Bearer ${store.getters['auth/accessToken']}`
    }
  }

  const client = axios.create(options)

  client.interceptors.request.use(
    requestConfig => requestConfig,
    requestError => {
      // sentry.captureException(requestError);

      return Promise.reject(requestError)
    }
  )

  client.interceptors.response.use(
    response => response,
    error => {
      if (error.response.status >= 500) {
        // sentry.captureException(error);
      }

      return Promise.reject(error)
    }
  )

  return client
}

class HttpClient {
  constructor(baseUrl = null) {
    this.client = getClient(baseUrl)
  }

  get(url, conf = {}) {
    return this.client
      .get(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }

  delete(url, conf = {}) {
    return this.client
      .delete(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }

  head(url, conf = {}) {
    return this.client
      .head(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }

  options(url, conf = {}) {
    return this.client
      .options(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }

  post(url, data = {}, conf = {}) {
    return this.client
      .post(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }

  put(url, data = {}, conf = {}) {
    return this.client
      .put(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }

  patch(url, data = {}, conf = {}) {
    return this.client
      .patch(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }
}

export { HttpClient }

export default {
  get(url, conf = {}) {
    return getClient()
      .get(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  delete(url, conf = {}) {
    return getClient()
      .delete(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  head(url, conf = {}) {
    return getClient()
      .head(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  options(url, conf = {}) {
    return getClient()
      .options(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  post(url, data = {}, conf = {}) {
    return getClient()
      .post(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  put(url, data = {}, conf = {}) {
    return getClient()
      .put(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  patch(url, data = {}, conf = {}) {
    return getClient()
      .patch(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }
}
