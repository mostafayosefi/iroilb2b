<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('companies')"
        />
        <div v-show="!user.role.company.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.company.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="companies"
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
                    <div v-if="props.column.field == 'info'" class="flex">
                        <img v-show="props.row.verified=='verified'" src="/images/verified.svg" class="w-5 mx-1">
                        <span class="px-2 mx-1 rounded-full text-xs bg-theme-21 text-white"
                              v-show="props.row.status=='draft'">{{ $t('check') }}</span>
                        <span class="text-xs bg-theme-1 px-2 text-white rounded-full text-xs"
                              v-show="props.row.status=='timeout'">{{ $t('timeout') }}</span>
                        <span class="bg-theme-18 px-2 text-dark rounded-full text-xs"
                              v-show="props.row.status=='reject'">{{ $t('reject') }}</span>
                        <span class="px-2 mx-1 rounded-full text-xs bg-theme-20 text-white"
                              v-show="props.row.status=='active'">{{ $t('active') }}</span>
                    </div>
                    <span v-if="props.column.field == 'after'" class="flex items-center">
                        <a v-show="props.row.status=='active'" target="_blank"
                           class="btn btn-sm btn-outline-primary mx-1"
                           :href="$hostname  + 'fa/co/'+ props.row.slug ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                   stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                                  d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                                  r="3"></circle></svg>
                             <span class="mr-2">{{ $t('persian') }}</span>
                        </a>
                         <a v-show="props.row.status=='active'" target="_blank"
                            class="btn btn-sm btn-outline-primary mx-1"
                            :href="$hostname  + 'en/co/'+ props.row.slug ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                   stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                                  d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                                  r="3"></circle></svg>
                             <span class="mr-2">{{ $t('english') }}</span>
                        </a>
                        <router-link v-show="user.role.company.edit/1"
                                     class="btn btn-sm btn-outline-dark my-0 mx-1 font-bold"
                                     :to="{path:'/fa/admin/companies/'+props.row.id}">
                           {{ $t('management') }}
                        </router-link>
                    </span>
                </template>
            </vue-good-table>
        </div>
    </div>

    <Teleport to=".product-fa">
        <span class="fi fi-ir float-right ml-2"></span>
    </Teleport>
    <Teleport to=".product-gb">
        <span class="fi fi-us float-right ml-2"></span>
    </Teleport>
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
            error: false,
            columns: [
                {
                    label: this.$t('name'),
                    field: 'nameFa',
                    thClass: 'product-fa'
                },
                {
                    label: this.$t('name'),
                    field: 'nameEn',
                    thClass: 'product-gb'
                },
                {
                    label: this.$t('public'),
                    field: 'create',
                },
                {
                    label: this.$t('last-update'),
                    field: 'update',
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
            companies: [],
        }
    },
    beforeCreate() {
        axios.get('/company/admin', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data) {
                this.companies.push({
                    id: responseElement.data.id,
                    nameFa: responseElement.fa.name,
                    nameEn: responseElement.en.name,
                    slug: responseElement.data.slug,
                    status: responseElement.data.status,
                    verified: responseElement.data.verified,
                    update: responseElement.data.update,
                    create: responseElement.data.create
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
                document.title = this.$t('companies') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>


