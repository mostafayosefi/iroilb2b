<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('users')"/>
        <div v-show="!user.role.users.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.users.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="users"
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
                    <div v-if="props.column.field == 'info'">
                        <span
                            class="py-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white font-medium">
                            {{ $t('sign-up-time') + ": " + props.row.time }}
                        </span>

                        <span v-show="props.row.active==0"
                            class="py-1 px-2 mx-1 rounded-full text-xs bg-theme-21 text-white font-medium">
                            <span>{{$t('not-active') + " "}}</span>
                        </span>
                        <span v-show="props.row.active==1"
                            class="py-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white font-medium">
                            <span>{{$t('active') + " "}}</span>
                        </span>

                        <span
                            class="py-1 px-2 mx-1 rounded-full text-xs bg-theme-26 text-white font-medium">
                            <span v-text="props.row.step=='one'? $t('step') + '1/3':''"></span>
                            <span v-text="props.row.step=='tow'? $t('step') + '2/3':''"></span>
                            <span v-text="props.row.step=='three'? $t('step') +'3/3':''"></span>
                            <span v-text="props.row.step=='four'? $t('done'):''"></span>
                        </span>
                    </div>
                    <span v-if="props.column.field == 'after'">
                        <button v-show="user.role.users.edit" @click.prevent="editUser(props.row.id)"
                                class="btn btn-sm btn-outline-dark m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4"><path
                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path
                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                    </span>
                </template>
            </vue-good-table>
        </div>
    </div>
    <a href="javascript:;" data-toggle="modal" ref="editModal" data-target="#modaledit"
       class="d-none"></a>
    <!--edit modal-->
    <div id="modaledit" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-bold ml-auto">
                        {{ $t('edit') + " " + account.name }}</h2>
                </div>
                <form @submit.prevent="">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <span>  {{ $t('user-role') }}</span>
                            <select class="form-control mt-2" v-model="account.role">
                                <option value="user">{{ $t('user') }}</option>
                                <option value="admin">{{ $t('admin') }}</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <span>  {{ $t('user-account') }}</span>
                            <select class="form-control mt-2" v-model="account.active">
                                <option value="1">{{ $t('active') }}</option>
                                <option value="0">{{ $t('not-active') }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button ref="closeEditModal" type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="updateUser()" class="btn btn-success w-20" :disabled="editLoad">
                            <div v-show="!editLoad">{{ $t('update') }}</div>
                            <div v-show="editLoad">
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
            account: {
                id: '',
                name: '',
                role: '',
                active: ''
            },
            editLoad: false,
            columns: [
                {
                    label: this.$t('name'),
                    field: 'name',
                },
                {
                    label: this.$t('phone'),
                    field: 'phone',
                },
                {
                    label: this.$t('email'),
                    field: 'email',
                },
                {
                    label: this.$t('information'),
                    field: 'info',
                },
                {
                    label: this.$t('the-operation'),
                    field: 'after'
                },
            ],
            users: [],
        }
    },
    methods: {
        editUser(id) {
            this.$refs.editModal.click();
            this.users.map(item => {
                if (item.id == id) {
                    this.account.id = id
                    this.account.name = item.name
                    this.account.role = item.role
                    this.account.active = item.active
                }
            });
        },
        updateUser() {
            this.$emit('loading');
            const sentData = {
                api_token: this.$cookies.get('user').token,
                id: this.account.id,
                active: this.account.active,
                role: this.account.role
            }
            axios.put("/user/update", sentData).then((response) => {
                if (response.data == 'successfully updated') {
                    this.users = this.users.map(item => {
                        if (item.id == this.account.id) {
                            item.active = this.account.active;
                            item.role = this.account.role;
                        }
                        return item;
                    });
                    this.$refs.closeEditModal.click();
                    this.$emit('loadingHide');
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
    },
    beforeCreate() {
        axios.get('/users/all', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            if (response != null) {
                for (const responseElement of response.data.data) {
                    this.users.push({
                        id: responseElement.id,
                        name: responseElement.name,
                        phone: responseElement.phone,
                        email: responseElement.email,
                        active: responseElement.active,
                        role: responseElement.role,
                        step: responseElement.step,
                        time: responseElement.time,
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
                document.title = this.$t('users') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


