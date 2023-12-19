<template>
    <div class="content ">
        <header-admin :user="user"
            :title="$t('labels')"
            :element="user.role.label.add"
            :elementText="$t('add')"/>
        <div v-show="!user.role.label.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.label.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="labels"
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
                    <span v-if="props.column.field == 'title'">
                         <span class="fi float-right ml-2" :class="props.row.lang=='fa'?'fi-ir':'fi-us'"></span>
                        {{ props.row.title }}
                    </span>
                    <span v-if="props.column.field == 'after'">
                        <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                           :href="$hostname + props.row.lang +'/tag/' + props.row.link ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                              d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                              r="3"></circle></svg>
                        </a>
                        <button v-show="user.role.label.edit" @click.prevent="editLabel(props.row.id)"
                                class="btn btn-sm btn-outline-dark m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4"><path
                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path
                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <button v-show="user.role.label.delete" @click.prevent="deleteLabel(props.row.id)"
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

    <!-- add modal -->
    <div id="header-footer-modal-preview" class="modal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('add-new-labels') }}</h2>
                </div>
                <form @submit.prevent="">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <input @keyup.enter="addLabels()" type="text" class="form-control mb-1"
                                   :placeholder="$t('name-labels' )"
                                   v-model="title">
                            <label for="languge" class="my-3">{{ $t('language') }} </label>
                            <select v-model="lang" id="languge" class="form-control mt-2">
                                <option value="fa"> {{ $t('persian') }}</option>
                                <option value="en">{{ $t('english') }}</option>
                            </select>
                            <p class="text-left mt-2" dir="ltr">
                                {{ $hostname + language() + "/tag/" + sanitizeTitle(title) }}</p>
                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="desc" class="my-3">{{ $t('descriptions') }}</label>
                             <textarea id="desc" class="form-control" rows="5" :placeholder="$t('descriptions')"
                                       v-model="content">
                            </textarea>

                        </div>
                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="addLabels()" class="btn btn-success w-20"
                                :disabled="title.length<=0">
                            <div v-show="!sendLoad">{{ $t('send') }}</div>
                            <div v-show="sendLoad">
                                <i data-loading-icon="puff" class="w-5 h-5"></i>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('add-new-labels') }}</h2>
                </div>
                <form @submit.prevent="">
                    <div v-show="error"
                         class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mx-6"
                         role="alert">
                        <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                        {{ $t('error-empty-fields') }}
                    </div>
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="title-edit">{{ $t('name-label') }}</label>
                            <input @keyup.enter="updateLabel(label.id)" type="text" id="title-edit"
                                   class="form-control mb-2"
                                   :placeholder="$t('name-labels' )"
                                   v-model="label.title">
                            <label for="link-edit">{{ $t('link') }}</label>
                            <div class="input-group mb-2">
                                <input dir="ltr" id="link-edit" @keyup.enter="updateLabel(label.id)" type="text"
                                       class="form-control text-left"
                                       :placeholder="$t('name-labels' )"
                                       v-model="label.link">
                                <div id="input-group-price" class="input-group-text pb-0" dir="ltr">
                                    {{ $hostname + label.lang + "/tag/" }}
                                </div>
                            </div>

                            <label for="languge" class="my-3">{{ $t('language') }}</label>
                            <select v-model="label.lang" id="languge" class="form-control mt-2">
                                <option value="fa"> {{ $t('persian') }}</option>
                                <option value="en">{{ $t('english') }}</option>
                            </select>

                        </div>
                        <div class="col-span-12 sm:col-span-12">
                            <label for="des" class="my-3">{{ $t('descriptions') }}</label>
                            <textarea id="des" class="form-control" rows="5" :placeholder="$t('descriptions')"
                                      v-model="label.description">
                            </textarea>
                        </div>
                    </div>

                    <div class="modal-footer justify-end flex items-center">
                        <button ref="closeEditModal"
                                @click="label.title='';label.lang='';label.link='';label.id='';label.description='';"
                                type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button type="button" @click="updateLabel(label.id)" class="btn btn-success w-20">
                            <div v-show="!editLoad">{{ $t('edit') }}</div>
                            <div v-show="editLoad">
                                <i data-loading-icon="puff" class="w-5"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- successs message toggle -->
    <div id="basic-non-sticky-notification-content" class="toastify-content hidden flex flex-col sm:flex-row">
        <div class="font-medium">{{ $t('add-success-message') }}</div>
    </div>

    <button id="basic-non-sticky-notification-toggle" ref="toggleButton" class="d-none"></button>
