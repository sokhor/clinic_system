export default [
  {
    path: '/passport',
    name: 'passport',
    meta: {
      authRequired: true
    },
    component: () =>
      import(/* webpackChunkName: "passport" */ '@/pages/passport')
  }
]
