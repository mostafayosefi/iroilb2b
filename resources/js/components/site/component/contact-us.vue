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
            <div class="flex flex-col-reverse md:flex-row">
                <div class="w-full md:w-1/2 px-2">
                    <h2 :class="language=='fa'?'text-right':'text-left'" class="font-bold my-2">
                        {{ $t('contact-form', language) }} </h2>
                    <div>
                        <label class="text-sm font-bold text-gray-700"
                               for="name">
                            {{ $t('name', language) }}
                        </label>
                        <input v-model="form.name" type="text" id="name"
                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-700"
                               for="email">
                            {{ $t('email', language) }}
                        </label>
                        <input v-model="form.email" dir="ltr" type="email" id="email"
                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700"
                               for="subject">
                            {{ $t('subject', language) }}
                        </label>
                        <input v-model="form.subject" type="text" id="subject"
                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700"
                               for="text">
                            {{ $t('text', language) }}
                        </label>
                        <textarea v-model="form.text" :dir="language=='fa'?'rtl':'ltr'" id="text"
                                  class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"></textarea>
                    </div>
                    <button @click="sendContact()" :disabled="form.text.length==0"
                            class="btn bg-dark-primary p-2 text-white-primary text-center rounded-lg ">{{
                            $t('submit', language)
                        }}
                    </button>
                </div>
                <div class="w-full md:w-1/2 px-2">
                    <div v-show="page.image" class="w-full md:flex justify-center mb-6">
                        <img :src="page.image">
                    </div>
                    <div v-if="language=='fa'" class="my-4" v-html="page.text.fa"></div>
                    <div v-if="language=='en'" class="my-4" v-html="page.text.en"></div>
                    <a class="block md:float-right w-full my-2 flex items-center " v-if="language=='fa'"
                       v-for="element in page.element.fa"
                       :href="element.link">
                        <p class="float-right p-2 ml-2 border-solid border-2 rounded-2xl"
                           :style="'background:'+ element.color+';'">
                            <i :class="element.icon"></i>
                        </p>
                        {{ element.text }}
                    </a>
                    <a class="block md:float-right w-full my-2 flex items-center" v-if="language=='en'"
                       v-for="element in page.element.en"
                       :href="element.link">
                    <span class="float-right p-2 mr-2 border-solid border-2 rounded-2xl"
                          :style="'background:'+ element.color+';'">
                        <i :class="element.icon"></i>
                    </span>
                        {{ element.text }}
                    </a>
                </div>
            </div>
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
            language: this.$route.params.lang,
            item: '',
            form: {
                name: '',
                email: '',
                subject: '',
                text: ''
            },
            page: {
                image: '',
                text: {
                    fa: '',
                    en: ''
                },
                element: {
                    fa: [],
                    en: []
                },
                seo: '',
            },
            successState: false,
        }
    },
    emits: ['getUser'],
    methods: {
        sendContact() {
            this.isLoading = true;
            const sentData = {
                "body": this.form,
                "lang": this.language
            }
            axios.post("/form/contact", sentData).then((response) => {
                if (response.data.status == 200) {
                    this.form.name = '';
                    this.form.email = '';
                    this.form.subject = '';
                    this.form.text = '';
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
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    },
    async beforeCreate() {
        await axios.get('/b2bplus').then(response => {
            this.item = response.data.data
        })
        await axios.get('/b2bplus/contact').then(response => {
            if (response.data.images) {
                this.page.image = this.$sitename + 'upload/page/' + response.data.images.toLowerCase()
            }
            const Fa = JSON.parse(response.data.bodyFa);
            const En = JSON.parse(response.data.bodyEn);

            this.page.text.fa = Fa.body
            this.page.text.en = En.body
            for (const element of Fa.element) {
                this.page.element.fa.push({
                    icon: element.icon,
                    color: element.color,
                    link: element.link,
                    text: element.text,
                    id: element.id
                },);
            }
            for (const element of En.element) {
                this.page.element.en.push({
                    icon: element.icon,
                    color: element.color,
                    link: element.link,
                    text: element.text,
                    id: element.id
                },);
            }
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
