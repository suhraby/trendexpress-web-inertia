<script lang="ts" setup>
import SectionTitle from '@/Components/Landing/SectionTitle.vue';
import { useLocale } from '@/composables/useLocale';
import type { SectionData } from '@/types/data';

const { lang } = useLocale();

interface Props {
    data: SectionData;
}

defineProps<Props>();
</script>

<template>
    <div id="service" class="py-10 container-fluid md:py-20">
        <div
            class="bg-off-white rounded-3xl p-6 md:rounded-[52px] md:p-10 lg:p-16"
        >
            <SectionTitle
                :title="data.header?.[lang]"
                span-class="text-red-brand"
                class="mb-6"
            />

            <h1 class="h1 mb-8 w-full xl:w-211.5">{{ data.title?.[lang] }}</h1>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    class="rounded-[20px] bg-white px-6 py-5"
                    v-for="(item, key) in data.items"
                    :key="key"
                >
                    <div class="mb-6 h-30 w-30">
                        <img
                            :src="item.image"
                            :alt="item.title[lang]"
                            class="full-object-center"
                            loading="lazy"
                        />
                    </div>

                    <h3 class="mb-2 h3">{{ item.title[lang] }}</h3>

                    <div class="text-gray-medium">
                        {{ item.description?.[lang] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
