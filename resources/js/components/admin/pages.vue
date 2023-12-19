<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('pages')" :element="user.role.page.add"
                      :elementText="$t('add')" :linkElement="true" :link="'adminNewPages'"></header-admin>
        <div v-show="!user.role.page.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.page.show">
            <div class="w-full flex mt-2 mb-4 font-bold">
                <div class="w-1/2 box intro-y p-4 mx-1 flex justify-between items-center">
                    <span>{{ $t('page') + " " + $t('home') }}</span>
                    <div>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'fa/' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('persian') }}</span>
                        </a>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'en/' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('english') }}</span>
                        </a>
                        <a v-show="user.role.page.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                           :href="$hostname + 'fa/admin/pages/home'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4">
                                <path
                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path
                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="w-1/2 box intro-y p-4 mx-1 flex justify-between items-center">
                    <span>{{ $t('page') + " " + $t('b2b-plus') }}</span>
                    <div>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'fa/b2bplus' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('persian') }}</span>
                        </a>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'en/b2bplus' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('english') }}</span>
                        </a>
                        <a v-show="user.role.page.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                           :href="$hostname + 'fa/admin/pages/b2bplus'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4">
                                <path
                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path
                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full flex mt-2 mb-4 font-bold">
                <div class="w-1/2 box intro-y p-4 mx-1 flex justify-between items-center">
                    <span>{{ $t('page') + " " + $t('contact') }}</span>
                    <div>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'fa/b2bplus/contact' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('persian') }}</span>
                        </a>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'en/b2bplus/contact' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('english') }}</span>
                        </a>
                        <a v-show="user.role.page.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                           :href="$hostname + 'fa/admin/pages/contact'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4">
                                <path
                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path
                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="w-1/2 box intro-y p-4 mx-1 flex justify-between items-center">
                    <span>{{ $t('page') + " " + $t('faq') }}</span>
                    <div>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'fa/b2bplus/faq' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('persian') }}</span>
                        </a>
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  + 'en/b2bplus/faq' ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-eye block w-4 h-4">
                                <path
                                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12"
                                        r="3"></circle>
                            </svg>
                            <span class="mr-2">{{ $t('english') }}</span>
                        </a>
                        <a v-show="user.role.page.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                           :href="$hostname + 'fa/admin/pages/faq'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4">
                                <path
                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path
                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box intro-y">
                <!--data table -->
                <vue-good-table
                    class="p-2"
                    :columns="columns"
                    :rows="pages"
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
                            class="py-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white font-medium">{{
                                props.row.time
                            }}</span>
                            <span class="py-1 px-2 rounded-full text-xs font-medium"
                                  v-text="props.row.status=='draft'?$t('draft'):$t('publish')"
                                  :class="props.row.status=='draft'?'bg-theme-15 text-dark':'bg-theme-11 text-white'"></span>
                        </div>
                        <span v-if="props.column.field == 'after'">
                         <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                            :href="$hostname  + 'fa/'+ props.row.slug ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                   stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                                  d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                                  r="3"></circle></svg>
                             <span class="mr-2">{{ $t('persian') }}</span>
                        </a>
                         <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                            :href="$hostname  + 'en/'+ props.row.slug ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                   stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                                  d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                                  r="3"></circle></svg>
                             <span class="mr-2">{{ $t('english') }}</span>
                        </a>
                       <a v-show="user.role.page.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                          :href="$hostname + 'fa/admin/pages/edit/' + props.row.id ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4"><path
                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path
                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <button v-show="user.role.page.delete" @click.prevent="deletePost(props.row.id)"
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
    </div>
    <Teleport to=".page-fa">
        <span class="fi fi-ir float-right ml-2"></span>
    </Teleport>
    <Teleport to=".page-en">
        <span class="fi fi-us float-right ml-2"></span>
    </Teleport>
</template>
<script>
import axios from "axios";
import {defineAsyncComponent} from "vue";
import 'vue-good-table-next/dist/vue-good-table-next.css'
import {VueGoodTable} from 'vue-good-table-next';
import "/node_modules/flag-icons/css/flag-icons.min.css";

export default {
    props: {
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
    },
    data() {
        return {
            pages: [],
            columns: [
                {
                    label: this.$t('title'),
                    field: 'titleFa',
                    thClass: 'page-fa'
                },
                {
                    label: this.$t('title'),
                    field: 'titleEn',
                    thClass: 'page-en'
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
        }
    },
    methods: {
        deletePost(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/page/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.pages = this.pages.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
    },
    created() {
        axios.get('/page',
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            if (response.data != 'null') {
                for (const responseElement of response.data) {
                    this.pages.push({
                        id: responseElement.id,
                        titleFa: responseElement.titleFa,
                        titleEn: responseElement.titleEn,
                        slug: responseElement.slug,
                        status: responseElement.status,
                        time: responseElement.time,
                    });
                }
            }
            this.$emit('loadingHide');
        }).catch((error) => {
            console.log(error.response.status)
            this.$emit('loadingHide');
        });
    },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('pages') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
