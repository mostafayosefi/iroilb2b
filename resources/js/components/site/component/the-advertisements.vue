<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <h1 class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ $t('ads', language) }}
        </h1>
        <button @click="filter('all')" class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1"
                :class="active=='all'?'border-red-500 border-b-2':''">
            {{ $t('all', language) + ' ' }}
        </button>
        <button @click="filter('sale')" class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1"
                :class="active=='sale'?'border-red-500 border-b-2':''">
            {{ $t('sale', language) + ' ' }}
        </button>
        <button @click="filter('buy')" class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1"
                :class="active=='buy'?'border-red-500 border-b-2':''">
            {{ $t('buy', language) + ' ' }}
        </button>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-4 p-5 flex flex-wrap">
        <div v-for="ad in show" class="p-2 w-full md:w-1/3"
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
        <p v-show="!show[0]" class="mx-auto mt-2 p-2 text-center border rounded-lg ">
            {{ $t('empty-ads', language) }}
        </p>
    </div>
    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    data() {
        return {
            language: this.$route.params.lang,
            ads: [],
            active: 'all',
            show: []
        }
    },
    emits: ['getUser'],
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    },
    methods: {
        filter(type) {
            this.active = type;
            if (type == 'all') {
                this.show = this.ads;
            }
            if (type == 'sale') {
                this.show = this.ads.filter(item => item.type == type);
            }
            if (type == 'buy') {
                this.show = this.ads.filter(item => item.type == type);
            }
        }
    },
    created() {
        axios.get('/advertise/all', {
            params: {
                'language': this.language
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
                this.show = this.ads;
            }

        });
        document.title = this.$t('ads', this.language) + " | " + this.site.title
        document.querySelector('meta[name="description"]').setAttribute("content", this.$t('ads-desc', this.language));
    },

}
</script>
<style scoped>
.n-active {
    border-bottom: 2px solid #ea1b1b;
}
</style>
