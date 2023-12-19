<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-white-secondary p-10 text-center leading-8">
        <h1 class="text-3xl font-bold text-dark-primary py-6">
            {{ $t('blog', language) }}</h1>
        <router-link v-for="cat in cats" :to="{path:'/'+language+'/blog/'+cat.slug}" class="text-sm bg-dark-primary rounded text-white-primary py-1 px-2 mx-1 mb-1">
                {{ cat.title }}
        </router-link>
    </div>

    <div class="w-4/5 mx-auto mt-4" v-show="error">
        {{ $t('no-item', language) }}
    </div>
    <div class="w-full md:w-3/4 mx-auto mt-2 md:mt-4 md:p-4 flex flex-wrap">
        <section v-for="post in posts"
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

export default {
    data() {
        return {
            language: this.$route.params.lang,
            error: false,
            posts: [],
            cats: [],
        }
    },
    emits: ['getUser'],
    props: {
        site: Object,
        user: Object,
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    },
    beforeCreate() {
        axios.get('/blog',
            {
                params: {
                    lang: this.$route.params.lang
                }
            }).then(response => {
            if (response.data == 'null') {
                this.error = true
            } else {
                for (const responseElement of response.data.data) {
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
                }
                for (const responseElement of response.data.cat) {
                    this.cats.push({
                        title: responseElement.title,
                        slug: responseElement.slug,
                    });
                }

            }
            document.title = this.$t('blog', this.language) + " | " + this.site.title
        })
    },


}
</script>
