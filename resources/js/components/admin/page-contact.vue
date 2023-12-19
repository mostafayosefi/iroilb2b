<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('edit') + ' ' + $t('page')  + ' ' + $t('contact') ">
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
                                <QuillEditor v-model:content="page.text.fa" theme="snow" toolbar="full"
                                             ref="myEditorFa"/>
                                <hr class="my-4">
                                <label for="desc">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                                <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                      :class="page.seoDescription.fa.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                        page.seoDescription.fa.length
                                    }}</span>
                                <textarea id="desc" class="form-control mt-3" rows="3"
                                          :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                          v-model="page.seoDescription.fa" maxlength="170">
                            </textarea>
                                <hr class="my-4">
                                <button class="btn btn-sm btn-dark font-bold mb-2" @click="add('fa')">
                                    {{ $t('add') }}
                                </button>

                                <draggable
                                    tag="ul"
                                    :list="page.element.fa"
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

                                            <label class="mx-2 font-bold">{{ $t('icon') }}</label>
                                            <select id="" v-model="element.icon" class="form-control mb-2">
                                                <option value="adress">{{ $t('adress') }}</option>
                                                <option value="phone">{{ $t('phone') }}</option>
                                                <option value="telegram">{{ $t('telegram') }}</option>
                                                <option value="whatsapp">{{ $t('whatsapp') }}</option>
                                                <option value="facebook">{{ $t('facebook') }}</option>
                                                <option value="linkedin">{{ $t('linkedin') }}</option>
                                                <option value="twitter">{{ $t('twitter') }}</option>
                                                <option value="instagram">{{ $t('instagram') }}</option>
                                                <option value="aparat">{{ $t('aparat') }}</option>
                                                <option value="email">{{ $t('email') }}</option>
                                            </select>
                                            <br>
                                            <label class="mx-2 font-bold">{{ $t('color') }}</label>
                                            <input type="color" class="form-control mb-2" style="height: 50px;"
                                                   v-model="element.color"/>
                                            <br>
                                            <label class="mx-2 font-bold">{{ $t('title') }}</label>
                                            <input type="text" class="form-control" v-model="element.text"/>
                                            <br>
                                            <label class="mx-2 font-bold">{{ $t('link') }}</label>
                                            <input dir="ltr" type="text" class="form-control" v-model="element.link"/>

                                        </li>
                                    </template>
                                </draggable>
                            </div>
                            <div id="meta-title" role="tabpanel" class="tab-pane p-5">
                                <QuillEditor v-model:content="page.text.en" theme="snow" toolbar="full"
                                             ref="myEditorEn"/>
                                <hr class="my-4">
                                <label for="desc">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                                <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                      :class="page.seoDescription.en.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                        page.seoDescription.en.length
                                    }}</span>
                                <textarea id="desc" class="form-control mt-3" rows="3"
                                          :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                          v-model="page.seoDescription.en" maxlength="170">
                                </textarea>

                                <hr class="my-4">
                                <button class="btn btn-sm btn-dark font-bold mb-2" @click="add('en')">
                                    {{ $t('add') }}
                                </button>
                                <draggable
                                    tag="ul"
                                    :list="page.element.en"
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

                                            <label class="mx-2 font-bold">{{ $t('icon') }}</label>
                                            <select id="" v-model="element.icon" class="form-control mb-2">
                                                <option value="adress">{{ $t('adress') }}</option>
                                                <option value="phone">{{ $t('phone') }}</option>
                                                <option value="telegram">{{ $t('telegram') }}</option>
                                                <option value="whatsapp">{{ $t('whatsapp') }}</option>
                                                <option value="facebook">{{ $t('facebook') }}</option>
                                                <option value="linkedin">{{ $t('linkedin') }}</option>
                                                <option value="twitter">{{ $t('twitter') }}</option>
                                                <option value="instagram">{{ $t('instagram') }}</option>
                                                <option value="aparat">{{ $t('aparat') }}</option>
                                                <option value="email">{{ $t('email') }}</option>
                                            </select>
                                            <br>
                                            <label class="mx-2 font-bold">{{ $t('color') }}</label>
                                            <input type="color" class="form-control mb-2" style="height: 50px;"
                                                   v-model="element.color"/>
                                            <br>
                                            <label class="mx-2 font-bold">{{ $t('title') }}</label>
                                            <input type="text" class="form-control" v-model="element.text"/>
                                            <br>
                                            <label class="mx-2 font-bold">{{ $t('link') }}</label>
                                            <input dir="ltr" type="text" class="form-control" v-model="element.link"/>

                                        </li>
                                    </template>
                                </draggable>
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
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import axios from "axios";
import {defineAsyncComponent} from "vue";
import draggable from 'vuedraggable'
import {QuillEditor} from "@vueup/vue-quill";

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
        QuillEditor,
    },
    data() {
        return {
            error: false,
            page: {
                id: 3,
                image: '',
                text: {
                    fa: '',
                    en: '',
                },
                element: {
                    fa: [],
                    en: [],
                },
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
                this.page.element.fa.splice(idx, 1);
            }
            if (lang == 'en') {
                this.page.element.en.splice(idx, 1);
            }
        },
        add: function (lang) {
            if (lang == 'fa') {
                this.page.element.fa.push({
                    icon: 'adress',
                    text: '',
                    color: '',
                    link: '',
                    id: j
                });
                i++;
            }
            if (lang == 'en') {
                this.page.element.en.push({
                    icon: 'adress',
                    text: '',
                    color: '',
                    link: '',
                    id: j
                });
                j++;
            }
        },
        onChangeImage() {
            this.page.image = this.$refs["image"].files[0];
        },
        updatePage() {
            this.$emit('loading');
            const bodyFa = {
                body: this.$refs.myEditorFa.getHTML(),
                element: this.page.element.fa
            }
            const bodyEn = {
                body: this.$refs.myEditorEn.getHTML(),
                element: this.page.element.en
            }
            let formData = new FormData();
            formData.append('api_token', this.$cookies.get('user').token);
            formData.append('id', this.page.id);
            formData.append('images', this.page.image);
            formData.append('body_fa', JSON.stringify(bodyFa));
            formData.append('body_en', JSON.stringify(bodyEn));
            formData.append('description_fa', this.page.seoDescription.fa);
            formData.append('description_en', this.page.seoDescription.en);
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
            const Fa = JSON.parse(response.data.data.bodyFa);
            const En = JSON.parse(response.data.data.bodyEn);
            this.$refs.myEditorFa.setHTML(Fa.body)
            this.$refs.myEditorEn.setHTML(En.body)
            if (response.data.data.images) {
                this.page.image = this.$hostname + 'upload/page/' + response.data.data.images;
            }
            this.page.seoDescription.fa = response.data.data.seoDescriptionFa;
            this.page.seoDescription.en = response.data.data.seoDescriptionEn;
            for (const element of Fa.element) {
                this.page.element.fa.push({
                    icon: element.icon,
                    color: element.color,
                    link: element.link,
                    text: element.text,
                    id: element.id
                },);
                i++;
            }
            for (const element of En.element) {
                this.page.element.en.push({
                    icon: element.icon,
                    color: element.color,
                    link: element.link,
                    text: element.text,
                    id: element.id
                },);
                j++;
            }

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
                document.title = this.$t('edit') + ' ' + this.$t('page') + ' ' + this.$t('contact') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
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
