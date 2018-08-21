import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "dashboard",
      component: () =>
        import(/* webpackChunkName: "dashboard" */ "./pages/Dashboard.vue")
    },
    {
      path: "/user",
      name: "user",
      component: () =>
        import(/* webpackChunkName: "user" */ "./pages/user")
    }
  ]
});
