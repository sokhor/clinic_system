import camelCase from 'lodash/camelCase'

const requireModule = require.context('.', true, /^((?!\.unit\.).)*\.js$/)
const root = { modules: {} }

console.log(requireModule.keys())

requireModule.keys().forEach(fileName => {
  if (fileName === './index.js') return

  const modulePath = fileName
    .replace(/^\.\//, '')
    .replace(/\.\w+$/, '')
    .split(/\//)
    .map(camelCase)

  const { modules } = getNamespace(root, modulePath)

  modules[modulePath.pop()] = {
    namespaced: true,
    ...requireModule(fileName)
  }

  function getNamespace(subtree, path) {
    if (path.length === 1) return subtree

    const namespace = path.shift()
    subtree.modules[namespace] = { modules: {}, ...subtree.modules[namespace] }
    return getNamespace(subtree.modules[namespace], path)
  }
})

export default root.modules
