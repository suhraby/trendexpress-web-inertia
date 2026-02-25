<template if-show="data">
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
                :alt="data?.title?.[lang]"
                loading="lazy"
                class="object-cover w-full h-full object-bottom-left"
            />
        </div>

        <div class="container-fluid">
            <div
                class="bg-off-white relative -top-16 z-10 rounded-3xl p-8 md:-top-25 lg:top-auto lg:w-102.75"
            >
                <h2 class="mb-3 h2">{{ data?.title?.[lang] }}</h2>

                <div
                    class="mb-4 text-gray-medium"
                    v-html="data?.description?.[lang]"
                ></div>

                <div class="flex mb-6 font-medium space-x-7 text-nowrap">
                    <div
                        class="flex space-x-2"
                        v-for="(item, key) in data?.items"
                        :key="key"
                    >
                        <span v-html="item.icon"> </span>
                        <span>{{ item.title[lang] }}</span>
                    </div>
                </div>

                <div class="inline-flex">
                    <a
                        href="sectionData.button_link"
                        class="px-6 py-3 text-sm text-white bg-charcoal rounded-xl xl:text-base"
                    >
                        <span class="inline-block font-semibold">
                            {{ data?.button_text?.[lang] }}
                        </span>
                        <span class="inline-block ml-4 align-middle">
                            <ArrowUpRightIcon />
                        </span>
                    </a>
                </div>

                <hr class="w-full my-8 text-gray-light md:w-1/2 lg:w-full" />

                <h3
                    class="w-full mb-6 h3 md:w-2/5 lg:w-full xl:w-2/5 2xl:w-full"
                >
                    {{ data?.search_label?.[lang] }}
                </h3>

                <form
                    id="search-form"
                    class="relative"
                    @submit.prevent="onSubmit"
                >
                    <span class="text-red-brand absolute top-3.25 left-3">
                        <PinIcon />
                    </span>
                    <input
                        type="text"
                        class="w-full py-3 pl-10 text-sm transition-all duration-150 bg-white placeholder-gray-medium focus-visible:outline-red-brand rounded-xl pr-28 2xl:text-base"
                        :placeholder="data?.search_placeholder?.[lang]"
                        v-model="form.search"
                        @keydown.enter="onSubmit"
                    />
                    <button
                        class="absolute flex items-center px-4 py-2 space-x-1 text-sm font-medium text-white rounded-lg bg-red-brand top-1 right-1 xl:text-base"
                        @click="onSubmit"
                    >
                        <span>{{ data?.search_button_text?.[lang] }}</span>
                        <span>
                            <ArrowRightIcon />
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import ArrowRightIcon from '@/Components/Icons/ArrowRightIcon.vue';
import ArrowUpRightIcon from '@/Components/Icons/ArrowUpRightIcon.vue';
import PinIcon from '@/Components/Icons/PinIcon.vue';
import { useLocale } from '@/composables/useLocale';
import type { SectionData } from '@/types/data';
import { router, useForm } from '@inertiajs/vue3';

const { lang } = useLocale();
const form = useForm({
    search: '',
});

interface Props {
    data: SectionData | undefined;
}

defineProps<Props>();

const onSubmit = () => {
    router.get(
        route('dashboard'),
        { search: form.search },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>
