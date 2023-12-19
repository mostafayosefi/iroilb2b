<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <h1 class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ cat.title }}</h1>
    </div>

    <div class="w-full md:w-4/5 mx-auto mt-4 px-2 md:px-0">
        <div class="mx-auto my-4 border rounded-lg p-5 bg-white leading-8 text-justify">
            {{ cat.description }}
        </div>
        <div class="px-2 w-full md:flex flex-wrap justify-between">
            <section v-for="post in posts"
                     class="w-full md:w-[calc(33%-13px)] p-2 mb-4 border rounded-lg md:flex flex-col justify-between">
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
            posts: [],
            cat: {
                title: '',
                description: ''
            }
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
    },
    beforeCreate() {
        axios.get('/blog/categories',
            {
                params: {
                    lang: this.$route.params.lang,
                    slug: this.$route.params.cat
                }
            }).then(response => {
            if (response.data == 'null') {
                this.$router.push({name: 'siteNotFound'})
            } else {
                this.cat.title = response.data.cat.title
                this.cat.description = response.data.cat.description
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

            }
            document.title = this.$t('blog', this.language) + " | " + this.site.title
            document.querySelector('meta[name="description"]').setAttribute("content", response.data.cat.description.substring(0, 320));
        })
    },

}
</script>
