<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <!--        Loader       -->
    <div v-show="isLoading" class="h-screen w-screen fixed flex items-center justify-center !z-50">
        <section
            class="w-[200px] h-[100px] bg-dark-primary-trans p-5 rounded-2xl flex justify-center items-center blur-panel">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </section>
    </div>
    <div v-show="!loginCheck()" class="w-3/4 md:w-full mx-auto my-4 flex flex-col items-center">
        <span class="my-2">
            {{ $t('support-message', language) }}
        </span>
        <a href="https://wa.me/+989337813003"
           class="w-40 bg-green-100 m-1 p-2 block border border-green-400 border-2 rounded-2xl text-center text-green-500">
            {{ $t('whatsapp', language) }}
        </a>
        <a href="https://t.me/+989337813003"
           class="w-40 bg-sky-100 m-1 p-2 block border border-sky-400 border-2 rounded-2xl text-center text-sky-500">
            {{ $t('telegram', language) }}
        </a>
    </div>
    <section class="flex pb-14">
        <aside
            class="bg-dark-primary md:w-2/6 xl:w-1/6 min-h-[calc(100vh-140px)] hidden md:flex flex-wrap content-between">
            <panelSideBar :site="site" :user="user"></panelSideBar>
        </aside>
        <div class="w-full px-2 md:px-7 md:w-4/6 xl:w-5/6">
            <div v-show="loginCheck()">
                <section v-show="user.step=='one'"
                         class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                    <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                        <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize">  {{ $t('step', language) }} (1/3) :</b>
                        {{ $t('step-one', language) }}
                    </span>
                    </div>
                    <router-link :to="{name:'sitePanelCompany'}"
                                 class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                        {{ $t('company-step', language) }}
                    </router-link>
                </section>
                <section v-show="user.step=='tow'"
                         class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                    <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                        <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize">  {{ $t('step', language) }} (2/3) :</b>
                        {{ $t('step-tow', language) }}
                    </span>
                    </div>
                    <router-link :to="{name:'sitePanelAds'}"
                                 class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                        {{ $t('ad-step', language) }}
                    </router-link>
                </section>
                <section v-show="user.step=='three'"
                         class="text-white px-6 py-2 mb-4 bg-red-500 md:flex justify-between items-center rounded-lg mt-2">
                    <div class="flex items-center">
                    <span class="hidden md:flex text-xl mr-5 items-center">
                        <i class="fe fe-compass"></i>
                    </span>
                        <span class="inline-block align-middle mr-2 md:mr-8 text-justify">
                        <b class="capitalize">  {{ $t('step', language) }} (3/3) :</b>
                        {{ $t('step-three', language) }}
                    </span>
                    </div>
                    <router-link :to="{name:'siteFeedBack'}"
                                 class="rounded-lg animate-bounce bg-red-700 p-2 flex items-center justify-center text-center mt-2 md:mt-0">
                        {{ $t('feed-step', language) }}
                    </router-link>
                </section>
                <div v-show="show=='tow'" class="w-full md:w-3/4 mx-auto space-y-2 py-2 py-2">
                    <section>
                        <label class="text-sm font-bold text-gray-700"
                               :class="error && ticket.subject==''?'!text-red-600':''"
                               for="subject">{{ $t('title', language) }}</label>
                        <input id="subject" v-model="ticket.subject" type="text"
                               :dir="language=='fa'? 'rtl':'ltr'"
                               class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                               :class="error && ticket.subject==''?'ring ring-red-400':''">
                    </section>
                    <section>
                        <label class="text-sm font-bold text-gray-700"
                               :class="error && ticket.message==''?'!text-red-600':''"
                               for="message">{{ $t('text', language) }}</label>
                        <textarea id="message" v-model="ticket.message" rows="6"
                                  :dir="language=='fa'? 'rtl':'ltr'"
                                  class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                                  :class="error && ticket.message==''?'ring ring-red-400':''"></textarea>
                    </section>
                    <input id="upload" ref="file" type="file"
                           style="display: none;" @change="onChangeFile"/>
                    <div class="w-full flex justify-between items-center py-4">
                        <button type="button"
                                class="btn border border-solid border-gray-300 rounded-lg px-4 py-2 text-dark-primary"
                                @click="reset()">
                            {{ $t('cancel', language) }}
                        </button>
                        <section class="space-x-2 flex items-center"
                                 :class="language=='fa'?'space-x-reverse':''">
                            <button type="button"
                                    class="btn bg-white-primary px-4 py-2 text-dark-primary rounded-lg">
                                <label for="upload" class="cursor-pointer">
                                    {{ $t('upload-file', language) }}
                                </label>
                                <span v-show="ticket.file!=''"
                                      class="bg-white-secondary rounded-full flex items-center px-1">
                                    ({{ ticket.file.name }})
                                      <button type="button" class="flex items-center"
                                              @click="ticket.file = ''; $refs['file'].value = null">
                                        <i class="fe fe-x"></i>
                                    </button>
                                </span>
                            </button>
                            <button @click="submitForm()" class="btn bg-dark-primary rounded-lg px-4 py-2 text-white">
                                {{ $t('submit', language) }}
                            </button>
                        </section>

                    </div>
                </div>
            </div>
            <div>
                <div @click="showTicket(item.id)" v-show="show=='one' && tickets[0]" v-for="item in tickets"
                     :key="item.id"
                     class="border-2 border-slate-200 border-solid rounded-lg p-2 md:p-4 m-2 text-sm block md:grid grid-cols-4 place-items-center justify-items-stretch place-content-stretch shadow-md">
                    <strong class="block mb-2 md:mb-0">{{ item.subject }}</strong>
                    <section class="justify-self-start">
                        <span class="bg-purple-100 px-2 text-purple-500 rounded-xl"
                              v-show="item.status=='check'">{{ $t('check', language) }}</span>
                        <span class="bg-slate-100 px-2 text-slate-500 rounded-xl"
                              v-show="item.status=='answered'">{{ $t('answered', language) }}</span>
                        <span class="bg-orange-100 px-2 text-orange-500 rounded-xl"
                              v-show="item.status=='process'">{{ $t('process', language) }}</span>
                        <span class="bg-green-100 px-2 text-green-500 rounded-xl"
                              v-show="item.status=='new'">{{ $t('new', language) }}</span>
                    </section>
                    <span class="block mt-2 mb-2 md:mt-0 md:mb-0">
                        {{ $t('expire-at', language) + ": " + item.time }}</span>
                    <button
                        class="px-4 py-1 font-semibold text-sm bg-dark-primary text-white rounded-full shadow-sm justify-self-end">
                        {{ $t('view', language) }}
                    </button>
                </div>
            </div>
            <div v-show="show=='one' && loginCheck()" class="w-3/4 md:w-full mx-auto my-4 flex flex-col items-center">
                <span class="my-2">
                    {{ $t('support-message', language) }}
                </span>
                <button @click="show='tow'"
                        class="w-40 bg-red-100 m-1 p-2 block border border-red-400 border-2 rounded-xl text-center text-red-500">
                    {{ $t('send-ticket', language) }}
                </button>
                <a href="https://wa.me/+989337813003"
                   class="w-40 bg-green-100 m-1 p-2 block border border-green-400 border-2 rounded-xl text-center text-green-500">
                    {{ $t('whatsapp', language) }}
                </a>
                <a href="https://t.me/+989337813003"
                   class="w-40 bg-sky-100 m-1 p-2 block border border-sky-400 border-2 rounded-xl text-center text-sky-500">
                    {{ $t('telegram', language) }}
                </a>
            </div>
            <div v-show="show=='four'" class="w-full mx-auto my-4 flex flex-col items-center space-y-2">
                <div class="w-full">
                    <strong>{{ $t('subject', language) }} : {{ ticketShow.subject }}</strong>
                    <p>{{ $t('text', language) }} : {{ ticketShow.text }}</p>
                    <a v-show="ticketShow.file" :href="ticketShow.file">{{ $t('file') }}</a>
                    <div v-for="item of ticketShow.dialog" class="bg-slate-200 p-2 rounded mt-2">
                        <p v-show="item.text">
                            {{ item.text }}
                        </p>
                        <small>
                            {{ item.time }} - {{ item.user }}
                            <a v-show="item.file" :href="this.$sitename + 'upload/support/' +item.file"> - {{
                                    $t('file', language)
                                }}</a>
                        </small>
                    </div>
                </div>
                <div class="w-full">
                    <label class="text-sm font-bold text-gray-700"
                           :class="error && ticket.message==''?'!text-red-600':''"
                           for="answer">{{ $t('text', language) }}</label>
                    <textarea id="answer"
                              class="w-full border border-slate-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-gray-300 p-3 text-gray-400"
                              v-model="answer.text">
                    </textarea>
                </div>
                <div class="flex space-x-2 items-center"
                     :class="language=='fa'?'space-x-reverse':''">
                    <input id="document" ref="document" type="file"
                           style="display: none;" @change="onChangeDoc"/>
                    <button
                        class="btn bg-white-primary px-4 py-2 text-dark-primary rounded-lg">
                        <label for="document" class="cursor-pointer">
                            {{ $t('upload-file', language) }}
                        </label>
                        <span v-show="answer.file!=''"
                              class="bg-white-secondary rounded-full flex items-center px-1">
                            ({{ answer.file.name }})
                              <button type="button" class="flex items-center"
                                      @click="answer.file = ''; $refs['document'].value = null">
                                <i class="fe fe-x"></i>
                            </button>
                        </span>
                    </button>
                    <button v-show="answer.text.length>0 || answer.file!=''" @click="updateTicket()"
                            class="btn bg-dark-primary p-2 text-white-primary rounded-lg mx-2">
                        {{ $t('answer', language) }}
                    </button>
                    <button @click="show='one' ; answer.text='' ; answer.file='' "
                            class="btn border border-solid border-gray-300 rounded-lg px-4 py-2 text-dark-primary">
                        {{ $t('cancel', language) }}
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";

