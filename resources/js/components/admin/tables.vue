<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('tables')"
                      :element="user.role.table.add?true:false"
                      :elementText="$t('add')" :linkElement="true" :link="'adminTablesMaker'"/>
        <div v-show="!user.role.table.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.table.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="tables"
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
                    <span v-if="props.column.field == 'language' && props.row.language=='en'">{{ $t('english') }}</span>
                    <span v-if="props.column.field == 'language' && props.row.language=='fa'">{{ $t('persian') }}</span>
                    <span v-if="props.column.field == 'language' && props.row.language=='all'">{{ $t('all') }}</span>
                    <span v-if="props.column.field == 'after'">
                         <a v-show="user.role.table.edit" target="_blank" class="btn btn-sm btn-outline-secondary m-1"
                            :href="$hostname + 'fa/admin/tables/pdf/' + props.row.id ">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-download w-4 h-4"><path
                               d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline
                               points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        </a>
                        <a v-show="user.role.table.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                           :href="$hostname + 'fa/admin/tables/edit/' + props.row.id ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4"><path
                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path
                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <button v-show="user.role.table.delete" @click.prevent="deleteTable(props.row.id)"
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
            columns: [
                {
                    label: this.$t('name'),
                    field: 'title',
                },
                {
                    label: this.$t('language'),
                    field: 'language',
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
            tables: [],
        }
    },
    methods: {
        deleteTable(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/table/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.tables = this.tables.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
    },
    beforeCreate() {
        axios.get('/table', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            if (response.data != 'null') {
                for (const responseElement of response.data) {
                    this.tables.push({
                        id: responseElement.id,
                        title: responseElement.title,
                        language: responseElement.language,
                        time: responseElement.time,
                    });
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
                document.title = this.$t('tables') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


