<template>
    <div
        class="error-page flex flex-col lg:flex-row items-center justify-center
        h-screen text-center lg:text-right mr-5">
        <div class="-intro-x lg:ml-20">
            <img alt="Tinker Tailwind HTML Admin Template" class="h-48 lg:h-auto"
                 src="/images/admin/error-illustration.svg">
        </div>
        <div class="text-white mt-10 lg:mt-0">
            <div class="intro-x text-8xl font-medium">404</div>
            <div class="intro-x text-xl lg:text-3xl font-medium mt-5">اوه، این صفحه گمشده است.</div>
            <div class="intro-x text-lg mt-3">ممکنه آدرس رو اشتباه وارد کرده باشید یا این صفحه جا به جا شده
                باشه
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$emit('loadingHide');
    }
}
</script>

