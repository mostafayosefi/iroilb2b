<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('operators')"/>
        <div v-show="!user.role.operator.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.operator.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="operators"
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
                        <button @click.prevent="editOperator(props.row.id)"
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
                        {{ $t('edit') + " " + operator.name }}</h2>
                </div>
                <form @submit.prevent="">
                    <div class="modal-body">
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('dashboard') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.dashboard.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('post') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.post.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.post.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.post.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.post.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('categories') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.category.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.category.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.category.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.category.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('labels') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.label.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.label.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.label.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.label.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('pages') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.page.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.page.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.page.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.page.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('tables') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.table.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.table.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.table.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.table.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('forms') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.forms.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.forms.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('settings') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.settings.site">
                                <span class="mx-2">
                                    {{ $t('site-settings') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.settings.header">
                                <span class="mx-2">
                                    {{ $t('header') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.settings.sidebar">
                                <span class="mx-2">
                                    {{ $t('side-bar') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.settings.footer">
                                <span class="mx-2">
                                    {{ $t('footer') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('redirects') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.redirect.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.redirect.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.redirect.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('users') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.users.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.users.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('messages') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.notificate.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.notificate.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('products') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.product.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.product.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.product.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.product.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('filters') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.tag.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.tag.add">
                                <span class="mx-2">
                                    {{ $t('add') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.tag.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.tag.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('companies') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.company.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.company.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('ads') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.ads.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.ads.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.ads.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                        <div class="w-full border p-2 rounded mb-2">
                            <p class="mb-2">
                                {{ $t('support') }}
                            </p>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.support.show">
                                <span class="mx-2">
                                    {{ $t('view') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.support.edit">
                                <span class="mx-2">
                                    {{ $t('edit') }}
                               </span>
                            </label>
                            <label class="flex align-items-center">
                                <input type="checkbox" v-model="role.support.delete">
                                <span class="mx-2">
                                    {{ $t('delete') }}
                               </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button ref="closeEditModal" type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="updateOperator(operator.id)" class="btn btn-success w-20"
                                :disabled="editLoad">
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
            loading: true,
            operator: {
                id: '',
                name: '',
            },
            editLoad: false,
            columns: [
                {
                    label: this.$t('name'),
                    field: 'name',
                },
                {
                    label: this.$t('the-operation'),
                    field: 'after'
                },
            ],
            operators: [],
            role: {
                dashboard: {
                    show: '',
                },
                post: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                category: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                label: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                page: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                operator: {
                    show: false,
                },
                table: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                forms: {
                    show: '',
                    delete: ''
                },
                settings: {
                    site: '',
                    header: '',
                    sidebar: '',
                    footer: ''
                },
                redirect: {
                    show: '',
                    add: '',
                    delete: ''
                },
                users: {
                    show: '',
                    edit: ''
                },
                notificate: {
                    show: '',
                    add: '',
                },
                product: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                tag: {
                    show: '',
                    add: '',
                    edit: '',
                    delete: ''
                },
                company: {
                    show: '',
                    edit: '',
                },
                ads: {
                    show: '',
                    edit: '',
                    delete: ''
                },
                support: {
                    show: '',
                    edit: '',
                },
            }
        }
    },
    methods: {
        editOperator(id) {
            this.$refs.editModal.click();
            this.operators.map(item => {
                if (item.id == id) {
                    this.operator.id = id
                    this.operator.name = item.name
                }
            });
            axios.get('/operators/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                if (response.data != null) {
                    this.role.dashboard.show = response.data.dashboard.show
                    this.role.table.show = response.data.table.show
                    this.role.table.add = response.data.table.add
                    this.role.table.edit = response.data.table.edit
                    this.role.table.delete = response.data.table.delete
                    this.role.product.show = response.data.product.show
                    this.role.product.add = response.data.product.add
                    this.role.product.edit = response.data.product.edit
                    this.role.product.delete = response.data.product.delete
                    this.role.tag.show = response.data.tag.show
                    this.role.tag.add = response.data.tag.add
                    this.role.tag.edit = response.data.tag.edit
                    this.role.tag.delete = response.data.tag.delete
                    this.role.forms.show = response.data.forms.show
                    this.role.forms.delete = response.data.forms.delete
                    this.role.redirect.show = response.data.redirect.show
                    this.role.redirect.add = response.data.redirect.add
                    this.role.redirect.delete = response.data.redirect.delete
                    this.role.page.show = response.data.page.show
                    this.role.page.add = response.data.page.add
                    this.role.page.edit = response.data.page.edit
                    this.role.page.delete = response.data.page.delete
                    this.role.users.show = response.data.users.show
                    this.role.users.edit = response.data.users.edit
                    this.role.notificate.show = response.data.notificate.show
                    this.role.notificate.add = response.data.notificate.add
                    this.role.settings.site = response.data.settings.site
                    this.role.settings.header = response.data.settings.header
                    this.role.settings.sidebar = response.data.settings.sidebar
                    this.role.settings.footer = response.data.settings.footer
                    this.role.post.show = response.data.post.show
                    this.role.post.add = response.data.post.add
                    this.role.post.edit = response.data.post.edit
                    this.role.post.delete = response.data.post.delete
                    this.role.label.show = response.data.label.show
                    this.role.label.add = response.data.label.add
                    this.role.label.edit = response.data.label.edit
                    this.role.label.delete = response.data.label.delete
                    this.role.category.show = response.data.category.show
                    this.role.category.add = response.data.category.add
                    this.role.category.edit = response.data.category.edit
                    this.role.category.delete = response.data.category.delete
                    this.role.company.show = response.data.company.show
                    this.role.company.edit = response.data.company.edit
                    this.role.ads.show = response.data.ads.show
                    this.role.ads.edit = response.data.ads.edit
                    this.role.ads.delete = response.data.ads.delete
                    this.role.support.show = response.data.support.show
                    this.role.support.edit = response.data.support.edit
                    this.role.support.delete = response.data.support.delete
                }
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
        updateOperator(id) {
            this.$emit('loading');
            const sentData = {
                api_token: this.$cookies.get('user').token,
                id: id,
                role: this.role
            }
            axios.put("/operators/update", sentData).then((response) => {
                if (response.data == 'successfully updated') {
                    this.$refs.closeEditModal.click();
                }
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
    },
    beforeCreate() {
        axios.get('/operators/all', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            if (response != null) {
                if (response.data.data) {
                    for (const responseElement of response.data.data) {
                        this.operators.push({
                            id: responseElement.id,
                            name: responseElement.name,
                            role: responseElement.role,
                        });
                    }
                }
            }
            this.$emit('loadingHide');
        }).catch(() => {
            this.$emit('loadingHide');
        });
    },
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('operators') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


