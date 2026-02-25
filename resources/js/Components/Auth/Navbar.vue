<template>
    <header class="text-sm border-b border-gray-light">
        <nav
            class="flex flex-col flex-wrap items-center py-6 space-y-2 container-auth sm:flex-row sm:justify-between sm:space-y-0"
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
                <SwitchLocale />
            </div>
        </nav>
    </header>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import SwitchLocale from '../SwitchLocale.vue';
</script>
