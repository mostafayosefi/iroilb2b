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
    <section class="flex mb-14 items-start">
        <aside
            class="bg-dark-primary md:w-2/6 xl:w-1/6 min-h-[calc(100vh-140px)] hidden md:flex flex-wrap content-between">
            <panelSideBar :site="site" :user="user"></panelSideBar>
        </aside>
        <div class="w-full flex flex-wrap content-start">
            <p v-show="!ads[0]" class="w-1/2 mx-auto mt-2 p-2 text-center border rounded-lg ">
                {{ $t('empty-list', language) }}
            </p>
            <section v-for="ad in ads" class="p-2 w-full md:w-1/3"
                     :dir="language=='fa'?'rtl':'ltr'">
                <router-link :to="{path:'/'+language+'/ads/'+ad.slug}">
                    <div class="border rounded py-2 px-5">
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
                            {{ $t('view', language) + ' ' }}
                        </span>
                        </div>
                    </div>
                </router-link>
            </section>
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
            show: false,
            ads: [],
            isLoading: false,
        }
    },
    methods: {
        loading() {
            this.show = false;
        },
    },
    created() {
        // get user bookmark
        axios.get('/advertise/bookmark', {
            params: {
                'api_token': this.$cookies.get('user').token,
                'user': this.$cookies.get('user').id,
            }
        }).then(response => {
            if (response.data[0]) {
                for (const res of response.data) {
                    this.ads.push({
                        type: res.type,
                        title: res.title,
                        slug: res.slug,
                        language: res.language,
                        expireFa: res.expireFa,
                        expireEn: res.expireEn
                    });
                }
            }

        });
        // page title
        document.title = this.$t('bookmarks', this.language) + " | " + this.site.title
    },
}
</script>
