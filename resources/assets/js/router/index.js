import vue from 'vue';
import Router from 'vue-router';

vue.use(Router);

export default new Router({
  mode: 'history',
  activeLinkClass: 'active',
  routes: [
    {
      path: '/',
      component: () => import(/* webpackChunkName: "dashboard" */ '../pages/Dashboard.vue')
    }
  ]
})