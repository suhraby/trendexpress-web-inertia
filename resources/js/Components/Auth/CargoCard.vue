<template>
    <div class="bg-off-white relative rounded-[20px] px-5 pt-5 pb-5 lg:pt-8">
        <div class="mb-3 text-lg font-bold lg:mb-7 lg:text-xl">
            # {{ cargo.number }}
        </div>

        <div
            :class="[
                'mb-3 grid grid-cols-2 gap-2 lg:gap-3',
                cargo.received_address ? 'xl:grid-cols-4' : 'xl:grid-cols-3',
            ]"
        >
            <div class="p-3 text-base bg-white rounded-xl">
                <span class="block mb-2 text-gray-medium">
                    {{ $t('Weight') }}:
                </span>
                <span class="font-medium">{{ cargo.weight }}</span>
            </div>
            <div class="p-3 text-base bg-white rounded-xl">
                <span class="block mb-2 text-gray-medium">
                    {{ $t('Created date') }}:
                </span>
                <span class="font-medium">{{ cargo.created_at }}</span>
            </div>

            <div
                v-if="cargo.received_address"
                class="p-3 text-base bg-white rounded-xl"
            >
                <span class="block mb-2 text-gray-medium">
                    {{ $t('Received address') }}:
                </span>
                <span class="font-medium">{{ cargo.received_address }}</span>
            </div>

            <div class="p-3 text-base bg-white rounded-xl">
                <span class="block mb-2 text-gray-medium">
                    {{ $t('Current status') }}:
                </span>
                <span
                    class="inline-flex flex-row px-2 py-1 space-x-1 font-medium align-middle rounded-lg font-sm bg-mint-green text-forest-green text-nowrap"
                >
                    <span
                        v-html="cargo.current_status_icon"
                        class="inline align-text-bottom"
                    ></span>
                    <span>{{ cargo.current_status[lang] }}</span>
                </span>
            </div>
        </div>

        <div class="mb-4 rounded-[20px] bg-white p-6 lg:mb-0">
            <div
                class="flex flex-col items-start space-y-1.5 lg:flex-row lg:items-center lg:space-y-0 lg:space-x-4"
            >
                <div
                    v-for="(status, key) in statuses"
                    :key
                    :class="{
                        'flex flex-1 flex-col space-y-1.5 lg:flex-row lg:space-x-2':
                            key !== statuses.length - 1,
                    }"
                >
                    <div
                        class="flex flex-row items-center space-x-2 lg:flex-col lg:space-y-2 lg:space-x-0"
                    >
                        <div
                            v-if="
                                getStatusState(
                                    status.id,
                                    cargo.current_status_id,
                                ) === 'completed'
                            "
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-red-brand"
                        ></div>

                        <div
                            v-else-if="
                                getStatusState(
                                    status.id,
                                    cargo.current_status_id,
                                ) === 'current'
                            "
                            class="flex items-center justify-center w-10 h-10 bg-white border-2 rounded-full border-red-brand"
                        >
                            <div
                                class="rounded-full bg-red-brand h-7 w-7"
                            ></div>
                        </div>

                        <div
                            v-else
                            class="w-10 h-10 rounded-full bg-gray-light"
                        ></div>

                        <span
                            :class="
                                getStatusLabelClass(
                                    status.id,
                                    cargo.current_status_id,
                                )
                            "
                        >
                            {{ status.name[lang] }}
                        </span>
                    </div>

                    <div
                        v-if="
                            getStatusState(
                                status.id,
                                cargo.current_status_id,
                            ) === 'completed' && key !== statuses.length - 1
                        "
                        class="bg-red-brand ml-4.5 h-6 w-1 lg:mt-5 lg:ml-0 lg:h-1 lg:w-0 lg:flex-1"
                    ></div>

                    <div
                        v-if="
                            getStatusState(
                                status.id,
                                cargo.current_status_id,
                            ) !== 'completed' && key !== statuses.length - 1
                        "
                        class="bg-gray-light ml-4.5 h-6 w-1 lg:mt-5 lg:ml-0 lg:h-1 lg:w-0 lg:flex-1"
                    ></div>
                </div>
            </div>
        </div>

        <div class="lg:absolute lg:top-8.75 lg:right-5">
            <FancyCargoImage :images="cargo.images" :cargoIndex />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useLocale } from '@/composables/useLocale';
import { CargoData, StatusData } from '@/types/data';
import { computed } from 'vue';
import FancyCargoImage from './FancyCargoImage.vue';

const { lang } = useLocale();

defineProps<{
    cargo: CargoData;
    statuses: StatusData[];
    cargoIndex: number;
}>();

type StatusState = 'completed' | 'current' | 'pending';

const getStatusLabelClass = computed(() => {
    return (statusId: number, currentStatusId: number): string => {
        const state = getStatusState(statusId, currentStatusId);
        const baseClass = 'text-base font-medium';

        if (state === 'completed' || state === 'current') {
            return `${baseClass} text-charcoal`;
        } else {
            return `${baseClass} text-gray-medium`;
        }
    };
});

const getStatusState = (
    statusId: number,
    currentStatusId: number,
): StatusState => {
    if (statusId < currentStatusId) {
        return 'completed';
    } else if (statusId === currentStatusId) {
        return 'current';
    } else {
        return 'pending';
    }
};
</script>

<style scoped>
svg {
    display: inline !important;
}
</style>
