<script lang="ts" setup>
// import { useLanguage } from '@/composables/useLanguage'
import SectionTitle from '@/components/Landing/SectionTitle.vue';
import type { SectionData } from '@/types/data';

// const { tApi } = useLanguage();

interface Props {
    data: SectionData;
}

defineProps<Props>();
</script>

<template>
    <div id="about" class="container-fluid py-10 md:py-20">
        <div class="flex flex-col space-y-10 xl:flex-row xl:space-y-0">
            <div
                class="3xl:w-[calc(100%-948px)] relative w-full xl:w-[calc(100%-812px)] 2xl:w-[calc(100%-736px)]"
            >
                <SectionTitle
                    :title="data.header?.en"
                    span-class="text-red-brand"
                    class="mb-8"
                />

                <div
                    class="static max-w-70 space-y-4 font-medium md:max-w-75 xl:absolute xl:bottom-0 xl:left-0"
                >
                    <div
                        class="bg-off-white flex space-x-3 rounded-[40px] text-base md:text-lg"
                        v-for="(item, key) in data.items"
                        :key="key"
                    >
                        <span
                            class="bg-red-brand flex h-12 w-12 items-center justify-center rounded-full text-white"
                            >{{ key + 1 }}</span
                        >
                        <span class="py-2.5 pr-4">{{ item.title.en }}</span>
                    </div>
                </div>
            </div>

            <div class="3xl:w-237 w-full xl:w-203 2xl:w-184">
                <h1 class="h1 mb-3">{{ data.title?.en }}</h1>
                <div
                    class="text-gray-medium mb-10 text-xl"
                    v-html="data.description?.en"
                ></div>

                <div
                    class="h-36 overflow-hidden rounded-3xl md:h-76 lg:h-86 xl:h-100 2xl:h-83"
                >
                    <img
                        :src="data.image"
                        :alt="data.title?.en"
                        loading="lazy"
                        class="full-object-center"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
