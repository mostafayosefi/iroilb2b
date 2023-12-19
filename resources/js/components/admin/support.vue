<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('support')"
        />
        <div v-show="!user.role.support.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.support.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="tickets"
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
                    <div v-if="props.column.field == 'status'">
                    <span v-show="props.row.status=='new'"
                          class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-21 text-white ">{{
                            $t('new') + " "
                        }}</span>
                        <span v-show="props.row.status=='answered'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white ">{{
                                $t('answered') + " "
                            }}</span>
                        <span v-show="props.row.status=='process'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                $t('process') + " "
                            }}</span>
                        <span v-show="props.row.status=='check'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                $t('check') + " "
                            }}</span>
                    </div>
                    <span v-if="props.column.field == 'after'">
                        <button v-show="user.role.support.edit" @click.prevent="getTicket(props.row.id)"
                                class="btn btn-sm btn-outline-dark m-1 font-bold">
                           {{ $t('management') }}
                        </button>
                    </span>
                </template>
            </vue-good-table>
        </div>
    </div>

    <!--edit modal-->
    <a href="javascript:;" data-toggle="modal" ref="editModal" data-target="#modaledit"
       class="d-none"></a>

    <div id="modaledit" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('answer') + " " + ticket.subject }}</h2>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <p>{{ $t('last-update') }} : {{ ticket.time }}</p>
                        <p>{{ $t('name') }} : {{ ticket.user }}</p>
                        <p>{{ $t('status') }} :
                            <span v-show="ticket.status=='new'"
                                  class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-21 text-white ">{{
                                    $t('new') + " "
                                }}</span>
                            <span v-show="ticket.status=='answered'"
                                  class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white ">{{
                                    $t('answered') + " "
                                }}</span>
                            <span v-show="ticket.status=='process'"
                                  class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                    $t('process') + " "
                                }}</span>
                            <span v-show="ticket.status=='check'"
                                  class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                    $t('check') + " "
                                }}</span>
                        </p>
                        <p>{{ $t('text') }} : {{ ticket.text }}</p>
                        <a v-show="ticket.file" :href="ticket.file">{{ $t('file') }}</a>

                        <div v-for="item of ticket.dialog" class="bg-light-2 p-2 rounded mt-2">
                            {{item.text}}
                            <br>
                            <small>
                                {{ item.time }} - {{item.user}} -
                                <a v-show="item.file" :href="this.$hostname + 'upload/support/' +item.file">{{ $t('file') }}</a>
                            </small>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <textarea class="form-control" v-model="answer.text">
                        </textarea>
                        <select v-model="answer.status" class="form-control">
                            <option value="check">{{ $t('check') }}</option>
                            <option value="process">{{ $t('process') }}</option>
                            <option value="answered">{{ $t('answered') }}</option>
                            <option value="new">{{ $t('new') }}</option>
                        </select>
                    </div>
                    <input id="document" ref="document" type="file"
                           style="display: none;" @change="onChangeDoc"/>
                    <button class="btn btn-light w-20">
                        <label for="document" class="cursor-pointer">
                            {{ $t('upload') }}
                        </label>
                    </button>
                </div>
                <div class="modal-footer justify-end flex items-center">
                    <button ref="closeEditModal" @click="answer.text='';"
                            type="button"
                            data-dismiss="modal"
                            class="btn btn-outline-secondary w-20 mx-4">
                        {{ $t('cancel') }}
                    </button>
                    <button type="button" @click="updateTicket()" class="btn btn-success w-20">
                        <div v-show="!editLoad">{{ $t('answer') }}</div>
                        <div v-show="editLoad">
                            <i data-loading-icon="puff" class="w-5"></i>
                        </div>
                    </button>
                </div>
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
            loading: true,
            editLoad: false,
            successState: false,
            answer: {
                text: '',
                file: '',
                status: 'answered'
            },
            columns: [
                {
                    label: this.$t('name'),
                    field: 'user',
                },
                {
                    label: this.$t('subject'),
                    field: 'subject',
                },
                {
                    label: this.$t('status'),
                    field: 'status',
                },
                {
                    label: this.$t('last-update'),
                    field: 'time',
                },
                {
                    label: this.$t('the-operation'),
                    field: 'after'
                },
            ],
            tickets: [],
            ticket: {
                id: '',
                subject: '',
                status: '',
                user: '',
                userId: '',
                text: '',
                time: '',
                file: '',
                dialog: []
            }
        }
    },
    methods: {
        onChangeDoc() {
            this.answer.file = this.$refs["document"].files[0];
        },
        updateTicket() {
            this.editLoad = false;
            let formData = new FormData();
            formData.append('api_token', this.$cookies.get('user').token);
            formData.append('userid', parseInt(this.$cookies.get('user').id));
            formData.append('text', this.answer.text);
            formData.append('status', this.answer.status);
            formData.append('ticket', this.ticket.id);
            formData.append('file', this.answer.file);
            formData.append('type', 'admin');
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
                    this.answer.status = 'answered';
                    this.ticket.id = '';
                    this.ticket.subject = '';
                    this.ticket.status = '';
                    this.ticket.user = '';
                    this.ticket.userId = '';
                    this.ticket.text = '';
                    this.ticket.time = '';
                    this.ticket.file = '';
                    this.ticket.dialog = [];
                    this.$refs.toggleButton.click();
                    this.getAll();
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
            this.editLoad = false;
        },
        getTicket(id) {
            this.editLoad = false;
            this.$refs.editModal.click();
            axios.get('/ticket/single/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'language': 'fa'
                }
            }).then(response => {
                this.ticket.id = response.data.id;
                this.ticket.subject = response.data.subject;
                this.ticket.status = response.data.status;
                this.ticket.user = response.data.user;
                this.ticket.userId = response.data.userId;
                this.ticket.text = response.data.text;
                this.ticket.time = response.data.time;
                this.ticket.file = response.data.file != null ? this.$hostname + 'upload/support/' + response.data.file : null;
                this.ticket.dialog = response.data.dialog;
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
        getAll() {
            this.tickets = [];
            axios.get('/ticket', {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                for (const responseElement of response.data) {
                    this.tickets.push({
                        id: responseElement.id,
                        user: responseElement.user,
                        subject: responseElement.subject,
                        status: responseElement.status,
                        time: responseElement.time,
                    });
                }
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    }
    ,
    beforeCreate() {
        axios.get('/ticket', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data) {
                this.tickets.push({
                    id: responseElement.id,
                    user: responseElement.user,
                    subject: responseElement.subject,
                    status: responseElement.status,
                    time: responseElement.time,
                });
            }
            this.$emit('loadingHide');
        }).catch(() => {
            this.$emit('loadingHide');
        });
    }
    ,
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('support') + ' | ' + this.$t('adminTitlePage');
            }
        }
        ,
    }
    ,

}
</script>


