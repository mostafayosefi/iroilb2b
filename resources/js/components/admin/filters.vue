<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('filters')"
                      :element="user.role.tag.add"
                      :elementText="$t('add')"/>
        <div v-show="!user.role.tag.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.tag.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="filters"
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
                        <button v-show="user.role.tag.edit" @click.prevent="editfilter(props.row.id)"
                                class="btn btn-sm btn-outline-dark m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4"><path
                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path
                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <button v-show="user.role.tag.delete" @click.prevent="deletefilter(props.row.id)"
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

    <Teleport to=".filter-fa">
        <span class="fi fi-ir float-right ml-2"></span>
    </Teleport>
    <Teleport to=".filter-gb">
        <span class="fi fi-us float-right ml-2"></span>
    </Teleport>

    <!-- successs message toggle -->
    <div id="basic-non-sticky-notification-content" class="toastify-content hidden flex flex-col sm:flex-row">
        <div class="font-medium">{{ $t('add-success-message') }}</div>
    </div>

    <button id="basic-non-sticky-notification-toggle" ref="toggleButton" class="d-none"></button>

    <!-- add modal -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('add-new-filter') }}</h2>
                </div>
                <form @submit.prevent="">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <div id="input-group-email" class="input-group-text">
                                    <span class="fi fi-ir"></span>
                                </div>
                                <input @keyup.enter="addfilter" type="text" class="form-control"
                                       :placeholder="$t('name-filter' )"
                                       v-model="filter.nameFa">
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <input @keyup.enter="addfilter" type="text" dir="ltr" class="form-control text-left"
                                       :placeholder="$t('name-filter','en')"
                                       v-model="filter.nameEn">
                                <div id="input-group-email" class="input-group-text">
                                    <span class="fi fi-us"></span>
                                </div>
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
                        <button type="button" @click="addfilter()" class="btn btn-success w-20" :disabled="sendLoad">
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
    <!--edit modal-->
    <a href="javascript:;" data-toggle="modal" ref="editModal" data-target="#modaledit"
       class="d-none"></a>

    <div id="modaledit" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('edit-filter') }}</h2>
                </div>
                <form @submit.prevent="updatefilter(filterId)">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <div id="input-group-email" class="input-group-text">
                                    <span class="fi fi-ir"></span>
                                </div>
                                <input @keyup.enter="updatefilter(filterId)" type="text" class="form-control"
                                       :placeholder="$t('name-filter' )"
                                       v-model="filter.nameFa">
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <div class="input-group">
                                <input @keyup.enter="updatefilter(filterId)" type="text" dir="ltr"
                                       class="form-control text-left"
                                       :placeholder="$t('filter-name','en')"
                                       v-model="filter.nameEn">
                                <div id="input-group-email" class="input-group-text">
                                    <span class="fi fi-us"></span>
                                </div>
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
                        <button ref="closeEditModal" @click="filter.nameEn='';filter.nameFa=''" type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="updatefilter(filterId)" class="btn btn-success w-20"
                                :disabled="!editLoad">
                            <div v-show="editLoad">{{ $t('edit') }}</div>
                            <div v-show="!editLoad">
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
            filter: {
                nameFa: '',
                nameEn: '',
            },
            filterId: '',
            sendLoad: false,
            editLoad: false,
            successState: false,
            error: false,
            columns: [
                {
                    label: this.$t('name-filter'),
                    field: 'fa',
                    thClass: 'filter-fa'
                },
                {
                    label: this.$t('name-filter'),
                    field: 'en',
                    thClass: 'filter-gb'
                },
                {
                    label: this.$t('the-operation'),
                    field: 'after'
                },
            ],
            filters: [],
        }
    },
    methods: {
        addfilter() {
            if (this.filter.nameFa != '' && this.filter.nameEn != '') {
                this.sendLoad = true;
                this.error = false;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    filter: this.filter
                }
                axios.post("/filter/create", sentData).then((response) => {
                    if (response.data == 'success') {
                        this.filter.nameFa = '';
                        this.filter.nameEn = '';
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
        deletefilter(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/filter/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.filters = this.filters.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
        editfilter(id) {
            this.editLoad = false;
            this.error = false;
            this.$refs.editModal.click();
            axios.get('/filter/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                this.filter.nameFa = response.data.name_fa;
                this.filter.nameEn = response.data.name_en;
                this.filterId = response.data.id;
                this.editLoad = true;
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
        updatefilter(id) {
            if (this.filter.nameFa != '' && this.filter.nameEn != '') {
                this.$emit('loading');
                this.error = false;
                const sentData = {
                    api_token: this.$cookies.get('user').token,
                    filter: this.filter
                }
                axios.put("/filter/update/" + id, sentData).then((response) => {
                    if (response.data == 'successfully updated') {
                        this.filters = this.filters.map(item => {
                            if (item.id == id) {
                                item.fa = this.filter.nameFa;
                                item.en = this.filter.nameEn;
                            }
                            return item;
                        });
                        this.$refs.closeEditModal.click();
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            } else {
                this.error = true
            }
        },
        getAll() {
            this.filters = [];
            axios.get('/filter', {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                for (const responseElement of response.data.data) {
                    this.filters.push({
                        id: responseElement.id,
                        fa: responseElement.name_fa,
                        en: responseElement.name_en,
                    });
                }
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    },
    beforeCreate() {
        axios.get('/filter', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data.data) {
                this.filters.push({
                    id: responseElement.id,
                    fa: responseElement.name_fa,
                    en: responseElement.name_en,
                });
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
                document.title = this.$t('filters') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


