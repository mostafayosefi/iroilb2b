<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <div class="bg-white-secondary p-4 md:p-10 text-center">
        <div class="relative flex flex-wrap items-stretch w-full md:w-1/2 mx-auto">
            <button @click="search()"
                    class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 bg-transparent rounded text-base items-center justify-center w-8 py-4"
                    :class="language=='fa'?'left-0 pl-3':'right-0 pr-3'">
                <i class="fe fe-search"></i>
            </button>
            <input @keyup.enter="search()" v-model="searchText" type="text" :placeholder="$t('search', language)+'...'"
                   class="py-4 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full"
                   :class="language=='fa'?'pl-10 pr-2':'pr-10 pl-2'"/>
        </div>
        <div class="w-full md:w-3/4 mx-auto mt-4 p-3 leading-8">
            <router-link v-for="tag in tags"
                         class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1"
                         :to="{path:'/'+language+'/filter/'+tag.link}">
                <span v-show="language=='fa'">{{ tag.fa + ' ' }}</span>
                <span v-show="language=='en'">{{ tag.en + ' ' }}</span>
            </router-link>
            <div class="flex justify-center">
                <button class="flex items-center" @click="moreStatus=!moreStatus">
                    <span>{{ $t('more', language) }}</span>
                    <i class="fe fe-chevrons-down"></i>
                </button>
            </div>
            <div v-show="moreStatus">
                <router-link v-for="tag in moreTags"
                             class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1 mb-1"
                             :to="{path:'/'+language+'/filter/'+tag.link}">
                    <span v-show="language=='fa'">{{ tag.fa + ' ' }}</span>
                    <span v-show="language=='en'">{{ tag.en + ' ' }}</span>
                </router-link>
            </div>
        </div>
    </div>
    <div v-show="status=='search'">
        <ul class="w-full md:w-3/4 mx-auto flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                   @click="tab='one'"
                   :class="{'text-emerald-600 bg-white': tab != 'one', 'text-white bg-dark-primary': tab == 'one'}">
                    {{ $t('companies', language) }}
                </a>
            </li>
            <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                   @click="tab='tow'"
                   :class="{'text-emerald-600 bg-white': tab != 'tow', 'text-white bg-dark-primary': tab === 'tow'}">
                    {{ $t('ads', language) }}
                </a>
            </li>
        </ul>
        <div class="w-full md:w-3/4 mx-auto mt-4 p-5 flex flex-wrap" v-show="tab=='tow'">
            <router-link v-for="ad in ads" :to="{path:'/'+language+'/ads/'+ad.slug}"
                         class="w-full md:w-[calc(25%-1rem)] mb-2 mx-2 border rounded-lg py-2 px-5 flex flex-col justify-between"
                         :dir="language=='fa'?'rtl':'ltr'">
                <p>
                    {{ ad.title }}
                </p>
                <p class="mb-2">
                    {{ $t('type', language) + ": " }}
                    <span v-show="ad.type=='sale'">{{ $t('seller', language) }}</span>
                    <span v-show="ad.type=='buy'">{{ $t('buyer', language) }}</span>
                </p>
                <div class="flex justify-between">
                    <span v-show="language=='fa'"
                          class="text-sm text-slate-400 block">
                        {{ $t('expire-at', language) + ": " + ad.expireFa }}
                    </span>
                    <span v-show="language=='en'"
                          class="text-sm text-slate-400 block">
                        {{ $t('expire-at', language) + ": " + ad.expireEn }}
                    </span>
                    <span class="!text-slate-400 text-sm">
                          <i class="text-dark-primary text-lg fe fe-more-horizontal"></i>
                    </span>
                </div>
            </router-link>
        </div>
        <div class="w-full md:w-3/4 mx-auto mb-2 px-5 py-2 flex flex-wrap" v-show="tab=='one'">
            <router-link :to="{path:'/'+language+'/co/'+co.slug}" v-for="co in company"
                         class="w-full md:w-[calc(25%-1rem)] mb-2 mx-2 border rounded-lg p-2 flex flex-col justify-between"
                         :dir="language=='fa'?'rtl':'ltr'">
                <img class="w-full mb-2 rounded-lg" v-show="co.logo!='-'"
                     :src="$sitename + 'upload/company/thunb/'+co.logo" alt="">
                <img class="w-full mb-2 rounded-lg" v-show="co.logo=='-'"
                     :src="$sitename + 'images/no-logo.jpg'" alt="no-logo">
                <div class="w-full mt-2">
                    <div v-show="co.verified=='verified'">
                        <i class="verified mx-2" :style="language=='fa'?'float:right;':'float:left;'"></i>
                    </div>
                    <span> {{ co.name }}</span>
                </div>
                <p class="!text-slate-400 text-sm mt-2">
                    {{ $t('view', language) + ' ' }}
                </p>
            </router-link>
        </div>
    </div>
    <div v-show="status=='result'">
        <div
            class="w-full md:w-3/4 md:mx-auto mt-4">
            <div class="mx-2 bg-white-secondary py-4 px-6 flex justify-between items-center rounded-2xl">
                <h3>{{ $t('result-for', language) + " " + result.search }}</h3>
                <button @click="reset()"
                        class="rounded text-base w-8 p-4">
                    <i class="fe fe-x"></i>
                </button>
            </div>
        </div>

        <div v-show="!result.ads[0] && !result.companies[0] && !result.posts[0]"
             class="w-full md:w-3/4 mx-auto mt-4 bg-white-secondary py-4 px-6 rounded-2xl text-center">
            <h3>{{ $t('no-result', language) }}</h3>
        </div>
        <div v-show="result.ads[0] || result.companies[0] || result.posts[0]">
            <ul class="w-full md:w-3/4 mx-auto flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                <li v-show="result.companies[0]" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                       @click="tab='one'"
                       :class="{'text-emerald-600 bg-white': tab != 'one', 'text-white bg-dark-primary': tab == 'one'}">
                        {{ $t('companies', language) }}
                    </a>
                </li>
                <li v-show="result.ads[0]" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                       @click="tab='tow'"
                       :class="{'text-emerald-600 bg-white': tab != 'tow', 'text-white bg-dark-primary': tab === 'tow'}">
                        {{ $t('ads', language) }}
                    </a>
                </li>
                <li v-show="result.posts[0]" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal mx-2 cursor-pointer"
                       @click="tab='three'"
                       :class="{'text-emerald-600 bg-white': tab != 'three', 'text-white bg-dark-primary': tab === 'three'}">
                        {{ $t('posts', language) }}
                    </a>
                </li>
            </ul>
            <div class="w-full md:w-3/4 mx-auto mt-2 md:mt-4 md:p-4 flex flex-wrap"
                 v-show="result.posts[0] && tab=='three'">
                <section v-for="post in result.posts"
                         class="w-full md:w-[calc(33%-15px)] p-2 mx-2 mb-4 border rounded-lg md:flex flex-col justify-between">
                    <router-link :to="{path:'/'+language+'/post/'+post.slug}"
                                 class="flex content-start justify-start items-start md:block">
                        <img v-show="post.image" :src="$sitename + 'upload/post/' + post.image"
                             :alt="post.title"
                             class="rounded h-auto md:h-64 object-cover w-1/3 md:w-full"
                             :class="language=='fa'?'ml-2':'mr-2'">
                        <h3 class="text-[1rem] md:text-lg font-bold text-dark-primary md:my-2 w-2/3 md:w-full">
                            {{ post.title }}</h3>
                    </router-link>
                    <p class="hidden md:block text-slate-500 mb-4" v-html="post.text+' ...'"></p>
                    <div class="hidden md:flex flex-row-reverse justify-between items-end">
                        <router-link class="text-dark-secondary text-sm"
                                     :to="{path:'/'+language+'/post/'+post.slug}">
                            <i class="text-dark-primary text-lg fe fe-more-horizontal"></i>
                        </router-link>
                        <span class="text-sm text-slate-400">
                             {{ $t('last-update', language) }}
                             {{ post.time }}
                        </span>
                    </div>
                </section>
            </div>
            <div class="w-full md:w-3/4 mx-auto md:mt-4 flex flex-wrap" v-show="result.ads[0] && tab=='tow'">
                <router-link v-for="ad in result.ads" class="p-2 w-full md:w-1/3"
                             :dir="language=='fa'?'rtl':'ltr'" :to="{path:'/'+language+'/ads/'+ad.slug}">
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
                                <span v-show="language=='fa'"
                                      class="text-sm text-slate-400 block">
                                    {{ $t('expire-at', language) + ": " + ad.expireFa }}
                                </span>
                            <span v-show="language=='en'"
                                  class="text-sm text-slate-400 block">
                                    {{ $t('expire-at', language) + ": " + ad.expireEn }}
                                </span>
                            <span class="!text-slate-400 text-sm">
                                    <i class="text-dark-primary text-lg fe fe-more-horizontal"></i>
                            </span>
                        </div>
                    </div>
                </router-link>
            </div>
            <section class="w-full md:w-3/4 mx-auto mb-2 rounded p-2 flex flex-wrap"
                     v-show="result.companies[0] && tab=='one'">
                <router-link v-for="co in result.companies" :to="{path:'/'+language+'/co/'+co.slug}"
                             class="w-full md:w-[calc(25%-1rem)] mb-2 mx-[0.5rem] border rounded-lg p-2 flex flex-col justify-between">
                    <img class="w-full mb-2 rounded" v-show="co.logo!='-'"
                         :src="$sitename + 'upload/company/thunb/'+co.logo" alt="">
                    <img class="w-full mb-2 rounded" v-show="co.logo=='-'"
                         :src="$sitename + 'images/no-logo.jpg'" alt="no-logo">
                    <div class="w-full mt-2">
                        <div v-show="co.verified=='verified'">
                            <i class="verified mx-2 flo"
                               :style="language=='fa'?'float:right;':'float:left;'"></i>
                        </div>
                        <span> {{ co.name }}</span>
                    </div>
                    <p class="!text-slate-400 text-sm mt-2">
                        {{ $t('view', language) + ' ' }}
                    </p>
                </router-link>
            </section>
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
            tags: [],
            moreTags: [],
            moreStatus: false,
            ads: [],
            company: [],
            tab: 'one',
            status: 'search',
            searchText: '',
            result: {
                search: '',
                ads: [],
                companies: [],
                posts: []
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
        reset() {
            this.status = 'search';
            this.searchText = '';
            this.result.search = '';
            this.result.ads = [];
            this.result.posts = [];
            this.result.companies = [];
            this.tab = 'one';
        },
        async search() {
            this.show = true;
            await axios.get('/search/' + this.searchText, {
                params: {
                    'language': this.$route.params.lang,
                }
            }).then(response => {
                this.status = 'result';
                this.result.search = response.data.search
                this.result.ads = response.data.ads;
                this.result.posts = response.data.posts;
                this.result.companies = response.data.companies;
                if (response.data.ads[0] && !response.data.companies[0]) {
                    this.tab = 'tow';
                }
                if (!response.data.ads[0] && response.data.companies[0]) {
                    this.tab = 'one';
                }
                if (!response.data.ads[0] && !response.data.companies[0] && response.data.posts[0]) {
                    this.tab = 'three';
                }
            });
            this.loading()
        }
    },
    async beforeCreate() {
        await axios.get('/advertise/all', {
            params: {
                'language': this.$route.params.lang,
            }
        }).then(response => {
            var i = 0;
            if (response.data[0]) {
                for (const res of response.data) {
                    if (i == 12) {
                        break;
                    }
                    this.ads.push({
                        type: res.type,
                        title: res.title,
                        slug: res.slug,
                        language: res.language,
                        expireFa: res.expireFa,
                        expireEn: res.expireEn
                    });
                    i++;
                }
            }
        });
        axios.get('/tags').then(response => {
            var i = 0;
            if (response.data[0]) {
                for (const res of response.data) {
                    if (i < 5) {
                        this.tags.push({
                            id: res.id,
                            fa: res.fa,
                            en: res.en,
                            link: res.link,
                        });
                    } else {
                        this.moreTags.push({
                            id: res.id,
                            fa: res.fa,
                            en: res.en,
                            link: res.link,
                        });
                    }
                    i++;
                }
            }
        })

        await axios.get('/company/all', {
            params: {
                'language': this.$route.params.lang,
            }
        }).then(response => {
            var i = 0;
            if (response.data[0]) {
                for (const res of response.data) {
                    if (i == 8) {
                        break;
                    }
                    this.company.push({
                        logo: res.logo,
                        name: res.name,
                        slug: res.slug,
                        verified: res.verified
                    });
                    i++;
                }
            }
        });
        document.title = this.$t('search', this.$route.params.lang) + " | " + this.site.title
        this.loading();
    }

}
</script>
<style scoped>
.n-active {
    border-bottom: 2px solid #ea1b1b;
}

.verified {
    background: url("/images/verified.svg") no-repeat;
    background-size: 20px;
    width: 20px;
    height: 20px;
}
</style>
