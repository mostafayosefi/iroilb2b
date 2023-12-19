<template>
    <!--    loading-->
    <section v-show="show" class="!z-50">
        <div class="fixed top-0 w-full h-full flex justify-center items-center">
            <div class="bg-dark-primary-trans p-5 rounded-2xl flex justify-center items-center">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </section>
    <!--    mobile header-->
    <header class="flex justify-around md:hidden border-b py-5 border-slate-200 bg-white">
        <div class="w-1/4 flex items-center justify-center">
            <div id="sidemenu">
                <button class="sidemenu__btn" v-on:click="navOpen=!navOpen" v-bind:class="{active:navOpen}">
                    <span class="top"></span>
                    <span class="mid"></span>
                    <span class="bottom"></span>
                </button>
                <transition name="translateX">
                    <nav v-show="navOpen">
                        <div class="sidemenu__wrapper mt-4">
                            <div class="w-full flex justify-around items-center border-b py-5 border-slate-200">
                                <router-link v-if="!$cookies.isKey('user')" :to="{name:'siteAccount'}">
                                    <span class="mx-1 bg-white-primary py-2 px-3 rounded-lg duration-300">
                                        {{ $t('login', language) }}
                                    </span>
                                </router-link>
                                <router-link v-if="!$cookies.isKey('user')" :to="{name:'siteSignup'}">
                                    <span class="mx-1 bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                                        {{ $t('signup', language) }}
                                    </span>
                                </router-link>
                                <div>
                                    <select v-model="lang" class="mx-1 bg-dark-secondary text-dark-primary py-2 px-3 rounded-lg">
                                        <option value="fa">{{ $t('persian', language) }}</option>
                                        <option value="en">{{ $t('english', language) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="!$cookies.isKey('user')" class="w-full px-2 text-dark-primary">
                                <router-link v-for="list in site.header"
                                             :to="list.link=='home'?{name:'siteHome'}:{
                                    path:'/'+language+'/'+list.link,
                             }">
                                    <div class="mx-1 hover:bg-white-primary py-2 px-3 my-1 rounded-lg duration-300">
                                        <span v-if="language=='fa'">{{ list.text.fa }}</span>
                                        <span v-if="language=='en'">{{ list.text.en }}</span>
                                    </div>
                                    <hr class="border-gray-200">
                                </router-link>

                            </div>
                            <div v-if="$cookies.isKey('user')" class="w-full px-2 text-dark-primary">
                                <router-link :to="{name:'sitePanel'}" class="block p-4 rounded-lg">
                                    <i class="fe fe-home"></i>
                                    {{ $t('dashboard', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'sitePanelCompany'}" class="block p-4">
                                    <i class="fe fe-compass"></i>
                                    {{ $t('company-managment', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'sitePanelAds'}" class="block p-4">
                                    <i class="fe fe-tag"></i>
                                    {{ $t('my-ads', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'sitePanelBookmark'}" class="block p-4">
                                    <i class="fe fe-bookmark"></i>
                                    {{ $t('bookmarks', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'siteLivePrice'}" class="block p-4">
                                    <span class="relative inline-flex">
                                          <span class="flex h-3 w-3 ">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                          </span>
                                    </span>
                                    {{ $t('global-prices-petroleum-products', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'siteSupport'}" class="block p-4 ">
                                    <i class="fe fe-message-circle"></i>
                                    {{ $t('support', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'siteProfile'}" class="block p-4 ">
                                    <i class="fe fe-user"></i>
                                    {{ $t('profile-setting', language) }}
                                </router-link>
                                <hr class="border-gray-200">
                                <button class="p-4 w-full block" :class="language=='fa'?'text-right':'text-left'"
                                        @click="logout()">
                                    <i class="fe fe-log-out"></i>
                                    {{ $t('logout', language) }}
                                </button>
                            </div>
                        </div>
                    </nav>
                </transition>
            </div>
        </div>
        <div class="w-3/4 flex items-center justify-center">
            <router-link :to="{name:'siteHome'}">
                <img :src="site.logoDark" :alt="site.title" width="140">
            </router-link>
        </div>
    </header>
    <!--    desktop header-->
    <header class="hidden md:flex justify-between border-b py-5 border-slate-200 bg-white z-10">
        <div class="w-3/4 m-auto flex justify-between">
            <router-link :to="{name:'siteHome'}">
                <img :src="site.logoDark" :alt="site.title" width="140">
            </router-link>
            <div class="w-3/4 flex items-center">
                <ul class="flex justify-between text-dark-primary text-sm w-full items-center">
                    <div class="w-1/2 flex items-center">
                        <router-link v-for="list in site.header"
                                     :to="list.link=='home'?{name:'siteHome'}:{
                                    path:'/'+language+'/'+list.link,
                             }">
                            <li class="mx-1 hover:bg-white-primary py-2 px-3 rounded-lg duration-300">
                                <span v-if="language=='fa'">{{ list.text.fa }}</span>
                                <span v-if="language=='en'">{{ list.text.en }}</span>
                            </li>
                        </router-link>
                    </div>
                    <div class="w-1/2 flex justify-end">
                        <router-link v-if="!$cookies.isKey('user')" :to="{name:'siteAccount'}">
                            <li class="mx-1 bg-white-primary py-2 px-3 rounded-lg duration-300">
                                {{ $t('login', language) }}
                            </li>
                        </router-link>
                        <router-link v-if="!$cookies.isKey('user')" :to="{name:'siteSignup'}">
                            <li class="mx-1 bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                                {{ $t('signup', language) }}
                            </li>
                        </router-link>
                        <a v-if="$cookies.isKey('user') && $cookies.get('user').role=='admin'"
                           :href="$sitename + 'fa/admin'" target="_blank">
                            <li class="mx-1 bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                                {{ $t('dashboard', language) }}
                            </li>
                        </a>
                        <Popper v-if="$cookies.isKey('user')">
                            <button class="mx-1 bg-white-primary py-2 px-3 rounded-lg duration-300">
                                <span class="mx-2 text-sm">  {{ user.name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-down inline">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <template #content>
                                <div>
                                    <router-link :to="{name:'sitePanel'}" class="block my-2 !text-white-primary">
                                        {{ $t('user-panel', language) }}

                                    </router-link>
                                    <hr class="border-gray-500">
                                    <router-link :to="{name:'sitePanelCompany'}"
                                                 class="block my-2 !text-white-primary">
                                        {{ $t('company-managment', language) }}
                                    </router-link>
                                    <hr class="border-gray-500">
                                    <router-link :to="{name:'sitePanelAds'}" class="block my-2 !text-white-primary">
                                        {{ $t('my-ads', language) }}
                                    </router-link>
                                    <hr class="border-gray-500">
                                    <router-link :to="{name:'siteSupport'}" class="block my-2 !text-white-primary">
                                        {{ $t('support', language) }}
                                    </router-link>
                                    <hr class="border-gray-500">
                                    <button class="my-2" @click="logout()">
                                        {{ $t('logout', language) }}
                                    </button>
                                </div>
                            </template>
                        </Popper>
                        <div v-show="language=='en'" class="py-2 px-1" @click="flagShow=!flagShow">
                            <span class="fi fi-us"></span>
                            <a :href="$route.href.replace('en', 'fa')">
                                <span v-show="flagShow" class="fi fi-ir mx-1"></span>
                            </a>
                        </div>
                        <div v-show="language=='fa'" class="py-2 px-1" @click="flagShow=!flagShow">
                            <span class="fi fi-ir"></span>
                            <a :href="$route.href.replace('fa', 'en')">
                                <span v-show="flagShow" class="fi fi-us mx-1"></span>
                            </a>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </header>
    <!--    mobile nav bar-->
    <nav
        class="fixed bottom-0 z-10 bg-white flex md:hidden w-full shadow-[0_-2px_5px_0px_rgba(215,215,215,0.7)] text-sm">
        <router-link :to="{name:'sitePanel'}" class="block p-4 w-1/5 flex flex-col items-center">
            <i class="fe fe-compass mb-2"></i>
            {{ $t('profile', language) }}
        </router-link>
        <router-link :to="{name:'siteSupport'}" class="block p-4 w-1/5 flex flex-col items-center">
            <i class="fe fe-message-circle mb-2"></i>
            {{ $t('support', language) }}
        </router-link>
        <router-link :to="{name:'siteHome'}" class="block p-4 w-1/5 flex flex-col items-center">
            <i class="fe fe-home mb-2"></i>
            {{ $t('home', language) }}
        </router-link>
        <router-link :to="{name:'siteSearch'}" class="block p-4 w-1/5 flex flex-col items-center">
            <i class="fe fe-search mb-2"></i>
            {{ $t('search', language) }}
        </router-link>
        <router-link :to="{name:'siteAds'}" class="block p-4 w-1/5 flex flex-col items-center whitespace-nowrap">
            <i class="fe fe-tag mb-2"></i>
            {{ $t('short-ads', language) }}
        </router-link>
    </nav>
    <!--    dektop navbar-->
    <nav class="fixed bottom-0 z-10 bg-white hidden md:flex w-full shadow-[0_-2px_5px_0px_rgba(215,215,215,0.7)]">
        <router-link :to="{name:'sitePanel'}" class="block p-4 w-1/4 text-center">
            <i class="fe fe-compass"></i>
            {{ $t('profile', language) }}
        </router-link>
        <router-link :to="{name:'siteSupport'}" class="block p-4 w-1/4 text-center">
            <i class="fe fe-message-circle"></i>
            {{ $t('support', language) }}
        </router-link>
        <router-link :to="{name:'siteHome'}" class="block p-4 w-1/4 text-center">
            <i class="fe fe-home"></i>
            {{ $t('home', language) }}
        </router-link>
        <router-link :to="{name:'siteSearch'}" class="block p-4 w-1/4 text-center">
            <i class="fe fe-search"></i>
            {{ $t('search', language) }}
        </router-link>
        <router-link :to="{name:'siteAds'}" class="block p-4 w-1/4 text-center">
            <i class="fe fe-tag"></i>
            {{ $t('short-ads', language) }}
        </router-link>
    </nav>
    <!--    fix social meno icon-->
    <section class="fixed z-30" :class="language=='fa'?'left-0':'right-1'" style="width: 40px;">
        <a class="float-left p-2 block my-1 border-solid border-2" target="_blank"
           :class="language=='fa'?'border-r-slate-500 rounded-r-2xl':'border-l-slate-500 rounded-l-2xl'"
           v-for="menu in site.menu" :style="'background:'+ menu.color+';'"
           :href="menu.link">
            <i :class="menu.icon"></i>
        </a>
    </section>
</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";
import Popper from "vue3-popper";

export default {
    components: {
        Popper,
    },
    props: {
        site: Object,
        user: Object,
        show: Boolean
    },
    data() {
        return {
            navOpen: false,
            flagShow: false,
            arrayOfObjects: [],
            object: {
                name: 'Object Name',
            },
            language: this.$route.params.lang,
            lang: this.$route.params.lang
        }
    },
    watch: {
        lang(oldLang, newLang) {
            if ('fa' == this.language) {
                window.location.replace(this.$route.href.replace('fa', 'en'));
            }else{
                window.location.replace(this.$route.href.replace('en', 'fa'));
            }
        }
    },
    methods: {
        methodToRunOnSelect(payload) {
            this.object = payload;
        },
        logout() {
            this.$cookies.remove('user');
            this.$router.push({name: 'siteAccount'})
        }
    },
}
</script>

<style>
:root {
    --popper-theme-background-color: #495464;
    --popper-theme-background-color-hover: #495464;
    --popper-theme-text-color: #F4F4F2;
    --popper-theme-border-width: 0px;
    --popper-theme-border-style: solid;
    --popper-theme-border-radius: 6px;
    --popper-theme-padding: 5px 20px;
}
</style>
<style scoped>
.n-active {
    color: #ea1b1b;
}
</style>