export default {
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "panelSideBar": defineAsyncComponent(() => import('./../layout/side-bar-panel.vue')),
    },
    emits: ['getUser'],
    data() {
        return {
            language: this.$route.params.lang,
            show: 'one',
            ticket: {
                subject: '',
                message: '',
                file: ''
            },
            error: false,
            isLoading: false,
            tickets: [],
            ticketShow: {
                id: '',
                subject: '',
                status: '',
                user: '',
                userId: '',
                text: '',
                time: '',
                file: '',
                dialog: []
            },
            answer: {
                text: '',
                file: '',
            },
        }
    },
    methods: {
        updateTicket() {
            this.isLoading = true;
            let formData = new FormData();
            formData.append('api_token', this.$cookies.get('user').token);
            formData.append('userid', parseInt(this.$cookies.get('user').id));
            formData.append('text', this.answer.text);
            formData.append('status', 'new');
            formData.append('ticket', this.ticketShow.id);
            formData.append('file', this.answer.file);
            formData.append('type', 'user');
            axios.post("/ticket/update", formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((response) => {
                if (response.data == 'success') {
                    this.answer.text = '';
                    this.answer.file = '';
                    this.ticketShow.id = '';
                    this.ticketShow.subject = '';
                    this.ticketShow.status = '';
                    this.ticketShow.user = '';
                    this.ticketShow.userId = '';
                    this.ticketShow.text = '';
                    this.ticketShow.time = '';
                    this.ticketShow.file = '';
                    this.ticketShow.dialog = [];
                    this.getTicket()
                }
            }).catch(() => {
            });
            this.show = 'one'
            this.isLoading = false;
        },
        onChangeDoc() {
            this.answer.file = this.$refs["document"].files[0];
        },
        reset() {
            this.error = false;
            this.ticket.subject = '';
            this.ticket.message = '';
            this.ticket.file = '';
            this.show = 'one';
        },
        loginCheck() {
            if (this.$cookies.isKey('user')) {
                return true;
            } else {
                return false;
            }
        },
        onChangeFile() {
            this.ticket.file = this.$refs["file"].files[0];
        },
        checkFields() {
            var check = 0;
            if (this.ticket.subject == '') {
                this.error = true;
                check = 1;
            }
            if (this.ticket.message == '') {
                this.error = true;
                check = 1;
            }
            if (check == 1)
                return false
            return true

        },
        submitForm() {
            if (this.checkFields()) {
                this.isLoading = true;
                let formData = new FormData();
                formData.append('api_token', this.$cookies.get('user').token);
                formData.append('user_id', this.$cookies.get('user').id);
                formData.append('subject', this.ticket.subject);
                formData.append('message', this.ticket.message);
                formData.append('file', this.ticket.file)
                axios.post('/ticket/new',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((res) => {
                    if (res.data == 'success') {
                        this.show = 'one';
                        this.ticket.subject = '';
                        this.ticket.message = '';
                        this.ticket.file = '';
                        this.getTicket();
                    }
                    this.isLoading = false;
                }).catch(error => {
                    this.isLoading = false;
                });
            }
        },
        showTicket(id) {
            this.isLoading = true;
            this.show = 'four';
            axios.get('/ticket/single/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'language': this.language
                }
            }).then(response => {
                this.ticketShow.id = response.data.id;
                this.ticketShow.subject = response.data.subject;
                this.ticketShow.status = response.data.status;
                this.ticketShow.user = response.data.user;
                this.ticketShow.userId = response.data.userId;
                this.ticketShow.text = response.data.text;
                this.ticketShow.time = response.data.time;
                this.ticketShow.file = response.data.file != null ? this.$sitename + 'upload/support/' + response.data.file : null;
                this.ticketShow.dialog = response.data.dialog;
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },
        getTicket() {
            axios.get('/ticket/' + this.$cookies.get('user').id, {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'id': this.$cookies.get('user').id,
                    'language': this.$route.params.lang,
                }
            }).then(response => {
                if (response.data) {
                    this.tickets = [];
                    if (response.data != 'null') {
                        for (const responseElement of response.data) {
                            this.tickets.push({
                                id: responseElement.id,
                                subject: responseElement.subject,
                                status: responseElement.status,
                                text: responseElement.text,
                                file: responseElement.file,
                                time: responseElement.time,
                            });
                        }
                    }
                }
            }).catch(error => {
                this.tickets = [];
            });
        }
    },
    async beforeCreate() {
        if (this.$cookies.isKey('user')) {
            await axios.get('/ticket/' + this.$cookies.get('user').id, {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'id': this.$cookies.get('user').id,
                    'language': this.$route.params.lang,
                }
            }).then(response => {
                if (response.data) {
                    this.tickets = [];
                    if (response.data != 'null') {
                        for (const responseElement of response.data) {
                            this.tickets.push({
                                id: responseElement.id,
                                subject: responseElement.subject,
                                status: responseElement.status,
                                text: responseElement.text,
                                file: responseElement.file,
                                time: responseElement.time,
                            });
                        }
                    }
                }
            }).catch(error => {
                this.tickets = [];
            });
        }
        document.title = this.$t('support', this.language) + " | " + this.site.title
    }
}
</script>
