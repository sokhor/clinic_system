require('./bootstrap');
import Vue from 'vue';
import router from './router';
import Application from './components/Application.vue';

Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));
Vue.component('spacer', require('./components/Spacer.vue'));

const app = new Vue({
    el: '#application',
    router,
    render: h => h(Application)
});
