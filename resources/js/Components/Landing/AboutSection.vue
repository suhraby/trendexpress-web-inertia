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
    <div id="about" class="py-10 container-fluid md:py-20">
        <div class="flex flex-col space-y-10 xl:flex-row xl:space-y-0">
            <div
                class="3xl:w-[calc(100%-948px)] relative w-full xl:w-[calc(100%-812px)] 2xl:w-[calc(100%-736px)]"
            >
                <SectionTitle
                    :title="data.header?.[lang]"
                    span-class="text-red-brand"
                    class="mb-8"
                />

                <div
                    class="static space-y-4 font-medium max-w-70 md:max-w-75 xl:absolute xl:bottom-0 xl:left-0"
                >
                    <div
                        class="bg-off-white flex space-x-3 rounded-[40px] text-base md:text-lg"
                        v-for="(item, key) in data.items"
                        :key="key"
                    >
                        <span
                            class="flex items-center justify-center w-12 h-12 text-white rounded-full bg-red-brand"
                            >{{ key + 1 }}</span
                        >
                        <span class="py-2.5 pr-4">{{ item.title[lang] }}</span>
                    </div>
                </div>
            </div>

            <div class="w-full 3xl:w-237 xl:w-203 2xl:w-184">
                <h1 class="mb-3 h1">{{ data.title?.[lang] }}</h1>
                <div
                    class="mb-10 text-xl text-gray-medium"
                    v-html="data.description?.[lang]"
                ></div>

                <div
                    class="overflow-hidden h-36 rounded-3xl md:h-76 lg:h-86 xl:h-100 2xl:h-83"
                >
                    <img
                        :src="data.image"
                        :alt="data.title?.[lang]"
                        loading="lazy"
                        class="full-object-center"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
