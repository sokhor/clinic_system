import nprogress from 'nprogress'

export default class NProgress {
  constructor() {
    this.requestsTotal = 0
    this.requestsCompleted = 0
    this.confirmed = true
    this.latencyThreshold = 100

    nprogress.configure({ showSpinner: false })
  }

  setComplete() {
    this.requestsTotal = 0
    this.requestsCompleted = 0
    nprogress.done()
  }

  initProgress() {
    if (0 === this.requestsTotal) {
      setTimeout(() => nprogress.start(), this.latencyThreshold)
    }
    this.requestsTotal++
    nprogress.set(this.requestsCompleted / this.requestsTotal)
  }

  increase() {
    // Finish progress bar 50 ms later
    setTimeout(() => {
      ++this.requestsCompleted
      if (this.requestsCompleted >= this.requestsTotal) {
        this.setComplete()
      } else {
        nprogress.set(this.requestsCompleted / this.requestsTotal - 0.1)
      }
    }, this.latencyThreshold + 50)
  }
}
