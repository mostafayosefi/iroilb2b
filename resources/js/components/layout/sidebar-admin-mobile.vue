<template>
    <div class="mobile-menu md:hidden bg-meno-mobile">
        <div class="mobile-menu-bar">
            <a href="" class="flex ml-auto">
                <img alt="iroilb2b" class="w-30" src="/images/logo/iroilb2b-trans-mobile.png">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2"
                                                                class="w-8 h-8 text-white transform -rotate-270"></i>
            </a>
        </div>
        <ul class="mobile-menu-box py-5 hidden">
            <li v-show="user.role.dashboard.show">
                <router-link @click="message('home')" :to="{name:'indexAdmin'}" class="menu">
                    <div class="menu__icon"><i data-feather="home"></i></div>
                    <div class="menu__title"> {{ $t('dashboard') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.post.show || user.role.category.show || user.role.label.show">
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-feather="box"></i></div>
                    <div class="menu__title">{{ $t('blog') }}
                        <i data-feather="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>
                <ul class="">
                    <li v-show="user.role.post.show">
                        <router-link @click="message('adminPosts')" :to="{name:'adminPosts'}" class="menu">
                            <div class="menu__icon"><i data-feather="file-text"></i></div>
                            <div class="menu__title"> {{ $t('posts') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.category.show">
                        <router-link @click="message('adminCategories')" :to="{name:'adminCategories'}" class="menu">
                            <div class="menu__icon"><i data-feather="list"></i></div>
                            <div class="menu__title">{{ $t('categories') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.label.show">
                        <router-link @click="message('adminLabels')" :to="{name:'adminLabels'}" class="menu">
                            <div class="menu__icon"><i data-feather="tag"></i></div>
                            <div class="menu__title">{{ $t('labels') }}</div>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-show="user.role.page.show">
                <router-link @click="message('adminPages')" :to="{name:'adminPages'}" class="menu">
                    <div class="menu__icon"><i data-feather="layers"></i></div>
                    <div class="menu__title">{{ $t('pages') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.operator.show">
                <router-link @click="message('adminOperators')" :to="{name:'adminOperators'}" class="menu">
                    <div class="menu__icon"><i data-feather="shield"></i></div>
                    <div class="menu__title">{{ $t('operators') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.table.show">
                <router-link @click="message('adminTables')" :to="{name:'adminTables'}" class="menu">
                    <div class="menu__icon"><i data-feather="database"></i></div>
                    <div class="menu__title">{{ $t('tables') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.forms.show">
                <router-link @click="message('adminForms')" :to="{name:'adminForms'}" class="menu">
                    <div class="menu__icon"><i data-feather="inbox"></i></div>
                    <div class="menu__title">{{ $t('forms') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.settings.site || user.role.settings.header || user.role.settings.sidebar || user.role.settings.footer">
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-feather="tool"></i></div>
                    <div class="menu__title"> {{ $t('setting') }}
                        <i data-feather="chevron-down" class="menu__sub-icon "></i>
                    </div>
                </a>

                <ul class="">
                    <li v-show="user.role.settings.site">
                        <router-link @click="message('adminSetting')" :to="{name:'adminSetting'}" class="menu">
                            <div class="menu__icon"><i data-feather="settings"></i></div>
                            <div class="menu__title">{{ $t('site-settings') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.settings.header">
                        <router-link @click="message('adminSettingHeader')" :to="{name:'adminSettingHeader'}"
                                     class="menu">
                            <div class="menu__icon"><i data-feather="sliders"></i></div>
                            <div class="menu__title">{{ $t('header') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.settings.sidebar">
                        <router-link @click="message('adminSettingSideBar')" :to="{name:'adminSettingSideBar'}"
                                     class="menu">
                            <div class="menu__icon"><i data-feather="sliders"></i></div>
                            <div class="menu__title">{{ $t('side-bar') }}</div>
                        </router-link>
                    </li>
                    <!------ FOOTER COMMENT ------->
                </ul>
            </li>
            <li v-show="user.role.redirect.show">
                <router-link @click="message('adminRedirect')" :to="{name:'adminRedirect'}" class="menu">
                    <div class="menu__icon"><i data-feather="external-link"></i></div>
                    <div class="menu__title">{{ $t('redirects') }}</div>
                </router-link>
            </li>
            <li class="menu__devider my-6"></li>
            <li v-show="user.role.users.show || user.role.notificate.show">
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-feather="star"></i></div>
                    <div class="menu__title"> {{ $t('management-customers') }}</div>
                    <i data-feather="chevron-down" class="menu__sub-icon "></i>
                </a>
                <ul class="">
                    <li v-show="user.role.users.show">
                        <router-link @click="message('adminUsers')" :to="{name:'adminUsers'}" class="menu">
                            <div class="menu__icon"><i data-feather="users"></i></div>
                            <div class="menu__title">{{ $t('users') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.notificate.show">
                        <router-link @click="message('adminUsersMessageView')" :to="{name:'adminUsersMessageView'}"
                                     class="menu">
                            <div class="menu__icon"><i data-feather="message-circle"></i></div>
                            <div class="menu__title">{{ $t('messages-management') }}</div>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-show="user.role.company.show || user.role.product.show || user.role.tag.show">
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"><i data-feather="package"></i></div>
                    <div class="menu__title">
                        {{ $t('management-companies') }}
                        <div class="menu__sub-icon "><i data-feather="chevron-down"></i></div>
                    </div>
                </a>
                <ul class="">
                    <li v-show="user.role.product.show">
                        <router-link @click="message('adminProducts')" :to="{name:'adminProducts'}" class="menu">
                            <div class="menu__icon"><i data-feather="archive"></i></div>
                            <div class="menu__title">{{ $t('products') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.tag.show">
                        <router-link @click="message('adminUsersMessageView')" :to="{name:'adminCompanyFilter'}"
                                     class="menu">
                            <div class="menu__icon"><i data-feather="filter"></i></div>
                            <div class="menu__title">{{ $t('filters') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.company.show">
                        <router-link @click="message('adminCompanies')" :to="{name:'adminCompanies'}" class="menu">
                            <div class="menu__icon"><i data-feather="briefcase"></i></div>
                            <div class="menu__title">{{ $t('companies') }}</div>
                        </router-link>
                    </li>
                </ul>
            </li>

            <li v-show="user.role.ads.show">
                <router-link @click="message('adminAdvertisements')" :to="{name:'adminAdvertisements'}" class="menu">
                    <div class="menu__icon"><i data-feather="paperclip"></i></div>
                    <div class="menu__title">{{ $t('advertisements') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.support.show">
                <router-link @click="message('adminSupport')" :to="{name:'adminSupport'}" class="menu">
                    <div class="menu__icon"><i data-feather="message-square"></i></div>
                    <div class="menu__title">{{ $t('support') }}</div>
                </router-link>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    data() {
        return {}
    },
    props: {
        user: Object
    },
    methods: {
        message(text) {
            if (this.$route.name != text) {
                return this.$emit('loading');
            }
        }
    }
}
</script>
