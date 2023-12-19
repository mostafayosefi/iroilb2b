<template>
    <siteHeader :site="site" :user="user" :show="load"></siteHeader>
    <section class="flex mb-14">
        <aside
            class="bg-dark-primary md:w-2/6 xl:w-1/6 min-h-[calc(100vh-140px)] hidden md:flex flex-wrap content-between">
            <panelSideBar :site="site" :user="user"></panelSideBar>
        </aside>
        <div class="w-full px-1 md:px-7 md:w-4/6 xl:w-5/6">
            <div class="w-full">
                <div class="w-full">
                    <div class="w-full md:flex py-2 justify-center">
                        <router-link :to="{name:'siteSupport'}"
                                     class="block px-4 py-2 bg-white-primary rounded-xl mx-2 my-2 md:my-0">
                            <i class="fe fe-message-circle"></i>
                            {{ $t('support', language) }}
                        </router-link>
                        <router-link :to="{name:'siteProfile'}"
                                     class="block px-4 py-2 bg-white-primary rounded-xl mx-2 my-2 md:my-0">
                            <i class="fe fe-user"></i>
                            {{ $t('profile-setting', language) }}
                        </router-link>
                        <router-link :to="{name:'siteLivePrice'}"
                                     class="block px-4 py-2 bg-white-primary rounded-xl mx-2 my-2 md:my-0">
                            <span class="relative inline-flex">
                                  <span class="flex h-3 w-3 ">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                  </span>
                            </span>
                            {{ $t('global-prices-petroleum-products', language) }}
                        </router-link>
                        <router-link :to="{name:'sitePanelCompany'}"
                                     class="block px-4 py-2 bg-white-primary rounded-xl mx-2 my-2 md:my-0">
                            <i class="fe fe-compass"></i>
                            {{ $t('company-managment', language) }}
                        </router-link>
                        <router-link :to="{name:'sitePanelAds'}"
                                     class="block px-4 py-2 bg-white-primary rounded-xl mx-2 my-2 md:my-0">
                            <i class="fe fe-tag"></i>
                            {{ $t('my-ads', language) }}
                        </router-link>
                    </div>
                    <!--   steps         -->
                    <p class="mx-auto text-center py-2">
                        {{ $t('welcome', language) }}
                        {{ user.step!='four'?$t('start-terms', language):'' }}
                    </p>
                    <div v-show="user.step!='four'" class="md:w-2/3 mx-auto p-2 space-y-6 md:space-y-0 md:p-4 md:space-x-2 mt-4 md:flex"
                         :class="language=='fa'?'md:space-x-reverse':''">
                        <router-link :to="{name:'sitePanelCompany'}"
                                     class="w-full float-right md:w-1/3 bg-gradient-to-b from-dark-primary to-slate-800 hover:bg-gradient-to-r rounded-xl text-white p-2 relative shadow-md animate-fade-down"
                                     :class="user.step=='one'?'border-red-500 border-b-2':''">
                            <div
                                class="absolute top-[-20px] w-[50px] h-[50px] bg-gradient-to-t from-slate-800 to-slate-500 rounded-full flex items-center justify-center text-2xl font-bold"
                                :class="user.step=='one'?(language=='fa'?'right-5 border-red-500 border-b-2' :'left-5 border-red-500 border-b-2'):(language=='fa'?'right-5' :'left-5')">
                                1
                            </div>
                            <h2 class="mt-8 mx-2 font-bold">
                                {{ $t('company-step', language) }}
                            </h2>
                            <p class="mx-2 mt-2 text-white-primary">
                                {{ $t('company-step-message', language) }}
                            </p>
                        </router-link>
                        <router-link :to="{name:'sitePanelAds'}"
                                     class="w-full float-right md:w-1/3 bg-gradient-to-b from-dark-primary to-slate-800 hover:bg-gradient-to-r rounded-xl text-white p-2 relative shadow-md animate-fade-down"
                                     :class="user.step=='tow'?'border-red-500 border-b-2':''">
                            <div
                                class="absolute top-[-20px] w-[50px] h-[50px] bg-gradient-to-t from-slate-800 to-slate-500 rounded-full flex items-center justify-center text-2xl font-bold"
                                :class="user.step=='tow'?(language=='fa'?'right-5 border-red-500 border-b-2' :'left-5 border-red-500 border-b-2'):(language=='fa'?'right-5' :'left-5')">
                                2
                            </div>
                            <h2 class="mt-8 mx-2 font-bold">
                                {{ $t('ad-step', language) }}
                            </h2>
                            <p class="mx-2 mt-2 text-white-primary">
                                {{ $t('ad-step-message', language) }}
                            </p>
                        </router-link>
                        <router-link :to="{name:'siteFeedBack'}"
                                     class="w-full float-right md:w-1/3 bg-gradient-to-b from-dark-primary to-slate-800 hover:bg-gradient-to-r rounded-xl text-white p-2 relative shadow-md animate-fade-down"
                                     :class="user.step=='three'?'border-red-500 border-b-2':''">
                            <div
                                class="absolute top-[-20px] w-[50px] h-[50px] bg-gradient-to-t from-slate-800 to-slate-500 rounded-full flex items-center justify-center text-2xl font-bold"
                                :class="user.step=='three'?(language=='fa'?'right-5 border-red-500 border-b-2' :'left-5 border-red-500 border-b-2'):(language=='fa'?'right-5' :'left-5')">
                                3
                            </div>
                            <h2 class="mt-8 mx-2 font-bold">
                                {{ $t('feed-step', language) }}
                            </h2>
                            <p class="mx-2 mt-2 text-white-primary">
                                {{ $t('feed-step-message', language) }}
                            </p>
                        </router-link>
                    </div>

                    <div class="p-4 float-right w-full" v-if="notificate[0]">
                        <p class="border-b pb-2 font-bold">
                            {{ $t('last-messages', language) }}
                        </p>
                        <div v-for="not in notificate" class="mt-2 bg-white-secondary rounded-xl p-2 my-2">
                            <div class="flex justify-between">
                               <span>
                                    {{ $t('message-from', language) + " " + not.sender }}
                               </span>
                                <button @click="show=not.id" class="rounded-xl bg-white-primary p-2 text-xs">
                                    {{ $t('view', language) }}
                                </button>

                            </div>
                            <small class="text-slate-400">
                                {{ not.time }}
                            </small>
                            <p v-show="show==not.id">
                                {{ not.message }}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "panelSideBar": defineAsyncComponent(() => import('./../layout/side-bar-panel.vue')),
    },
    emits: ['getUser'],
    data() {
        return {
            language: this.$route.params.lang,
            notificate: [],
            show: '',
            load: true
        }
    },
    methods: {
        loading() {
            this.load = false;
        },
    },
    async beforeCreate() {
        await axios.get('/user/notification', {
            params: {
                'api_token': this.$cookies.get('user').token,
                'id': this.$cookies.get('user').id,
                'language': this.$route.params.lang,
            }
        }).then(response => {
            this.notificate = [];
            if (response.data.notificate) {
                for (const responseElement of response.data.notificate) {
                    this.notificate.push({
                        id: responseElement.id,
                        message: responseElement.message,
                        status: responseElement.status,
                        sender: responseElement.sender,
                        time: responseElement.time,
                    });
                }
            }
        })
        document.title = this.$t('dashboard', this.language) + " | " + this.site.title
        this.loading();
    },
}
</script>

