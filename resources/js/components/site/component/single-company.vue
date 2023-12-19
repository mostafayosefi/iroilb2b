<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <div class="bg-white-secondary p-10 text-center flex justify-center items-center">
        <div v-show="company.verified=='verified'">
            <i class="verified mx-2" :style="language=='fa'?'float:right;':'float:left;'"></i>
        </div>
        <h1 class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ company.name }}</h1>
    </div>
    <div class="text-white-primary text-center bg-dark-primary border border-b-0 border-slate-300">
        <button @click="tab='first'" class="mx-3 px-8 py-4"
                :class="tab=='first'?'border-b-2 border-solid border-red-500':''">
            <strong> {{ $t('intro', language) + " " }} </strong>
        </button>
        <button @click="tab='second'" class="mx-3 px-8 py-4"
                :class="tab=='second'?'border-b-2 border-solid border-red-500':''">
            <strong> {{ $t('contact-data', language) + " " }} </strong>
        </button>
        <button v-show="company.ads" @click="tab='third'" class="mx-3 px-8 py-4"
                :class="tab=='third'?'border-b-2 border-solid border-red-500':''">
            <strong> {{ $t('ads', language) + " " }} </strong>
        </button>
    </div>
    <div v-show="tab=='first'" class="w-full md:w-3/4 mx-auto mt-4 p-5 md:flex">
        <div class="w-full md:w-1/4 rounded-full px-2">
            <img v-show="company.logo" :src="company.logo" :alt="company.name" class="w-full  rounded-full shadow-lg">
            <img v-show="!company.logo" class="w-full rounded-full shadow-lg"
                 :src="$sitename + 'images/no-logo.jpg'" alt="no-logo">
        </div>
        <div class="w-full mt-2 md:mt-0 md:mx-2 md:w-3/4">
            <div class="border rounded-lg py-2 px-5">
                <p class="leading-8 text-justify">
                    {{ company.description }}
                </p>
                <p class="mt-4" v-show="language=='fa'">
                    <span> {{ $t('local-work', language) + ": " }} </span>
                    <strong v-for="data in countries" v-show="company.local == data.name"> {{ data.fa + " " }} </strong>
                </p>
                <p class="mt-2" v-show="language=='en'">
                    <span> {{ $t('local-work', language) + ": " }} </span>
                    <strong v-for="data in countries" v-show="company.local == data.name"> {{
                            data.name + " "
                        }} </strong>
                </p>
                <p v-show="company.filters">
                    <span> {{ $t('field-of-activity', language) + ": " }} </span>
                    <strong v-for="filter in company.filters">
                        <span v-show="language=='fa'">{{ filter.fa + " " }}</span>
                        <span v-show="language=='en'">{{ filter.en + " " }}</span>
                    </strong>
                </p>
                <p>
                    <span> {{ $t('ceo', language) + ": " }} </span>
                    <strong> {{ company.ceo.name + " " }} </strong>
                </p>
                <p class="mb-2">
                    <span> {{ $t('manager', language) + ": " }} </span>
                    <strong> {{ company.manager.name + " " }} </strong>
                </p>
                <section class="leading-8">
                    <span> {{ $t('products', language) + ": " }} </span>
                    <router-link v-for="tag in company.tags"
                                 class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1"
                                 :to="{path:'/'+language+'/filter/'+tag.link}">
                        <span v-show="language=='fa'">{{ tag.fa + ' ' }}</span>
                        <span v-show="language=='en'">{{ tag.en + ' ' }}</span>
                    </router-link>
                </section>
            </div>
        </div>
    </div>
    <div v-show="tab=='second'" class="w-full md:w-3/4 mx-auto mt-4 p-5">
        <div v-show="!loginCheck()">
            <div class="mx-auto md:w-1/2 w-full border-2 border-solid border-white-primary rounded-lg p-6 text-center">
                <p class="mb-4">
                    {{ $t('view-contact-co', language) }}
                </p>
                <router-link :to="{name:'siteAccount'}" class="mx-1 bg-white-primary py-2 px-3 rounded-lg duration-300">
                    {{ $t('login', language) }}
                </router-link>
                <router-link :to="{name:'siteSignup'}"
                             class="mx-1 bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                    {{ $t('signup', language) }}
                </router-link>
            </div>
        </div>
        <div v-show="loginCheck()"
             class="mx-auto w-full md:w-2/3 border-2 border-solid border-white-primary rounded-lg p-6 md:flex flex-wrap">
            <p class="w-full md:w-1/2">
                <span> {{ $t('ceo-phone', language) + ": " }} </span>
                <a :href="'tel:'+company.ceo.phone">
                    <strong> {{ company.ceo.phone + " " }} </strong>
                </a>
            </p>
            <p class="w-full md:w-1/2">
                <span> {{ $t('ceo-email', language) + ": " }} </span>
                <a :href="'mailto::'+company.ceo.email">
                    <strong> {{ company.ceo.email + " " }} </strong>
                </a>
            </p>
            <p class="w-full md:w-1/2 mt-2">
                <span> {{ $t('manager-phone', language) + ": " }} </span>
                <a :href="'tel:'+company.manager.phone">
                    <strong> {{ company.manager.phone + " " }} </strong>
                </a>
            </p>
            <p class="w-full md:w-1/2 mt-2">
                <span> {{ $t('manager-email', language) + ": " }} </span>
                <a :href="'mailto::'+company.manager.email">
                    <strong> {{ company.manager.email + " " }} </strong>
                </a>
            </p>
            <p class="w-full mt-2">
                <span> {{ $t('tell', language) + ": " }} </span>
                <a :href="'tel:'+company.tell">
                    <strong> {{ company.tell + " " }} </strong>
                </a>
            </p>
            <p class="w-full mt-2">
                <span> {{ $t('adress', language) + ": " }} </span>
                <strong> {{ company.adress + " " }} </strong>
            </p>
            <div class="flex w-full mt-6 mx-auto text-center justify-center" style="width: 40px;">
                <a class="float-left p-2 mx-2"
                   :href="'https://instagram.com/'+company.instagram" v-show="company.instagram!='-'">
                    <i class="instagram"></i>
                </a>
                <a class="float-left p-2 mx-2" v-show="company.linkedin!='-'"
                   :href="'https://linkedin.com/'+company.linkedin">
                    <i class="linkedin"></i>
                </a>
                <a class="float-left p-2 mx-2" v-show="company.facebook!='-'"
                   :href="'https://facebook.com/'+company.facebook">
                    <i class="facebook"></i>
                </a>
            </div>
            <div v-show="messageState=='second'"
                 class="w-full mt-4 bg-red-100 bg-opacity-70 border-2 border-red-300 rounded-lg text-red-600 py-2 px-4">
                {{ $t('message-send', language) }}
            </div>
            <div class="w-full mt-4 text-center" v-show="messageState=='first'">
                <label for="message" class="text-center">{{ $t('message-co', language) + ": " }}</label>
                <textarea id="message" v-model="message"
                          :dir="language=='fa'?'rtl':'ltr'"
                          class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                          :placeholder="$t('message',language)"></textarea>
                <button @click="send()" :disabled="message.length<10"
                        class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">
                    <span v-show="!load">{{ $t('submit', language) }}</span>
                    <span v-show="load">...</span>
                </button>
            </div>
        </div>
    </div>
    <div v-show="tab=='third'" class="w-full md:w-3/4 mx-auto mt-4 p-2 flex flex-wrap">
        <div v-for="ad in company.ads" class="p-2 w-full md:w-1/3"
             :dir="language=='fa'?'rtl':'ltr'">
            <router-link :to="{path:'/'+language+'/ads/'+ad.slug}">
                <div class="border rounded-lg py-2 px-5">
                    <p>
                        {{ ad.title }}
                    </p>
                    <p class="mb-2">
                        {{ $t('type', language) + ": " }}
                        <span v-show="ad.type=='sale'">{{ $t('seller', language) }}</span>
                        <span v-show="ad.type=='buy'">{{ $t('buyer', language) }}</span>
                    </p>
                    <div class="flex justify-between">
                        <i v-show="language=='fa'"
                           class="text-sm text-slate-400 block">{{
                                $t('expire-at', language) + ": " + ad.expireFa
                            }}</i>
                        <i v-show="language=='en'"
                           class="text-sm text-slate-400 block">{{
                                $t('expire-at', language) + ": " + ad.expireEn
                            }}</i>
                        <span class="!text-slate-400 text-sm">
                            <i class="text-dark-primary text-lg fe fe-more-horizontal"></i>
                        </span>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";
