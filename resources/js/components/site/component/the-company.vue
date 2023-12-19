<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <h1 class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
            {{ $t('companies', language) }}
        </h1>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-4 p-5 flex flex-wrap">
        <div v-for="co in company" class="p-2 w-full md:w-1/3">
            <router-link :to="{path:'/'+language+'/co/'+co.slug}">
                <div class="border rounded py-2 px-5">
                    <img class="w-full mb-2 mt-2 rounded" v-show="co.logo!='-'"
                         :src="$sitename + 'upload/company/thunb/'+co.logo" alt="">
                    <img class="w-full mb-2 mt-2 rounded" v-show="co.logo=='-'"
                         :src="$sitename + 'images/no-logo.jpg'" alt="no-logo">
                    <div class="w-full mt-4">
                        <div v-show="co.verified=='verified'">
                            <i class="verified mx-2 flo" :style="language=='fa'?'float:right;':'float:left;'"></i>
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
    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    data() {
        return {
            language: this.$route.params.lang,
            company: [],
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
        axios.get('/company/all', {
            params: {
                'language': this.language
            }
        }).then(response => {
            this.company = response.data;
        });

        document.title = this.$t('companies', this.language) + " | " + this.site.title
        document.querySelector('meta[name="description"]').setAttribute("content", this.$t('company-desc', this.language));

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
