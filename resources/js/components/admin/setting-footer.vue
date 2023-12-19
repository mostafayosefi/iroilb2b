<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('setting') + ' ' + $t('footer')">

            <button v-show="user.role.settings.footer" class="btn btn-sm btn-success mx-1 font-bold" @click="updateFooter()">{{ $t('save') }}</button>
        </header-admin>

        <div v-show="!user.role.settings.footer"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.settings.footer" class="col-span-12 lg:col-span-4">
            <div class="intro-y pl-1">
                <div class="box p-2">
                    <div class="pos__tabs nav nav-tabs justify-center" role="tablist">
                        <a id="ticket-tab" data-toggle="tab" data-target="#footer1" href="javascript:;"
                           class="flex-1 py-2 rounded-md text-center active" role="tab" aria-controls="ticket"
                           aria-selected="true">
                            {{ $t('column-one') }}
                        </a>
                        <a id="details-tab" data-toggle="tab" data-target="#footer2" href="javascript:;"
                           class="flex-1 py-2 rounded-md text-center" role="tab" aria-controls="details"
                           aria-selected="false">
                            {{ $t('column-tow') }}
                        </a>
                        <a id="details-tab" data-toggle="tab" data-target="#footer3" href="javascript:;"
                           class="flex-1 py-2 rounded-md text-center" role="tab" aria-controls="details"
                           aria-selected="false">
                            {{ $t('column-three') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="tab-content intro-y">
                <div id="footer1" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                    <div class="box p-5 mt-5">
                        <label for="">{{ $t('title') + " " + $t('persian') }}</label>
                        <input type="text" class="form-control" v-model="footer.one.fa">
                        <label for="">{{ $t('title') + " " + $t('english') }}</label>
                        <input dir="ltr" type="text" class="form-control" v-model="footer.one.en">

                        <button class="btn btn-sm btn-dark font-bold mt-2" @click="add('one')">
                            {{ $t('add') + " " + $t('item') }}
                        </button>

                        <draggable
                            tag="ul"
                            :list="footer.one.lists"
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
                                        <i class="close cursor-pointer" @click="removeAt(index,'one')">
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
                                    <label class="mx-2 font-bold">{{ $t('persian-name') }}</label>
                                    <input type="text" class="form-control mb-2" v-model="element.text.fa"/>
                                    <br>
                                    <label class="mx-2 font-bold">{{ $t('english-name') }}</label>
                                    <input dir="ltr" type="text" class="form-control mb-2" v-model="element.text.en"/>
                                    <br>
                                    <label class="mx-2 font-bold">{{ $t('link') }}</label>
                                    <input dir="ltr" type="text" class="form-control" v-model="element.link"/>
                                </li>
                            </template>
                        </draggable>
                    </div>
                </div>
                <div id="footer2" class="tab-pane" role="tabpanel" aria-labelledby="details-tab">
                    <div class="box p-5 mt-5">
                        <label for="">{{ $t('title') + " " + $t('persian') }}</label>
                        <input type="text" class="form-control" v-model="footer.tow.fa">
                        <label for="">{{ $t('title') + " " + $t('english') }}</label>
                        <input dir="ltr" type="text" class="form-control" v-model="footer.tow.en">

                        <button class="btn btn-sm btn-dark font-bold mt-2" @click="add('tow')">
                            {{ $t('add') + " " + $t('item') }}
                        </button>

                        <draggable
                            tag="ul"
                            :list="footer.tow.lists"
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
                                        <i class="close cursor-pointer" @click="removeAt(index,'tow')">
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
                                    <label class="mx-2 font-bold">{{ $t('persian-name') }}</label>
                                    <input type="text" class="form-control mb-2" v-model="element.text.fa"/>
                                    <br>
                                    <label class="mx-2 font-bold">{{ $t('english-name') }}</label>
                                    <input dir="ltr" type="text" class="form-control mb-2" v-model="element.text.en"/>
                                    <br>
                                    <label class="mx-2 font-bold">{{ $t('link') }}</label>
                                    <input dir="ltr" type="text" class="form-control" v-model="element.link"/>
                                </li>
                            </template>
                        </draggable>
                    </div>
                </div>
                <div id="footer3" class="tab-pane" role="tabpanel" aria-labelledby="details-tab">
                    <div class="box p-5 mt-5">
                        <label for="">{{ $t('title') + " " + $t('persian') }}</label>
                        <input type="text" class="form-control" v-model="footer.three.fa">
                        <label for="">{{ $t('title') + " " + $t('english') }}</label>
                        <input dir="ltr" type="text" class="form-control" v-model="footer.three.en">

                        <button class="btn btn-sm btn-dark font-bold mt-2" @click="add('three')">
                            {{ $t('add') + " " + $t('item') }}
                        </button>

                        <draggable
                            tag="ul"
                            :list="footer.three.lists"
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
                                        <i class="close cursor-pointer" @click="removeAt(index,'three')">
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
                                    <label class="mx-2 font-bold">{{ $t('persian-name') }}</label>
                                    <input type="text" class="form-control mb-2" v-model="element.text.fa"/>
                                    <br>
                                    <label class="mx-2 font-bold">{{ $t('english-name') }}</label>
                                    <input dir="ltr" type="text" class="form-control mb-2" v-model="element.text.en"/>
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
    </div>

</template>
<script>
import headerAdmin from './../layout/header-admin.vue'
import axios from "axios";
import draggable from 'vuedraggable'

let i = 0;
let j = 0;
let k = 0;
export default {
    props: {
        user: Object
    },
    components: {
        "header-admin": headerAdmin,
        draggable,
    },
    data() {
        return {
            footer: {
                one: {
                    fa: "",
                    en: "",
                    lists: [],
                },
                tow: {
                    fa: "",
                    en: "",
                    lists: [],
                },
                three: {
                    fa: "",
                    en: "",
                    lists: [],
                }
            },
            dragging: false,
        }
    }, computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        }
    }, methods: {
        removeAt(idx, footer) {
            if (footer == 'one') {
                this.footer.one.lists.splice(idx, 1);
            }
            if (footer == 'tow') {
                this.footer.tow.lists.splice(idx, 1);
            }
            if (footer == 'three') {
                this.footer.thre.lists.splice(idx, 1);
            }

        },
        add: function (footer) {
            if (footer == 'one') {
                i++;
                this.footer.one.lists.push({
                    text: {
                        fa: '',
                        en: ''
                    },
                    link: '',
                    id: i
                },);
            }
            if (footer == 'tow') {
                j++;
                this.footer.tow.lists.push({
                    text: {
                        fa: '',
                        en: ''
                    },
                    link: '',
                    id: j
                },);
            }
            if (footer == 'three') {
                k++;
                this.footer.three.lists.push({
                    text: {
                        fa: '',
                        en: ''
                    },
                    link: '',
                    id: k
                },);
            }
        },
        updateFooter() {
            this.$emit('loading');
            const sentData = {
                'api_token': this.$cookies.get('user').token,
                'footer': this.footer
            };
            axios.put("/footer/update/", sentData).then((response) => {
                if (response.data == 'successfully updated') {
                    this.$emit('loadingHide');
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    }, created() {
        axios.get('/meno').then(response => {
            if (response.data != 'null') {
                this.footer.one.fa = response.data.footer.one.fa
                this.footer.one.en = response.data.footer.one.en
                this.footer.tow.fa = response.data.footer.tow.fa
                this.footer.tow.en = response.data.footer.tow.en
                this.footer.three.fa = response.data.footer.three.fa
                this.footer.three.en = response.data.footer.three.en
                for (const responseElement of response.data.footer.one.lists) {
                    this.footer.one.lists.push({
                        text: {
                            fa: responseElement.text.fa,
                            en: responseElement.text.en
                        },
                        link: responseElement.link,
                        id: responseElement.id
                    },);
                    i++;
                }
                for (const responseElement of response.data.footer.tow.lists) {
                    this.footer.tow.lists.push({
                        text: {
                            fa: responseElement.text.fa,
                            en: responseElement.text.en
                        },
                        link: responseElement.link,
                        id: responseElement.id
                    },);
                    j++;
                }
                for (const responseElement of response.data.footer.three.lists) {
                    this.footer.three.lists.push({
                        text: {
                            fa: responseElement.text.fa,
                            en: responseElement.text.en
                        },
                        link: responseElement.link,
                        id: responseElement.id
                    },);
                    k++;
                }
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
                document.title = this.$t('setting') + ' ' + this.$t('footer') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
