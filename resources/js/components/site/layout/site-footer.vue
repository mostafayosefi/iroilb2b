<template>
    <!--    desktop footer-->
    <footer class="bottom-0 absolute w-full border-0 hidden md:block mb-[-160px]">
        <div class="w-full bg-white-secondary mt-4 flex justify-between items-center py-5 mb-12 border-slate-200">
            <div class="w-3/4 m-auto flex justify-between">
                <section class="flex items-center">
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
                        <router-link :to="{path:'/'+language+'/b2bplus/rules'}">
                            <li class="mx-1 hover:underline py-2 px-3">
                                {{ $t('rules', $route.params.lang) }}
                            </li>
                        </router-link>
                    </ul>
                </section>
                <img class="h-fit" :src="site.logoDark" :alt="site.title" width="100">
            </div>
        </div>
    </footer>
    <!--    mobile footer-->
    <footer class="block md:hidden bottom-0 absolute w-full border-0 mb-[-290px] bg-white-secondary mt-4 px-2">
        <section class="mb-[6rem]">
            <ul class="text-dark-primary text-sm border-t border-slate-200">
                <router-link :to="{name:'siteContact'}">
                    <li class="mx-1 hover:underline py-2 px-3 my-1">
                        {{ $t('contact', $route.params.lang) }}
                    </li>
                </router-link>
                <router-link :to="{name:'siteFaq'}">
                    <li class="mx-1 hover:underline py-2 px-3 my-1">
                        {{ $t('faq', $route.params.lang) }}
                    </li>
                </router-link>
                <router-link :to="{path:'/'+language+'/b2bplus/rules'}">
                    <li class="mx-1 hover:underline py-2 px-3 my-1">
                        {{ $t('rules', $route.params.lang) }}
                    </li>
                </router-link>
            </ul>
            <p class="text-center mt-2">{{ date() + " " + $t('copy-rights', $route.params.lang) }}</p>
        </section>
    </footer>
</template>

<script>
export default {
    props: {
        site: Object,
    },
    data() {
        return {
            language: this.$route.params.lang,
        }
    }, methods: {
        date() {
            const date = new Date();
            return date.getFullYear();
        }
    }
}
</script>
