<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user" :title="$t('management') + ' ' +$t('company')">
            <button v-show="user.role.company.edit" type="button" @click="submit()"
                    class="btn btn-sm font-bold btn-success w-20 ml-2">
                <div v-show="!load">{{ $t('edit') }}</div>
                <div v-show="load">
                    . . .
                </div>
            </button>
        </header-admin>
        <div v-show="!user.role.company.edit"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.company.edit" class="box intro-y">
            <div class="p-2">
                <div class="input-group intro-y mb-2" :class="error?'border-2 border-theme-21 rounded':''">
                    <input dir="ltr" id="slug" type="text"
                           class="form-control text-left"
                           :placeholder="$t('company-slug' )"
                           v-model="company.data.slug">
                    <div id="input-group-price" class="input-group-text pb-0" dir="ltr">
                        {{ $hostname + "{language}/co/" }}
                    </div>
                </div>

                <label for="status">{{ $t('status') }}</label>
                <select id="status" v-model="company.data.status"
                        class="form-control mb-2">
                    <option value="draft">
                        {{ $t('check') }}
                    </option>
                    <option value="timeout">
                        {{ $t('timeout') }}
                    </option>
                    <option value="reject">
                        {{ $t('reject') }}
                    </option>
                    <option value="active">
                        {{ $t('active') }}
                    </option>
                </select>
                <label for="modal">{{ $t('modal') }}</label>
                <select id="modal" v-model="company.data.verified"
                        class="form-control">
                    <option value="normal">
                        {{ $t('normal') }}
                    </option>
                    <option value="verified">
                        {{ $t('verified') }}
                    </option>
                </select>
                <div class="mt-4">
                    <label for="local">{{ $t('sup-activity') }}</label>
                    <div class="mt-2 mb-4">
                        <Multiselect id="filter" v-model="company.data.filter"
                                     :placeholder="'...'"
                                     :rtl="true"
                                     :noOptionsText="$t('empty')"
                                     mode="tags" :searchable="true"
                                     :options="filters"/>
                    </div>
                    <div class="my-4">
                        <Multiselect id="tags" class="mt-2 mb-3" v-model="company.data.tag"
                                     :placeholder="$t('products')"
                                     :noOptionsText="$t('empty')"
                                     :rtl="true"
                                     mode="tags" :searchable="true"
                                     :options="tags"/>
                    </div>
                </div>
                <div class="mt-2">
                    <a class="btn mx-1" v-show="company.data.logo!=null"
                       :href="$hostname + 'upload/company/logo/'+company.data.logo">{{ $t('logo') }}</a>
                    <a class="btn " v-show="company.data.documentOne!=null"
                       :href="$hostname + 'upload/company/doc/'+company.data.documentOne">{{ $t('document') }}</a>
                    <a class="btn mx-1" v-show="company.data.documentTow!=null"
                       :href="$hostname + 'upload/company/doc/'+company.data.documentTow">{{ $t('document') }}</a>
                    <a class="btn mx-1" v-show="company.data.documentThree!=null"
                       :href="$hostname + 'upload/company/doc/'+company.data.documentThree">{{ $t('document') }}</a>
                </div>

                <div class="mt-2">
                    {{ $t('users') }}:
                    <span>{{ company.data.users }}</span>
                </div>

            </div>
            <div class="post intro-y overflow-hidden box mt-2 p-2">
                <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                     role="tablist">
                    <a :title="$t('persian')" data-toggle="tab" data-target="#content" href="javascript:;"
                       class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center active"
                       id="content-tab" role="tab">
                        <i class="fi fi-ir ml-2"></i>
                        {{ $t('persian') }}
                    </a>
                    <a :title="$t('english')" data-toggle="tab" data-target="#meta-title" href="javascript:;"
                       class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center"
                       id="meta-title-tab" role="tab">
                        <i class="fi fi-us ml-2"></i>
                        {{ $t('english') }}
                    </a>
                </div>
                <div class="post__content tab-content">
                    <div id="content" class="tab-pane p-5 active" role="tabpanel">
                        <form>
                            <textarea v-model="company.fa.seo" maxlength="320"
                                      class="form-control"
                                      :placeholder="$t('seo')"></textarea>
                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('base-data') }}</legend>
                                <input v-model="company.fa.name" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('company-name')">
                                <textarea v-model="company.fa.description"
                                          class="form-control mb-4"
                                          :placeholder="$t('intro-company')"></textarea>
                                <label for="local">{{ $t('local-work') }}</label>
                                <select id="local" v-model="company.fa.local"
                                        class="form-control">
                                    <option v-for="data in countries" :value="data.name">
                                        {{ data.fa }}
                                    </option>
                                </select>
                            </fieldset>
                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('contact-data') }}</legend>
                                <input v-model="company.fa.tell" type="tel"
                                       class="form-control mb-4"
                                       :placeholder="$t('tell')" dir="ltr">
                                <input v-model="company.fa.instagram" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('instagram-id')" dir="ltr">
                                <input v-model="company.fa.facebook" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('facebook-id')" dir="ltr">
                                <input v-model="company.fa.linkedin" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('linkedin-id')" dir="ltr">
                                <textarea v-model="company.fa.adress"
                                          class="form-control"
                                          :placeholder="$t('adress')"></textarea>
                            </fieldset>
                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('ceo',) }}</legend>
                                <input v-model="company.fa.ceo.name" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('name')">
                                <input v-model="company.fa.ceo.phone" type="tel"
                                       class="form-control mb-4"
                                       :placeholder="$t('phone')" dir="ltr">
                                <input v-model="company.fa.ceo.email" type="email"
                                       class="form-control"
                                       :placeholder="$t('email')" dir="ltr">
                            </fieldset>

                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('manager',) }}</legend>
                                <input v-model="company.fa.manager.name" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('name')">
                                <input v-model="company.fa.manager.phone" type="tel"
                                       class="form-control mb-4"
                                       :placeholder="$t('phone')" dir="ltr">
                                <input v-model="company.fa.manager.email" type="email"
                                       class="form-control"
                                       :placeholder="$t('email')" dir="ltr">
                            </fieldset>
                        </form>
                    </div>

                    <div id="meta-title" role="tabpanel" class="tab-pane p-5">
                        <form>
                            <textarea dir="ltr" v-model="company.en.seo" maxlength="320"
                                      class="form-control"
                                      :placeholder="$t('seo')"></textarea>
                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('base-data') }}</legend>
                                <input dir="ltr" v-model="company.en.name" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('company-name')">
                                <textarea dir="ltr" v-model="company.en.description"
                                          class="form-control mb-4"
                                          :placeholder="$t('intro-company')"></textarea>
                                <label for="localen">{{ $t('local-work') }}</label>
                                <select dir="ltr" id="localen" v-model="company.en.local"
                                        class="form-control">
                                    <option v-for="data in countries" :value="data.name">
                                        {{ data.name }}
                                    </option>
                                </select>
                            </fieldset>
                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('contact-data') }}</legend>
                                <input v-model="company.en.tell" type="tel"
                                       class="form-control mb-4"
                                       :placeholder="$t('tell')" dir="ltr">
                                <input v-model="company.en.instagram" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('instagram-id')" dir="ltr">
                                <input v-model="company.en.facebook" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('facebook-id')" dir="ltr">
                                <input v-model="company.en.linkedin" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('linkedin-id')" dir="ltr">
                                <textarea dir="ltr" v-model="company.en.adress"
                                          class="form-control"
                                          :placeholder="$t('adress')"></textarea>
                            </fieldset>
                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('ceo',) }}</legend>
                                <input dir="ltr" v-model="company.en.ceo.name" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('name')">
                                <input v-model="company.en.ceo.phone" type="tel"
                                       class="form-control mb-4"
                                       :placeholder="$t('phone')" dir="ltr">
                                <input v-model="company.en.ceo.email" type="email"
                                       class="form-control"
                                       :placeholder="$t('email')" dir="ltr">
                            </fieldset>

                            <fieldset class="border p-3 rounded mb-2">
                                <legend class="mx-2 px-2">{{ $t('manager',) }}</legend>
                                <input dir="ltr" v-model="company.en.manager.name" type="text"
                                       class="form-control mb-4"
                                       :placeholder="$t('name')">
                                <input v-model="company.en.manager.phone" type="tel"
                                       class="form-control mb-4"
                                       :placeholder="$t('phone')" dir="ltr">
                                <input v-model="company.en.manager.email" type="email"
                                       class="form-control"
                                       :placeholder="$t('email')" dir="ltr">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";
