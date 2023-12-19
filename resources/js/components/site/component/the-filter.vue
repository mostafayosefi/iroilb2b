<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <div class="relative flex flex-wrap items-stretch w-1/2 mx-auto">
            <h1 class="mx-auto leading-[3rem] font-bold" v-if="language=='fa' && title.fa">
                {{ title.fa }}
            </h1>
            <h1 class="mx-auto leading-[3rem] font-bold" v-else-if="language=='en' && title.en">
                {{ title.en }}
            </h1>
        </div>
    </div>
    <div>
        <ul class="w-full md:w-3/4 mx-auto flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
            <li v-show="companies[0]" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                   @click="tab='one'"
                   :class="{'text-emerald-600 bg-white': tab != 'one', 'text-white bg-dark-primary': tab == 'one'}">
                    {{ $t('companies', language) }}
                </a>
            </li>
            <li v-show="ads[0]" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                   @click="tab='tow'"
                   :class="{'text-emerald-600 bg-white': tab != 'tow', 'text-white bg-dark-primary': tab === 'tow'}">
                    {{ $t('ads', language) }}
                </a>
            </li>
        </ul>
        <div class="w-full md:w-3/4 mx-auto mt-4 rounded p-5" v-show="ads[0] && tab=='tow'">
            <div class="flex flex-wrap">
                <div v-for="ad in ads" class="p-2 w-full md:w-1/3"
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
                </div>
            </div>
        </div>
        <div class="w-full md:w-3/4 mx-auto mb-2 rounded px-5 py-2" v-show="companies[0] && tab=='one'">
            <div class="flex flex-wrap">
                <div v-for="co in companies" class="p-2 w-full md:w-1/4">
                    <router-link :to="{path:'/'+language+'/co/'+co.slug}">
                        <div class="border rounded py-2 px-5">
                            <img class="w-full mb-2 mt-2 rounded" v-show="co.logo!='-'"
                                 :src="$sitename + 'upload/company/thunb/'+co.logo" alt="">
                            <div class="w-full mt-4">
                                <div v-show="co.verified=='verified'">
                                    <i class="verified mx-2 flo"
                                       :style="language=='fa'?'float:right;':'float:left;'"></i>
                                </div>
                                <span> {{ co.name }}</span>
                            </div>
                            <div class="mt-2 mx-2">
                            <span class="!text-slate-400 text-sm">
                                {{ $t('view', language) + ' ' }}
                            </span>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    data() {
        return {
            show: true,
            language: this.$route.params.lang,
            ads: [],
            companies: [],
            tab: 'one',
            title: {
                fa: '',
                en: ''
            }
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
        loading() {
            this.show = false;
        },
    },
    async beforeCreate() {
        await axios.get('/tags/' + this.$route.params.slug, {
            params: {
                'language': this.$route.params.lang,
            }
        }).then(response => {
            if (response.data == 'null') {
                window.location.replace(this.$sitename + this.$route.params.lang + '/404');
            }
            this.ads = response.data.ads
            this.companies = response.data.companies
            this.title.en = response.data.titleEn
            this.title.fa = response.data.titleFa
        });
        document.title = this.$t('search', this.$route.params.lang) + " | " + this.site.title
        this.loading();

    }

}
</script>
<style scoped>
.verified {
    background: url("/images/verified.svg") no-repeat;
    background-size: 20px;
    width: 20px;
    height: 20px;
}
</style>
