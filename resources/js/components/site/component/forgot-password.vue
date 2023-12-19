<template>
    <accountHeader :site="site"></accountHeader>
    <div class="md:flex justify-center py-5 w-full lg:w-4/5 xl:w-2/3 m-auto md:mt-10">
        <div class="w-full md:w-2/4 relative">
            <div v-show="isLoading" class="blur-login">
                <img class="loader" src="/images/loading.svg" alt="loading">
            </div>
            <div class="w-full rounded-lg shadow-lg px-4 pb-10" v-show="step==1">
                <h2 class="font-bold text-xl">
                    {{ $t('welcome', $route.params.lang) + " - " + $t('forgot-password', $route.params.lang) }}
                </h2>
                <section class="mt-5 space-x-2" :class="$route.params.lang=='fa'?'space-x-reverse':''">
                    <button @click="loginState='email'"
                            class="text-xs font-semibold inline-block py-1 px-2 rounded-lg text-blueGray-600 bg-gray-200 last:mr-0 mr-1 border-2"
                            :class="loginState=='email'?'border-slate-500':''">
                        {{ $t('login-with-email', $route.params.lang) }}
                    </button>
                    <button @click="loginState='phone'"
                            class="text-xs font-semibold inline-block py-1 px-2 rounded-lg text-blueGray-600 bg-gray-200 last:mr-0 mr-1 border-2"
                            :class="loginState=='phone'?'border-slate-500':''">
                        {{ $t('login-with-phone', $route.params.lang) }}
                    </button>
                </section>
                <form @submit.prevent=''>
                    <vue-tel-input v-show="loginState=='phone'" dir="ltr" v-model="phone"
                                   :styleClasses="'p-2 border w-full mt-5 block w-full focus:text-sky-500'"
                                   v-on:country-changed="countryChanged"
                                   :item="placeHolderCode"
                                   v-bind="bindProps"></vue-tel-input>
                    <div dir="ltr" v-show="loginState=='email'"
                         class="relative mt-5 flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                        <i class="fe fe-mail text-xl"></i>
                        </span>
                        <input v-model="email" dir="ltr" type="email"
                               :placeholder="$t('email',$route.params.lang)"
                               :class="$route.params.lang=='fa'?'placeholder:text-right':''"
                               class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"/>
                    </div>

                    <button @click="loginEmail()" v-show="loginState=='email'"
                            class="bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full hover:bg-slate-500"
                            type="button">
                        {{ $t('send', $route.params.lang) + " " + $t('code', $route.params.lang) }}
                    </button>
                    <button @click="loginPhone()" v-show="loginState=='phone'"
                            class="bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full hover:bg-slate-500"
                            type="button">
                        {{ $t('send', $route.params.lang) + " " + $t('code', $route.params.lang) }}
                    </button>

                </form>
                <span> {{ $t('sign-up-now', $route.params.lang) + ' ' }} </span>
                <router-link :to="{name:'siteSignup'}" class="text-blue-500">
                    {{ $t('signup', $route.params.lang) + " " + $t('O-signup', $route.params.lang) }}
                </router-link>
            </div>
            <div class="w-full rounded-lg shadow-lg p-10" v-show="step==2">

                <div v-if="countDown > 0" class="py-5 ">
                    <p class="text-center text-red-700 text-xl bold">
                        {{ countDown + " " + $t('seconds', $route.params.lang) }}</p>
                </div>
                <div v-else-if="countDown == 0" class="py-5">
                    <p @click="sentAgain(phone!=''?'phone':'email')" class="text-center text-slate-400"
                       style="cursor: pointer;">
                        {{ $t('sent-again-code', $route.params.lang) }}
                    </p>
                </div>

                <p>
                    {{ $t('inter-code', $route.params.lang) }}
                </p>

                <p v-show="phone!=''" class="text-left mt-5 text-slate-400">
                    {{ phone }}</p>
                <p v-show="email!=''" class="text-left text-slate-400">
                    {{ email }}</p>
                <div dir="ltr" class="relative flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                        <i class="fe fe-smartphone text-xl"></i>
                        </span>
                    <input dir="ltr" type="number" v-model="code"
                           :placeholder="$t('submit-code',$route.params.lang) "
                           :class="$route.params.lang=='fa'?'placeholder:text-right':''"
                           class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"/>
                </div>

                <button @click="authenticate(phone!=''?'phone':'email')"
                        class="bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full focus:ring focus:ring-slate-300"
                        type="button">
                    {{ $t('authenticate', $route.params.lang) }}
                </button>
            </div>
            <section v-show="messageAlert[0]"
                     class="text-red-600 relative m-4">
                <strong class="inline-block w-full align-middle bg-red-50 border-red-600 my-1 p-3 border-2 rounded-lg"
                        v-for="(message,index) in messageAlert" :key="index">
                     <span class="text-xl inline-block mx-2 align-middle">
                        <i class="fe fe-bell"></i>
                      </span>
                    {{ message }}
                </strong>
            </section>
        </div>
        <div class="w-full md:w-1/2 text-sm">
            <section class="w-full sm:flex p-10">
                <div class="w-full sm:w-1/2  flex justify-center">
                    <img width="300" class="h-fit" :src="$sitename + 'images/' + '/login-right-img.png'" alt="login">
                </div>
                <div class="w-full sm:w-1/2 mt-2 md:mt-0 text-center"
                     :class="$route.params.lang=='fa'?'sm:text-right':'sm:text-left'">
                    <strong class="text-dark-primary">
                        {{ $t('login-top-header', $route.params.lang) }}
                    </strong>
                    <p class="mt-2">
                        {{ $t('login-top-text', $route.params.lang) }}
                    </p>
                </div>
            </section>
            <section class="w-full sm:flex p-10 flex-row-reverse">
                <div class="w-full sm:w-1/2 flex justify-center">
                    <img width="300" class="h-fit" :src="$sitename + 'images/' + '/login-left-img.png'" alt="login">
                </div>
                <div class="w-full sm:w-1/2 mt-2 md:mt-0 text-center"
                     :class="$route.params.lang=='fa'?'sm:text-right':'sm:text-left'">
                    <strong class="text-dark-primary">
                        {{ $t('login-bottom-header', $route.params.lang) }}
                    </strong>
                    <p class="mt-2">
                        {{ $t('login-bottom-text', $route.params.lang) }}
                    </p>
                </div>
            </section>
        </div>
    </div>
    <accountFooter :site="site"></accountFooter>