import axios from 'axios'
import {defineAsyncComponent} from "vue";
import countries from './../../../../public/js/countries.json'
import Multiselect from "@vueform/multiselect";

export default {
    emits: ['loadingHide', 'loading'],
    props: {
        loading: Boolean,
        user: Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
        Multiselect,
    },
    data() {
        return {
            load: false,
            error: false,
            countries: countries,
            company: {
                fa: {
                    name: '',
                    tell: '',
                    instagram: '',
                    facebook: '',
                    linkedin: '',
                    local: 'ایران',
                    adress: '',
                    description: '',
                    ceo: {
                        name: '',
                        phone: '',
                        email: '',
                    },
                    manager: {
                        name: '',
                        phone: '',
                        email: '',
                    },
                    seo: '',
                },
                en: {
                    name: '',
                    tell: '',
                    instagram: '',
                    facebook: '',
                    linkedin: '',
                    local: 'دولة الإمارات العربية المتحدة',
                    adress: '',
                    description: '',
                    ceo: {
                        name: '',
                        phone: '',
                        email: '',
                    },
                    manager: {
                        name: '',
                        phone: '',
                        email: '',
                    },
                    seo: '',
                },
                data: {
                    id: '',
                    logo: '',
                    documentOne: '',
                    documentTow: '',
                    documentThree: '',
                    tag: [],
                    filter: [],
                    users: '',
                    slug: '',
                    verified: '',
                    status: '',
                }
            },
            tags: [],
            filters: [],
        }
    },
    methods: {
        submit() {
            if (this.company.data.slug != '') {
                this.load = true;
                this.error = false;
                let formData = new FormData();
                formData.append('id', this.$cookies.get('user').id);
                formData.append('api_token', this.$cookies.get('user').token);
                formData.append('body_fa', JSON.stringify(this.company.fa));
                formData.append('body_en', JSON.stringify(this.company.en));
                formData.append('filters', JSON.stringify(this.company.data.filter));
                formData.append('tags', JSON.stringify(this.company.data.tag));
                formData.append('slug', this.company.data.slug);
                formData.append('status', this.company.data.status);
                formData.append('verified', this.company.data.verified);
                axios.post('/company/update/admin/' + this.company.data.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    this.load = false;
                    this.$emit('loadingHide');
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            } else {
                this.error = true;
            }

        }
    },
    beforeCreate() {
        axios.get('/product', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data.data) {
                this.tags.push(responseElement.name_fa);
            }
        }).catch(() => {
        });
        axios.get('/filter', {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            for (const responseElement of response.data.data) {
                this.filters.push(responseElement.name_fa);

            }
        }).catch(() => {
        });
        axios.get('/company/get/' + this.$route.params.co, {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            this.company.data.id = response.data.id;
            this.company.data.users = response.data.users;
            this.company.data.slug = response.data.slug;
            this.company.data.status = response.data.status;
            for (const res of response.data.tag) {
                this.company.data.tag.push(res);
            }
            for (const res of response.data.filter) {
                this.company.data.filter.push(res);
            }
            this.company.data.verified = response.data.verified;
            this.company.data.logo = response.data.logo;
            this.company.data.documentOne = response.data.documentOne;
            this.company.data.documentTow = response.data.documentTow;
            this.company.data.documentThree = response.data.documentThree;
            this.company.fa.name = response.data.bodyFa.name
            this.company.fa.seo = response.data.bodyFa.seo
            this.company.fa.tell = response.data.bodyFa.tell
            this.company.fa.instagram = response.data.bodyFa.instagram
            this.company.fa.facebook = response.data.bodyFa.facebook
            this.company.fa.linkedin = response.data.bodyFa.linkedin
            this.company.fa.local = response.data.bodyFa.local
            this.company.fa.adress = response.data.bodyFa.adress
            this.company.fa.description = response.data.bodyFa.description
            this.company.fa.ceo.name = response.data.bodyFa.ceo.name
            this.company.fa.ceo.phone = response.data.bodyFa.ceo.phone
            this.company.fa.ceo.email = response.data.bodyFa.ceo.email
            this.company.fa.manager.name = response.data.bodyFa.manager.name
            this.company.fa.manager.phone = response.data.bodyFa.manager.phone
            this.company.fa.manager.email = response.data.bodyFa.manager.email
            this.company.en.name = response.data.bodyEn.name
            this.company.en.seo = response.data.bodyEn.seo
            this.company.en.tell = response.data.bodyEn.tell
            this.company.en.instagram = response.data.bodyEn.instagram
            this.company.en.facebook = response.data.bodyEn.facebook
            this.company.en.linkedin = response.data.bodyEn.linkedin
            this.company.en.local = response.data.bodyEn.local
            this.company.en.adress = response.data.bodyEn.adress
            this.company.en.description = response.data.bodyEn.description
            this.company.en.ceo.name = response.data.bodyEn.ceo.name
            this.company.en.ceo.phone = response.data.bodyEn.ceo.phone
            this.company.en.ceo.email = response.data.bodyEn.ceo.email
            this.company.en.manager.name = response.data.bodyEn.manager.name
            this.company.en.manager.phone = response.data.bodyEn.manager.phone
            this.company.en.manager.email = response.data.bodyEn.manager.email
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
                document.title = this.$t('management') + " " + this.$t('company') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>

