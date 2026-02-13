<script lang="ts" setup>
import SectionTitle from '@/Components/Landing/SectionTitle.vue';
import type { SectionData } from '@/types/data';
// import { useLanguage } from '@/composables/useLanguage'

// const { tApi } = useLanguage();

interface Props {
    data: SectionData | undefined;
}

defineProps<Props>();
</script>

<template>
    <div id="mission" class="container-fluid py-10 md:py-20">
        <div
            class="bg-charcoal relative overflow-hidden rounded-3xl p-6 text-white md:rounded-[52px] md:p-16"
        >
            <SectionTitle
                :title="data?.header?.en"
                span-class="text-white"
                class="mb-5"
            />

            <h1 class="h1 mb-20 w-full xl:w-1/2 2xl:w-2/5">
                {{ data?.title?.en }}
            </h1>

            <div class="mb-20 grid grid-cols-1 gap-10 md:grid-cols-3 xl:mb-0">
                <div v-for="(item, key) in data?.items" :key="key">
                    <div
                        class="bg-red-brand mb-4 inline-block rounded-xl p-3"
                        v-html="item.icon"
                    ></div>

                    <h3 class="h3">{{ item.title?.en }}</h3>

                    <div class="text-gray-medium">
                        {{ item.description?.en }}
                    </div>
                </div>
            </div>

            <div
                class="h-56.5 w-full md:h-113.5 lg:h-132 xl:absolute xl:top-0 xl:right-0 xl:h-120.75 xl:w-150.5"
            >
                <img
                    :src="data?.image"
                    :alt="data?.title?.en"
                    loading="lazy"
                    class="full-object-center"
                />
            </div>
        </div>
    </div>
</template>
