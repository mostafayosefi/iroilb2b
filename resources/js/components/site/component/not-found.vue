<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <section class="w-full md:w-1/3 mx-auto flex justify-center">
        <img class="w-full mt-10" src="/images/404.jpg" alt="404">
    </section>
    <div class="my-6 mx-auto w-1/2 text-center">
        <router-link :to="{name:'siteHome'}" class="btn bg-black mt-2 text-white p-4 rounded-lg">
            {{ $t('back-home', language) }}
        </router-link>
    </div>

    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";

export default {
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    },
    data() {
        return {
            language: this.$route.params.lang,
        }
    },
    emits: ['getUser'],
    created() {
        document.title = "404" + " | " + this.site.title
    }
}
</script>
