<template>
    <siteHeader :site="site" :user="user"></siteHeader>
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
            <div class="w-full md:w-1/2 mx-auto p-4 text-center">
                <span>{{ $t('feed-message', language) }}</span>
                <textarea
                    class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                    rows="5"
                    :dir="language=='fa'?'rtl':'ltr'" v-model="feedBack.text"></textarea>
                <div class="w-full text-center">
                    <button @click="submit()" type="button"
                            class="btn border border-solid border-gray-300 rounded-lg px-4 py-2 text-dark-primary">
                        {{ $t('submit', language) }}
                    </button>
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
            feedBack: {
                text: '',
                companyId: '',
            },
            isLoading: false,
        }
    },
    methods: {
        submit() {
            this.isLoading = true;
            const sentData = {
                body: this.feedBack,
                lang: this.language,
                id: this.$cookies.get('user').id,
                step: this.user.step,
            }
            axios.post("/form/feedback", sentData).then((response) => {
                if (response.data.status == 200) {
                    this.$router.push({name: 'sitePanel'})
                    this.$emit('getUser');
                    this.feedBack.text = '';
                }
            })
        }
    },
    beforeCreate() {
        document.title = this.$t('feedback', this.$route.params.lang) + " | " + this.site.title
        axios.get('/company/user', {
            params: {
                'api_token': this.$cookies.get('user').token,
                'id': this.$cookies.get('user').id,
                'language': this.language,
            }
        }).then(response => {
            this.feedBack.companyId = response.data[0].data.id;
        }).catch(() => {
        });
    },
}
</script>
