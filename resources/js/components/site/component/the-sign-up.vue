<template>
    <accountHeader :site="site"></accountHeader>
    <div class="md:flex justify-center py-5 w-full lg:w-4/5 xl:w-2/3 m-auto md:mt-10">
        <div class="w-full md:w-2/4 relative">
            <div v-show="isLoading" class="blur-login">
                <img class="loader" src="/images/loading.svg" alt="loading">
            </div>
            <div class="w-full rounded-lg shadow-lg pb-10 px-4" v-show="step==1">
                <h2 class="font-bold text-xl">
                    {{ $t('free-join', $route.params.lang) }}
                </h2>
                <form class="mt-10" @submit.prevent="">
                    <div class="relative flex w-full flex-wrap items-stretch">
                        <span
                            :class="$route.params.lang=='fa'?'left-5':''"
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400 ">
                            <i class="fe fe-user text-xl"></i>
                        </span>
                        <input type="text" v-model="name"
                               :placeholder="$t('fullname',$route.params.lang) + ' '+ $t('required',$route.params.lang) "
                               :class="$route.params.lang=='fa'?'placeholder:text-right':''"
                               class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"/>
                    </div>
                    <vue-tel-input dir="ltr" v-model="phone"
                                   :styleClasses="'p-2 border w-full mt-5 block w-full focus:text-sky-500'"
                                   v-on:country-changed="countryChanged"
                                   :item="placeHolderCode"
                                   v-bind="bindProps"></vue-tel-input>
                    <div dir="ltr" class="relative mt-5 flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                         <i class="fe fe-mail text-xl"></i>
                        </span>
                        <input dir="ltr" type="email" v-model="email"
                               :placeholder="$t('email',$route.params.lang) + ' ' + $t('required',$route.params.lang) "
                               :class="$route.params.lang=='fa'?'placeholder:text-right':''"
                               class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
                    </div>
                    <div dir="ltr" class="relative mt-5 flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                        <i class="fe fe-lock text-xl"></i>
                        </span>
                        <input dir="ltr" type="password" v-model="password"
                               :placeholder="$t('password',$route.params.lang) + ' ' + $t('required',$route.params.lang) "
                               class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"
                               :class="[passwordState ? 'ring ring-red-600' : '',$route.params.lang=='fa'?'placeholder:text-right':'']"/>
                    </div>
                    <div dir="ltr" class="relative mt-5 flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                        <i class="fe fe-lock text-xl"></i>
                        </span>
                        <input dir="ltr" type="password" v-model="repeatPassword"
                               :placeholder="$t('password-again',$route.params.lang) + ' ' + $t('required',$route.params.lang) "
                               class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400 mb-2 pl-14"
                               :class="[passwordState ? 'ring ring-red-600' : '',$route.params.lang=='fa'?'placeholder:text-right':'']"
                               @keyup="passwordMatch"/>
                    </div>
                    <div class="text-justify">
                        <input v-model="setting.postemail" type="checkbox" class="mx-2 accent-dark-primary" id="email">
                        <label for="email"> {{ $t('email-notificate', $route.params.lang) }}</label>
                    </div>
                    <div class="text-justify">
                        <input v-model="setting.advsms" type="checkbox" class="mx-2 accent-dark-primary" id="phone">
                        <label for="phone"> {{ $t('phone-notificate', $route.params.lang) }}</label>
                    </div>
                    <button @click="sendCode()"
                            class="bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full hover:bg-slate-500"
                            type="button">
                        {{ $t('signup-btn', $route.params.lang) }}
                    </button>
                </form>
                <span> {{ $t('login-now', $route.params.lang) + ' ' }} </span>
                <router-link :to="{name:'siteAccount'}" class="text-blue-500">
                    {{ $t('login', $route.params.lang) }}
                </router-link>
            </div>
            <div class="w-full shadow-md p-10" v-show="step==2">
                <div v-if="countDown > 0" class="py-5 ">
                    <p class="text-center text-red-700 text-xl bold">
                        {{ countDown + " " + $t('seconds', $route.params.lang) }}</p>
                </div>
                <div v-else-if="countDown == 0" class="py-5">
                    <p @click="sentAgain()" class="text-center text-slate-400"
                       style="cursor: pointer;">
                        {{ $t('sent-again-code', $route.params.lang) }}
                    </p>
                </div>
                <p>
                    1- {{ $t('authenticate-message', $route.params.lang) }}
                </p>
                <p>
                    2- {{ $t('authenticate-force', $route.params.lang) }}
                </p>
                <span class="float-left mt-5 text-slate-400">{{ phone }}</span>
                <div dir="ltr" class="relative flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                        <i class="fe fe-smartphone text-xl"></i>
                        </span>
                    <input dir="ltr" type="number" v-model="phoneCode"
                           :placeholder="$t('submit-code',$route.params.lang) "
                           class="py-3 placeholder-slate-400 text-blueGray-600 relative border border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 w-full px-14 rounded-md focus:ring-1 h-full focus:text-sky-500"/>
                </div>
                <span class="float-left mt-5 text-slate-400">{{ email }}</span>
                <div dir="ltr" class="relative flex w-full flex-wrap items-stretch">
                        <span
                            class="z-10 h-full font-normal absolute text-center bg-transparent rounded items-center justify-center w-10 px-5 py-3 text-slate-400">
                        <i class="fe fe-mail text-xl"></i>
                        </span>
                    <input dir="ltr" type="number" v-model="emailCode"
                           :placeholder="$t('submit-code',$route.params.lang) "
                           class="py-3 placeholder-slate-400 text-blueGray-600 relative border border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 w-full px-14 rounded-md focus:ring-1 h-full focus:text-sky-500"/>
                </div>
                <button @click="authenticate()"
                        class="bg-dark-primary text-white font-bold uppercase text-xs py-3 rounded-full outline-none my-5 w-full hover:bg-slate-500"
                        type="button">
                    {{ $t('authenticate', $route.params.lang) }}
                </button>
            </div>
        </div>
        <div class="w-full md:w-1/2 text-sm p-5">
            <section class="w-full mt-4 text-center"
                     :class="$route.params.lang=='fa'?'sm:text-right':'sm:text-left'">
                <strong class="text-dark-primary">
                    {{ $t('login-top-header', $route.params.lang) }}
                </strong>
                <p class="mt-2">
                    {{ $t('login-top-text', $route.params.lang) }}
                </p>
            </section>
            <section class="w-full mt-4 text-center"
                     :class="$route.params.lang=='fa'?'sm:text-right':'sm:text-left'">
                <strong class="text-dark-primary">
                    {{ $t('login-bottom-header', $route.params.lang) }}
                </strong>
                <p class="mt-2">
                    {{ $t('login-bottom-text', $route.params.lang) }}
                </p>
            </section>
            <section v-show="passwordState"
                     class="text-red-600 relative m-4">
                <strong class="inline-block w-full align-middle bg-red-50 border-red-600 my-1 p-3 border-2 rounded-lg">
                     <span class="text-xl inline-block mx-2 align-middle">
                        <i class="fe fe-lock"></i>
                      </span>
                    {{ passwordMessage }}
                </strong>
            </section>
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
    </div>
    <accountFooter :site="site"></accountFooter>
