<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <h1 v-if="language=='fa'" class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ page.title.fa }}</h1>
        <h1 v-if="language=='en'" class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ page.title.en }}</h1>
    </div>

    <div class="w-full md:w-3/4 mx-auto my-4 px-2">
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
            language: this.$route.params.lang,
            page: {
                title: {
                    fa: '',
                    en: ''
                },
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
    created() {
        axios.get('/pages/' + this.$route.params.page).then(response => {
            if (response.data == 'null') {
                this.$router.push({name: 'siteNotFound'})
            }
            if (response.data.images) {
                this.page.image = this.$sitename + 'upload/page/' + response.data.images.toLowerCase()
            }
            this.page.title.fa = response.data.titleFa
            this.page.title.en = response.data.titleEn
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
    }

}
</script>
<style scoped>
.n-active {
    border-bottom: 2px solid #ea1b1b;
}
</style>
