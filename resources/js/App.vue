<template>
    <section v-show="isLoading" class="blur" v-if="$cookies.isKey('user') && $cookies.get('user').role!='user'">
        <img class="loader" src="/images/loading.svg" alt="loading">
    </section>
    <sideBarMobile :user="user" @loading="loading()"
                   v-if="$cookies.isKey('user') && $cookies.get('user').rol!='user'">
    </sideBarMobile>
    <main class="flex overflow-hidden"
          v-if="$cookies.isKey('user') && $cookies.get('user').role!='user'">
        <sideBarDesktop :user="user" @loading="loading()"></sideBarDesktop>

        <router-view :user="user" :loading="isLoading" :key="$route.path"
                     @loading="loading()" @loadingHide="loadingHide()">
        </router-view>
    </main>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    components: {
        "sideBarMobile": defineAsyncComponent(() => import('./components/layout/sidebar-admin-mobile.vue')),
        "sideBarDesktop": defineAsyncComponent(() => import('./components/layout/sidebar-admin-desktop.vue'))
    },
    data() {
        return {
            lang: 'fa',
            isLoading: true,
            user: {
                name: '',
                role: {
                    dashboard: [],
                    post: [],
                    category: [],
                    label: [],
                    page: [],
                    operator: [],
                    table: [],
                    forms: [],
                    settings: [],
                    redirect: [],
                    users: [],
                    notificate: [],
                    product: [],
                    tag: [],
                    company: [],
                    ads: [],
                    support: []
                }
            }
        }
    },
    methods: {
        loading() {
            this.isLoading = true;
        },
        loadingHide() {
            this.isLoading = false;
        },
    },
    async beforeCreate() {
        if (this.$cookies.isKey('user')) {
            if (this.$cookies.get('user').role == 'user') {
                this.$cookies.remove('user');
                window.location.replace(this.$hostname + 'en/account');
            } else {
                document.body.style.backgroundColor = 'rgba(73, 84, 100 ,1 )'
                await axios.get('/user', {
                    params: {
                        'api_token': this.$cookies.get('user').token,
                        'id': this.$cookies.get('user').id
                    }
                }).then(response => {
                    this.user.name = response.data.name
                    this.user.role.dashboard = response.data.role.dashboard
                    this.user.role.post = response.data.role.post
                    this.user.role.category = response.data.role.category
                    this.user.role.label = response.data.role.label
                    this.user.role.page = response.data.role.page
                    this.user.role.operator = response.data.role.operator
                    this.user.role.table = response.data.role.table
                    this.user.role.forms = response.data.role.forms
                    this.user.role.settings = response.data.role.settings
                    this.user.role.redirect = response.data.role.redirect
                    this.user.role.users = response.data.role.users
                    this.user.role.notificate = response.data.role.notificate
                    this.user.role.product = response.data.role.product
                    this.user.role.tag = response.data.role.tag
                    this.user.role.company = response.data.role.company
                    this.user.role.ads = response.data.role.ads
                    this.user.role.support = response.data.role.support
                })
            }
        } else {
            window.location.replace(this.$hostname + 'en/account');
        }

        const recaptchaScript = document.createElement("script");
        recaptchaScript.setAttribute(
            "src",
            "/js/app.js"
        );
        document.head.appendChild(recaptchaScript);
    },
}
</script>

