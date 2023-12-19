<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
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
    <section class="flex mb-14">
        <aside
            class="bg-dark-primary md:w-2/6 xl:w-1/6 min-h-[calc(100vh-140px)] hidden md:flex flex-wrap content-between">
            <panelSideBar :site="site" :user="user"></panelSideBar>
        </aside>
        <div class="w-full px-1 md:px-7 md:w-4/6 xl:w-5/6">
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
            <section v-show="user.step=='one'"
                     class="w-full lg:w-1/2 mx-auto border-2 border-white-primary rounded-lg p-6 text-center">
                {{ $t('ads-one-message', language) }}
            </section>
            <section v-show="companyStatus"
                     class="mx-auto w-full lg:w-1/2 border-2 border-solid border-white-primary rounded-lg p-6 text-center mt-4">
                {{ $t('insert-ads-message', language) }}
            </section>
            <div v-show="!companyStatus">
                <div v-show="user.step=='tow'|| user.step=='three' || user.step=='four'" class="p-2">
                    <div v-show="!showInsert" class="text-center m-2 border rounded-lg p-4">
                        <div class="my-4">
                            {{ $t('ads-message', language) }}
                        </div>
                        <button @click="showInsert=!showInsert"
                                class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">
                            {{ $t('add-ad', language) }}
                        </button>
                    </div>
                    <div v-show="!showInsert">
                        <section v-for="item in adsList" :key="item.id"
                                 class="border-2 border-slate-200 border-solid rounded-lg p-2 md:p-4 m-2 text-sm block md:grid grid-cols-5 place-items-center justify-items-stretch place-content-stretch shadow-md">
                            <section class="hidden md:block justify-self-start"
                                     :class="language=='fa'?'text-right':'text-left'">
                                <span class="bg-purple-100 px-2 text-purple-500 rounded-lg"
                                      v-show="item.status=='draft'">{{ $t('check', language) }}</span>
                                <span class="bg-slate-100 px-2 text-slate-500 rounded-lg"
                                      v-show="item.status=='timeout'">{{ $t('expire', language) }}</span>
                                <span class="bg-orange-100 px-2 text-orange-500 rounded-lg"
                                      v-show="item.status=='reject'">{{ $t('reject', language) }}</span>
                                <span class="bg-green-100 px-2 text-green-500 rounded-lg"
                                      v-show="item.status=='active'">{{ $t('active', language) }}</span>
                            </section>
                            <strong class="md:col-span-2 block my-2 md:my-0 justify-self-start"
                                    :class="language=='fa'?'text-right':'text-left'">{{ item.title }}</strong>
                            <div class=" block mb-2 md:mb-0 mt-2 md:mt-0">
                                <span v-show="item.type=='sale'">
                                    {{ $t('sale', language) }}</span>
                                <span v-show="item.type=='buy'">
                                    {{ $t('buy', language) }}</span>
                                <span> - {{
                                        ' ' + $t('expire-at', language) + ": " + item.time
                                    }}</span>
                            </div>
                            <div class="self-center flex justify-between justify-self-end items-center space-x-2">
                                <section class="block md:hidden">
                                    <span class="bg-purple-100 px-2 text-purple-500 rounded-lg"
                                          v-show="item.status=='draft'">{{ $t('check', language) }}</span>
                                    <span class="bg-slate-100 px-2 text-slate-500 rounded-lg"
                                          v-show="item.status=='timeout'">{{ $t('expire', language) }}</span>
                                    <span class="bg-orange-100 px-2 text-orange-500 rounded-lg"
                                          v-show="item.status=='reject'">{{ $t('reject', language) }}</span>
                                    <span class="bg-green-100 px-2 text-green-500 rounded-lg"
                                          v-show="item.status=='active'">{{ $t('active', language) }}</span>
                                </section>
                                <router-link v-show="item.status=='active' || item.status=='timeout'"
                                             class="px-4 py-1 font-semibold text-sm bg-dark-primary text-white rounded-full shadow-sm"
                                             :to="language=='en'?{path:'/en/ads/'+item.slug}:{path:'/fa/ads/'+item.slug}">
                                    {{ $t('view', language) }}
                                </router-link>
                                <button @click="deleteAds(item.id)"
                                        class="btn bg-red-600 rounded-full text-xl text-white flex items-center p-1">
                                    <i class="fe fe-trash-2"></i>
                                </button>
                            </div>
                        </section>
                    </div>
                    <div v-show="showInsert">
                        <form class="pt-2 px-4 border-slate-200 border-2 mb-2 rounded-lg shadow-md space-y-2">
                            <div>
                                <label class="text-sm font-bold text-gray-700"
                                       :class="error && ad.body.title==''?'!text-red-600':''" for="subject">
                                    {{ $t('subject', language) }}
                                </label>
                                <input id="subject" v-model="ad.body.title" type="text"
                                       class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                       :dir="language=='fa'?'rtl':'ltr'"
                                       :class="error && ad.body.title==''?'ring ring-red-600':''">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700"
                                       for="description">{{ $t('description', language) }}</label>
                                <textarea id="description" v-model="ad.body.description"
                                          class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                          :dir="language=='fa'?'rtl':'ltr'"></textarea>
                            </div>
                            <div class="md:flex justify-between space-y-2 md:space-y-0 md:space-x-2"
                                 :class="language=='fa'?'md:space-x-reverse':''">
                                <section class="w-full md:w-1/3">
                                    <label class="text-sm font-bold text-gray-700"
                                           for="language">{{ $t('language', language) }}</label>
                                    <select id="language" v-model="ad.language" :dir="language=='fa'?'rtl':'ltr'"
                                            class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                        <option value="fa">
                                            {{ $t('persian', language) }}
                                        </option>
                                        <option value="en">
                                            {{ $t('english', language) }}
                                        </option>
                                    </select>
                                </section>
                                <section class="w-full md:w-1/3">
                                    <label class="text-sm font-bold text-gray-700" for="type">{{
                                            $t('type', language)
                                        }}</label>
                                    <select id="type" v-model="ad.type" :dir="language=='fa'?'rtl':'ltr'"
                                            class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                        <option value="sale">
                                            {{ $t('sale', language) }}
                                        </option>
                                        <option value="buy">
                                            {{ $t('buy', language) }}
                                        </option>
                                    </select>
                                </section>
                                <section class="w-full md:w-1/3">
                                    <label class="text-sm font-bold text-gray-700"
                                           for="local">{{ $t('producing-country', language) }}</label>
                                    <select id="local" v-model="ad.body.country"
                                            class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                                        <option v-for="data in countries" :value="data.name">
                                            {{ language == 'fa' ? data.fa : data.name }}
                                        </option>
                                    </select>
                                </section>
                            </div>

                            <div>
                                <label class="text-sm font-bold text-gray-700"
                                       :class="error && ad.body.title==''?'!text-red-600':''" for="price">{{
                                        $t('price', language)
                                    }}</label>
                                <input id="price" v-model="ad.body.price" type="text"
                                       class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                       :dir="language=='fa'?'rtl':'ltr'"
                                       :class="error && ad.body.price==''?'ring ring-red-600':''">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700"
                                       :class="error && ad.body.title==''?'!text-red-600':''" for="weight">{{
                                        $t('weight', language)
                                    }}</label>
                                <input id="weight" v-model="ad.body.weight" type="text"
                                       class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                       :dir="language=='fa'?'rtl':'ltr'"
                                       :class="error && ad.body.weight==''?'ring ring-red-600':''">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700"
                                       :class="error && ad.body.title==''?'!text-red-600':''"
                                       for="tags">{{ $t('choose-category', language) }}</label>
                                <Multiselect id="tags" v-model="ad.body.tags"
                                             :rtl="language=='fa'?true:false"
                                             :noOptionsText="$t('empty',language)"
                                             mode="tags" :searchable="true"
                                             :options="ad.language=='fa'?tags.fa:tags.en"
                                             :class="error && ad.body.tags==''?'ring ring-red-600':''"/>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-red-600"
                                      v-show="error && ad.expire==''">{{ $t('expire-time-message', language) }}</span>
                                <date-picker id="expire" simple :locale="ad.language=='fa'?'fa':'en'"
                                             v-model="ad.expire"
                                             :placeholder="$t('expire-ad',language)"
                                             class="p-2 rounded-lg"></date-picker>
                            </div>
                        </form>
                        <section
                            class="flex justify-between w-full items-center pb-4">
                            <button @click="showInsert=!showInsert" v-show="showInsert"
                                    class="btn border border-solid border-gray-300 rounded-lg px-4 py-2 text-dark-primary">
                                {{ $t('close', language) }}
                            </button>
                            <button @click="addAds()" class="btn bg-dark-primary rounded-lg px-4 py-2 text-white"
                                    :disabled="isLoading">
                                {{ $t('submit-ad', language) }}
                            </button>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import DatePicker from 'vue3-persian-datetime-picker'