</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";
import axios from "axios";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {defineAsyncComponent} from "vue";
import 'vue-good-table-next/dist/vue-good-table-next.css'
import {VueGoodTable} from 'vue-good-table-next';

export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user:Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
        VueGoodTable,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            title: '',
            lang: 'fa',
            sendLoad: false,
            slug: '',
            content: '',
            columns: [
                {
                    label: this.$t('name-label'),
                    field: 'title',
                    tdClass: 'tdrow'
                },
                {
                    label: this.$t('the-operation'),
                    field: 'after'
                },
            ],
            labels: [],
            error: false,
            editLoad: false,
            label: {
                id: '',
                title: '',
                link: '',
                lang: '',
                description: ''
            }
        }
    },
    methods: {
        sanitizeTitle: function (title) {
            var slug = "";
            // Change to lower case
            var titleLower = title.toLowerCase();
            // Letter "e"
            slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
            // Letter "a"
            slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
            // Letter "o"
            slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
            // Letter "u"
            slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
            // Letter "d"
            slug = slug.replace(/đ/gi, 'd');
            // Trim the last whitespace
            slug = slug.replace(/\s*$/g, '');
            // Change whitespace to "-"
            slug = slug.replace(/\s+/g, '-');
            // remove markup
            slug = slug.replace(/[`~!@#$%^&*()_؟|+\=?;:'",.،<>\{\}\[\]\\\/]/gi, '');
            this.slug = slug;
            return slug;
        },
        language() {
            return this.lang;
        },
        addLabels() {
            const sentData = {
                api_token: this.$cookies.get('user').token,
                title: this.title,
                slug: this.slug,
                text: this.content,
                lang: this.lang
            };
            if (this.title != '') {
                this.sendLoad = true;
                this.error = false;
                axios.post("/label/create", sentData).then((response) => {
                    if (response.data == 'success') {
                        this.title = '';
                        this.lang = 'fa';
                        this.content='';
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
        deleteLabel(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/label/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.labels = this.labels.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
        editLabel(id) {
            this.editLoad = false;
            this.error = false;
            this.$refs.editModal.click();
            axios.get('/label/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                this.label.id = response.data.id
                this.label.title = response.data.title
                this.label.link = response.data.slug
                this.label.lang = response.data.lang
                this.label.description = response.data.description;
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
        updateLabel(id) {
            if (this.label.title != '' && this.label.link != '') {
                this.$emit('loading');
                this.error = false;
                const sentData = {
                    'api_token': this.$cookies.get('user').token,
                    'label': this.label
                };
                axios.put("/label/update/" + id, sentData).then((response) => {
                    if (response.data == 'successfully updated') {
                        this.getAll();
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
            this.labels = [];
            axios.get('/label', {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                for (const responseElement of response.data.data) {
                    this.labels.push({
                        id: responseElement.id,
                        title: responseElement.title,
                        link: responseElement.slug,
                        lang: responseElement.lang,
                    });
                }
                this.$emit('loadingHide');
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    },
    beforeCreate() {
        axios.get('/label',
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            for (const responseElement of response.data.data) {
                this.labels.push({
                    id: responseElement.id,
                    title: responseElement.title,
                    lang: responseElement.lang,
                    link: responseElement.slug,

                });
                this.$emit('loadingHide');
            }
        }).catch(() => {
            this.$emit('loadingHide');
        });
    },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('labels') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
<style>
div#header-footer-modal-preview {
    z-index: 100 !important;
}

.ql-toolbar.ql-snow {
    direction: ltr;
}

.ql-editor {
    font-family: 'IRANYekan-L';
}
</style>
