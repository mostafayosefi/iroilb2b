<template>
    <component :is="'script'" type="application/ld+json">
        {
        "@context": "https://schema.org/",
        "@type": "CreativeWorkSeries",
        "name": "{{ post.title }}",
        "aggregateRating": {
        "@type": "AggregateRating",
        "itemReviewed":"{{ post.title }}",
        "ratingValue": "{{ Number(score).toFixed(1) }}",
        "bestRating": "5",
        "ratingCount": "{{ count }}"
        }
        }
    </component>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-dark-primary text-white-primary pt-6 md:pt-10 pb-24 md:pb-32 text-center">
        <div class="flex flex-col-reverse md:flex-row items-center justify-center">
            <p class="rounded text-sm text-dark-primary bg-white-primary mx-3 px-1 pt-1">
                <i class=" mx-1 fe fe-eye"></i>
                <span class="pt-1 px-1">
                    {{ post.view }}
                </span>
            </p>
            <h1 class="text-3xl font-bold py-6 leading-[3rem]">
                {{ post.title }}
            </h1>
        </div>
        <div class="hidden md:block">
            <div class="flex items-center justify-center">
                <span class="text-sm">{{ $t('published', language) + ": " + post.created }} </span>
                <span class="text-sm mx-2"> {{ $t('last-update', language) + ": " + post.time }}</span>
                <router-link class="mx-1" v-for="cat in cat" :to="{path:'/'+language+'/blog/'+cat.slug}">
                <span class="text-white-primary text-sm">
                    #{{ cat.title }}
                </span>
                </router-link>
                <router-link class="mx-1" v-for="label in labels" :to="{path:'/'+language+'/tag/'+label.slug}">
                <span class="text-white-primary text-sm">
                    #{{ label.title }}
                </span>
                </router-link>
            </div>
        </div>
    </div>

    <div class="w-full md:w-3/4 -mt-12 md:mx-auto">
        <div class="mx-2  border rounded-lg p-4 bg-white">
            <div v-show="post.image.length>10" class="w-full flex justify-center mb-6">
                <img :src="post.image">
            </div>
            <div class="page leading-8" v-html="post.text"></div>
            <div class="block md:hidden mt-4">
                <div :class="language=='fa'?'text-right':'text-left'">
                    <p class="w-full text-sm">{{ $t('published', language) + ": " + post.created }} </p>
                    <p class="w-full text-sm">{{ $t('last-update', language) + ": " + post.time }}</p>
                    <router-link class="mx-1" v-for="cat in cat" :to="{path:'/'+language+'/blog/'+cat.slug}">
                <span class="text-dark-primary text-sm">
                    #{{ cat.title }}
                </span>
                    </router-link>
                    <router-link class="mx-1" v-for="label in labels" :to="{path:'/'+language+'/tag/'+label.slug}">
                <span class="text-white-primary text-sm">
                    #{{ label.title }}
                </span>
                    </router-link>
                </div>
            </div>
            <div class="w-full md:w-1/3 mx-auto border rounded-lg p-5 mt-8 text-center">
                <span v-show="!rateState"> {{ $t('rate-post', language) }}</span>
                <span v-show="rateState"> {{ $t('rate-message', language) }}</span>
                ({{ Number(score).toFixed(1) }}) - {{ count }}
                <rate :length="5" :value="4" :showcount="true" v-model="rate" @after-rate="onAfterRate"
                      :disabled="rateState"/>
            </div>
        </div>
    </div>
    <div v-show="relatedShow" class="bg-white-primary text-center text-dark-primary my-6 py-10">
        <strong class="text-xl">
            {{ $t('similar-content', language) }}
        </strong>

    </div>
    <div class="w-full md:w-3/4 mx-auto mt-2 md:mt-4 md:p-4 flex flex-wrap">
        <section v-for="post in related"
                 class="w-full md:w-[calc(33%-13px)] p-2 mx-2 mb-4 border rounded-lg md:flex flex-col justify-between">
            <router-link class="flex content-start justify-start items-start md:block"
                         :to="{path:'/'+language+'/post/'+post.slug}">
                <img v-show="post.image" :src="post.image" :alt="post.title"
                     class="rounded h-auto md:h-64 object-cover w-1/3 md:w-full" :class="language=='fa'?'ml-2':'mr-2'">
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
    <siteFooter :site="site"></siteFooter>
</template>
<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";
import 'vue-rate/dist/vue-rate.css'

export default {
    data() {
        return {
            language: this.$route.params.lang,
            post: {
                id: '',
                title: '',
                image: '',
                text: '',
                seoDescription: '',
                seoKeyword: [],
                time: '',
                created: '',
                view: ''
            },
            cat: [],
            labels: [],
            related: [],
            relatedShow: false,
            rate: '',
            count: '',
            score: '',
            rateState: false,
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
        onAfterRate(rate) {
            this.rateState = true
            const sentData = {
                "post": this.post.id,
                "rate": rate
            }
            axios.post("/blog/rate", sentData).then((response) => {
                if (response.data.status == 200) {
                    //
                }
            })
        }
    },
    beforeCreate() {
        axios.get('/blog/post/' + this.$route.params.post,
            {
                params: {
                    lang: this.$route.params.lang
                }
            }).then(response => {
            if (response.data == 'null') {
                window.location.replace(this.$sitename + this.$route.params.lang + '/404');
            }
            if (response.data.post.images) {
                this.post.image = this.$sitename + 'upload/post/' + response.data.post.images.toLowerCase()
            }
            if (response.data.cat != null) {
                for (const responseElement of response.data.cat) {
                    this.cat.push({
                        title: responseElement.title,
                        slug: responseElement.slug
                    });
                }
            }
            if (response.data.label != null) {
                for (const responseElement of response.data.label) {
                    this.labels.push({
                        title: responseElement.title,
                        slug: responseElement.slug
                    });
                }
            }

            if (response.data.related != null) {
                this.relatedShow = true;
                for (const responseElement of response.data.related) {
                    let image = '';
                    if (responseElement.image) {
                        image = this.$sitename + 'upload/post/' + responseElement.image.toLowerCase()
                    } else {
                        image = false;
                    }
                    this.related.push({
                        image: image,
                        title: responseElement.title,
                        text: responseElement.text,
                        slug: responseElement.slug,
                        time: responseElement.time,
                    });
                }
            }
            this.post.id = response.data.post.id
            this.post.title = response.data.post.title
            this.post.text = response.data.post.body
            this.post.time = response.data.time
            this.post.created = response.data.created
            this.post.view = response.data.post.views
            this.score = response.data.rate
            this.count = response.data.count
            this.post.seoDescription = response.data.post.seoDes;
            this.post.seoKeyword = response.data.post.seoKay;
            document.title = response.data.post.title + " | " + this.site.title
            document.querySelector('meta[name="description"]').setAttribute("content", this.post.seoDescription);
            document.querySelector('meta[name="keywords"]').setAttribute("content", this.post.seoKeyword);
        })
    }

}
</script>

