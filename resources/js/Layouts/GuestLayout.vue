<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" color="#FFF"/>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>

<style scoped>
.auth {
    background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);
}
</style>
