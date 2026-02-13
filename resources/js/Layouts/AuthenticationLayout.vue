<template>
    <Head :title />
    <Navbar />

    <main
        class="relative flex min-h-[calc(100vh-96px)] w-full flex-col items-center justify-center overflow-y-auto"
    >
        <img
            src="/assets/images/login-pattern.png"
            alt="Pattern image"
            class="absolute -top-10 left-1/2 z-0 -translate-x-1/2"
        />
        <div class="container-auth static z-10 pt-6 pb-12">
            <div class="mx-auto w-full sm:w-100">
                <div class="mb-8 text-center">
                    <img
                        src="/assets/images/auth-header.png"
                        alt="Auth header icon"
                        class="mx-auto mb-4"
                    />
                    <h2 class="h2 mb-2">Trend Express</h2>
                    <div class="text-gray-medium font-normal">{{ header }}</div>
                </div>

                <slot />
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import Navbar from '@/Components/Auth/Navbar.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    title: string;
    header: string;
}>();
</script>
