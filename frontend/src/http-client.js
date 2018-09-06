import axios from 'axios'
// import sentry from '@sentry/browser';
import store from './store'
import NProgress from '@/nprogress'

const nprogress = new NProgress()

const getClient = ({ baseUrl = null, showProgressBar = false } = {}) => {
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
    requestConfig => {
      if (showProgressBar) {
        nprogress.initProgress()
      }

      return requestConfig
    },
    requestError => {
      // sentry.captureException(requestError);
      return Promise.reject(requestError)
    }
  )

  client.interceptors.response.use(
    response => {
      if (showProgressBar) {
        nprogress.increase()
      }

      return response
    },
    error => {
      if (error.response.status >= 500) {
        // sentry.captureException(error);
      }

      if (showProgressBar) {
        nprogress.increase()
      }

      return Promise.reject(error)
    }
  )

  return client
}

export default {
  get(url, conf = {}, options = {}) {
    return getClient(options)
      .get(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  delete(url, conf = {}, options = {}) {
    return getClient(options)
      .delete(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  head(url, conf = {}, options = {}) {
    return getClient(options)
      .head(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  options(url, conf = {}, options = {}) {
    return getClient(options)
      .options(url, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  post(url, data = {}, conf = {}, options = {}) {
    return getClient(options)
      .post(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  put(url, data = {}, conf = {}, options = {}) {
    return getClient(options)
      .put(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  },
  patch(url, data = {}, conf = {}, options = {}) {
    return getClient(options)
      .patch(url, data, conf)
      .then(response => Promise.resolve(response))
      .catch(error => Promise.reject(error))
  }
}
