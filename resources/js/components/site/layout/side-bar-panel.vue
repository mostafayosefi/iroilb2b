<template>
    <!--    side bar panel-->
    <section class="text-white-primary w-full">
        <router-link :to="{name:'sitePanel'}" class="block p-4 hover:bg-slate-600">
            <i class="fe fe-home"></i>
            {{ $t('dashboard', language) }}
        </router-link>
        <hr class="border-gray-500">
        <router-link :to="{name:'sitePanelCompany'}" class="block p-4 hover:bg-slate-600">
            <i class="fe fe-compass"></i>
            {{ $t('company-managment', language) }}
        </router-link>
        <hr class="border-gray-500">
        <router-link :to="{name:'sitePanelAds'}" class="block p-4 hover:bg-slate-600">
            <i class="fe fe-tag"></i>
            {{ $t('my-ads', language) }}
        </router-link>
        <hr class="border-gray-500">
        <router-link :to="{name:'sitePanelBookmark'}" class="block p-4 hover:bg-slate-600">
            <i class="fe fe-bookmark"></i>
            {{ $t('bookmarks', language) }}
        </router-link>
        <hr class="border-gray-500">
        <router-link :to="{name:'siteLivePrice'}" class="block p-4 hover:bg-slate-600">
            <span class="relative inline-flex">
                  <span class="flex h-3 w-3 ">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white-primary"></span>
                  </span>
            </span>
            {{ $t('global-prices-petroleum-products', language) }}
        </router-link>
        <hr class="border-gray-500">
        <router-link :to="{name:'siteSupport'}" class="block p-4 hover:bg-slate-600">
            <i class="fe fe-message-circle"></i>
            {{ $t('support', language) }}
        </router-link>
        <hr class="border-gray-500">
        <router-link :to="{name:'siteProfile'}" class="block p-4 hover:bg-slate-600">
            <i class="fe fe-user"></i>
            {{ $t('profile-setting', language) }}
        </router-link>
        <hr class="border-gray-500">
        <button class="p-4 block w-full" :class="language=='fa'?'text-right':'text-left'" @click="logout()">
            <i class="fe fe-log-out"></i>
            {{ $t('logout', language) }}
        </button>
    </section>
    <div
        class="bottom-0 flex justify-center pb-14 w-full bg-gradient-to-b from-dark-primary to-slate-800">
        <img :src="site.logoLight" :alt="site.title" class="w-2/3 mt-2">
    </div>
</template>

<script>
export default {
    props: {
        site: Object,
        user: Object
    },
    data() {
        return {
            language: this.$route.params.lang
        }
    },
    methods: {
        logout() {
            this.$cookies.remove('user');
            this.$router.push({name: 'siteAccount'})
        }
    },
}
</script>
