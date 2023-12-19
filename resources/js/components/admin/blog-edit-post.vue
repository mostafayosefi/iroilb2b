<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('edit') + ' ' + $t('post') + ': ' + post.title "></header-admin>
        <div v-show="!show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mb-4 bg-white"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('post-notfound') }}
        </div>
        <div v-show="!user.role.post.edit"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.post.edit">
            <div v-show="show" class="pos intro-y grid grid-cols-12 gap-5 mt-5">

                <div class="intro-y col-span-12 lg:col-span-9">
                    <div v-show="error"
                         class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mb-4 bg-white"
                         role="alert">
                        <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                        {{ $t('error-empty-post-fields') }}
                    </div>
                    <input :dir="post.language=='fa'?'rtl':'ltr'" type="text"
                           class="form-control py-3 px-4 box placeholder-theme-8 mb-4"
                           :placeholder="$t('title')" v-model="post.title">

                    <div class="box p-2">
                        <div class="input-group intro-y">
                            <input dir="ltr" id="slug" type="text"
                                   class="form-control text-left "
                                   :placeholder="$t('post-slug' )"
                                   v-model="post.slug">
                            <div id="input-group-price" class="input-group-text pb-0" dir="ltr">
                                {{ $hostname + post.language + "/post/" }}
                            </div>
                        </div>
                    </div>

                    <div class="post intro-y overflow-hidden box mt-5">
                        <div
                            class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                            role="tablist">
                            <a :title="$t('body')" data-toggle="tab" data-target="#content" href="javascript:;"
                               class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center active"
                               id="content-tab" role="tab">
                                <i data-feather="file-text" class="w-4 h-4 ml-2"></i>
                                {{ $t('body') }}
                            </a>
                            <a :title="$t('seo-tools')" data-toggle="tab" data-target="#meta-title" href="javascript:;"
                               class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center"
                               id="meta-title-tab" role="tab">
                                <i data-feather="code" class="w-4 h-4 ml-2"></i>
                                {{ $t('seo-tools') }}
                            </a>
                        </div>
                        <div class="post__content tab-content">
                            <div id="content" class="tab-pane p-5 active" role="tabpanel">
                                <QuillEditor v-model:content="post.body" theme="snow" toolbar="full"
                                             ref="myEditor"/>
                            </div>

                            <div id="meta-title" role="tabpanel" class="tab-pane p-5">
                                <label for="desc" class="mt-3">{{ $t('descriptions') + ' ' + $t('seo') }}</label>
                                <span class="mx-2 px-2 rounded-full bg-theme-21 text-xs text-white"
                                      :class="post.seoDescription.length<160 ? 'bg-theme-' : 'bg-theme-20'">{{
                                        post.seoDescription.length
                                    }}</span>
                                <textarea id="desc" class="form-control mt-3" rows="3"
                                          :placeholder="$t('descriptions') + ' ' + $t('seo')"
                                          v-model="post.seoDescription" maxlength="320">
                            </textarea>
                                <div class="mt-2 mb-4">
                                    <Multiselect id="kay" class="mt-2.5 mb-3" v-model="post.seoKayword" :rtl="true"
                                                 :placeholder="$t('insert-kaywords')" :noOptionsText="$t('empty')"
                                                 v-bind="multiOption"
                                                 :options="post.seoKayword"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="intro-y col-span-12 lg:col-span-3 text-left">
                    <button class="btn mb-4 btn-lg border-0" :class="post.status=='publish'? 'btn-green' :'btn-dark' "
                            @click="updatePost()">
                        <span v-show="post.status=='draft'">{{ $t('save') + " " + $t('draft') }}</span>
                        <span v-show="post.status=='publish'">{{ $t('update') }}</span>
                    </button>
                    <div class="box p-2 text-right">
                        <p class="bg-light-2 p-2 font-bold rounded mb-2">{{ $t('setting') }}</p>
                        <select id="lang" class="form-control" v-model="post.language">
                            <option value="fa">{{ $t('persian') }}</option>
                            <option value="en">{{ $t('english') }}</option>
                        </select>

                        <select id="lang" class="form-control mt-2" v-model="post.status">
                            <option value="draft">{{ $t('draft') }}</option>
                            <option value="publish">{{ $t('publish') }}</option>
                        </select>
                    </div>

                    <div class="box p-2 text-right mt-6">
                        <p class="bg-light-2 p-2 font-bold rounded mb-2">{{ $t('post-image') }}</p>
                        <img class="rounded mb-2" :src="(post.image==null || post.image.name)?'':post.image">
                        <input type="file" ref="image" @change="onChangeImage">

                    </div>
                    <div class="box p-2 text-right mt-6">
                        <p class="bg-light-2 p-2 font-bold rounded mb-2">{{ $t('categories') }}</p>
                        <ul v-for="cat in categories" :key="cat.id" class="label">
                            <li>
                                <input type="checkbox" v-model="post.category" :id="cat.titleEn" :value="cat.id">
                                <label :for="cat.titleEn">
                                    {{ cat.titleFa + " (" + cat.titleEn + ") " }}
                                </label>
                                <ul v-for="subCat in subCategories" :key="subCat.id" class="ul">
                                    <li v-if="subCat.parentId==cat.id">
                                        <input type="checkbox" v-model="post.category" :id="subCat.titleEn"
                                               :value="subCat.id">
                                        <label :for="subCat.titleEn">
                                            {{ subCat.titleFa + " (" + subCat.titleEn + ") " }}
                                        </label>
                                        <ul v-for="aSubCat in subCategories" :key="aSubCat.id" class="ul">
                                            <li v-if="aSubCat.parentId==subCat.id">
                                                <input type="checkbox" v-model="post.category" :id="aSubCat.titleEn"
                                                       :value="aSubCat.id">
                                                <label :for="aSubCat.titleEn">
                                                    {{ aSubCat.titleFa + " (" + aSubCat.titleEn + ") " }}
                                                </label>
                                                <ul v-for="bSubCat in subCategories" :key="bSubCat.id" class="ul">
                                                    <li v-if="bSubCat.parentId==aSubCat.id">
                                                        <input type="checkbox" v-model="post.category"
                                                               :id="bSubCat.titleEn"
                                                               :value="bSubCat.id">
                                                        <label :for="bSubCat.titleEn">
                                                            {{ bSubCat.titleFa + " (" + bSubCat.titleEn + ") " }}
                                                        </label>
                                                        <ul v-for="cSubCat in subCategories" :key="cSubCat.id"
                                                            class="ul">
                                                            <li v-if="cSubCat.parentId==bSubCat.id">
                                                                <input type="checkbox" v-model="post.category"
                                                                       :id="cSubCat.titleEn" :value="cSubCat.id">
                                                                <label :for="cSubCat.titleEn">
                                                                    {{
                                                                        cSubCat.titleFa + " (" + cSubCat.titleEn + ") "
                                                                    }}
                                                                </label>
                                                                <ul v-for="dSubCat in subCategories"
                                                                    :key="dSubCat.id" class="ul">
                                                                    <li v-if="dSubCat.parentId==cSubCat.id">
                                                                        <input type="checkbox" v-model="post.category"
                                                                               :id="dSubCat.titleEn"
                                                                               :value="dSubCat.id">
                                                                        <label :for="dSubCat.titleEn">
                                                                            {{
                                                                                dSubCat.titleFa + " (" + dSubCat.titleEn + ") "
                                                                            }}
                                                                        </label>
                                                                        <ul v-for="eSubCat in subCategories"
                                                                            :key="eSubCat.id" class="ul">
                                                                            <li v-if="eSubCat.parentId==dSubCat.id">
                                                                                <input type="checkbox"
                                                                                       v-model="post.category"
                                                                                       :id="eSubCat.titleEn"
                                                                                       :value="eSubCat.id">
                                                                                <label :for="eSubCat.titleEn">
                                                                                    {{
                                                                                        eSubCat.titleFa + " (" + eSubCat.titleEn + ") "
                                                                                    }}
                                                                                </label>
                                                                                <ul v-for="fSubCat in subCategories"
                                                                                    :key="fSubCat.id" class="ul">
                                                                                    <li v-if="fSubCat.parentId==eSubCat.id">
                                                                                        <input type="checkbox"
                                                                                               v-model="post.category"
                                                                                               :id="fSubCat.titleEn"
                                                                                               :value="fSubCat.id">
                                                                                        <label :for="fSubCat.titleEn">
                                                                                            {{
                                                                                                fSubCat.titleFa + " (" + fSubCat.titleEn + ") "
                                                                                            }}
                                                                                        </label>
                                                                                        <ul v-for="gSubCat in subCategories"
                                                                                            :key="gSubCat.id"
                                                                                            class="ul">
                                                                                            <li v-if="gSubCat.parentId==fSubCat.id">
                                                                                                <input type="checkbox"
                                                                                                       v-model="post.category"
                                                                                                       :id="gSubCat.titleEn"
                                                                                                       :value="gSubCat.id">
                                                                                                <label
                                                                                                    :for="gSubCat.titleEn">
                                                                                                    {{
                                                                                                        gSubCat.titleFa + " (" + gSubCat.titleEn + ") "
                                                                                                    }}
                                                                                                </label>
                                                                                                <ul v-for="hSubCat in subCategories"
                                                                                                    :key="hSubCat.id"
                                                                                                    class="ul">
                                                                                                    <li v-if="hSubCat.parentId==gSubCat.id">
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            v-model="post.category"
                                                                                                            :id="hSubCat.titleEn"
                                                                                                            :value="hSubCat.id">
                                                                                                        <label
                                                                                                            :for="hSubCat.titleEn">
                                                                                                            {{
                                                                                                                hSubCat.titleFa + " (" + hSubCat.titleEn + ") "
                                                                                                            }}
                                                                                                        </label>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </li>
                                                                                </ul>

                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>

                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="box p-2 text-right mt-6">
                        <p class="bg-light-2 p-2 font-bold rounded mb-2">{{ $t('labels') }}</p>
                        <Multiselect id="kay" class="mt-2.5 mb-3" v-model="post.label" :rtl="true"
                                     :placeholder="$t('insert-kaywords')" :noOptionsText="$t('empty')"
                                     mode="tags" :searchable="true"
                                     :options="post.language=='en'?labels.en : labels.fa"/>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {defineAsyncComponent} from "vue";