</template>
<script>
import {defineAsyncComponent} from "vue";
import {VueTelInput} from 'vue-tel-input';
import axios from "axios";

export default {
    props: {
        site: Object,
        user: Object
    },
    components: {
        "accountHeader": defineAsyncComponent(() => import('./../layout/account-header.vue')),
        "accountFooter": defineAsyncComponent(() => import('./../layout/account-footer.vue')),
        VueTelInput,
    },
    emits: ['getUser'],
    data() {
        return {
            isLoading: false,
            loginState: 'email',
            phone: '',
            email: '',
            step: 1,
            code: '',
            bindProps: {
                validCharactersOnly: true,
                ignoredCountries: ['IL'],
                enabledCountryCode: true,
                autoFormat: false,
                inputOptions: {
                    placeholder: this.$t('phone-input', this.$route.params.lang)
                }
            },
            country: null,
            messageAlert: [],
            countDown: 120,
            placeHolderCode: this.$route.params.lang == 'fa' ? 'tel98547' : '',
        }
    },
    methods: {
        countryChanged(country) {
            this.country = country.dialCode
        },
        loginEmail() {
            if (this.emailCheck()) {
                this.isLoading = true;
                const sentData = {
                    type: 'email',
                    email: this.email,
                };
                axios.post("/login/code", sentData).then((response) => {
                    if (response.data.status == 200) {
                        this.countDownTimer();
                    }
                    this.step = 2;
                    this.isLoading = false;
                }).catch((error) => {
                    this.isLoading = false;
                    let errorOne = this.$t('incorect-user', this.$route.params.lang, {data: this.$t('email', this.$route.params.lang)})
                    this.messageAlert.push(errorOne)
                    setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                        , 4000)
                });
            }

        },
        loginPhone() {
            if (this.phoneCheck()) {
                this.isLoading = true;
                const sentData = {
                    type: 'phone',
                    phone: this.country + this.phone,
                };
                axios.post("/login/code", sentData).then((response) => {
                    if (response.data.status == 200) {
                        this.countDownTimer();
                    }
                    this.step = 2;
                    this.isLoading = false;
                }).catch((error) => {
                    this.isLoading = false;
                    let errorOne = this.$t('incorect-user', this.$route.params.lang, {data: this.$t('mobile', this.$route.params.lang)})
                    this.messageAlert.push(errorOne)
                    setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                        , 4000)
                });
            }

        },
        emailCheck() {
            var validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
            if (this.email.match(validRegex)) {
                return true;
            } else {
                let errorOne = this.$t('email-check', this.$route.params.lang)
                this.messageAlert.push(errorOne)
                setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                    , 4000)
                return false;
            }
        },
        phoneCheck() {
            let errorTow = this.$t('phone-error', this.$route.params.lang);
            if (this.phone.length < 10) {
                this.messageAlert.push(errorTow)
                setTimeout(() => this.messageAlert = this.messageAlert = this.messageAlert.filter(item => item != errorTow)
                    , 4000)
                return false;
            } else {
                this.messageAlert = this.messageAlert.filter(item => item != errorTow)
                return true;
            }
        },
        countDownTimer() {
            if (this.countDown > 0) {
                setTimeout(() => {
                    this.countDown -= 1
                    this.countDownTimer()
                }, 1000)
            }
        },
        setCountDown(time) {
            this.countDown = time
        },
        sentAgain(type) {
            this.isLoading = true;
            let setData = {
                'type': type,
                'email': this.email,
                'phone': this.country + this.phone
            }
            axios.post("/login/code", setData)
                .then((response) => {
                    if (response.status == 200) {
                        this.setCountDown(120)
                        this.countDownTimer()
                    }
                    this.isLoading = false;
                }).catch(error => {
                this.isLoading = false;
            });
        },
        authenticate(type) {
            this.isLoading = true;
            let setData = {
                'email': this.email,
                'phone': this.country + this.phone,
                'code': this.code,
                'type': type
            }
            axios.post("/login/auth", setData)
                .then((response) => {
                    if (response.data.status == 200) {
                        this.$router.push({name: 'sitePanel'})
                        const user = {
                            id: response.data.data.id,
                            token: response.data.data.token,
                            role: response.data.data.role,
                            session: '25j_7Sl6xDq2Kc3ym0fmrSSk2xV2XkUkX'
                        };
                        this.$cookies.set('user', user, '180d');
                        this.$emit('getUser');
                    } else {
                        let errorOne = this.$t('not-valied', this.$route.params.lang)
                        this.messageAlert.push(errorOne)
                        setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                            , 4000)
                    }
                    this.isLoading = false;
                }).catch(error => {
                this.isLoading = false;
            });

        },

    },
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('login', this.$route.params.lang) + ' - ' + this.$t('user-account', this.$route.params.lang) + ' | ' + document.title;
            }
        },
    },
}
</script>
<style>
.vue-tel-input:focus-within {
    box-shadow: unset !important;
    border: 2px solid #0ea5e9 !important;
}

.vue-tel-input {
    box-shadow: unset !important;
    border-radius: 7px !important;
    border: 1px solid #CBD5E1 !important;
}

.vue-tel-input[item="tel98547"] > input.vti__input::placeholder {
    text-align: right;
}
</style>
<style scoped>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>