import {defineAsyncComponent} from "vue";
import countries from './../../../../../public/js/countries.json'
import axios from "axios";
import Multiselect from "@vueform/multiselect";

export default {
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        DatePicker,
        Multiselect,
        "panelSideBar": defineAsyncComponent(() => import('./../layout/side-bar-panel.vue')),
    },
    emits: ['getUser'],
    data() {
        return {
            show: true,
            showInsert: false,
            isLoading: false,
            language: this.$route.params.lang,
            countries: countries,
            companyStatus: '',
            companyId: '',
            tags: {
                en: [],
                fa: []
            },
            ad: {
                language: this.$route.params.lang,
                type: 'sale',
                body: {
                    title: '',
                    weight: '',
                    tags: [],
                    country: 'Iran',
                    price: '',
                    description: ''
                },
                expire: '',
            },
            error: false,
            adsList: [],
        }
    },
    methods: {
        loading() {
            this.show = false;
        },
        deleteAds(id) {
            if (confirm(this.$t('delete-message', this.language))) {
                this.isLoading = true;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    id: this.$cookies.get('user').id,
                    ads: id
                }
                axios.post("/advertise/delete/user", sentData).then((response) => {
                    if (response.data == 'success') {
                        this.getAds();
                    }
                    this.isLoading = false;
                }).catch(() => {
                    this.isLoading = false;
                });
            }
        },
        sanitize() {
            var i = 0;
            if (this.ad.body.title != '') {
                i++;
            }
            if (this.ad.body.weight != '') {
                i++;
            }
            if (this.ad.body.tags != '') {
                i++;
            }
            if (this.ad.body.price != '') {
                i++;
            }
            if (this.ad.expire != '') {
                i++;
            }

            if (i == 5) {
                return true;
            }

            return false;
        }
        ,
        addAds() {
            if (this.sanitize()) {
                this.isLoading = true;
                this.error = false;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    id: this.$cookies.get('user').id,
                    step: this.user.step,
                    company_id: this.companyId,
                    language: this.ad.language,
                    body: this.ad.body,
                    type: this.ad.type,
                    expire: this.ad.expire,
                }
                axios.post("/advertise/create", sentData).then((response) => {
                    if (response.data == 'success') {
                        this.ad.body.title = '';
                        this.ad.body.weight = '';
                        this.ad.body.tags = [];
                        this.ad.body.price = '';
                        this.ad.body.description = '';
                        this.ad.expire = '';
                        this.showInsert = false;
                        this.getAds();
                    }
                    this.isLoading = false;
                }).catch(() => {
                    this.isLoading = false;
                });
            } else {
                this.error = true
            }
        }
        ,
        getAds() {
            axios.get('/advertise/user/' + this.companyId, {
                params: {
                    'api_token': this.$cookies.get('user').token,
                }
            }).then(response => {
                this.adsList = [];
                for (const responseElement of response.data) {
                    this.adsList.push({
                        id: responseElement.id,
                        slug: responseElement.slug,
                        status: responseElement.status,
                        title: responseElement.title,
                        type: responseElement.type,
                        language: responseElement.language,
                        time: responseElement.time,
                    });
                }
            }).catch(() => {
            });
        }
        ,
    },
    created() {
        if (this.language == 'fa') {
            countries.sort((a, b) => {
                let fa = a.fa.toLowerCase(),
                    fb = b.fa.toLowerCase();

                if (fa < fb) {
                    return -1;
                }
                if (fa > fb) {
                    return 1;
                }
                return 0;
            });
        }

        if (this.language == 'en') {
            countries.sort((a, b) => {
                let fa = a.name.toLowerCase(),
                    fb = b.name.toLowerCase();

                if (fa < fb) {
                    return -1;
                }
                if (fa > fb) {
                    return 1;
                }
                return 0;
            });
        }
    },

    async beforeCreate() {
        await axios.get('/product', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data.data) {
                this.tags.fa.push(responseElement.name_fa);
                this.tags.en.push(responseElement.name_en);
            }
        }).catch(() => {
        });
        await axios.get('/company/user', {
            params: {
                'api_token': this.$cookies.get('user').token,
                'id': this.$cookies.get('user').id,
                'language': this.language,
            }
        }).then(response => {
            this.companyId = response.data[0].data.id;
            axios.get('/advertise/user/' + response.data[0].data.id, {
                params: {
                    'api_token': this.$cookies.get('user').token,
                }
            }).then(response => {
                this.adsList = [];
                for (const responseElement of response.data) {
                    this.adsList.push({
                        id: responseElement.id,
                        slug: responseElement.slug,
                        status: responseElement.status,
                        title: responseElement.title,
                        type: responseElement.type,
                        language: responseElement.language,
                        time: responseElement.time,
                    });
                }
            }).catch(() => {
            });
            if (response.data[0].data.status == 'draft') {
                this.companyStatus = true
            } else {
                this.companyStatus = false
            }
        }).catch(() => {
        });
        document.title = this.$t('my-ads', this.language) + " | " + this.site.title
        this.loading()
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
label.vpd-icon-btn {
    width: 50px;
    height: 50px;
}

span.vpd-input-group input {
    height: 50px;
}

span.vpd-input-group {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #ccc;
}

.vpd-input-group input {
    border: unset;
}

.multiselect {
    border-radius: 0.5rem;
    padding: 0.25rem;
}

.multiselect-tag {
    background: #495464;
}

span.multiselect-clear {
    display: none;
}

span.multiselect-caret {
    margin: 0 !important;
    padding: 10px !important;
    width: 37px;
}
</style>
