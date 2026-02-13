<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
// import {
//   DropdownMenu,
//   DropdownMenuContent,
//   DropdownMenuItem,
//   DropdownMenuTrigger,
// } from '@/components/ui/dropdown-menu'
// import { computed } from 'vue'
// import { useLanguage } from '@/composables/useLanguage'
// import type { Language } from '@/types/api'
import GlobeIcon from '@/Components/Icons/GlobeIcon.vue';
// import ChevronDownIcon from '@/Components/Icons/ChevronDownIcon.vue'

// const { currentLanguage, setLanguage, availableLanguages } = useLanguage()

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
</script>

<template>
    <header class="border-gray-light border-b text-sm">
        <nav
            class="container-auth flex flex-col flex-wrap items-center space-y-2 py-6 sm:flex-row sm:justify-between sm:space-y-0"
        >
            <div class="shrink-0">
                <Link :href="route('index')">
                    <img
                        src="/assets/images/logo-dark.svg"
                        alt="TrendExpress dark logo"
                        class="w-auto lg:h-12"
                    />
                </Link>
            </div>

            <div class="text-gray-medium">
                <span class="flex"> <GlobeIcon /> lang </span>
                <!-- <DropdownMenu :modal="false">
          <DropdownMenuTrigger
            class="inline-flex items-center justify-center w-full py-3 font-medium transition duration-300 cursor-pointer space-x-1"
          >
            <GlobeIcon />
            <span>{{ getCurrentLanguageLabel }}</span>
            <ChevronDownIcon />
          </DropdownMenuTrigger>
          <DropdownMenuContent
            class="px-2 bg-white/20 backdrop-blur-md rounded-xl border-none font-medium"
          >
            <DropdownMenuItem
              v-for="lang in availableLanguages"
              :key="lang.value"
              @click="handleLanguageChange(lang.value)"
              :class="{
                'font-bold': currentLanguage === lang.value,
                'cursor-pointer': currentLanguage !== lang.value,
              }"
              class="language-item"
            >
              {{ lang.label }}
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu> -->
            </div>
        </nav>
    </header>
</template>
