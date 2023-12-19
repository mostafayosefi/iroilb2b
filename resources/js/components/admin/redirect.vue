<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('redirects')"
                      :element="user.role.redirect.add"
                      :elementText="$t('add')"/>
        <div v-show="!user.role.redirect.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.redirect.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="redirects"
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
                <template #table-row="props">
                    <span v-if="props.column.field == 'after'">
                        <button v-show="user.role.redirect.delete" @click.prevent="deleteRedirect(props.row.id)"
                                class="btn btn-sm btn-outline-danger m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-trash w-4 h-4"><polyline
                                points="3 6 5 6 21 6"></polyline><path
                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </span>
                </template>
            </vue-good-table>
        </div>
    </div>

    <!-- successs message toggle -->
    <div id="basic-non-sticky-notification-content" class="toastify-content hidden flex flex-col sm:flex-row">
        <div class="font-medium">{{ $t('add-success-message') }}</div>
    </div>

    <button id="basic-non-sticky-notification-toggle" ref="toggleButton" class="d-none"></button>

    <!-- add modal -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('add-new-redirect') }}</h2>
                </div>
                <form @submit.prevent="">
                    <input type="hidden" name="_token">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <div dir="ltr" class="input-group-text">
                                    {{ $t('link') }}
                                </div>
                                <input dir="ltr" type="text" class="form-control"
                                       v-model="redirect.link">
                                <div dir="ltr" class="input-group-text">
                                    {{ $hostname }}
                                </div>

                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{ $t('to') }}
                                </div>
                                <input dir="ltr" type="text" class="form-control"
                                       v-model="redirect.to" placeholder="https://google.com">
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <div class="input-group-text w-48">
                                    {{ $t('redirect-type') }}
                                </div>
                                <input dir="ltr" type="number" class="form-control"
                                       v-model="redirect.code">
                            </div>
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
                        <button type="button" @click="addRedirect()" class="btn btn-success w-20" :disabled="sendLoad">
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
            redirect: {
                link: "",
                to: "",
                code: ""
            },
            sendLoad: false,
            successState: false,
            error: false,
            columns: [
                {
                    label: this.$t('link'),
                    field: 'link',
                },
                {
                    label: this.$t('to'),
                    field: 'to',
                },
                {
                    label: this.$t('redirect-type'),
                    field: 'code',
                },
                {
                    label: this.$t('the-operation'),
                    field: 'after'
                },
            ],
            redirects: [],
        }
    },
    methods: {
        addRedirect() {
            if (this.redirect.link != '' && this.redirect.to != '' && this.redirect.code != '') {
                this.sendLoad = true;
                this.error = false;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    link: '/' + this.redirect.link,
                    to: this.redirect.to,
                    code: this.redirect.code
                }
                axios.post("/redirect/create", sentData).then((response) => {
                    if (response.data == 'success') {
                        this.redirect.link = '';
                        this.redirect.to = '';
                        this.redirect.code = '';
                        this.successState = true;
                        this.sendLoad = false;
                        setTimeout(() => this.successState = false, 2000)
                        this.$refs.toggleButton.click();
                        this.getAll();
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            } else {
                this.error = true
            }
        },
        deleteRedirect(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/redirect/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.redirects = this.redirects.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
        getAll() {
            this.redirects = [];
            axios.get('/redirect', {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                if (response != null) {
                    for (const responseElement of response.data.data) {
                        this.redirects.push({
                            id: responseElement.id,
                            link: responseElement.link,
                            to: responseElement.redirect,
                            code: responseElement.status
                        });
                    }
                }
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    },
    beforeCreate() {
        axios.get('/redirect', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            if (response != null) {
                for (const responseElement of response.data.data) {
                    this.redirects.push({
                        id: responseElement.id,
                        link: responseElement.link,
                        to: responseElement.redirect,
                        code: responseElement.status
                    });
                }
            }
            this.$emit('loadingHide');
        }).catch(() => {
            this.$emit('loadingHide');
        });
    },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('redirects') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


