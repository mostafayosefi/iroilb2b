<template>
    <!--    desktop footer-->
    <footer class="hidden absolute bottom-0 w-full bg-white md:flex justify-between py-5 border-slate-200 inset-x-0">
        <div class="w-2/3 m-auto flex justify-between">
            <section class="md:w-full flex items-center">
                <span>{{ date() + " " + $t('copy-rights', $route.params.lang) }}</span>
                <ul class="flex text-dark-primary text-sm">
                    <router-link :to="{name:'siteContact'}">
                        <li class="mx-1 hover:underline py-2 px-3">
                            {{ $t('contact', $route.params.lang) }}
                        </li>
                    </router-link>
                    <router-link :to="{name:'siteFaq'}">
                        <li class="mx-1 hover:underline py-2 px-3">
                            {{ $t('faq', $route.params.lang) }}
                        </li>
                    </router-link>
                    <router-link :to="{path:'b2bplus/rules'}">
                        <li class="mx-1 hover:underline py-2 px-3">
                            {{ $t('rules', $route.params.lang) }}
                        </li>
                    </router-link>
                </ul>
            </section>
            <img class="h-fit" :src="site.logoDark" :alt="site.title" width="100">
        </div>
    </footer>
    <!--    mobile footer-->
    <footer class="md:hidden block w-full bg-white py-5 border-slate-200 inset-x-0 px-2">
        <ul class="flex justify-center text-dark-primary text-sm">
            <router-link :to="{name:'siteContact'}">
                <li class="mx-1 hover:underline py-2 px-3">
                    {{ $t('contact', $route.params.lang) }}
                </li>
            </router-link>
            <router-link :to="{name:'siteFaq'}">
                <li class="mx-1 hover:underline py-2 px-3">
                    {{ $t('faq', $route.params.lang) }}
                </li>
            </router-link>
            <router-link :to="{path:'b2bplus/rules'}">
                <li class="mx-1 hover:underline py-2 px-3">
                    {{ $t('rules', $route.params.lang) }}
                </li>
            </router-link>
        </ul>
        <div class="flex justify-center float-left w-full my-4">
            <img :src="site.logoDark"
                 :alt="site.title" width="100">
        </div>
        <p class="w-full mt-2 text-center">{{ date() + " " + $t('copy-rights', $route.params.lang) }}</p>
    </footer>
</template>

<script>
export default {
    props: {
        site: Object,
    },
    data() {
        return {}
    }, methods: {
        date() {
            const date = new Date();
            return date.getFullYear();
        }
    },
}
</script>

