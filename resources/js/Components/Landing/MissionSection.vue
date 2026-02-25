<script lang="ts" setup>
import SectionTitle from '@/Components/Landing/SectionTitle.vue';
import { useLocale } from '@/composables/useLocale';
import type { SectionData } from '@/types/data';

const { lang } = useLocale();

interface Props {
    data: SectionData | undefined;
}

defineProps<Props>();
</script>

<template>
    <div id="mission" class="py-10 container-fluid md:py-20">
        <div
            class="bg-charcoal relative overflow-hidden rounded-3xl p-6 text-white md:rounded-[52px] md:p-16"
        >
            <SectionTitle
                :title="data?.header?.[lang]"
                span-class="text-white"
                class="mb-5"
            />

            <h1 class="w-full mb-20 h1 xl:w-1/2 2xl:w-2/5">
                {{ data?.title?.[lang] }}
            </h1>

            <div class="grid grid-cols-1 gap-10 mb-20 md:grid-cols-3 xl:mb-0">
                <div v-for="(item, key) in data?.items" :key="key">
                    <div
                        class="inline-block p-3 mb-4 bg-red-brand rounded-xl"
                        v-html="item.icon"
                    ></div>

                    <h3 class="h3">{{ item.title?.[lang] }}</h3>

                    <div class="text-gray-medium">
                        {{ item.description?.[lang] }}
                    </div>
                </div>
            </div>

            <div
                class="h-56.5 w-full md:h-113.5 lg:h-132 xl:absolute xl:top-0 xl:right-0 xl:h-120.75 xl:w-150.5"
            >
                <img
                    :src="data?.image"
                    :alt="data?.title?.[lang]"
                    loading="lazy"
                    class="full-object-center"
                />
            </div>
        </div>
    </div>
</template>
