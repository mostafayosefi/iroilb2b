<template>
    <div class="content ">
        <header-admin :user="user" :title="$t('setting') + ' ' + $t('side-bar')">
            <button v-show="user.role.settings.site" type="button" @click="changeSetting()"
                    class="btn btn-sm font-bold btn-success w-20 ml-2">
                <div v-show="!load">{{ $t('edit') }}</div>
                <div v-show="load">
                    . . .
                </div>
            </button>
        </header-admin>
        <div>
            <div class="col-span-12 mt-3 flex justify-between p-3 items-center">
                <div v-show="sideBar.image!=''" class="bg-gray-300 rounded p-2 ">
                    <img :src="sideBar.image">
                    <button @click="deleteImage()"
                            class="text-blue-500 font-bold w-full mt-3 btn btn-outline-dark">
                        {{ $t('delete') + " " + $t('image') }}
                    </button>
                </div>
                <div class="col-span-4">
                    <input id="logo-light" type="file" class="form-control"
                           ref="logo-light" @change="onChangeLogoLight">
                </div>
            </div>
            <input @keyup.enter="" type="text" dir="ltr"
                   class="form-control text-left"
                   :placeholder="$t('site-title','en')"
                   v-model="sideBar.link">

            <button class="btn btn-sm btn-dark font-bold mb-2 mt-2" @click="add">{{
                    $t('add') + " " + $t('fix-meno')
                }}
            </button>
            <draggable
                tag="ul"
                :list="list"
                class="list-group"
                handle=".handle"
                item-key="name">
                <template #item="{ element, index }">
                    <li class="bg-white mt-1 p-3 rounded mx-1">
                        <div class="flex content-between">
                            <i class="cursor-pointer handle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"
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
                            <option value="telegram">{{ $t('telegram') }}</option>
                            <option value="whatsapp">{{ $t('whatsapp') }}</option>
                            <option value="facebook">{{ $t('facebook') }}</option>
                            <option value="linkedin">{{ $t('linkedin') }}</option>
                            <option value="twitter">{{ $t('twitter') }}</option>
                            <option value="instagram">{{ $t('instagram') }}</option>
                            <option value="aparat">{{ $t('aparat') }}</option>
                        </select>
                        <br>
                        <label class="mx-2 font-bold">{{ $t('color') }}</label>
                        <input type="color" class="form-control mb-2" style="height: 50px;" v-model="element.color"/>
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
import "/node_modules/flag-icons/css/flag-icons.min.css";
import axios from "axios";
import {defineAsyncComponent} from "vue";
import draggable from 'vuedraggable'

let id = 0;
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
            load:false,
            sideBar: {
                id: 3,
                image:'',
                link:'',
                data: []
            },
            dragging: false,
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
                icon: 'telegram',
                color: '',
                link: '',
                id
            },);
        },
        onChangeLogoLight() {
            this.logoLight = this.$refs["logo-light"].files[0];
        },
        onChangeLogoDark() {
            this.logoDark = this.$refs["logo-dark"].files[0];
        },
        onChangeFavIcon() {
            this.favIcon = this.$refs["fav-icon"].files[0];
        },
        changeSetting() {
            this.load = true;
            let formData = new FormData();
            formData.append('api_token', this.$cookies.get('user').token);
            formData.append('title-fa', this.siteSetting.siteTitleFa);
            formData.append('title-en', this.siteSetting.siteTitleEn);
            formData.append('logo-light', this.logoLight);
            formData.append('logo-dark', this.logoDark);
            formData.append('fav-icon', this.favIcon);
            formData.append('menu', JSON.stringify(this.list));
            axios.post('/sitesetting/update',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((res) => {
                if (res.data.status == 200) {
                    this.getData()
                    this.load = false;
                }
            }).catch(error => {
                this.load = false;
            });
        },
        getData() {
            axios.get('/sitesetting', {
                params: {
                    api_token: this.$cookies.get('user').token
                }
            }).then(response => {
                if (response.data.status == 204) {
                    this.errorLoadState = true;
                    this.errorLoadMessage = response.data.message
                } else {
                    this.siteSetting.siteTitleFa = response.data.data.titleFa;
                    this.siteSetting.siteTitleEn = response.data.data.titleEn;
                    this.siteSetting.logoLight = this.$hostname + 'upload/site/' + response.data.data.logoLight;
                    this.siteSetting.logoDark = this.$hostname + 'upload/site/' + response.data.data.logoDark;
                    this.siteSetting.favIcon = this.$hostname + 'upload/site/' + response.data.data.favIcon;
                    this.siteSetting.updateTime = response.data.time;
                    for (const responseElement of response.data.menu) {
                        this.list.push({
                            icon: responseElement.icon,
                            color: responseElement.color,
                            link: responseElement.link,
                        },);
                        id++;
                    }
                }
            }).catch((error) => {
            });
        },
        deleteLogo(item) {
            if (confirm(this.$t('delete-message'))) {
                this.$emit('loading');
                axios.delete('/sitesetting/delete/' + item, {
                    params: {
                        api_token: this.$cookies.get('user').token
                    }
                }).then(response => {
                    if (response.data.status == 204) {
                        this.errorLoadState = true;
                        this.errorLoadMessage = response.data.message
                    } else {
                        this.getData();
                    }
                    this.$emit('loadingHide');
                }).catch((error) => {
                });
            }
        }
    },
    beforeCreate() {
        axios.get('/sitesetting', {
            params: {
                api_token: this.$cookies.get('user').token
            }
        }).then(response => {
            if (response.data.status == 204) {
                this.errorLoadState = true;
                this.errorLoadMessage = response.data.message
            } else {
                this.siteSetting.siteTitleFa = response.data.data.titleFa;
                this.siteSetting.siteTitleEn = response.data.data.titleEn;
                this.siteSetting.logoLight = this.$hostname + 'upload/site/' + response.data.data.logoLight;
                this.siteSetting.logoDark = this.$hostname + 'upload/site/' + response.data.data.logoDark;
                this.siteSetting.favIcon = this.$hostname + 'upload/site/' + response.data.data.favIcon;
                this.siteSetting.updateTime = response.data.time;
                for (const responseElement of response.data.data.menu) {
                    this.list.push({
                        icon: responseElement.icon,
                        color: responseElement.color,
                        link: responseElement.link,
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
                document.title = this.$t('setting') + ' ' + this.$t('side-bar') + ' | ' + this.$t('adminTitlePage');
            }
        },
    },

}
</script>
