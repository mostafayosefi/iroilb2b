import {createApp} from 'vue';
import App from './App.vue';
import router from './router';
import {createI18n} from 'vue-i18n';
import fa from './language/fa.json';
import en from './language/en.json';
import VueCookies from 'vue3-cookies'
import axios from 'axios';
import VueGoodTablePlugin from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css'
import FlagIcon from 'vue-flag-icon'
// site class
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';
import Site from './Site.vue';
import rate from 'vue-rate'
import Vue3PersianDatetimePicker from 'vue3-persian-datetime-picker'

const i18n = createI18n({
    messages: {
        fa: fa,
        en: en
    },
    locale: 'fa',
    fallbackLocale: 'fa'
});
var link = 'https://iroilb2b.com/'
//var link = 'http://127.0.0.1:8000/'
axios.defaults.baseURL = link + 'api/v1';
axios.defaults.headers.post['Content-Type'] = 'application/json; charset=UTF-8';
axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

// admin class

const app = createApp(App);
app.use(FlagIcon);
app.use(i18n);
app.use(router);
app.use(VueGoodTablePlugin);
app.use(VueCookies);
app.config.globalProperties.$hostname = link;
app.mount('#app');

const site = createApp(Site);
site.use(Vue3PersianDatetimePicker, {
    name: 'CustomDatePicker',
    props: {
        format: 'YYYY-MM-DD',
        displayFormat: 'jYYYY-jMM-jDD',
        editable: false,
        altFormat: 'YYYY-MM-DD',
        color: '#495464',
        autoSubmit: true,
    }
})
site.use(FlagIcon);
site.use(VueTelInput);
site.use(router);
const sitei18n = createI18n({
    messages: {
        fa: fa,
        en: en
    },
    locale: 'en',
    fallbackLocale: ['fa', 'en']
});
site.use(rate);
site.use(sitei18n);
site.use(VueCookies);
site.config.globalProperties.$sitename = link;
site.mount('#site');

