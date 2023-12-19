<template>
    <siteHeader :site="site" :user="user"></siteHeader>
    <div class="bg-white-secondary p-10 text-center">
        <h1 class="text-3xl font-bold text-dark-primary py-6 leading-[3rem]">
              <span class="relative inline-flex">
                  <span class="flex h-5 w-5 ">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500"></span>
                  </span>
            </span>
            {{ $t('global-prices-petroleum-products', language) }}
        </h1>
    </div>
    <div v-show="loginCheck()">
        <div id="scroll"
            class="text-white-primary text-center bg-dark-primary border border-b-0 border-slate-300 overflow-x-auto flex flex-row-reverse md:block px-2">
            <button v-for="table in tables" @click="tab=table.key"
                    class="mx-1 px-2 py-4 md:px-8 hover-meno whitespace-nowrap"
                    :class="tab==table.key?'n-active':''">
                <strong> {{ table.title }} </strong>
            </button>
        </div>
        <div class="px-2 md:px-4 overflow-x-scroll md:overflow-x-hidden">
            <div v-for="table in tables" v-show="tab==table.key" class="p-4 lg:w-2/3 lg:mx-auto">
                <div class="flex justify-center">
                 <span v-for="detail in table.detail"
                       class=" px-16 py-1 text-center mb-2 font-bold bg-slate-300 rounded-lg text-dark-primary">
                {{ detail }}
                 </span>
                </div>

                <table dir="ltr" id="table" class="global border-collapse w-full text-sm">
                    <thead class="text-dark-primary font-bold bg-slate-300">
                    <tr class="border">
                        <th v-for="head in table.header" class="border p-4" style="text-align: left !important;">
                            {{ head.title }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="data in table.data">
                        <td v-for="row in data.col" class="border p-2" style="text-align: left !important;">
                            {{ row.title }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div v-show="!loginCheck()" class="w-full md:w-3/4 mx-auto mt-4 rounded px-2">
        <div class="w-full md:w-1/2 px-2 mx-auto border-2 border-solid border-white-primary rounded-lg p-6 text-center">
            <p class="mb-4">
                {{ $t('view-membership', language) }}
            </p>
            <router-link :to="{name:'siteAccount'}" class="mx-1 bg-white-primary py-2 px-3 rounded-lg duration-300">
                {{ $t('login', language) }}
            </router-link>
            <router-link :to="{name:'siteSignup'}"
                         class="mx-1 bg-dark-primary text-white py-2 px-3 rounded-lg duration-300">
                {{ $t('signup', language) }}
            </router-link>
        </div>
    </div>

    <siteFooter :site="site"></siteFooter>
</template>

<script>
import {defineAsyncComponent} from "vue";
import axios from "axios";
import $ from "jquery"
import "datatables.net-bs4";
import '../../../../../public/css/datatables.min.css';

export default {
    data() {
        return {
            language: this.$route.params.lang,
            tables: [],
            tab: ''
        }
    },
    emits: ['getUser'],
    props: {
        site: Object,
        user: Object
    },
    components: {
        "siteHeader": defineAsyncComponent(() => import('./../layout/site-header.vue')),
        "siteFooter": defineAsyncComponent(() => import('./../layout/site-footer.vue'))
    },
    methods: {
        loginCheck() {
            if (this.$cookies.isKey('user')) {
                return true;
            } else {
                return false;
            }
        },
    },
    async beforeCreate() {
        if (this.$cookies.isKey('user')) {
            await axios.get('/table/all', {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'language': this.$route.params.lang,
                }
            }).then(response => {
                if (response.data) {
                    this.tables = [];
                    for (const responseElement of response.data) {
                        this.tables.push({
                            id: responseElement.id,
                            key: responseElement.key,
                            title: responseElement.title,
                            header: responseElement.header,
                            data: responseElement.data,
                            detail: responseElement.detail,
                        });
                        this.tab = responseElement.key
                    }
                }
            }).catch(error => {
                this.tables = [];
            });
            $('table.global').DataTable({
                "aaSorting": []
            });
        }
        if (this.$route.params.lang=='fa'){
            document.getElementById("scroll").scrollLeft = 500
        }

        document.title = this.$t('live-price', this.language) + " | " + this.site.title
    }
}
</script>
<style>
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: #495464 !important;
    border: 1px solid #cbd5e1;
    background-color: #111;
    background: #cbd5e1;
}

li.paginate_button.page-item.active {
    background: #e9e9e9;
}
</style>
<style scoped>
.n-active {
    border-bottom: 2px solid #ea1b1b;
    background: #ffffff1a;
}
</style>
