<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <div class="bg-white-secondary px-2 pb-6 md:p-10 text-center mb-2">
        <h1 class="text-3xl font-bold text-dark-primary pt-6 pb-4 leading-[3rem]">
            <button v-if="$cookies.isKey('user')" @click="bookmark()">
                <svg :class="favorite.status==true?'fill-dark-primary':''" xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-bookmark">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
            </button>
            {{ ad.body.title }}
        </h1>
        <h2 class="flex justify-center">
            <div v-show="company.verified=='verified'">
                <i class="verified mx-2" :style="language=='fa'?'float:right;':'float:left;'"></i>
            </div>
            <router-link :to="{path:'/'+language+'/co/'+company.link}" class="mb-2 underline underline-offset-8">
                {{ company.name }}
            </router-link>
        </h2>
        <h3 class="mt-2">
            <router-link v-for="tag in ad.body.tags"
                         class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1"
                         :to="{path:'/'+language+'/filter/'+tag.link}">
                <span v-show="language=='fa'">{{ tag.fa + ' ' }}</span>
                <span v-show="language=='en'">{{ tag.en + ' ' }}</span>
            </router-link>
        </h3>
    </div>
    <div class="w-100 md:w-3/4 text-center my-2 mx-auto flex justify-center flex-wrap">
        <div class="border border-slate-300 hover:border-slate-800 mx-[10px] mb-2 p-2 rounded-lg text-right">
            {{ $t('type', language) }}:
            <span v-show="ad.type=='buy'">{{ $t('buy', language) }}</span>
            <span v-show="ad.type=='sale'">{{ $t('sale', language) }}</span>
        </div>
        <div class="border border-slate-300 hover:border-slate-800 mx-[10px] mb-2 p-2 rounded-lg text-right">
            {{ $t('weight', language) }}:
            <span>{{ ad.body.weight }}</span>
        </div>
        <div class="border border-slate-300 hover:border-slate-800 mx-[10px] mb-2 p-2 rounded-lg text-right">
            {{ $t('price', language) }}:
            <span>{{ ad.body.price }}</span>
        </div>
        <div v-show="ad.body.description.length>0"
             class="border border-slate-300 hover:border-slate-800 mx-[10px] mb-2 p-2 rounded-lg text-right">
            {{ $t('description', language) }}:
            <span>{{ ad.body.description }}</span>
        </div>
    </div>
    <div class="w-3/4 text-center my-2 mx-auto">
        {{ $t('expire-in', language) }}:
    </div>
    <Countdown countdownSize="2rem" :deadline="ad.time" mainFlipBackgroundColor="#495464"
               secondFlipBackgroundColor="#73787F" mainColor="#E8E8E8" secondFlipColor="#F4F4F2"
               :labels="language=='fa'?{days: 'روز',hours: 'ساعت',minutes: 'دقیقه',seconds: 'ثانیه',}:{days: 'Days',hours: 'Hours',minutes: 'Minutes',seconds: 'Seconds',}"/>
    <!--    show related advertise-->
    <div v-show="related[0]" class="w-full md:w-3/4 mx-auto mt-4 p-2">
        <p class="text-center font-bold my-4">
            {{ $t('related-ads', language) }}
        </p>
        <section class="flex flex-wrap">
            <router-link v-for="ad in related" class="p-2 w-full md:w-1/3" :to="{path:'/'+language+'/ads/'+ad.slug}"
                         :key="ad.id"
                         :dir="language=='fa'?'rtl':'ltr'">
                <section class="border rounded-lg py-2 px-5">
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
                </section>
            </router-link>
        </section>
    </div>
    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";
import 'vue-rate/dist/vue-rate.css'
import {Countdown} from 'vue3-flip-countdown'

export default {
    data() {
        return {
            favorite: {
                status: false,
                user: '',
                ads: '',
            },
            language: this.$route.params.lang,
            company: {
                name: '',
                verified: '',
                link: ''
            },
            ad: {
                status: '',
                id: '',
                slug: null,
                language: '',
                type: '',
                body: {
                    title: '',
                    weight: '',
                    tags: [],
                    country: '',
                    price: '',
                    description: ''
                },
                time: '2022/1/1',
                expire: '',
            },
            related: []
        }
    },
    props: {
        site: Object,
        user: Object,
        show: Boolean
    },
    emits: ['getUser'],
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue')),
        Countdown
    }, methods: {
        bookmark() {
            if (this.favorite.status == true) {
                axios.delete("/bookmark/remove", {
                    params: {
                        'api_token': this.$cookies.get('user').token,
                        'user': this.$cookies.get('user').id,
                        "ads": this.ad.id
                    }
                }).then((response) => {
                    if (response.data.status == 200) {
                        this.favorite.status = false;
                    }
                })
            } else {
                const sentData = {
                    'api_token': this.$cookies.get('user').token,
                    'user': this.$cookies.get('user').id,
                    "ads": this.ad.id
                }
                axios.post("/bookmark/add", sentData).then((response) => {
                    if (response.data.status == 200) {
                        this.favorite.status = true;
                    }
                })
            }
        }
    },
    async beforeCreate() {
        var id = this.$cookies.isKey('user') ? this.$cookies.get('user').id : '-'
        await axios.get('/advertise/single/' + this.$route.params.slug, {
            params: {
                user: id
            }
        }).then(response => {
            if (response.data == 'null') {
                this.$router.push({name: 'siteNotFound'})
            }
            this.favorite.status = response.data.bookmark;
            if (this.$route.params.lang == 'fa') {
                this.company.name = response.data.company.fa == '-' ? response.data.company.en : response.data.company.fa;
            } else {
                this.company.name = response.data.company.en == '-' ? response.data.company.fa : response.data.company.en;
            }
            this.company.verified = response.data.company.verified
            this.company.link = response.data.company.link
            this.ad.type = response.data.type
            this.ad.id = response.data.id
            this.ad.time = response.data.time
            this.ad.expire = response.data.expire
            this.ad.body.title = response.data.body.title
            this.ad.body.weight = response.data.body.weight
            this.ad.body.country = response.data.body.country
            this.ad.body.tags = response.data.tags
            this.ad.body.price = response.data.body.price
            this.ad.body.description = response.data.body.description ? response.data.body.description : ''
            // related ads
            this.related = response.data.related
            // title page
            document.title = this.ad.body.title + " | " + this.site.title;
            // seo description
            document.querySelector('meta[name="description"]').setAttribute("content", this.ad.body.title.substring(0, 320));
        })
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
</style>


