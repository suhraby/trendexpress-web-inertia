<script lang="ts" setup>
// import { useLanguage } from '@/composables/useLanguage'
import ArrowRightIcon from '@/Components/Icons/ArrowRightIcon.vue';
import ArrowUpRightIcon from '@/Components/Icons/ArrowUpRightIcon.vue';
import PinIcon from '@/Components/Icons/PinIcon.vue';
import type { SectionData } from '@/types/section';

// const { tApi } = useLanguage()

interface Props {
    data: SectionData | undefined;
}

defineProps<Props>();
</script>

<template>
    <div
        id="hero"
        class="2x:py-[154px] relative pt-15 md:pt-0 lg:pt-33.5 lg:pb-20"
    >
        <div
            id="img-wrapper"
            class="h-100 w-full md:h-170 lg:absolute lg:top-0 lg:right-0 lg:w-223.75 xl:h-179.75 xl:w-269.75 2xl:top-15 2xl:right-25 2xl:h-180 2xl:w-5xl"
        >
            <img
                :src="data?.image"
                :alt="data?.title?.en"
                loading="lazy"
                class="h-full w-full object-cover object-bottom-left"
            />
        </div>

        <div class="container-fluid">
            <div
                class="bg-off-white relative -top-16 z-10 rounded-3xl p-8 md:-top-25 lg:top-auto lg:w-102.75"
            >
                <h2 class="h2 mb-3">{{ data?.title?.en }}</h2>

                <div
                    class="text-gray-medium mb-4"
                    v-html="data?.description?.en"
                ></div>

                <div class="mb-6 flex space-x-7 font-medium text-nowrap">
                    <div
                        class="flex space-x-2"
                        v-for="(item, key) in data?.items"
                        :key="key"
                    >
                        <span v-html="item.icon"> </span>
                        <span>{{ item.title?.en }}</span>
                    </div>
                </div>

                <div class="inline-flex">
                    <a
                        href="sectionData.button_link"
                        class="bg-charcoal rounded-xl px-6 py-3 text-sm text-white xl:text-base"
                    >
                        <span class="inline-block font-semibold">
                            {{ data?.button_text?.en }}
                        </span>
                        <span class="ml-4 inline-block align-middle">
                            <ArrowUpRightIcon />
                        </span>
                    </a>
                </div>

                <hr class="text-gray-light my-8 w-full md:w-1/2 lg:w-full" />

                <h3
                    class="h3 mb-6 w-full md:w-2/5 lg:w-full xl:w-2/5 2xl:w-full"
                >
                    {{ data?.search_label?.en }}
                </h3>

                <form id="search-form" action="" class="relative">
                    <span class="text-red-brand absolute top-3.25 left-3">
                        <PinIcon />
                    </span>
                    <input
                        type="text"
                        class="placeholder-gray-medium focus-visible:outline-red-brand w-full rounded-xl bg-white py-3 pr-28 pl-10 text-sm transition-all duration-150 2xl:text-base"
                        :placeholder="data?.search_placeholder?.en"
                    />
                    <button
                        class="bg-red-brand absolute top-1 right-1 flex items-center space-x-1 rounded-lg px-4 py-2 text-sm font-medium text-white xl:text-base"
                    >
                        <span>{{ data?.search_button_text?.en }}</span>
                        <span>
                            <ArrowRightIcon />
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
