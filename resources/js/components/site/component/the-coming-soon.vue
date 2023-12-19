<template>
    <div class="w-full h-screen flex flex-wrap items-center justify-center">
        <div>
            <img :src="site.logoDark" :alt="site.title" width="200">
            <p class="my-4">
                {{ $t('coming-soon', $route.params.lang) }}
            </p>
        </div>
    </div>
</template>
<script>
export default {
    name: "the-coming-soon.vue",
    props: {
        site: Object,
    },
}
</script>

