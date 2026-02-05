<script lang="ts" setup></script>

<template>
    <footer class="container-fluid py-8 text-sm text-white">
        <div
            class="bg-charcoal flex flex-col items-center justify-center rounded-xl px-6 py-4 md:flex-row md:justify-between"
        >
            <img
                src="/assets/images/logo-light.svg"
                alt="TrendExpress logo light"
                class="order-2 h-12 w-auto md:order-1"
            />

            <span class="order-1 mb-10 font-medium md:order-2 md:mb-0"
                >© {{ new Date().getFullYear() }}, TrendExpress</span
            >
        </div>
    </footer>
</template>