import Multiselect from '@vueform/multiselect'

export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
        QuillEditor,
        Multiselect
    },
    data() {
        return {
            error: false,
            show: true,
            post: {
                title: '',
                slug: '',
                language: '',
                status: 'draft',
                image: '',
                category: [],
                label: [],
                body: '',
                seoDescription: '',
                seoKayword: [],
            },
            multiOption: {
                mode: 'tags',
                closeOnSelect: false,
                searchable: true,
                createOption: true
            },
            categories: [],
            subCategories: [],
            labels: {
                en: [],
                fa: []
            },
        }
    },
    methods: {
        onChangeImage() {
            this.post.image = this.$refs["image"].files[0];
            console.log(this.post.image.name)
        },
        updatePost() {
            if (this.post.title != '' && this.post.slug != '') {
                this.$emit('loading');
                this.error = false;
                this.post.body = this.$refs.myEditor.getHTML()
                let formData = new FormData();
                formData.append('api_token', this.$cookies.get('user').token);
                formData.append('id', this.post.id);
                formData.append('title', this.post.title);
                formData.append('slug', this.post.slug);
                formData.append('language', this.post.language);
                formData.append('status', this.post.status);
                formData.append('images', this.post.image);
                formData.append('categories', this.post.category);
                formData.append('labels', this.post.label);
                formData.append('body', this.post.body);
                formData.append('seo_description', this.post.seoDescription);
                formData.append('seo_kaywords', this.post.seoKayword);
                axios.post('/post/update',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((res) => {
                    if (res.data.status == 200) {
                        this.$router.push({name: 'adminPosts'})
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
        axios.get('/category',
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            for (const res of response.data.cat) {
                this.categories.push({
                    id: res.id,
                    slug: res.slug,
                    titleFa: res.titleFa,
                    titleEn: res.titleEn,
                    descriptionFa: res.descriptionFa,
                    descriptionEn: res.descriptionEn,
                    child: []
                });
            }
            for (const res of response.data.subCat) {
                this.subCategories.push({
                    id: res.id,
                    parentId: res.parentId,
                    slug: res.slug,
                    titleFa: res.titleFa,
                    titleEn: res.titleEn,
                    descriptionFa: res.descriptionFa,
                    descriptionEn: res.descriptionEn,
                    child: []
                });
            }
        }).catch((error) => {
        });

        axios.get('/label',
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            for (const responseElement of response.data.data) {
                if (responseElement.lang == 'en') {
                    this.labels.en.push(responseElement.title);
                } else {
                    this.labels.fa.push(responseElement.title);
                }
            }
        }).catch((error) => {
        });

        axios.get('/post/' + this.$route.params.id,
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            this.post.id = response.data.id;
            this.post.title = response.data.title;
            this.post.slug = response.data.slug;
            this.post.language = response.data.language;
            this.post.status = response.data.status;
            if (response.data.images) {
                this.post.image = this.$hostname + 'upload/post/' + response.data.images;
            }
            this.post.category = response.data.categories;
            this.post.label = response.data.labels;
            this.$refs.myEditor.setHTML(response.data.body);
            this.post.seoDescription = response.data.seoDes;
            this.post.seoKayword = response.data.seoKay;
            this.$emit('loadingHide');
        }).catch((error) => {
            this.show = false
            this.$emit('loadingHide');
        });
    },
    name: 'App',
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('edit') + ' ' + this.$t('post') + ' | ' + this.$t('adminTitlePage');
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
