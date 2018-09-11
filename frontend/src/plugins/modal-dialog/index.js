import Vue from 'vue'
import { create } from './create'
import DialogsWrapper from './wrapper'
import confirmDelete from './confirm-delete.vue'

export { create, DialogsWrapper, Vue as DialogComponent }

/** vue-modal-dialogs plugin installer */
export default {
  install(Vue, options) {
    Vue.component('DialogsWrapper', DialogsWrapper)

    Vue.prototype.$confirmDelete = (...args) => {
      if (typeof args[0] === 'object') {
        let {
          title,
          content,
          yes = 'Yes',
          yesValue = true,
          no = 'No',
          noValue = false
        } = args[0]

        return create(confirmDelete)({
          title,
          content,
          yes,
          yesValue,
          no,
          noValue
        })
      }

      return create(confirmDelete, 'title', 'content')('Warning', args[0])
    }
  }
}
