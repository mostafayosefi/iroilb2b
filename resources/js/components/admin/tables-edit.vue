<template>
    <div class="content ">
        <!-- header -->
        <header-admin :user="user"
                      :title="$t('edit-table')">
            <button v-show="user.role.table.edit" type="button" @click="addHeader()"
                    class="btn btn-sm font-bold btn-success ml-2">
                {{ $t('add-header') }}
            </button>
            <button v-show="user.role.table.edit" type="button" @click="addRow()"
                    class="btn btn-sm font-bold btn-success ml-2">
                {{ $t('add-data') }}
            </button>
            <button v-show="user.role.table.edit" type="button" @click="updateTable()"
                    class="btn btn-sm font-bold btn-dark ml-2">
                {{ $t('edit') }}
            </button>
        </header-admin>
        <div v-show="!user.role.table.edit"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.table.edit" class="box intro-y p-4">
            <div v-show="error"
                 class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 mb-2"
                 role="alert">
                <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
                {{ $t('error-empty-fields') }}
            </div>
            <input dir="rtl" type="text"
                   class="form-control" :class="error && table.title=='' ? 'alert-outline-danger':''"
                   :placeholder="$t('title' )"
                   v-model="table.title">
            <input dir="ltr" type="text"
                   class="form-control mt-2" :placeholder="$t('description')"
                   v-model="table.detail.description">
            <select id="lang" class="form-control mt-2" v-model="table.language">
                <option value="all">{{ $t('all') }}</option>
                <option value="fa">{{ $t('persian') }}</option>
                <option value="en">{{ $t('english') }}</option>
            </select>
            <div dir="ltr">
                <table class="mt-2">
                    <thead class="float-left">
                    <tr class="inline">
                        <th v-for="(item,index) in header">
                            <input type="text" v-model="item.title"
                                   class="border-2 p-2 rounded border-solid border-theme-15 font-bold">
                            <button class="btn btn-danger mx-1"
                                    @click="removeHeader(index)">
                                -
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <draggable
                        tag="ul"
                        :list="data"
                        class="list-group"
                        handle=".handle"
                        item-key="name">
                        <template #item="{ element, index }">
                            <li class="bg-white py-2 rounded">
                                <tr class="flex align-items-center">
                                    <div v-for="row in element" class="inline">
                                        <td v-for="(value,id ) in row">
                                            <input type="text" v-model="value.title" class="border p-2 rounded">
                                            <button class="btn btn-danger mx-1"
                                                    @click="removeCol(index , id)">
                                                -
                                            </button>
                                        </td>

                                    </div>
                                    <button class="btn btn-success mx-1"
                                            @click="addCol(index)">
                                        +
                                    </button>
                                    <button class="btn btn-dark mx-1"
                                            @click="removeRow(index)">
                                        -
                                    </button>
                                    <button class="btn handle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="feather feather-align-justify block mx-auto">
                                            <line x1="21" y1="10" x2="3" y2="10"></line>
                                            <line x1="21" y1="6" x2="3" y2="6"></line>
                                            <line x1="21" y1="14" x2="3" y2="14"></line>
                                            <line x1="21" y1="18" x2="3" y2="18"></line>
                                        </svg>
                                    </button>
                                </tr>
                            </li>
                        </template>
                    </draggable>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>
<script>
import axios from 'axios'
import {defineAsyncComponent} from "vue";
import draggable from 'vuedraggable'

var i = 0;
var j = 0;
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
            loading: true,
            header: [],
            data: [],
            dragging: false,
            table: {
                id: '',
                title: '',
                language: '',
                detail: {
                    description: ''
                },
            },
            error: false,
        }
    },
    methods: {
        addHeader() {
            this.header.push({
                id: i,
                title: ''
            });
            i++;
        },
        addRow() {
            this.data.push({
                col: []
            });
        },
        addCol(index) {
            this.data[index].col.push({
                id: j,
                title: ''
            })
            j++;
        },
        removeRow(id) {
            this.data = this.data.filter((item, index, arr) => index !== id);
        },
        removeCol(index, id) {
            this.data[index].col = this.data[index].col.filter((item, index, arr) => index !== id);
        },
        removeHeader(id) {
            this.header = this.header.filter((item, index, arr) => index !== id);
        },
        updateTable() {
            if (this.table.title != '' && this.table.key != '') {
                if (confirm(this.$t('update-message'))) {
                    this.$emit('loading');
                    this.error = false;
                    const sentData = {
                        api_token: this.$cookies.get('user').token,
                        title: this.table.title,
                        language: this.table.language,
                        header: this.header,
                        detail: this.table.detail,
                        data: this.data
                    }
                    axios.put("/table/update/" + this.$route.params.id, sentData).then((response) => {
                        if (response.data == 'success') {
                            this.table.title = '';
                            this.table.language = '';
                            this.header = [];
                            this.data = [];
                            this.table.detail.description = '';
                            i = 0;
                            j = 0;
                        }
                        this.$emit('loadingHide');
                    }).catch(() => {
                        this.$emit('loadingHide');
                    });
                }
            } else {
                this.error = true
            }
        },
    },
    computed: {
        draggingInfo() {
            return this.dragging ? "under drag" : "";
        }
    },
    beforeCreate() {
        axios.get('/table/id/' + this.$route.params.id, {
            params: {
                'api_token': this.$cookies.get('user').token
            }
        }).then(response => {
            this.table.id = response.data.id
            this.table.title = response.data.title
            this.table.language = response.data.language
            this.table.detail.description = response.data.detail.description;
            for (const responseElement of response.data.header) {
                this.header.push({
                    id: responseElement.id,
                    title: responseElement.title,
                });
                i = responseElement.id + 1;
            }
            var index = 0;
            for (const responseElement of response.data.data) {
                this.data.push({
                    col: []
                });
                for (const res of responseElement.col) {
                    this.data[index].col.push({
                        id: res.id,
                        title: res.title,
                    })
                    j = responseElement.id + 1;
                }
                index++;
            }
            this.$emit('loadingHide');
        }).catch(() => {
            this.$emit('loadingHide');
        });
    },
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = this.$t('tables') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
<style scoped>
td {
    border: 0 !important;
}
</style>