import 'vue-rate/dist/vue-rate.css'
import countries from './../../../../../public/js/countries.json'

export default {
    data() {
        return {
            show: true,
            language: this.$route.params.lang,
            tab: 'first',
            countries: countries,
            message: '',
            messageState: 'first',
            load: false,
            company: {
                id: '',
                name: '',
                tell: '',
                instagram: '',
                facebook: '',
                linkedin: '',
                local: '',
                adress: '',
                description: '',
                seo: '',
                ceo: {
                    name: '',
                    phone: '',
                    email: '',
                },
                manager: {
                    name: '',
                    phone: '',
                    email: '',
                },
                logo: false,
                tags: [],
                filters: [],
                ads: [],
                verified: ''
            }
        }
    },
    props: {
        site: Object,
        user: Object
    },
    emits: ['getUser'],
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    }, methods: {
        loginCheck() {
            if (this.$cookies.isKey('user')) {
                return true;
            } else {
                return false;
            }
        },
        send() {
            this.load = true;
            const sentData = {
                id: this.$cookies.get('user').id,
                company: this.company.id,
                message: this.message,
            }
            axios.post("/notification/usersend", sentData).then((response) => {
                if (response.data == 'success') {
                    this.messageState = 'second';
                    this.message = '';
                    this.load = false;
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
        loading() {
            this.show = false;
        }
    },
    async created() {
        await axios.get('/company/single/' + this.$route.params.slug).then(response => {
            if (response.data == 'null') {
                this.$router.push({name: 'siteNotFound'})
            }
            if (response.data.logo) {
                this.company.logo = this.$sitename + 'upload/company/logo/' + response.data.logo.toLowerCase();
            }
            this.company.verified = response.data.verified
            this.company.id = response.data.id
            if (this.$route.params.lang == 'fa') {
                this.company.name = response.data.bodyFa.name != '-' ? response.data.bodyFa.name : response.data.bodyEn.name;
                this.company.seo = response.data.bodyFa.seo != '' ? response.data.bodyFa.seo : response.data.bodyEn.seo;
                this.company.description = response.data.bodyFa.description != '-' ? response.data.bodyFa.description : response.data.bodyEn.description;
                this.company.local = response.data.bodyFa.local != '-' ? response.data.bodyFa.local : response.data.bodyEn.local;
                this.company.adress = response.data.bodyFa.adress != '-' ? response.data.bodyFa.adress : response.data.bodyEn.adress;
                this.company.tell = response.data.bodyFa.tell != '-' ? response.data.bodyFa.tell : response.data.bodyEn.tell;
                this.company.instagram = response.data.bodyFa.instagram != '-' ? response.data.bodyFa.instagram : response.data.bodyEn.instagram;
                this.company.facebook = response.data.bodyFa.facebook != '-' ? response.data.bodyFa.facebook : response.data.bodyEn.facebook;
                this.company.linkedin = response.data.bodyFa.linkedin != '-' ? response.data.bodyFa.linkedin : response.data.bodyEn.linkedin;
                this.company.ceo.name = response.data.bodyFa.ceo.name != '-' ? response.data.bodyFa.ceo.name : response.data.bodyEn.ceo.name;
                this.company.ceo.phone = response.data.bodyFa.ceo.phone != '-' ? response.data.bodyFa.ceo.phone : response.data.bodyEn.ceo.phone;
                this.company.ceo.email = response.data.bodyFa.ceo.email != '-' ? response.data.bodyFa.ceo.email : response.data.bodyEn.ceo.email;
                this.company.manager.name = response.data.bodyFa.manager.name != '-' ? response.data.bodyFa.manager.name : response.data.bodyEn.manager.name;
                this.company.manager.phone = response.data.bodyFa.manager.phone != '-' ? response.data.bodyFa.manager.phone : response.data.bodyEn.manager.phone;
                this.company.manager.email = response.data.bodyFa.manager.email != '-' ? response.data.bodyFa.manager.email : response.data.bodyEn.manager.email;
            } else {
                this.company.name = response.data.bodyEn.name != '-' ? response.data.bodyEn.name : response.data.bodyFa.name;
                this.company.seo = response.data.bodyEn.seo != '' ? response.data.bodyEn.seo : response.data.bodyFa.seo;
                this.company.description = response.data.bodyEn.description != '-' ? response.data.bodyEn.description : response.data.bodyFa.description;
                this.company.local = response.data.bodyEn.local != '-' ? response.data.bodyEn.local : response.data.bodyFa.local;
                this.company.adress = response.data.bodyEn.adress != '-' ? response.data.bodyEn.adress : response.data.bodyFa.adress;
                this.company.tell = response.data.bodyEn.tell != '-' ? response.data.bodyEn.tell : response.data.bodyFa.tell;
                this.company.instagram = response.data.bodyEn.instagram != '-' ? response.data.bodyEn.instagram : response.data.bodyFa.instagram;
                this.company.facebook = response.data.bodyEn.facebook != '-' ? response.data.bodyEn.facebook : response.data.bodyFa.facebook;
                this.company.linkedin = response.data.bodyEn.linkedin != '-' ? response.data.bodyEn.linkedin : response.data.bodyFa.linkedin;
                this.company.ceo.name = response.data.bodyEn.ceo.name != '-' ? response.data.bodyEn.ceo.name : response.data.bodyFa.ceo.name;
                this.company.ceo.phone = response.data.bodyEn.ceo.phone != '-' ? response.data.bodyEn.ceo.phone : response.data.bodyFa.ceo.phone;
                this.company.ceo.email = response.data.bodyEn.ceo.email != '-' ? response.data.bodyEn.ceo.email : response.data.bodyFa.ceo.email;
                this.company.manager.name = response.data.bodyEn.manager.name != '-' ? response.data.bodyEn.manager.name : response.data.bodyFa.manager.name;
                this.company.manager.phone = response.data.bodyEn.manager.phone != '-' ? response.data.bodyEn.manager.phone : response.data.bodyFa.manager.phone;
                this.company.manager.email = response.data.bodyEn.manager.email != '-' ? response.data.bodyEn.manager.email : response.data.bodyFa.manager.email;
            }
            this.company.filters = response.data.filters;
            this.company.tags = response.data.tags;
            this.company.ads = response.data.ads;

            document.title = this.company.name + " | " + this.site.title;
            document.querySelector('meta[name="description"]').setAttribute("content", this.company.seo == '-' ? this.company.description.substring(0, 320) : this.company.seo);
        })
        this.loading();
    }

}
</script>
<style>
.verified {
    background: url("/images/verified.svg") no-repeat;
    background-size: 25px;
    width: 25px;
    height: 25px;
}
</style>


