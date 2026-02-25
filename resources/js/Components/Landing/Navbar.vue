<template>
    <header class="absolute z-50 w-full lg:top-3">
        <nav class="px-0 mx-auto max-w-screen lg:max-w-480 lg:px-20 2xl:px-60">
            <div
                class="flex flex-wrap items-center justify-between w-full px-4 py-4 mx-auto 3xl:p-4 max-w-screen bg-white/20 backdrop-blur-md md:px-10 lg:rounded-2xl lg:px-0 xl:px-4"
            >
                <div class="shrink-0">
                    <Link :href="route('index')">
                        <img
                            src="/assets/images/logo-dark.svg"
                            alt="TrendExpress dark logo"
                            class="w-auto h-10 lg:h-12"
                        />
                    </Link>
                </div>

                <div class="block lg:hidden">
                    <button
                        @click="toggleMobileMenu"
                        class="text-charcoal hover:text-gray-medium flex cursor-pointer items-center p-1.5 transition duration-300"
                    >
                        <MenuIcon
                            :class="!isMobileMenuOpen ? 'block' : 'hidden'"
                        />
                        <CloseIcon
                            :class="isMobileMenuOpen ? 'block' : 'hidden'"
                        />
                    </button>
                </div>

                <div
                    id="nav-content"
                    :class="[
                        'w-full grow flex-col items-start py-3 lg:visible lg:flex lg:w-auto lg:flex-row lg:items-center lg:pt-0',
                        isMobileMenuOpen ? 'flex' : 'hidden',
                    ]"
                >
                    <div
                        class="flex flex-col items-start w-full space-y-2 3xl:space-x-10 lg:w-auto lg:grow lg:flex-row lg:justify-center lg:space-y-0 lg:space-x-1 xl:space-x-8"
                    >
                        <NavLink link="#about">{{ $t('About us') }}</NavLink>
                        <NavLink link="#service">{{ $t('Service') }}</NavLink>
                        <NavLink link="#contact">{{
                            $t('Contact us')
                        }}</NavLink>
                        <NavLink :link="route('dashboard')">{{
                            $t('Track my cargo')
                        }}</NavLink>
                    </div>

                    <div
                        class="flex flex-col w-full pt-6 space-y-3 lg:w-auto lg:flex-row lg:items-center lg:space-y-0 lg:space-x-5 lg:pt-0"
                    >
                        <div class="hidden lg:block">
                            <SwitchLocale :show-icon="false" />
                        </div>

                        <div class="block space-y-2 lg:hidden">
                            <SwitchLocale
                                :is-mobile="true"
                                @switched="toggleMobileMenu"
                            />
                        </div>

                        <div class="pt-3 lg:pt-0">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="bg-charcoal w-full basis-0 rounded-xl px-9.5 py-3 font-semibold text-nowrap text-white transition duration-300 lg:w-auto"
                            >
                                {{ $t('Dashboard') }}
                            </Link>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="bg-charcoal w-full basis-0 rounded-xl px-9.5 py-3 font-semibold text-nowrap text-white transition duration-300 lg:w-auto"
                                >
                                    {{ $t('Log in') }}
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script lang="ts" setup>
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import NavLink from '@/Components/Landing/NavLink.vue';
import SwitchLocale from '@/Components/SwitchLocale.vue';
import { Link } from '@inertiajs/vue3';
import { ref, Ref } from 'vue';

const isMobileMenuOpen: Ref<boolean> = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>
