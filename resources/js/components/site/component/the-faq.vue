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

    <div class="w-full md:w-3/4 mx-auto">
        <div class="p-5">
            <div v-show="page.image" class="w-full flex justify-center mb-6 mt-4">
                <img :src="page.image">
            </div>

            <details v-if="language=='fa'" dir="rtl" v-for="list in page.text.fa">
                <summary>{{ list.question }}</summary>
                <section class="float-right">
                    {{ list.answer }}
                </section>
            </details>

            <details v-if="language=='en'" dir="ltr" v-for="list in page.text.en">
                <summary>{{ list.question }}</summary>
                <section class="float-left">
                    {{ list.answer }}
                </section>
            </details>

            <h2 class="text-center my-4 text-red-400"> {{ $t('have-question', language) }} </h2>

            <textarea v-model="form.question" :dir="language=='fa'?'rtl':'ltr'"
                      :placeholder="$t('text', language)"
                      class="py-3 placeholder-slate-400 w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"></textarea>
            <button @click="sendQuestion()" :disabled="form.question.length==0"
                    class="btn bg-dark-primary p-2 text-white-primary text-center rounded-lg">{{
                    $t('submit', language)
                }}
            </button>
        </div>
    </div>

    <div v-show="page.form[0]">
        <h2 class="text-center my-4 text-red-400">
            {{ $t('your-question', language) }} </h2>
        <div class="w-full md:w-3/4 mx-auto my-4 rounded-lg bg-white-secondary p-4" v-for="item in page.form">
            <p>{{ item.body.question }}</p>
            <p v-show="item.body.answer" class="m-2 text-red-500 border-red-300 p-2"
               :class="language=='fa'?'border-r-2':'border-l-2'">
                {{ item.body.answer }}</p>
        </div>

    </div>
    <div v-show="successState"
         class="bg-red-100 bg-opacity-70 border-2 border-red-300 rounded text-red-600 py-2 px-4 fixed bottom-32 left-2">
        <span>{{ $t('send-200', language) }}</span>
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
            isLoading: false,
            language: this.$route.params.lang,
            item: '',
            form: {
                question: '',
                answer: ''
            },
            page: {
                image: '',
                text: {
                    fa: '',
                    en: ''
                },
                seo: '',
                form: []
            },
            successState: false,
        }
    },
    emits: ['getUser'],
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue')),
    },
    methods: {
        sendQuestion() {
            this.isLoading = true;
            const sentData = {
                "body": this.form,
                "lang": this.language
            }
            axios.post("/form/faq", sentData).then((response) => {
                if (response.data.status == 200) {
                    this.form.question = '';
                    this.isLoading = false;
                    this.successState = true;
                    setTimeout(() => this.successState = false, 2000)
                }
            })
        },
        loading() {
            this.show = false;
        }
    },
    async created() {
        await axios.get('/b2bplus').then(response => {
            this.item = response.data.data
        })
        await axios.get('/b2bplus/faq').then(response => {
            if (response.data.images) {
                this.page.image = this.$sitename + 'upload/page/' + response.data.data.images.toLowerCase()
            }
            this.page.text.fa = JSON.parse(response.data.data.bodyFa)
            this.page.text.en = JSON.parse(response.data.data.bodyEn)
            for (const responseElement of response.data.form) {
                if (this.language == responseElement.language) {
                    this.page.form = [];
                    this.page.form.push({
                        body: JSON.parse(responseElement.body),
                    });
                }
            }
            if (this.language == 'fa') {
                document.title = response.data.data.titleFa + " | " + this.site.title
                this.page.seo = response.data.data.seoDescriptionFa;
            } else {
                document.title = response.data.data.titleEn + " | " + this.site.title
                this.page.seo = response.data.data.seoDescriptionEn;
            }
            document.querySelector('meta[name="description"]').setAttribute("content", this.page.seo);
        })
        this.loading()
    },
}
</script>
<style scoped>
.n-active {
    border-bottom: 2px solid #ea1b1b;
    background: #ffffff1a;
}

details {
    width: 100%;
    margin: 0 auto;
    background: #ffffff;
    margin-bottom: 0.5rem;
    border: 1px #dedede solid;
    border-radius: 10px;
    overflow: hidden;
}

summary {
    padding: 1rem;
    display: block;
    border: 1px #495464 solid;
    padding-left: 2.2rem;
    position: relative;
    border-radius: 10px;
    cursor: pointer;
}

summary:before {
    content: "";
    border-width: 0.4rem;
    border-style: solid;
    border-color: transparent transparent transparent #495464;
    position: absolute;
    top: 1.3rem;
    left: 1rem;
    transform: rotate(0);
    transform-origin: 0.2rem 50%;
    transition: 0.25s transform ease;
}

details[open] > summary:before {
    transform: rotate(90deg);
}

details summary::-webkit-details-marker {
    display: none;
}

details > section {
    margin: 15px;
}

</style>
