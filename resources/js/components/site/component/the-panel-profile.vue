<template>
    <siteHeader :site="site" :user="user" :show="load"></siteHeader>
    <!--        Loader       -->
    <div v-show="isLoading" class="h-screen w-screen fixed flex items-center justify-center !z-50">
        <section
            class="w-[200px] h-[100px] bg-dark-primary-trans p-5 rounded-2xl flex justify-center items-center blur-panel">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </section>
    </div>
    <section class="flex">
        <aside
            class="bg-dark-primary md:w-2/6 xl:w-1/6 min-h-[calc(100vh-140px)] hidden md:flex flex-wrap content-between">
            <panelSideBar :site="site" :user="user"></panelSideBar>
        </aside>
        <div class="w-full mx-7 md:w-4/6 xl:w-5/6">
            <section v-show="user.step=='one'"
                     class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                    <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize">  {{ $t('step', language) }} (1/3) :</b>
                        {{ $t('step-one', language) }}
                    </span>
                </div>
                <router-link :to="{name:'sitePanelCompany'}"
                             class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                    {{ $t('company-step', language) }}
                </router-link>
            </section>
            <section v-show="user.step=='tow'"
                     class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                    <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize">  {{ $t('step', language) }} (2/3) :</b>
                        {{ $t('step-tow', language) }}
                    </span>
                </div>
                <router-link :to="{name:'sitePanelAds'}"
                             class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                    {{ $t('ad-step', language) }}
                </router-link>
            </section>
            <section v-show="user.step=='three'"
                     class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                    <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize">  {{ $t('step', language) }} (3/3) :</b>
                        {{ $t('step-three', language) }}
                    </span>
                </div>
                <router-link :to="{name:'siteFeedBack'}"
                             class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                    {{ $t('feed-step', language) }}
                </router-link>
            </section>
            <div class="my-4 border-b-2">
                <button @click="show='one'" class="mx-2 pb-4 font-bold"
                        :class="show=='one'?'border-b-2 border-dark-primary':''">
                    {{ $t('notificate-setting', language) }}
                </button>
                <button :class="show=='tow'?'border-b-2 border-dark-primary':''" @click="show='tow'"
                        class="mx-2 pb-4 font-bold">
                    {{ $t('change-password', language) }}
                </button>
            </div>

            <div class="px-2" v-show="show=='one'">
                <div class="text-justify">
                    <input v-model="setting.postemail" type="checkbox" class="mx-2 accent-dark-primary" id="email">
                    <label for="email"> {{ $t('email-notificate', language) }}</label>
                </div>
                <div class="text-justify">
                    <input v-model="setting.advsms" type="checkbox" class="mx-2 accent-dark-primary" id="phone">
                    <label for="phone"> {{ $t('phone-notificate', language) }}</label>
                </div>
                <button @click="updateSetting()"
                        class="my-4 block bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                    {{ $t('ok', language) }}
                </button>
            </div>
            <div class="px-2" v-show="show=='tow'">
                <div v-show="status=='one' || status=='three' || status=='five'">
                    <div v-show="status=='five'" class="text-green-700 mb-2">
                        {{ $t('changed-password', language) }}
                    </div>
                    {{ $t('current-password', language) }}:
                    <input dir="ltr" v-model="password" type="password"
                           class="w-full md:w-1/2 border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                    <button @click="checkPassword()" :disabled="password==''"
                            class="my-4 block bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                        {{ $t('check', language) }}
                    </button>
                    <span v-show="status=='three'" class="text-red-700">
                         {{ $t('wrong-password', language) }}
                    </span>
                </div>
                <div v-show="status=='tow' || status=='four'">
                    <div>
                        {{ $t('new-password', language) }}:
                        <input dir="ltr" v-model="newPassword" type="password"
                               class="border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                    </div>
                    <div class="mt-2">
                        {{ $t('repeat-password', language) }}:
                        <input dir="ltr" v-model="repeatPassword" type="password"
                               class="border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                    </div>
                    <button @click="changePassword()" :disabled="newPassword=='' || repeatPassword==''"
                            class="my-4 block bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                        {{ $t('edit', language) }}
                    </button>
                    <span v-show="status=='four'" class="text-red-700">
                         {{ $t('password-wrong', language) }}
                    </span>
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
            show: 'one',
            isLoading: false,
            setting: {
                postemail: false,
                advsms: false
            },
            password: '',
            newPassword: '',
            repeatPassword: '',
            status: 'one',
            load: true,
        }
    },
    methods: {
        loading() {
            this.load = false;
        },
        updateSetting() {
            this.isLoading = true;
            const sentData = {
                api_token: this.$cookies.get('user').token,
                id: this.$cookies.get('user').id,
                setting: this.setting,
            }
            axios.post("/notification/setting", sentData).then((response) => {
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },
        checkPassword() {
            this.isLoading = true;
            const sentData = {
                api_token: this.$cookies.get('user').token,
                id: this.$cookies.get('user').id,
                password: this.password,
            }
            axios.post("/user/check", sentData).then((response) => {
                if (response.data.status == 'ok') {
                    this.status = 'tow';
                } else {
                    this.status = 'three';
                }
                this.password = '';
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },
        changePassword() {
            if (this.newPassword == this.repeatPassword) {
                this.isLoading = true;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    id: this.$cookies.get('user').id,
                    password: this.newPassword,
                }
                axios.post("/user/changepassword", sentData).then((response) => {
                    if (response.data.status == 'ok') {
                        this.status = 'five';
                        this.newPassword = '';
                        this.repeatPassword = '';
                    } else {
                        this.status = 'four';
                    }
                    this.isLoading = false;
                }).catch(() => {
                    this.isLoading = false;
                });
            } else {
                this.status = 'four';
            }
        }
    },
    async beforeCreate() {
        await axios.get('/notification/get', {
            params: {
                'api_token': this.$cookies.get('user').token,
                'id': this.$cookies.get('user').id,
            }
        }).then(response => {
            this.setting.postemail = response.data.postemail
            this.setting.advsms = response.data.advsms
        }).catch(() => {
        });
        document.title = this.$t('profile-setting', this.language) + " | " + this.site.title
        this.loading()
    },
}
</script>
