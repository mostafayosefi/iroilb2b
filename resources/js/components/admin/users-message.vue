<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user" :title="$t('messages-management')"
                      :element="user.role.notificate.add"
                      :elementText="$t('one-submit')">
            <a v-show="user.role.notificate.add" href="javascript:;" class="btn btn-sm btn-primary mx-1 font-bold" data-toggle="modal"
                    data-target="#modal">{{ $t('group-submit') }}</a>
        </header-admin>

        <div v-show="!user.role.notificate.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.notificate.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="messages"
                :rtl="true"
                theme="polar-bear"
                :line-numbers="true"
                :fixed-header="true"
                :pagination-options="{
                    enabled: true ,
                    mode: 'records',
                    perPage:10,
                    nextLabel:  $t('next'),
                    prevLabel:  $t('prev'),
                    rowsPerPageLabel: '',
                    ofLabel: $t('of'),
                    allLabel: $t('all'),}"
                :search-options="{
                    enabled: true,
                    placeholder: $t('search'), }">
            </vue-good-table>
        </div>
    </div>

    <div id="basic-non-sticky-notification-content" class="toastify-content hidden flex flex-col sm:flex-row">
        <div class="font-medium">{{ $t('add-success-message') }}</div>
    </div>

    <button id="basic-non-sticky-notification-toggle" ref="toggleButton" class="d-none"></button>
    <div id="header-footer-modal-preview" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('single-message') }}</h2>
                </div>
                <form @submit.prevent="">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="user"> {{ $t('choose-user') }}</label>
                            <select id="user" v-model="form.user" class="form-control mt-2">
                                <option v-for="user in users" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                          <textarea class="form-control" rows="5" v-model="form.text">
                          </textarea>
                        </div>

                        <div v-show="error"
                             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12"
                             role="alert">
                            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                            {{ $t('error-empty-fields') }}
                        </div>
                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="singleSend()" class="btn btn-success w-20" :disabled="sendLoad">
                            <div v-show="!sendLoad">{{ $t('send') }}</div>
                            <div v-show="sendLoad">
                                <i data-loading-icon="puff" class="w-5"></i>
                            </div>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('multi-message') }}</h2>
                </div>
                <form @submit.prevent="">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="user"> {{ $t('choose-tag') }}</label>
                            <select id="user" v-model="form.tag" class="form-control mt-2">
                                <option v-for="product in products" :value="product.id">
                                    {{ product.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                          <textarea class="form-control" rows="5" v-model="form.text">
                          </textarea>
                        </div>

                        <div v-show="error"
                             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12"
                             role="alert">
                            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                            {{ $t('error-empty-fields') }}
                        </div>
                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="multiSend()" class="btn btn-success w-20" :disabled="sendLoad">
                            <div v-show="!sendLoad">{{ $t('send') }}</div>
                            <div v-show="sendLoad">
                                <i data-loading-icon="puff" class="w-5"></i>
                            </div>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";
import axios from 'axios'
import {defineAsyncComponent} from "vue";
import 'vue-good-table-next/dist/vue-good-table-next.css'
import {VueGoodTable} from 'vue-good-table-next';

export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
        VueGoodTable
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: true,
            sendLoad: false,
            successState: false,
            error: false,
            columns: [
                {
                    label: this.$t('message'),
                    field: 'message',
                },
                {
                    label: this.$t('sender'),
                    field: 'sender',
                },
                {
                    label: this.$t('receiver'),
                    field: 'receiver',
                },
                {
                    label: this.$t('status'),
                    field: 'status',
                },
                {
                    label: this.$t('time'),
                    field: 'time'
                },
            ],
            form: {
                text: '',
                user: '',
                tag: ''
            },
            messages: [],
            users: [],
            products: []
        }
    },
    methods: {
        singleSend() {
            this.sendLoad = true;
            axios.post("notification/singlesend", {
                api_token: this.$cookies.get('user').token,
                sender: this.$cookies.get('user').id,
                receiver: this.form.user,
                message: this.form.text
            }).then((response) => {
                if (response.data == 'success') {
                    this.sendLoad = false;
                    this.form.user = '';
                    this.form.text = '';
                    setTimeout(() => this.successState = false, 2000)
                    this.$refs.toggleButton.click();
                }
            })
        },
        multiSend() {
            this.sendLoad = true;
            axios.post("notification/multisend", {
                api_token: this.$cookies.get('user').token,
                sender: this.$cookies.get('user').id,
                tag: this.form.tag,
                message: this.form.text
            }).then((response) => {
                if (response.data == 'success') {
                    this.sendLoad = false;
                    this.form.tag = '';
                    this.form.text = '';
                    setTimeout(() => this.successState = false, 2000)
                    this.$refs.toggleButton.click();
                }
            })
        },
    },
    async beforeCreate() {
        await axios.get('/notification', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const resElement of response.data) {
                this.messages.push({
                    id: resElement.id,
                    sender: resElement.sender,
                    receiver: resElement.receiver,
                    status: resElement.status,
                    message: resElement.message,
                    time: resElement.time,
                });
            }

        })
        await axios.get('/users/all', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            if (response != null) {
                for (const responseElement of response.data.data) {
                    this.users.push({
                        id: responseElement.id,
                        name: responseElement.name,
                    });
                }
            }
        })
        await axios.get('/product', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            if (response.data.data){
                for (const responseElement of response.data.data) {
                    this.products.push({
                        id: responseElement.id,
                        name: responseElement.name_fa,
                    });
                }
            }
        })
        this.$emit('loadingHide');
    },
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('messages-management') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


