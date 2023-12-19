<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <div v-for="data in page.text" v-show="data.show=='search'">
        <div class="p-10 text-center" :style="'background:'+data.background">
            <h2 class="text-3xl font-bold pt-6" :style="'color:'+data.color">
                {{ data.title }}
            </h2>
            <p class="text-sm pb-6 mt-4" :style="'color:'+data.color">
                {{ data.text }}
            </p>
        </div>
    </div>
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
        <div class="w-3/4 mx-auto mt-4 leading-8">
            <router-link v-for="tag in tags"
                         class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1 mb-1"
                         :to="{path:'/'+language+'/filter/'+tag.link}">
                <span v-show="language=='fa'">{{ tag.fa + ' ' }}</span>
                <span v-show="language=='en'">{{ tag.en + ' ' }}</span>
            </router-link>
            <div class="flex justify-center">
                <button class="flex items-center" @click="moreStatus=!moreStatus" v-show="!moreStatus">
                    <span>{{ $t('more', language) }}</span>
                    <i class="fe fe-chevrons-down"></i>
                </button>
                <button class="flex items-center" @click="moreStatus=!moreStatus" v-show="moreStatus">
                    <span>{{ $t('hide', language) }}</span>
                    <i class="fe fe-chevrons-up"></i>
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
    <div v-for="data in page.text" v-show="data.show=='advertise'">
        <div class="p-10 text-center" :style="'background:'+data.background">
            <h2 class="text-3xl font-bold pt-6" :style="'color:'+data.color">
                {{ data.title }}
            </h2>
            <p class="text-sm pb-6 mt-4" :style="'color:'+data.color">
                {{ data.text }}
            </p>
        </div>
    </div>
    <div class="w-full md:w-3/4 mx-auto mt-2 md:mt-4 rounded p-2 md:p-5">
        <div class="flex justify-between border-b pb-4 mb-4">
            <strong>{{ $t('ads', language) }}</strong>
            <router-link :to="{name:'siteAds'}">
                {{ $t('view-all', language) + ' ' }}
            </router-link>
        </div>
        <div class="relative overflow-auto flex flex-nowrap md:flex-wrap md:justify-between">
            <router-link :to="{path:'/'+language+'/ads/'+ad.slug}" v-for="ad in ads"
                         class="max-[1024px]:min-w-[46%] max-[768px]:min-w-[70%] md:w-[calc(25%-1rem)] mb-2 mx-2 border rounded-lg py-2 px-5 flex flex-col justify-between"
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
    </div>
    <div v-for="data in page.text" v-show="data.show=='company'">
        <div class="p-10 text-center" :style="'background:'+data.background">
            <h2 class="text-3xl font-bold pt-6" :style="'color:'+data.color">
                {{ data.title }}
            </h2>
            <p class="text-sm pb-6 mt-4" :style="'color:'+data.color">
                {{ data.text }}
            </p>
        </div>
    </div>
    <div class="bg-dark-primary p-10 text-center mb-4">
        <h2 class="text-3xl font-bold text-white-primary pt-6">
            {{ $t('companies', language) }}</h2>
        <router-link class="!text-slate-400 text-sm pb-6" :to="{name:'siteCompany'}">
            {{ $t('view-all', language) + ' ' }}
        </router-link>
    </div>
    <section
        class="relative overflow-auto flex flex-nowrap md:flex-wrap md:justify-between p-2 w-full md:w-3/4 mx-auto">
        <router-link :to="{path:'/'+language+'/co/'+co.slug}" v-for="co in company"
                     class="max-[1024px]:min-w-[46%] max-[768px]:min-w-[70%] md:w-[calc(25%-1rem)] mb-2 mx-2 border rounded-lg p-2 flex flex-col justify-between"
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
    </section>
    <div v-for="data in page.text" v-show="data.show=='blog'">
        <div class="p-10 text-center" :style="'background:'+data.background">
            <h2 class="text-3xl font-bold pt-6" :style="'color:'+data.color">
                {{ data.title }}
            </h2>
            <p class="text-sm pb-6 mt-4" :style="'color:'+data.color">
                {{ data.text }}
            </p>
        </div>
    </div>
    <div class="bg-white-secondary p-10 text-center">
        <h2 class="text-3xl font-bold text-dark-primary pt-6">
            {{ $t('articles', language) }}</h2>
        <router-link class="!text-slate-400 text-sm pb-6" :to="{name:'siteBlog'}">
            {{ $t('view-all', language) + ' ' }}
        </router-link>
    </div>
    <div class="w-full md:w-3/4 mx-auto mt-2 md:mt-4 md:p-4 flex flex-wrap">
        <section v-for="post in posts"
                 class="w-full md:w-[calc(33%-13px)] p-2 mx-2 mb-4 border rounded-lg md:flex flex-col justify-between">
            <router-link class="flex content-start justify-start items-start md:block"
                         :to="{path:'/'+language+'/post/'+post.slug}">
                <img v-show="post.image" :src="post.image" :alt="post.title"
                     class="rounded h-auto md:h-64 object-cover w-1/3 md:w-full"
                     :class="language=='fa'?'ml-2':'mr-2'">
                <h3 class="text-[1rem] md:text-lg font-bold text-dark-primary md:my-2 w-2/3 md:w-full">
                    {{ post.title }}
                </h3>
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
    <div v-for="data in page.text" v-show="data.show=='words'">
        <div class="p-10 text-center" :style="'background:'+data.background">
            <h2 class="text-3xl font-bold pt-6" :style="'color:'+data.color">
                {{ data.title }}
            </h2>
            <p class="text-sm pb-6 mt-4" :style="'color:'+data.color">
                {{ data.text }}
            </p>
        </div>
    </div>

    <div class="pt-0 px-4 pb-4 md:p10 md:px-10 text-center" v-show="feedback[0]">
        <hr class="border-t">
        <h2 class="text-3xl font-bold text-dark-primary pt-2 md:pt-6">
            {{ $t('customers-words', language) }}</h2>
    </div>
    <div class="w-full md:w-3/4 mx-auto mb-4 p-2 md:p-0" v-show="feedback[0]">
        <div class="p-6 w-full md:w-2/3 border-2 rounded-lg mx-auto text-center">
            <div v-for="(feed , index) in feedback" :key="index">
                <div v-if="index==count">
                    <h2>{{ feed.text }}</h2>
                    <br>
                    <router-link class="!text-slate-400 text-sm" :to="{path:'/'+language+'/co/'+feed.slug}">
                        <div v-if="feed.company.en">
                            <span v-if="language=='en'">{{ feed.company.en }}</span>
                            <span v-else>{{ feed.company.fa }}</span>
                        </div>
                        <div v-else>
                            <span v-if="language=='fa'">{{ feed.company.fa }}</span>
                            <span v-else>{{ feed.company.en }}</span>
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="mt-2">
                <button v-for="(feed , index) in feedback" :key="index" class="inline mx-1 bouble" @click="count=index"
                        :style="count==index?'background:#555;':''"></button>
            </div>
        </div>
    </div>
    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    props: {
        site: Object,
        user: Object
    },
    emits: ['getUser'],
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    },
    data() {
        return {
            show: true,
            count: 0,
            language: this.$route.params.lang,
            tags: [],
            moreTags: [],
            moreStatus: false,
            ads: [],
            posts: [],
            company: [],
            feedback: [],
            result: {
                search: '',
                ads: [],
                companies: [],
                posts: []
            },
            tab: 'one',
            status: 'search',
            searchText: '',
            page: {
                text: [],
                seo: ''
            }
        }
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
        await axios.get('/pages/home').then(response => {
            if (this.$route.params.lang == 'fa' && response.data.data.bodyFa) {
                if (response.data.data.bodyFa[0]) {
                    for (const res of response.data.data.bodyFa) {
                        this.page.text.push({
                            show: res.show,
                            title: res.title,
                            text: res.text,
                            color: res.color,
                            background: res.background,
                        });
                    }
                }
                document.title = response.data.data.titleFa + " | " + this.site.title
                this.page.seo = response.data.data.seoDescriptionFa;
            } else if (this.$route.params.lang == 'en' && response.data.data.bodyEn) {
                for (const res of response.data.data.bodyEn) {
                    this.page.text.push({
                        show: res.show,
                        title: res.title,
                        text: res.text,
                        color: res.color,
                        background: res.background,
                    });
                }
                document.title = response.data.data.titleEn + " | " + this.site.title
                this.page.seo = response.data.data.seoDescriptionEn;
            }
            document.querySelector('meta[name="description"]').setAttribute("content", this.page.seo);
        })

        await axios.get('/tags').then(response => {
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

        await axios.get('/advertise/all', {
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

        await axios.get('/company/all', {
            params: {
                'language': this.$route.params.lang,
            }
        }).then(response => {
            var i = 0;
            if (response.data) {
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
        await axios.get('/blog',
            {
                params: {
                    lang: this.$route.params.lang,
                }
            }).then(response => {
            if (response.data == 'null') {
                this.error = true
            } else {
                var i = 0;
                if (response.data.data) {
                    for (const responseElement of response.data.data) {
                        if (i == 6) {
                            break;
                        }
                        let image = '';
                        if (responseElement.image) {
                            image = this.$sitename + 'upload/post/' + responseElement.image.toLowerCase()
                        } else {
                            image = false;
                        }
                        this.posts.push({
                            image: image,
                            title: responseElement.title,
                            text: responseElement.text,
                            slug: responseElement.slug,
                            time: responseElement.time,
                        });
                        i++;
                    }
                }
            }
        })
        await axios.get('/feedback', {
            params: {
                'language': this.$route.params.lang
            }
        }).then(response => {
            this.feedback = response.data
        })
        this.loading();
    }
}
</script>
<style>
.verified {
    background: url("/images/verified.svg") no-repeat;
    background-size: 20px;
    width: 20px;
    height: 20px;
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.bouble {
    width: 10px;
    height: 10px;
    background: #bdbdbd;
    border-radius: 10px;
}
</style>
