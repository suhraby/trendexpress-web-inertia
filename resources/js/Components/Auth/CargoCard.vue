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
            <div class="rounded-xl bg-white p-3 text-base">
                <span class="text-gray-medium mb-2 block">Weight:</span>
                <span class="font-medium">{{ cargo.weight }}</span>
            </div>
            <div class="rounded-xl bg-white p-3 text-base">
                <span class="text-gray-medium mb-2 block">Created date:</span>
                <span class="font-medium">{{ cargo.created_at }}</span>
            </div>

            <div
                v-if="cargo.received_address"
                class="rounded-xl bg-white p-3 text-base"
            >
                <span class="text-gray-medium mb-2 block"
                    >Received address:</span
                >
                <span class="font-medium">{{ cargo.received_address }}</span>
            </div>

            <div class="rounded-xl bg-white p-3 text-base">
                <span class="text-gray-medium mb-2 block">Current status:</span>
                <span
                    class="font-sm bg-mint-green text-forest-green inline space-x-1 rounded-lg px-2 py-1 align-middle font-medium text-nowrap"
                >
                    <CheckIcon class="inline align-text-bottom" />
                    <!-- <span
                        v-html="cargo.current_status_icon"
                        class="inline align-text-bottom"
                    ></span> -->
                    <span>{{ cargo.current_status.en }}</span>
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
                            class="bg-red-brand flex h-10 w-10 items-center justify-center rounded-full"
                        ></div>

                        <div
                            v-else-if="
                                getStatusState(
                                    status.id,
                                    cargo.current_status_id,
                                ) === 'current'
                            "
                            class="border-red-brand flex h-10 w-10 items-center justify-center rounded-full border-2 bg-white"
                        >
                            <div
                                class="bg-red-brand h-7 w-7 rounded-full"
                            ></div>
                        </div>

                        <div
                            v-else
                            class="bg-gray-light h-10 w-10 rounded-full"
                        ></div>

                        <span
                            :class="
                                getStatusLabelClass(
                                    status.id,
                                    cargo.current_status_id,
                                )
                            "
                        >
                            {{ status.name.en }}
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
import CheckIcon from '@/Components/Icons/CheckIcon.vue';
import { CargoData, StatusData } from '@/types/data';
import { computed } from 'vue';
import FancyCargoImage from './FancyCargoImage.vue';

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
