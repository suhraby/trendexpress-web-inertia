<script setup lang="ts">
import ChevronRightIcon from '@/Components/Icons/ChevronRightIcon.vue';
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);
</script>

<template>
    <Head title="Dashboard" />

    <div>
        <!-- overlay goes here -->
    </div>
    <header
        class="fixed top-0 z-0 w-full bg-white text-sm md:static md:top-auto"
    >
        <nav
            class="container-dashboard border-gray-light flex flex-row flex-wrap items-center justify-between border-b py-3 md:py-6"
        >
            <div class="shrink-0">
                <Link :href="route('index')">
                    <img
                        src="/assets/images/logo-dark.svg"
                        alt="TrendExpress dark logo"
                        class="hidden h-12 w-auto md:block"
                    />

                    <img
                        src="/assets/images/logo.svg"
                        alt="TrendExpress logo-mark"
                        class="block h-12 w-auto md:hidden"
                    />
                </Link>
            </div>
            <div class="block md:hidden">
                <button
                    class="text-charcoal hover:text-gray-medium flex cursor-pointer items-center p-1.5 transition duration-300"
                >
                    <MenuIcon :class="!isMobileMenuOpen ? 'block' : 'hidden'" />
                    <CloseIcon :class="isMobileMenuOpen ? 'block' : 'hidden'" />
                </button>
            </div>
            <div
                class="text-charcoal right-nav hidden items-center space-x-6 md:flex"
            >
                <div>locale</div>
                <!-- @click="toggleProfileForm" -->
                <div class="flex cursor-pointer flex-row">
                    <span>John Doe</span>

                    <ChevronRightIcon />
                </div>
            </div>
        </nav>

        <!-- Mobile nav -->
        <div
            :class="[
                'container-dashboard absolute left-0 z-50 w-full space-y-2 bg-white py-4 md:hidden',
                isMobileMenuOpen ? 'block' : 'hidden',
            ]"
        >
            <!-- @click="toggleProfileForm" -->
            <a
                class="text-charcoal bg-off-white block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                >Profile</a
            >
            <div class="text-lg font-semibold">Language</div>
            <div>
                <a
                    href="#"
                    class="bg-off-white text-red-brand block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                >
                    English
                </a>
                <a
                    href="#"
                    class="text-charcoal bg-off-white block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                >
                    Turkmen
                </a>
                <a
                    href="#"
                    class="text-charcoal bg-off-white block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto"
                >
                    Russian
                </a>
            </div>
        </div>
    </header>

    <main class="container-dashboard text-charcoal my-24 md:mt-6 md:mb-0">
        <div class="flex flex-nowrap space-x-6">
            <div
                class="fixed bottom-0 left-0 z-auto hidden w-full rounded-tl-[20px] rounded-tr-[20px] bg-white p-4 md:static md:bottom-auto md:left-auto md:z-auto md:block md:w-60 md:rounded-none md:p-0"
            ></div>
        </div>
    </main>
</template>
