<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('setting') + ' ' + $t('header')">
            <button v-show="user.role.settings.header" class="btn btn-sm btn-dark font-bold" @click="add">{{ $t('add') }}</button>
            <button v-show="user.role.settings.header" class="btn btn-sm btn-primary mx-1 font-bold" @click="updateMeno()">{{ $t('save') }}</button>
        </header-admin>
        <div v-show="!user.role.settings.header"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.settings.header">
            <draggable
                tag="ul"
                :list="list"
                class="list-group"
                handle=".handle"
                item-key="name">
                <template #item="{ element, index }">
                    <li class="bg-white mt-1 p-3 rounded">
                        <i class="cursor-pointer handle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-align-justify block mx-auto">
                                <line x1="21" y1="10" x2="3" y2="10"></line>
                                <line x1="21" y1="6" x2="3" y2="6"></line>
                                <line x1="21" y1="14" x2="3" y2="14"></line>
                                <line x1="21" y1="18" x2="3" y2="18"></line>
                            </svg>
                        </i>
                        <i class="close cursor-pointer" @click="removeAt(index)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-x block mx-auto">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </i>

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
</template>
<script>
let id = 1;
import headerAdmin from './../layout/header-admin.vue'
import axios from "axios";
import draggable from 'vuedraggable'

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
            dragging: false,
            list: [],
        }
    }, computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        }
    },
    methods: {
        removeAt(idx) {
            this.list.splice(idx, 1);
        },
        add: function () {
            id++;
            this.list.push({
                text: {
                    fa: '',
                    en: ''
                },
                link: '',
                id
            },);
        },
        updateMeno() {
            this.$emit('loading');
            const sentData = {
                'api_token': this.$cookies.get('user').token,
                'meno': this.list
            };
            axios.put("/meno/update/", sentData).then((response) => {
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
                for (const responseElement of response.data.meno) {
                    this.list.push({
                        text: {
                            fa: responseElement.text.fa,
                            en: responseElement.text.en
                        },
                        link: responseElement.link,
                        id: responseElement.id
                    },);
                    id++;
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
                document.title = this.$t('setting') + ' ' + this.$t('header') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
<style scoped>

.handle {
    float: left;
    padding-top: 8px;
    padding-bottom: 8px;
}

.close {
    float: right;
    padding-top: 8px;
    padding-bottom: 8px;
}

input {
    display: inline-block;
    width: 50%;
}

</style>
