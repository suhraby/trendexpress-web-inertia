<script lang="ts" setup>
// import { useLanguage } from '@/composables/useLanguage'
import SectionTitle from '@/components/Landing/SectionTitle.vue';
import type { SectionData } from '@/types/data';

// const { tApi } = useLanguage()

interface Props {
    data: SectionData;
}

defineProps<Props>();
</script>

<template>
    <div id="service" class="container-fluid py-10 md:py-20">
        <div
            class="bg-off-white rounded-3xl p-6 md:rounded-[52px] md:p-10 lg:p-16"
        >
            <SectionTitle
                :title="data.header?.en"
                span-class="text-red-brand"
                class="mb-6"
            />

            <h1 class="h1 mb-8 w-full xl:w-211.5">{{ data.title?.en }}</h1>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    class="rounded-[20px] bg-white px-6 py-5"
                    v-for="(item, key) in data.items"
                    :key="key"
                >
                    <div class="mb-6 h-30 w-30">
                        <img
                            :src="item.image"
                            :alt="item.title.en"
                            class="full-object-center"
                            loading="lazy"
                        />
                    </div>

                    <h3 class="h3 mb-2">{{ item.title.en }}</h3>

                    <div class="text-gray-medium">
                        {{ item.description?.en }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
