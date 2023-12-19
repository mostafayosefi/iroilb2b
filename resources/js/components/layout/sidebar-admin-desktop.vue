<template>
    <nav class="side-nav">
        <a target="_blank" :href="$hostname + 'fa'" class="intro-x flex items-center pr-5 pt-4 mt-3">
            <img alt="iroilb2b" src="/images/logo/iroilb2b-trans.png">
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            <li v-show="user.role.dashboard.show">
                <router-link @click="message('home')" :to="{name:'indexAdmin'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="home"></i></div>
                    <div class="side-menu__title">
                        {{ $t('dashboard') }}
                    </div>
                </router-link>
            </li>
            <li v-show="user.role.post.show || user.role.category.show || user.role.label.show">
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="box"></i></div>
                    <div class="side-menu__title">
                        {{ $t('blog') }}
                        <div class="side-menu__sub-icon "><i data-feather="chevron-down"></i></div>
                    </div>
                </a>
                <ul class="">
                    <li v-show="user.role.post.show">
                        <router-link @click="message('adminPosts')" :to="{name:'adminPosts'}" class="side-menu">
                            <div class="side-menu__icon"><i data-feather="file-text"></i></div>
                            <div class="side-menu__title">{{ $t('posts') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.category.show">
                        <router-link @click="message('adminCategories')" :to="{name:'adminCategories'}"
                                     class="side-menu">
                            <div class="side-menu__icon"><i data-feather="list"></i></div>
                            <div class="side-menu__title">{{ $t('categories') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.label.show">
                        <router-link @click="message('adminLabels')" :to="{name:'adminLabels'}" class="side-menu">
                            <div class="side-menu__icon"><i data-feather="tag"></i></div>
                            <div class="side-menu__title">{{ $t('labels') }}</div>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-show="user.role.page.show">
                <router-link @click="message('adminPages')" :to="{name:'adminPages'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="layers"></i></div>
                    <div class="side-menu__title">{{ $t('pages') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.operator.show">
                <router-link @click="message('adminOperators')" :to="{name:'adminOperators'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="shield"></i></div>
                    <div class="side-menu__title">{{ $t('operators') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.table.show">
                <router-link @click="message('adminTables')" :to="{name:'adminTables'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="database"></i></div>
                    <div class="side-menu__title">{{ $t('tables') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.forms.show">
                <router-link @click="message('adminForms')" :to="{name:'adminForms'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="inbox"></i></div>
                    <div class="side-menu__title">{{ $t('forms') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.settings.site || user.role.settings.header || user.role.settings.sidebar || user.role.settings.footer">
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="tool"></i></div>
                    <div class="side-menu__title">
                        {{ $t('setting') }}
                        <div class="side-menu__sub-icon "><i data-feather="chevron-down"></i></div>
                    </div>
                </a>
                <ul class="">
                    <li v-show="user.role.settings.site">
                        <router-link @click="message('adminSetting')" :to="{name:'adminSetting'}" class="side-menu">
                            <div class="side-menu__icon"><i data-feather="settings"></i></div>
                            <div class="side-menu__title">{{ $t('site-settings') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.settings.header">
                        <router-link @click="message('adminSettingHeader')" :to="{name:'adminSettingHeader'}"
                                     class="side-menu">
                            <div class="side-menu__icon"><i data-feather="sliders"></i></div>
                            <div class="side-menu__title">{{ $t('header') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.settings.sidebar">
                        <router-link @click="message('adminSettingSideBar')" :to="{name:'adminSettingSideBar'}"
                                     class="side-menu">
                            <div class="side-menu__icon"><i data-feather="sliders"></i></div>
                            <div class="side-menu__title">{{ $t('side-bar') }}</div>
                        </router-link>
                    </li>
                    <!------ FOOTER COMMENT ------->
                </ul>
            </li>
            <li v-show="user.role.redirect.show">
                <router-link @click="message('adminRedirect')" :to="{name:'adminRedirect'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="external-link"></i></div>
                    <div class="side-menu__title">{{ $t('redirects') }}</div>
                </router-link>
            </li>
            <li class="side-nav__devider my-6"></li>

            <li v-show="user.role.users.show || user.role.notificate.show">
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="star"></i></div>
                    <div class="side-menu__title">
                        {{ $t('management-customers') }}
                        <div class="side-menu__sub-icon "><i data-feather="chevron-down"></i></div>
                    </div>
                </a>
                <ul class="">
                    <li v-show="user.role.users.show">
                        <router-link @click="message('adminUsers')" :to="{name:'adminUsers'}" class="side-menu">
                            <div class="side-menu__icon"><i data-feather="users"></i></div>
                            <div class="side-menu__title">{{ $t('users') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.notificate.show">
                        <router-link @click="message('adminUsersMessageView')" :to="{name:'adminUsersMessageView'}"
                                     class="side-menu">
                            <div class="side-menu__icon"><i data-feather="message-circle"></i></div>
                            <div class="side-menu__title">{{ $t('messages-management') }}</div>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-show="user.role.company.show || user.role.product.show || user.role.tag.show">
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="package"></i></div>
                    <div class="side-menu__title">
                        {{ $t('management-companies') }}
                        <div class="side-menu__sub-icon "><i data-feather="chevron-down"></i></div>
                    </div>
                </a>
                <ul class="">
                    <li v-show="user.role.product.show">
                        <router-link @click="message('adminProducts')" :to="{name:'adminProducts'}" class="side-menu">
                            <div class="side-menu__icon"><i data-feather="archive"></i></div>
                            <div class="side-menu__title">{{ $t('products') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.tag.show">
                        <router-link @click="message('adminUsersMessageView')" :to="{name:'adminCompanyFilter'}"
                                     class="side-menu">
                            <div class="side-menu__icon"><i data-feather="filter"></i></div>
                            <div class="side-menu__title">{{ $t('filters') }}</div>
                        </router-link>
                    </li>
                    <li v-show="user.role.company.show">
                        <router-link @click="message('adminCompanies')" :to="{name:'adminCompanies'}" class="side-menu">
                            <div class="side-menu__icon"><i data-feather="briefcase"></i></div>
                            <div class="side-menu__title">{{ $t('companies') }}</div>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li v-show="user.role.ads.show">
                <router-link @click="message('adminAdvertisements')" :to="{name:'adminAdvertisements'}"
                             class="side-menu">
                    <div class="side-menu__icon"><i data-feather="paperclip"></i></div>
                    <div class="side-menu__title">{{ $t('advertisements') }}</div>
                </router-link>
            </li>
            <li v-show="user.role.support.show">
                <router-link @click="message('adminSupport')" :to="{name:'adminSupport'}" class="side-menu">
                    <div class="side-menu__icon"><i data-feather="message-square"></i></div>
                    <div class="side-menu__title">{{ $t('support') }}</div>
                </router-link>
            </li>
        </ul>
    </nav>
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
<style scoped>
.n-active {
    background: #566883;
}
</style>