</template>
<script>
import {defineAsyncComponent} from "vue";
import {VueTelInput} from 'vue-tel-input';
import axios from 'axios'

export default {
    props: {
        site: Object,
        user: Object
    },
    emits: ['getUser'],
    components: {
        "accountHeader": defineAsyncComponent(() => import('./../layout/account-header.vue')),
        "accountFooter": defineAsyncComponent(() => import('./../layout/account-footer.vue')),
        VueTelInput,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            isLoading: false,
            name: "",
            step: 1,
            phone: '',
            email: "",
            password: "",
            setting: {
                postemail: true,
                advsms: true
            },
            repeatPassword: "",
            messageAlert: [],
            stateAlert: false,
            bindProps: {
                validCharactersOnly: true,
                ignoredCountries: ['IL'],
                enabledCountryCode: true,
                autoFormat: false,
                inputOptions: {
                    placeholder: this.$t('phone-input', this.$route.params.lang) + " " + this.$t('required', this.$route.params.lang)
                }
            },
            country: null,
            passwordState: false,
            passwordMessage: this.$t('password-wrong', this.$route.params.lang),
            countDown: 120,
            emailCode: '',
            phoneCode: '',
            placeHolderCode: this.$route.params.lang == 'fa' ? 'tel98547' : '',
        }
    },
    methods: {
        countryChanged(country) {
            this.country = country.dialCode
        },
        sendCode() {
            if (this.validData()) {
                this.isLoading = true;
                const sentData = {
                    lang: this.$route.params.lang,
                    name: this.name,
                    phone: this.country + this.phone,
                    email: this.email,
                    password: this.password,
                    setting: this.setting,
                };
                axios.post("/register", sentData).then((response) => {
                    if (response.status == 200) {
                        this.isLoading = false;
                        this.countDownTimer()
                        this.step = 2;
                    }
                }).catch((error) => {
                    this.isLoading = false;
                    if (error.response.data.errors.email) {
                        let errorOne = this.$t('email-exist', this.$route.params.lang)
                        this.messageAlert.push(errorOne)
                        setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                            , 4000)
                    }
                    if (error.response.data.errors.phone) {
                        let errorOne = this.$t('phone-exist', this.$route.params.lang)
                        this.messageAlert.push(errorOne)
                        setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                            , 4000)
                    }
                });
            }
        },
        validData() {
            let i = 0;
            let errorOne = this.$t('field-error', this.$route.params.lang);
            let errorTow = this.$t('phone-error', this.$route.params.lang);
            if (this.name.length < 2) {
                this.messageAlert.push(errorOne)
                i++;
                setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                    , 4000)
            } else {
                i = 0;
                this.messageAlert = this.messageAlert.filter(item => item != errorOne)
            }
            if (this.phone.length < 10) {
                this.messageAlert.push(errorTow)
                i++;
                setTimeout(() => this.messageAlert = this.messageAlert = this.messageAlert.filter(item => item != errorTow)
                    , 4000)
            } else {
                i = 0;
                this.messageAlert = this.messageAlert.filter(item => item != errorTow)
            }
            this.emailCheck();
            this.passwordMatch();
            if (i == 0 && this.passwordMatch() && this.emailCheck()) {
                return true;
            }
            return false;
        },
        passwordMatch() {
            if (this.password.length > 3) {
                if (this.password.length > 0 && this.password == this.repeatPassword) {
                    this.passwordState = false;
                    return true;
                } else {
                    this.passwordState = true;
                    return false;
                }
            } else {
                let errorOne = this.$t('password-less', this.$route.params.lang)
                this.messageAlert.push(errorOne)
                setTimeout(() => this.messageAlert = this.messageAlert.filter(item => item != errorOne)
                    , 4000)
                return false;
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

        sentAgain() {
            this.isLoading = true;
            let setData = {
                'email': this.email,
                'phone': this.country + this.phone
            }
            axios.post("/register/auth", setData)
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
        authenticate() {
            this.isLoading = true;
            let setData = {
                'email': this.email,
                'phone': this.country + this.phone,
                'phonecode': this.phoneCode,
                'emailcode': this.emailCode
            }
            axios.post("/register/done", setData)
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
                document.title = this.$t('signup', this.$route.params.lang) + ' - ' + this.$t('user-account', this.$route.params.lang) + ' | ' + document.title;
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

ul.vti__dropdown-list.below {
    z-index: 99;
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

