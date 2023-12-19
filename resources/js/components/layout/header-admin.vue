<template>
    <div class="top-bar -mx-4 px-4 md:mx-0 md:px-0">
        <div class="w-1/2 flex items-center	">
            <div class="mx-4"><h1 class="text-xl font-bold">{{ title }}</h1></div>
            <div v-if="element" class="flex justify-content-end">
                <a v-if="!linkElement" href="javascript:;" data-toggle="modal"
                   data-target="#header-footer-modal-preview"
                   class="btn btn-sm btn-dark font-bold">{{ elementText }}</a>
                <router-link v-if="linkElement" :to="{name:link}"
                             class="btn btn-sm btn-dark font-bold">
                    {{ elementText }}
                </router-link>
            </div>
            <slot></slot>

        </div>
        <div class="w-1/2 flex justify-end items-center">
            <!-- BEGIN: Notifications -->
            <div class="intro-x dropdown ml-auto sm:ml-6">
                <div :class="count>0?'notification--bullet':''" class="dropdown-toggle notification cursor-pointer"
                     role="button"
                     aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-bell notification__icon dark:text-gray-300">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </div>
                <div class="notification-content pt-2 dropdown-menu">
                    <div class="notification-content__box dropdown-menu__content box">
                        <div v-show="user.role.notificate.show">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    {{ $t('notficate') }}
                                </div>

                                <button v-show="count>0" @click="readNotficate()"
                                        class="border px-2 btn btn-outline-danger py-0">
                                    {{ $t('mark-as-read') }}
                                </button>
                            </div>
                            <div class="cursor-pointer relative flex items-center py-2 border-t b"
                                 v-for="item in notficate ">
                                <div class="mr-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <div class="text-xs text-gray-500 right-0 whitespace-nowrap">{{
                                                item.time
                                            }}
                                        </div>
                                    </div>
                                    <div class="w-full truncate left-0 text-gray-600 mt-0.5">
                                        {{ item.text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <router-link v-show="user.role.forms.show" :to="{name:'adminForms'}" class="flex items-center mt-2">
                                <div
                                    class="w-8 h-8 bg-theme-17 text-theme-20 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-inbox w-5 h-5"
                                         data-v-bf726dba="">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path
                                            d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                                <div class="mr-3">
                                    {{ $t('forms') }}
                                </div>
                            </router-link>
                            <router-link v-show="user.role.users.show" :to="{name:'adminUsers'}" class="flex items-center mt-2">
                                <div
                                    class="w-8 h-8 bg-theme-18 text-theme-21 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-users w-5 h-5">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <div class="mr-3">
                                    {{ $t('users') }}
                                </div>
                            </router-link>
                            <router-link v-show="user.role.support.show" :to="{name:'adminSupport'}" class="flex items-center mt-2">
                                <div
                                    class="w-8 h-8 bg-theme-19 text-theme-22 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-message-square w-5 h-5" data-v-bf726dba="">
                                        <path
                                            d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                </div>
                                <div class="mr-3">
                                    {{ $t('support') }}
                                </div>
                            </router-link>
                            <router-link v-show="user.role.ads.show" :to="{name:'adminAdvertisements'}"
                                         class="flex items-center mt-2">
                                <div
                                    class="w-8 h-8 bg-theme-18 text-theme-29 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-paperclip w-5 h-5" data-v-bf726dba="">
                                        <path
                                            d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                    </svg>
                                </div>
                                <div class="mr-3">
                                    {{ $t('advertisements') }}
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in"
                     role="button"
                     aria-expanded="false">
                    <img alt="Tinker Tailwind HTML Admin Template" :src="isProfile ? '' : '/images/avatar.jpg'">
                </div>
                <div class="dropdown-menu w-56">
                    <div class="dropdown-menu__content box dark:bg-dark-6">
                        <div class="p-4 border-b border-black border-opacity-5 dark:border-dark-3">
                            <div class="font-medium">{{ user.name }}</div>
                        </div>
                        <div class="p-2">
                            <a :href="$hostname + 'fa/panel/profile'"
                               class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user w-4 h-4 ml-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                {{ $t('user-account') }}
                            </a>
                        </div>
                        <div class="p-2 border-t border-black border-opacity-5 dark:border-dark-3">
                            <button @click="logout()"
                                    class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-toggle-right w-4 h-4 ml-2">
                                    <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
                                    <circle cx="16" cy="12" r="3"></circle>
                                </svg>
                                {{ $t('logout') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Account Menu -->
    </div>
</template>
<script>

import axios from "axios";

export default {
    props: {
        title: String,
        element: Boolean,
        elementText: String,
        linkElement: Boolean,
        link: String,
        user: Object
    },
    data() {
        return {
            isProfile: false,
            count: 0,
            notficate: [],
        }
    },
    methods: {
        logout() {
            this.$cookies.remove('user');
            window.location.replace(this.$hostname + 'fa/account');
        },
        readNotficate() {
            const sentData = {
                api_token: this.$cookies.get('user').token,
                data: 'read-message'
            }
            axios.post("/admin/notficate/read", sentData).then((response) => {
                if (response.data.status == 200) {
                    this.count = 0;
                }
            }).catch(() => {
                this.$emit('loadingHide');
            });
        }
    },
    created() {
        axios.get('/admin/notficate', {
            params: {
                api_token: this.$cookies.get('user').token
            }
        }).then(response => {
            this.count = response.data.count
            for (const responseElement of response.data.notficate) {
                this.notficate.push({
                    text: responseElement.text,
                    time: responseElement.time,
                });
            }
        })
    }
}
</script>
