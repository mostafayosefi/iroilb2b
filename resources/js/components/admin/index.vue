<template>
    <div class="content">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('dashboard')"/>
        <div v-show="!user.role.dashboard.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.dashboard.show" class="intro-y mt-2 flex">
            <div v-show="user.role.post.show" class="box p-5 w-1/4 mx-2">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-box" data-v-bf726dba="">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <div class="mr-auto">
                        <div class="report-box__indicator text-lg bg-theme-20 px-2 text-white rounded">
                            {{ count.post }}
                        </div>
                    </div>
                </div>
                <div class="text-base text-gray-600 mt-1">{{ $t('articles') }}</div>
            </div>
            <div v-show="user.role.company.show" class="box p-5 w-1/4 mx-2">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-briefcase" data-v-bf726dba="">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    <div class="mr-auto">
                        <div class="report-box__indicator text-lg bg-theme-24 px-2 text-white rounded">
                            {{ count.company }}
                        </div>
                    </div>
                </div>
                <div class="text-base text-gray-600 mt-1">{{ $t('companies') }}</div>
            </div>
            <div v-show="user.role.users.show" class="box p-5 w-1/4 mx-2 ">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-users" data-v-bf726dba="">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <div class="mr-auto">
                        <div class="report-box__indicator text-lg bg-theme-1 px-2 text-white rounded">{{ count.user }}
                        </div>
                    </div>
                </div>
                <div class="text-base text-gray-600 mt-1">{{ $t('users') }}</div>
            </div>
            <div v-show="user.role.ads.show" class="box p-5 w-1/4 mx-2">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-paperclip" data-v-bf726dba="">
                        <path
                            d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                    <div class="mr-auto">
                        <div class="report-box__indicator text-lg bg-theme-21 px-2 text-white rounded">{{ count.ad }}
                        </div>
                    </div>
                </div>
                <div class="text-base text-gray-600 mt-1">{{ $t('ads') }}</div>
            </div>
        </div>
        <div class="mt-6 mx-2 intro-y flex font-bold">
            <router-link v-show="user.role.post.show" @click="message('adminPosts')" :to="{name:'adminPosts'}" class="box p-4 mx-2 border-theme-1 w-1/4">
                {{ $t('posts') }}
            </router-link>
            <router-link v-show="user.role.page.show" @click="message('adminPages')" :to="{name:'adminPages'}" class="box p-4 mx-2 w-1/4">
                {{ $t('pages') }}
            </router-link>
            <router-link v-show="user.role.company.show" @click="message('adminCompanies')" :to="{name:'adminCompanies'}" class="box p-4 mx-2 w-1/4">
                {{ $t('companies') }}
            </router-link>
            <router-link v-show="user.role.ads.show" @click="message('adminAdvertisements')" :to="{name:'adminAdvertisements'}"
                         class="box p-4 mx-2 w-1/4">
                {{ $t('advertisements') }}
            </router-link>
        </div>
        <div class="mx-2 py-4 intro-y flex font-bold">
            <router-link v-show="user.role.users.show" @click="message('adminUsers')" :to="{name:'adminUsers'}" class="box p-4 mx-2 w-1/4">
                {{ $t('users') }}
            </router-link>
            <router-link v-show="user.role.tag.show" @click="message('adminUsersMessageView')" :to="{name:'adminCompanyFilter'}"
                         class="box p-4 mx-2 w-1/4">
                {{ $t('filters') }}
            </router-link>
            <router-link v-show="user.role.forms.show" @click="message('adminForms')" :to="{name:'adminForms'}" class="box p-4 mx-2 w-1/4">
                {{ $t('forms') }}
            </router-link>
            <router-link v-show="user.role.support.show" @click="message('adminSupport')" :to="{name:'adminSupport'}" class="box p-4 mx-2 w-1/4">
                {{ $t('support') }}
            </router-link>
        </div>
        <div v-show="user.role.notificate.show" class="mt-4 flex">
            <div class="w-1/2 mx-2 box p-2 border-b2b" v-show="notficate[0]">
               <p class="py-2 px-2 font-bold"> {{ $t('notficate') }}</p>
                <div class="relative flex items-center py-2 border-t b"
                     v-for="item in notficate ">
                    <div class="mr-2 overflow-hidden">
                        <div class="flex items-center">
                            <div class="text-xs text-gray-500 right-0 whitespace-nowrap">{{ item.time }}</div>
                        </div>
                        <div class="w-full truncate left-0 text-gray-600 mt-0.5">
                            {{ item.text }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import {defineAsyncComponent} from "vue";

export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),

    },
    data() {
        return {
            count: {
                post: 0,
                company: 0,
                user: 0,
                ad: 0
            },
            notficate: [],
        }
    },
    methods: {
        message(text) {
            if (this.$route.name != text) {
                return this.$emit('loading');
            }
        }
    },
    beforeCreate() {
        axios.get('/admin/get', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            this.count.post = response.data.count.posts
            this.count.company = response.data.count.companies
            this.count.user = response.data.count.users
            this.count.ad = response.data.count.ads
            this.$emit('loadingHide');
        }).catch(() => {
            this.$emit('loadingHide');
        });
        axios.get('/admin/notficate', {
            params: {
                api_token: this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data.notficate) {
                this.notficate.push({
                    text: responseElement.text,
                    time: responseElement.time,
                });
            }
        })
    },
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('dashboard') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
<style>
.border-b2b{
    border:2px solid #495464;
}
</style>


