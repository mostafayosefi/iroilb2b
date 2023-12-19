<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('posts')" :element="user.role.post.add"
                      :elementText="$t('add')" :linkElement="true" :link="'adminNewPosts'"></header-admin>
        <div v-show="!user.role.post.show"
             class="alert alert-outline-danger alert-dismissible show flex items-center col-span-12 bg-white mt-2 font-bold"
             role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 ml-2"></i>
            {{ $t('access-message') }}
        </div>
        <div v-show="user.role.post.show" class="box intro-y">
            <!--data table -->
            <vue-good-table
                class="p-2"
                :columns="columns"
                :rows="posts"
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
                    <div v-if="props.column.field == 'cat'">
                         <span class="py-1 px-2 mx-1 rounded-full text-xs bg-dark text-white"
                               v-for="cat in props.row.categories">
                             {{ " " + cat + " " }}
                         </span>

                    </div>
                    <div v-if="props.column.field == 'info'">
                        <span
                            class="py-1 px-2 mx-1 rounded-full text-xs bg-theme-20 text-white">{{
                                props.row.time
                            }}</span>
                        <span class="py-1 px-2 rounded-full text-xs font-medium"
                              v-text="props.row.status=='draft'?$t('draft'):$t('publish')"
                              :class="props.row.status=='draft'?'bg-theme-15 text-dark':'bg-theme-11 text-white'"></span>
                    </div>
                    <span v-if="props.column.field == 'after'">
                         <a target="_blank" class="btn btn-sm btn-outline-primary m-1"
                            :href="$hostname + props.row.language +'/post/' + props.row.slug ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                               stroke-linejoin="round" class="feather feather-eye block w-4 h-4"><path
                              d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12"
                                                                                              r="3"></circle></svg>
                        </a>
                       <a v-show="user.role.post.edit" target="_blank" class="btn btn-sm btn-outline-dark m-1"
                          :href="$hostname + 'fa/admin/posts/edit/' + props.row.id ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-edit w-4 h-4"><path
                                d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path
                                d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <button v-show="user.role.post.delete" @click.prevent="deletePost(props.row.id)"
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
</template>
<script>
import axios from "axios";
import {defineAsyncComponent} from "vue";
import 'vue-good-table-next/dist/vue-good-table-next.css'
import {VueGoodTable} from 'vue-good-table-next';

export default {
    props: {
        user:Object
    },
    components: {
        "header-admin": defineAsyncComponent(() => import('./../layout/header-admin.vue')),
    },
    data() {
        return {
            posts: [],
            columns: [
                {
                    label: this.$t('title'),
                    field: 'title',
                },
                {
                    label: this.$t('category'),
                    field: 'cat',
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
        }
    },
    methods: {
        deletePost(id) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/post/delete/' + id, {
                    params: {
                        'api_token': this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data == 'successfully deleted') {
                        this.posts = this.posts.filter(item => item.id != id);
                        this.$emit('loadingHide');
                    }
                }).catch(() => {
                    this.$emit('loadingHide');
                });
            }
        },
    },
    created() {
        axios.get('/post',
            {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
            if (response.data != 'null') {
                for (const responseElement of response.data) {
                    this.posts.push({
                        id: responseElement.id,
                        title: responseElement.title,
                        slug: responseElement.slug,
                        language: responseElement.language,
                        status: responseElement.status,
                        time: responseElement.time,
                        categories: responseElement.categories
                    });
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
                document.title = this.$t('posts') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
