<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('forms')"/>
        <div v-show="!user.role.forms.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.forms.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="forms"
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
                        <span v-show="props.row.language=='en' && props.row.type!='تماس با ما'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-29 text-white ">{{
                                $t('english') + " "
                            }}</span>
                        <span v-show="props.row.language=='fa'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-29 text-white ">{{
                                $t('persian') + " "
                            }}</span>
                        <span v-show="props.row.status=='draft' && props.row.type!='تماس با ما'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-21 text-white ">{{
                                $t('draft') + " "
                            }}</span>
                        <span v-show="props.row.status=='publish' && props.row.type!='تماس با ما'"
                              class="my-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white ">{{
                                $t('publish') + " "
                            }}</span>
                    </div>
                    <span v-if="props.column.field == 'after'" class="flex align-items-center">
                        <button @click.prevent="manafeForm(props.row.id)"
                                class="btn btn-sm btn-outline-dark m-1">
                           {{ $t('management') }}
                        </button>
                        <button v-show="user.role.forms.delete" @click.prevent="deleteForm(props.row.id)"
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-left ml-auto">
                        {{ $t('manage-form') }}</h2>
                </div>
                <form @submit.prevent="">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                        <div class="col-span-12 sm:col-span-12">
                            <div v-show="form.type=='faq'">
                                <label for="status">{{ $t('status') }}</label>
                                <select id="status" v-model="form.status" class="form-control mb-2">
                                    <option value="publish">{{ $t('publish') }}</option>
                                    <option value="draft">{{ $t('draft') }}</option>
                                </select>
                                <label for="lang">{{ $t('language') }}</label>
                                <select id="lang" v-model="form.language" class="form-control mb-2">
                                    <option value="fa">{{ $t('persian') }}</option>
                                    <option value="en">{{ $t('english') }}</option>
                                </select>
                                <textarea class="form-control w-100" v-model="form.faq.question"
                                          :placeholder="$t('question')"></textarea>
                                <textarea class="form-control" v-model="form.faq.answer"
                                          :placeholder="$t('answer')"></textarea>
                            </div>
                            <div v-show="form.type=='feedback'">
                                <label for="status">{{ $t('status') }}</label>
                                <select id="status" v-model="form.status" class="form-control mb-2">
                                    <option value="publish">{{ $t('publish') }}</option>
                                    <option value="draft">{{ $t('draft') }}</option>
                                </select>
                                <label for="lang">{{ $t('language') }}</label>
                                <select id="lang" v-model="form.language" class="form-control mb-2">
                                    <option value="fa">{{ $t('persian') }}</option>
                                    <option value="en">{{ $t('english') }}</option>
                                </select>
                                <textarea class="form-control w-100" v-model="form.feedback.text"
                                          :placeholder="$t('text')"></textarea>
                            </div>
                            <div v-show="form.type=='contact'">
                                <p v-text=" $t('name') + ': '+form.contact.name"></p>
                                <p v-text="$t('email') + ': '+form.contact.email"></p>
                                <p v-text="$t('subject') + ': '+form.contact.subject"></p>
                                <p v-text="$t('text') + ': '+form.contact.text"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-end flex items-center">
                        <button r type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-20 mx-4">
                            {{ $t('cancel') }}
                        </button>
                        <button v-show="form.type!='contact'" type="button"
                                @click="updateForm()" class="btn btn-success w-20">
                            <div v-show="editLoad">{{ $t('ok') }}</div>
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
            loading: true,
            columns: [
                {
                    label: this.$t('type-form'),
                    field: 'type',
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
            forms: [],
            form: {
                id: '',
                language: '',
                status: '',
                type: '',
                feedback: {
                    text: '',
                    companyId: ''
                },
                contact: {
                    name: '',
                    email: '',
                    subject: '',
                    text: ''
                },
                faq: {
                    question: '',
                    answer: ''
                }
            },
            editLoad: true,
        }
    },
    methods: {
        deleteForm(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/form/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.forms = this.forms.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
        getForm() {
            axios.get('/form', {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                this.forms = [];
                for (const responseElement of response.data) {
                    this.forms.push({
                        id: responseElement.id,
                        type: responseElement.type,
                        status: responseElement.status,
                        language: responseElement.language,
                        time: responseElement.time,
                    });
                }
            }).catch(() => {
                this.forms = [];
            });
        },
        updateForm() {
            this.$emit('loading');
            this.editLoad = false;
            if (this.form.type == 'faq') {
                var body = this.form.faq;
            } else {
                var body = this.form.feedback;
            }
            const sentData = {
                api_token: this.$cookies.get('user').token,
                language: this.form.language,
                status: this.form.status,
                body: body
            }
            axios.put("/form/update/" + this.form.id, sentData).then(() => {
                this.getForm();
                this.editLoad = true;
                this.$refs.closeEditModal.click();
                this.$emit('loadingHide');
            }).catch(() => {
                this.editLoad = true;
                this.$emit('loadingHide');
            });
        },
        manafeForm(id) {
            this.$refs.editModal.click();
            axios.get('/form/' + id, {
                params: {
                    'api_token': this.$cookies.get('user').token
                }
            }).then(response => {
                this.form.id = response.data.id
                this.form.language = response.data.language
                this.form.status = response.data.status
                this.form.type = response.data.type
                if (response.data.type == 'faq') {
                    this.form.faq.question = response.data.body.question
                    this.form.faq.answer = response.data.body.answer
                }
                if (response.data.type == 'feedback') {
                    this.form.feedback.text = response.data.body.text;
                    this.form.feedback.companyId = response.data.body.companyId;
                }
                if (response.data.type == 'contact') {
                    this.form.contact.name = response.data.body.name;
                    this.form.contact.email = response.data.body.email;
                    this.form.contact.subject = response.data.body.subject;
                    this.form.contact.text = response.data.body.text;
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
        },
    }
    ,
    beforeCreate() {
        axios.get('/form', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            this.forms = [];
            if (response.data != 'null') {
                for (const responseElement of response.data) {
                    this.forms.push({
                        id: responseElement.id,
                        type: responseElement.type,
                        status: responseElement.status,
                        language: responseElement.language,
                        time: responseElement.time,
                    });
                }
            }
            this.$emit('loadingHide');
        }).catch(() => {
            this.forms = [];
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
                    document.title = this.$t('forms') + ' | ' + this.$t('adminTitlePage');
                }
            }
            ,
        }
    ,

}
</script>


