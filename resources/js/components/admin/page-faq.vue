<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('edit') + ' ' + $t('page')  + ' ' + $t('faq') ">
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
        <div v-show="user.role.page.edit" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <div class="intro-y col-span-12 lg:col-span-9">
                <div class="post intro-y overflow-hidden box mt-5">
                    <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
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
                            <button class="btn btn-sm btn-dark font-bold mb-2" @click="add('fa')">
                                {{ $t('add') }}
                            </button>

                            <draggable
                                tag="ul"
                                :list="faq.fa"
                                class="list-group"
                                handle=".handle"
                                item-key="name">
                                <template #item="{ element, index }">
                                    <li class="bg-white mt-1 p-3 rounded">
                                        <div class="flex content-between">
                                            <i class="cursor-pointer handle">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     class="feather feather-align-justify block mx-auto">
                                                    <line x1="21" y1="10" x2="3" y2="10"></line>
                                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                                    <line x1="21" y1="18" x2="3" y2="18"></line>
                                                </svg>
                                            </i>
                                            <i class="close cursor-pointer" @click="removeAt(index,'fa')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     class="feather feather-x block mx-auto">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </i>
                                        </div>

                                        <label class="mx-2 font-bold">
                                            {{ $t('question') }}</label>
                                        <input type="text" class="form-control mb-2" v-model="element.question"/>
                                        <br>
                                        <label class="mx-2 font-bold">{{ $t('answer') }}</label>
                                        <textarea v-model="element.answer" class="form-control mb-2"> </textarea>

                                    </li>
                                </template>
                            </draggable>
                            <hr class="my-4">
                            <label for="desc">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                            <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                  :class="faq.seoDescription.fa.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                    faq.seoDescription.fa.length
                                }}</span>
                            <textarea id="desc" class="form-control mt-3" rows="3"
                                      :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                      v-model="faq.seoDescription.fa" maxlength="170">
                            </textarea>
                        </div>

                        <div id="meta-title" role="tabpanel" class="tab-pane p-5">
                            <button class="btn btn-sm btn-dark font-bold mb-2" @click="add('en')">
                                {{ $t('add') }}
                            </button>
                            <draggable
                                tag="ul"
                                :list="faq.en"
                                class="list-group"
                                handle=".handle"
                                item-key="name">
                                <template #item="{ element, index }">
                                    <li class="bg-white mt-1 p-3 rounded">
                                        <div class="flex content-between">
                                            <i class="cursor-pointer handle">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     class="feather feather-align-justify block mx-auto">
                                                    <line x1="21" y1="10" x2="3" y2="10"></line>
                                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                                    <line x1="21" y1="18" x2="3" y2="18"></line>
                                                </svg>
                                            </i>
                                            <i class="close cursor-pointer" @click="removeAt(index,'en')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     class="feather feather-x block mx-auto">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                            </i>
                                        </div>

                                        <label class="mx-2 font-bold">
                                            {{ $t('question') }}</label>
                                        <input type="text" class="form-control mb-2" v-model="element.question"/>
                                        <br>
                                        <label class="mx-2 font-bold">{{ $t('answer') }}</label>
                                        <textarea v-model="element.answer" class="form-control mb-2"> </textarea>

                                    </li>
                                </template>
                            </draggable>
                            <hr class="my-4">
                            <label for="desc">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                            <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                  :class="faq.seoDescription.en.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                    faq.seoDescription.en.length
                                }}</span>
                            <textarea id="desc" class="form-control mt-3" rows="3"
                                      :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                      v-model="faq.seoDescription.en" maxlength="170">
                            </textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="intro-y col-span-12 lg:col-span-3 text-left">
                <div class="box p-2 text-right mt-5">
                    <p class="bg-light-2 p-2 font-bold rounded mb-2">{{ $t('post-image') }}</p>
                    <img class="rounded mb-2" :src="(faq.image==null || faq.image.name)?'': faq.image">
                    <input type="file" ref="image" @change="onChangeImage">
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";
import axios from "axios";
import {defineAsyncComponent} from "vue";
import draggable from 'vuedraggable'

let i = 0;
let j = 0;
export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
        draggable,
    },
    data() {
        return {
            error: false,
            faq: {
                id: 4,
                image: '',
                fa: [],
                en: [],
                seoDescription: {
                    fa: '',
                    en: ''
                }
            }
        }
    },
    methods: {
        removeAt(idx, lang) {
            if (lang == 'fa') {
                this.faq.fa.splice(idx, 1);
            }
            if (lang == 'en') {
                this.faq.en.splice(idx, 1);
            }
        },
        add(lang) {
            if (lang == 'fa') {
                this.faq.fa.push({
                    question: '',
                    answer: '',
                    id: i
                });
                i++;
            }
            if (lang == 'en') {
                this.faq.en.push({
                    question: '',
                    answer: '',
                    id: j
                });
                j++;
            }
        },
        onChangeImage() {
            this.faq.image = this.$refs["image"].files[0];
        },
        updatePage() {
            this.$emit('loading');
            let formData = new FormData();
            formData.append('api_token', this.$cookies.get('user').token);
            formData.append('id', this.faq.id);
            formData.append('images', this.faq.image);
            formData.append('body_fa', JSON.stringify(this.faq.fa));
            formData.append('body_en', JSON.stringify(this.faq.en));
            formData.append('description_fa', this.faq.seoDescription.fa);
            formData.append('description_en', this.faq.seoDescription.en);
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
                console.log('error', error)
                this.$emit('loadingHide');
            });
        }
    },
    created() {
        axios.get('/page/special/' + this.faq.id,
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            this.faq.id = response.data.data.id;
            this.faq.fa = response.data.data.bodyFa?response.data.data.bodyFa:[];
            this.faq.en = response.data.data.bodyEn?response.data.data.bodyEn:[];
            if (response.data.data.images) {
                this.faq.image = this.$hostname + 'upload/page/' + response.data.data.images;
            }
            this.faq.seoDescription.fa = response.data.data.seoDescriptionFa;
            this.faq.seoDescription.en = response.data.data.seoDescriptionEn;
            this.$emit('loadingHide');
        }).catch((error) => {
            this.$emit('loadingHide');
        });
    },
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('edit') + ' ' + this.$t('page') + ' ' + this.$t('faq') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.label label {
    margin-right: 10px;
}

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
