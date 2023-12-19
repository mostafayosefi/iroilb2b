<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('ads')"/>
        <div v-show="!user.role.ads.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.ads.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="ads"
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
                            class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-27 text-white ">{{
                                props.row.time
                            }}</span>
                        <span v-show="props.row.language=='en'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-29 text-white ">{{
                                $t('english') + " "
                            }}</span>
                        <span v-show="props.row.language=='fa'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-29 text-white ">{{
                                $t('persian') + " "
                            }}</span>

                        <span v-show="props.row.status=='draft'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-21 text-white ">{{
                                $t('draft') + " "
                            }}</span>
                        <span v-show="props.row.status=='active'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white ">{{
                                $t('publish') + " "
                            }}</span>
                        <span v-show="props.row.status=='reject'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                $t('reject') + " "
                            }}</span>
                        <span v-show="props.row.status=='timeout'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                $t('timeout') + " "
                            }}</span>
                        <span v-show="props.row.status=='deleted'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-1 text-white ">{{
                                $t('user-deleted') + " "
                            }}</span>

                    </div>
                    <span v-if="props.column.field == 'after'" class="flex align-items-center">
                        <a v-show="props.row.status=='active' || props.row.status=='timeout'" target="_blank"
                           class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname  +props.row.language + '/ads/'+ props.row.slug ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                   stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                                  d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                                  r="3"></circle></svg>
                             <span class="mr-2">{{ $t('view') }}</span>
                        </a>
                        <button v-show="user.role.ads.edit" @click.prevent="getAd(props.row.id)"
                                class="btn btn-sm btn-outline-dark m-1">
                           {{ $t('management') }}
                        </button>
                        <button v-show="user.role.ads.delete" @click.prevent="deleteAds(props.row.id)"
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

    <a href="javascript:;" data-toggle="modal" ref="editModal" data-target="#modaledit"
       class="d-none"></a>

    <div id="modaledit" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('manage-ads') }}</h2>
                </div>
                <form @submit.prevent="">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <div class="box p-2">
                                <div class="input-group intro-y">
                                    <input dir="ltr" id="slug" type="text"
                                           class="form-control text-left "
                                           :placeholder="$t('ad-slug')"
                                           v-model="ad.slug">
                                    <div id="input-group-price" class="input-group-text pb-0" dir="ltr">
                                        {{ $hostname + ad.language + "/ads/" }}
                                    </div>
                                </div>
                                <select id="subject" v-model="ad.status"
                                        class="w-full form-control mt-2 mb-2">
                                    <option value="active">
                                        {{ $t('publish') }}
                                    </option>
                                    <option value="reject">
                                        {{ $t('reject') }}
                                    </option>
                                    <option value="draft">
                                        {{ $t('draft') }}
                                    </option>
                                    <option value="timeout">
                                        {{ $t('timeout') }}
                                    </option>
                                    <option value="deleted">
                                        {{ $t('user-deleted') }}
                                    </option>
                                </select>
                                <select id="language" v-model="ad.language"
                                        class="w-full form-control p-2 mt-2 mb-2">
                                    <option value="fa">
                                        {{ $t('persian') }}
                                    </option>
                                    <option value="en">
                                        {{ $t('english') }}
                                    </option>
                                </select>
                                <label for="type">{{ $t('type') }}</label>
                                <select id="type" v-model="ad.type"
                                        class="w-full form-control mt-2 mb-2">
                                    <option value="sale">
                                        {{ $t('sale') }}
                                    </option>
                                    <option value="buy">
                                        {{ $t('buy') }}
                                    </option>
                                </select>
                                <label for="title">{{ $t('title') }}</label>
                                <input :dir="ad.language=='fa'?'rtl':'ltr'" id="title" type="text"
                                       class="form-control mt-2 mb-2"
                                       v-model="ad.body.title">
                                <label for="description">{{ $t('description', language) }}</label>
                                <textarea id="description" :dir="ad.language=='fa'?'rtl':'ltr'"
                                          class="form-control mt-2 mb-2"
                                          v-model="ad.body.description"></textarea>
                                <label for="weight">{{ $t('weight') }}</label>
                                <input :dir="ad.language=='fa'?'rtl':'ltr'" id="weight" type="text"
                                       class="form-control mt-2 mb-2"
                                       v-model="ad.body.weight">
                                <label for="price">{{ $t('price') }}</label>
                                <input :dir="ad.language=='fa'?'rtl':'ltr'" id="price" type="text"
                                       class="form-control mt-2 mb-2"
                                       v-model="ad.body.price">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" :disabled="ad.slug == null"
                                @click="updateAd()" class="btn btn-success w-20">
                            <div>{{ $t('ok') }}</div>
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
            columns: [
                {
                    label: this.$t('title'),
                    field: 'title',
                },
                {
                    label: this.$t('type'),
                    field: 'type',
                },
                {
                    label: this.$t('expire-at'),
                    field: 'expire',
                },
                {
                    label: this.$t('company-name'),
                    field: 'company',
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
            ads: [],
            ad: {
                status: '',
                id: '',
                slug: null,
                language: '',
                type: '',
                body: {
                    title: '',
                    weight: '',
                    tags: [],
                    country: '',
                    price: '',
                    description:''
                },
                expire: '',
            },
        }
    },
    methods: {
        deleteAds(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/advertise/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.ads = this.ads.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
        getAd(id) {
            this.$refs.editModal.click();
            axios.get('/advertise/id/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                this.ad.status = response.data.status
                this.ad.id = response.data.id
                this.ad.slug = response.data.slug
                this.ad.type = response.data.type
                this.ad.language = response.data.language
                this.ad.body.title = response.data.body.title
                this.ad.body.weight = response.data.body.weight
                this.ad.body.country = response.data.body.country
                this.ad.body.tags = response.data.body.tags
                this.ad.body.price = response.data.body.price
                this.ad.body.description = response.data.body.description
            }).catch(() => {
            });
        },
        updateAd() {
            this.$emit('loading');
            const sentData = {
                api_token: this.$cookies.get('user').token,
                id: this.ad.id,
                status: this.ad.status,
                slug: this.ad.slug,
                type: this.ad.type,
                language: this.ad.language,
                body: this.ad.body
            }
            axios.put("/advertise/update/" + this.ad.id, sentData).then(() => {
                this.getAds();
                this.$refs.closeEditModal.click();
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
        getAds() {
            this.ads = [];
            axios.get('/advertise/get', {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                for (const responseElement of response.data) {
                    this.ads.push({
                        id: responseElement.id,
                        title: responseElement.title,
                        slug: responseElement.slug,
                        type: responseElement.type,
                        status: responseElement.status,
                        language: responseElement.language,
                        expire: responseElement.expire,
                        time: responseElement.time,
                        company: responseElement.company.fa == "-" ? responseElement.company.en : responseElement.company.fa,
                        verified: responseElement.company.verified,
                    });
                    this.$emit('loadingHide');
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    },
    beforeCreate() {
        axios.get('/advertise/get', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data) {
                this.ads.push({
                    id: responseElement.id,
                    title: responseElement.title,
                    slug: responseElement.slug,
                    type: responseElement.type,
                    status: responseElement.status,
                    language: responseElement.language,
                    expire: responseElement.expire,
                    time: responseElement.time,
                    company: responseElement.company.fa == "-" ? responseElement.company.en : responseElement.company.fa,
                    verified: responseElement.company.verified,
                });
                this.$emit('loadingHide');
            }
        }).catch(() => {
            this.$emit('loadingHide');
        });
    }
    ,
    name: 'App',
    watch:
        {
            $route: {
                immediate: true,
                handler(to, from) {
                    document.title = this.$t('ads') + ' | ' + this.$t('adminTitlePage');
                }
            }
            ,
        }
    ,

}
</script>


