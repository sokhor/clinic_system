import Vue from 'vue'
import { upperFirst, camelCase } from 'lodash'

const requireComponent = require.context('.', true, /_base-[\w-]+$/)

requireComponent.keys().forEach(fileName => {
  const componentConfig = requireComponent(fileName)
  const componentName = upperFirst(
    camelCase(fileName.replace(/^\.\/_/, '').replace(/\.\w+$/, ''))
  )

  Vue.component(componentName, componentConfig.default || componentConfig)
})
