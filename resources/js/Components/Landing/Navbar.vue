<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { ref, Ref } from 'vue';

// import {
//   DropdownMenu,
//   DropdownMenuContent,
//   DropdownMenuItem,
//   DropdownMenuTrigger,
// } from '@/components/ui/dropdown-menu'
// import { computed, ref } from 'vue'
// import { useLanguage } from '@/composables/useLanguage'
// import type { Language } from '@/types/api'
// import NavLink from './NavLink.vue'
import CloseIcon from '@/Components/Icons/CloseIcon.vue';
import MenuIcon from '@/Components/Icons/MenuIcon.vue';
import NavLink from './NavLink.vue';
// import ChevronDownIcon from '../Icons/ChevronDownIcon.vue'
// import { useAuth } from '@/composables/useAuth'

const isMobileMenuOpen: Ref<boolean> = ref(false);
// const { isAuthenticated } = useAuth()

// const { currentLanguage, setLanguage, availableLanguages, t } = useLanguage()

// const getCurrentLanguageLabel = computed(() => {
//   return (
//     availableLanguages.value.find((lang) => lang.value === currentLanguage.value)?.label ||
//     'English'
//   )
// })

// const handleLanguageChange = async (lang: Language): Promise<void> => {
//   try {
//     await setLanguage(lang)
//   } catch (error) {
//     console.error('Failed to change language:', error)
//   }
// }

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>

<template>
    <header class="absolute z-50 w-full lg:top-3">
        <nav class="mx-auto max-w-screen px-0 lg:max-w-480 lg:px-20 2xl:px-60">
            <div
                class="3xl:p-4 mx-auto flex w-full max-w-screen flex-wrap items-center justify-between bg-white/20 px-4 py-4 backdrop-blur-md md:px-10 lg:rounded-2xl lg:px-0 xl:px-4"
            >
                <div class="shrink-0">
                    <Link :href="route('index')">
                        <img
                            src="/assets/images/logo-dark.svg"
                            alt="TrendExpress dark logo"
                            class="h-10 w-auto lg:h-12"
                        />
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
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
                        class="3xl:space-x-10 flex w-full flex-col items-start space-y-2 lg:w-auto lg:grow lg:flex-row lg:justify-center lg:space-y-0 lg:space-x-1 xl:space-x-8"
                    >
                        <NavLink link="#about">About us</NavLink>
                        <NavLink link="#service">Service</NavLink>
                        <NavLink link="#contact">Contact us</NavLink>
                        <NavLink link="#track_my_cargo">Track my cargo</NavLink>
                    </div>

                    <div
                        class="flex w-full flex-col space-y-3 pt-6 lg:w-auto lg:flex-row lg:items-center lg:space-y-0 lg:space-x-3 lg:pt-0"
                    >
                        <div class="hidden lg:block">
                            <!-- TODO: localization dropdown goes here -->
                            <!-- <DropdownMenu :modal="false">
                                <DropdownMenuTrigger
                                    class="inline-flex w-full cursor-pointer items-center justify-center py-3 pr-6 font-semibold transition duration-300"
                                >
                                    <span>{{ getCurrentLanguageLabel }}</span>
                                    <ChevronDownIcon />
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    class="rounded-xl border-none bg-white/20 px-2 font-medium backdrop-blur-md"
                                >
                                    <DropdownMenuItem
                                        v-for="lang in availableLanguages"
                                        :key="lang.value"
                                        @click="
                                            handleLanguageChange(lang.value)
                                        "
                                        :class="{
                                            'font-bold':
                                                currentLanguage === lang.value,
                                            'cursor-pointer':
                                                currentLanguage !== lang.value,
                                        }"
                                        class="language-item"
                                    >
                                        {{ lang.label }}
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu> -->
                        </div>

                        <div class="block space-y-2 lg:hidden">
                            <!-- <div class="text-lg font-semibold">Language</div>

                            <a
                                v-for="lang in availableLanguages"
                                :key="lang.value"
                                @click="handleLanguageChange(lang.value)"
                                :class="[
                                    'text-charcoal bg-off-white block w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto',
                                    currentLanguage === lang.value
                                        ? 'text-red-brand'
                                        : '',
                                ]"
                                >{{ lang.label }}</a> -->
                            mobile nav lang
                        </div>

                        <div class="pt-3 lg:pt-0">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="bg-charcoal w-full basis-0 rounded-xl px-9.5 py-3 font-semibold text-nowrap text-white transition duration-300 lg:w-auto"
                            >
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="bg-charcoal w-full basis-0 rounded-xl px-9.5 py-3 font-semibold text-nowrap text-white transition duration-300 lg:w-auto"
                                >
                                    Log in
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
<!--
<style scoped>
.nav-locale a {
    padding-left: 12px;
    padding-right: 12px;
}

.nav-locale a:last-child {
    padding-right: 0;
}

.nav-locale a.add-after {
    position: relative;
}

.nav-locale a.add-after:after {
    content: '|';
    color: #161616;
    position: absolute;
    right: 0;
}
</style> -->
