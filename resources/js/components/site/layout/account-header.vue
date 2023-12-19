<template>
    <!--    mobile header-->
    <header class="flex justify-around md:hidden border-b py-5 border-slate-200 bg-white">
        <div class="w-1/4 flex items-center justify-center">
            <section id="sidemenu">
                <button class="sidemenu__btn" @click="navOpen=!navOpen" v-bind:class="{active:navOpen}">
                    <span class="top"></span>
                    <span class="mid"></span>
                    <span class="bottom"></span>
                </button>
                <transition name="translateX">
                    <nav v-show="navOpen">
                        <div class="sidemenu__wrapper mt-4">
                            <div class="w-full flex justify-around items-center border-b py-5 border-slate-200">
                                <div>
                                    <select v-model="lang"
                                            class="mx-1 bg-dark-secondary text-dark-primary py-2 px-3 rounded-lg">
                                        <option value="fa">{{ $t('persian', language) }}</option>
                                        <option value="en">{{ $t('english', language) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="px-2">
                                <router-link :to="{name:'siteAccount'}">
                                    <p class="mx-1 py-2 px-3 rounded-full duration-300 my-1">
                                        {{ $t('login', $route.params.lang) }}
                                    </p>
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'siteSignup'}">
                                    <p class="mx-1 py-2 px-3 rounded-full duration-300 my-1">
                                        {{ $t('signup', $route.params.lang) }}
                                    </p>
                                </router-link>
                                <hr class="border-gray-200">
                                <router-link :to="{name:'siteForgot'}">
                                    <p class="mx-1 py-2 px-3 rounded-full duration-300 my-1">
                                        {{ $t('one-time-password', $route.params.lang) }}
                                    </p>
                                </router-link>
                            </div>
                        </div>
                    </nav>
                </transition>
            </section>
        </div>
        <section class="w-3/4 flex items-center justify-center">
            <router-link :to="{name:'siteHome'}">
                <img :src="site.logoDark" :alt="site.title" width="140">
            </router-link>
        </section>
    </header>
    <!--desktop header-->
    <header class="hidden md:flex justify-between border-b py-5 border-slate-200 bg-white">
        <section class="w-2/3 m-auto flex justify-between">
            <router-link :to="{name:'siteHome'}">
                <img :src="site.logoDark" :alt="site.title" width="140">
            </router-link>
            <ul class="w-3/5 flex justify-end font-bold text-dark-primary text-sm">
                <router-link :to="{name:'siteAccount'}">
                    <li class="mx-1 hover:bg-dark-primary hover:text-white-primary py-2 px-3 rounded-full duration-300">
                        {{ $t('login', $route.params.lang) }}
                    </li>
                </router-link>
                <router-link :to="{name:'siteSignup'}">
                    <li class="mx-1 hover:bg-dark-primary hover:text-white-primary py-2 px-3 rounded-full duration-300">
                        {{ $t('signup', $route.params.lang) }}
                    </li>
                </router-link>
                <router-link :to="{name:'siteForgot'}">
                    <li class="mx-1 hover:bg-dark-primary hover:text-white-primary py-2 px-3 rounded-full duration-300">
                        {{ $t('one-time-password', $route.params.lang) }}
                    </li>
                </router-link>
                <div v-show="$route.params.lang=='en'" class="py-2 px-1" @click="flagShow=!flagShow">
                    <span class="fi fi-us"></span>
                    <a href="/fa/account">
                        <span v-show="flagShow" class="fi fi-ir mx-1"></span>
                    </a>
                </div>

                <div v-show="$route.params.lang=='fa'" class="py-2 px-1" @click="flagShow=!flagShow">
                    <span class="fi fi-ir"></span>
                    <a href="/en/account">
                        <span v-show="flagShow" class="fi fi-us mx-1"></span>
                    </a>
                </div>
            </ul>
        </section>
    </header>
</template>
<script>
import "/node_modules/flag-icons/css/flag-icons.min.css";

export default {
    props: {
        site: Object,
    },
    data() {
        return {
            flagShow: false,
            navOpen: false,
            language: this.$route.params.lang,
            lang: this.$route.params.lang
        }
    },
    watch: {
        lang(oldLang, newLang) {
            if ('fa' == this.language) {
                window.location.replace(this.$route.href.replace('fa', 'en'));
            } else {
                window.location.replace(this.$route.href.replace('en', 'fa'));
            }
        }
    },
}
</script>
