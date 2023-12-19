<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('edit') + ' ' + $t('page') + ' ' + $t('b2b-plus') ">
            <button v-show="user.role.page.edit" class="btn border-0 btn-green"
                    @click="updatePage()">
                <span>{{ $t('update') }}</span>
            </button>
        </header-admin>
        <div v-show="!user.role.page.edit"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.page.edit">
            <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                <div class="intro-y col-span-12 lg:col-span-9">
                    <div v-show="error"
                         class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mb-4 bg-white"
                         role="alert">
                        <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                        {{ $t('error-empty-page-fields') }}
                    </div>

                    <div class="post intro-y overflow-hidden box mt-5">
                        <div
                            class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                            role="tablist">
                            <a :title="$t('body')" data-toggle="tab" data-target="#content" href="javascript:;"
                               class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center active"
                               id="content-tab" role="tab">
                                <i class="fi fi-ir ml-2"></i>
                                {{ $t('persian') }}
                            </a>
                            <a :title="$t('seo-tools')" data-toggle="tab" data-target="#meta-title" href="javascript:;"
                               class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center"
                               id="meta-title-tab" role="tab">
                                <i class="fi fi-us ml-2"></i>
                                {{ $t('english') }}
                            </a>
                        </div>
                        <div class="post__content tab-content">
                            <div id="content" class="tab-pane p-5 active" role="tabpanel">
                                <QuillEditor v-model:content="page.fa.body" theme="snow" toolbar="full"
                                             ref="myEditorFa"/>
                                <hr class="my-4">
                                <label for="desc">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                                <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                      :class="page.fa.seoDescription.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                        page.fa.seoDescription.length
                                    }}</span>
                                <textarea id="desc" class="form-control mt-3" rows="3"
                                          :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                          v-model="page.fa.seoDescription" maxlength="170">
                            </textarea>
                            </div>

                            <div id="meta-title" role="tabpanel" class="tab-pane p-5">
                                <QuillEditor v-model:content="page.en.body" theme="snow" toolbar="full"
                                             ref="myEditorEn"/>
                                <hr class="my-4">
                                <label for="desc">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                                <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                      :class="page.en.seoDescription.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                        page.en.seoDescription.length
                                    }}</span>
                                <textarea id="desc" class="form-control mt-3" rows="3"
                                          :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                          v-model="page.en.seoDescription" maxlength="170">
                            </textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="intro-y col-span-12 lg:col-span-3 text-left">
                    <div class="box p-2 text-right mt-5">
                        <p class="bg-light-2 p-2 font-bold rounded mb-2">{{ $t('post-image') }}</p>
                        <img class="rounded mb-2" :src="(page.image==null || page.image.name)?'': page.image">
                        <input type="file" ref="image" @change="onChangeImage">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";
import axios from "axios";
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {defineAsyncComponent} from "vue";

export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
        QuillEditor,
    },
    data() {
        return {
            error: false,
            page: {
                id: 2,
                image: '',
                fa: {
                    body: '',
                    seoDescription: '',
                },
                en: {
                    body: '',
                    seoDescription: '',
                }
            },
        }
    },
    methods: {
        onChangeImage() {
            this.page.image = this.$refs["image"].files[0];
        },
        updatePage() {
            if (this.page.slug != '') {
                this.$emit('loading');
                this.error = false;
                this.page.fa.body = this.$refs.myEditorFa.getHTML()
                this.page.en.body = this.$refs.myEditorEn.getHTML()
                let formData = new FormData();
                formData.append('api_token', this.$cookies.get('user').token);
                formData.append('id', this.page.id);
                formData.append('images', this.page.image);
                formData.append('body_fa', this.page.fa.body);
                formData.append('body_en', this.page.en.body);
                formData.append('description_fa', this.page.fa.seoDescription);
                formData.append('description_en', this.page.en.seoDescription);
                axios.post('/page/special/update',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((res) => {
                    if (res.data.status == 200) {
                        this.$router.push({name: 'adminPages'})
                        this.$emit('loadingHide');
                    }
                }).catch(error => {
                    this.$emit('loadingHide');
                });
            } else {
                this.error = true;
            }

        }
    },
    created() {
        axios.get('/page/special/' + this.page.id,
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            this.page.id = response.data.data.id;
            if (response.data.data.images) {
                this.page.image = this.$hostname + 'upload/page/' + response.data.data.images;
            }
            this.$refs.myEditorFa.setHTML(response.data.data.bodyFa);
            this.$refs.myEditorEn.setHTML(response.data.data.bodyEn);
            this.page.fa.seoDescription = response.data.data.seoDescriptionFa;
            this.page.en.seoDescription = response.data.data.seoDescriptionEn;
            this.$emit('loadingHide');
        }).catch((error) => {
            this.$emit('loadingHide');
        });
    },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('edit') + ' ' + this.$t('page') + ' ' + this.$t('b2b-plus') + ' | ' + this.$t('adminTitlePage');
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
