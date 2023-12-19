<template>
    <siteHeader :site="site" :user="user" :show="show"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <h1 class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ $t('b2b-plus', language) }}</h1>
    </div>
    <div
        class="text-white-primary text-center bg-dark-primary md:py-4 border border-b-0 border-slate-300 relative overflow-x-auto overflow-y-hidden flex flex-nowrap justify-between md:block px-2 md:px-2">
        <router-link class="md:mx-3 mx-1 px-2 md:px-8 py-4 whitespace-nowrap" :to="{name:'siteB2bPlus'}">
            <strong> {{ $t('about', language) + " " }} </strong>
        </router-link>
        <router-link class="md:mx-3 mx-1 px-2 md:px-8 py-4 whitespace-nowrap" :to="{name:'siteContact'}">
            <strong> {{ $t('contact', language) + " " }} </strong>
        </router-link>
        <router-link class="md:mx-3 mx-1 px-2 md:px-8 py-4 whitespace-nowrap" :to="{name:'siteFaq'}">
            <strong> {{ $t('faq', language) + " " }} </strong>
        </router-link>
        <router-link class="md:mx-3 mx-1 px-2 md:px-8 py-4 whitespace-nowrap" v-for="link in item"
                     :to="{path:'/'+language+'/b2bplus/'+link.slug}">
            <strong v-if="language=='fa'"> {{ link.titleFa + " " }} </strong>
            <strong v-if="language=='en'">{{ link.titleEn }}</strong>
        </router-link>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-4 px-2">
        <div class="border rounded-lg px-5 py-4">
            <div v-show="page.image" class="w-full flex justify-center mb-6">
                <img :src="page.image">
            </div>
            <div v-if="language=='fa'" class="page leading-8" v-html="page.text.fa"></div>
            <div v-if="language=='en'" class="page leading-8" v-html="page.text.en"></div>
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
            item: '',
            page: {
                image: '',
                text: {
                    fa: '',
                    en: ''
                },
                seo: ''
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
        }
    },
    async created() {
        await axios.get('/b2bplus').then(response => {
            this.item = response.data.data
        })
        await axios.get('/pages/' + this.$route.params.page).then(response => {
            if (response.data == 'null') {
                this.$router.push({name: 'siteNotFound'})
            }
            if (response.data.images) {
                this.page.image = this.$sitename + 'upload/page/' + response.data.images.toLowerCase()
            }
            this.page.text.fa = response.data.bodyFa
            this.page.text.en = response.data.bodyEn
            if (this.language == 'fa') {
                document.title = response.data.titleFa + " | " + this.site.title
                this.page.seo = response.data.seoDescriptionFa;
            } else {
                document.title = response.data.titleEn + " | " + this.site.title
                this.page.seo = response.data.seoDescriptionEn;
            }
            document.querySelector('meta[name="description"]').setAttribute("content", this.page.seo);
        })
        this.loading();
    }

}
</script>
<style scoped>
.n-active {
    border-bottom: 2px solid #ea1b1b;
    background: #ffffff1a;
}
</style>
