<template>
    <!-- <FilterForm :statuses @filter-change="handleFilterChange" /> -->
    <div class="mb-5 border-b border-gray-light">
        <h5 class="mb-4 h5">Filter by status</h5>

        <div class="mb-6 space-y-3 text-sm font-medium text-charcoal">
            <div class="flex items-center space-x-2">
                <label
                    for="all"
                    class="bg-off-white relative block w-full cursor-pointer rounded-[10px] py-2.5 pr-2.5 pl-10 leading-none"
                >
                    <!-- :model-value="isAllSelected"
                                @update:model-value="handleAllChange" -->
                    <Checkbox
                        id="all"
                        class="absolute -translate-y-1/2 top-1/2 left-3"
                    />
                    <span class="ms-2">All</span>
                </label>
            </div>

            <div v-for="(status, key) in statuses" :key>
                <div class="flex items-center space-x-2">
                    <label
                        :for="`status-${status.id}`"
                        class="bg-off-white relative flex w-full cursor-pointer flex-row items-center space-x-1 rounded-[10px] py-2.5 pr-2.5 pl-10 leading-none"
                    >
                        <!-- :model-value="
                                            isStatusSelected(status.id)
                                        "
                                        @update:model-value="
                                            (
                                                checked:
                                                    | boolean
                                                    | 'indeterminate',
                                            ) =>
                                                handleStatusChange(
                                                    status.id,
                                                    checked,
                                                )
                                        " -->
                        <Checkbox
                            :id="`status-${status.id}`"
                            class="absolute -translate-y-1/2 top-1/2 left-3"
                        />
                        <span v-html="status.icon"></span>

                        <span>{{ status.name.en }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-6 border-b border-gray-light">
        <h5 class="mb-4 h5">By created date</h5>
        <div class="mb-6 space-y-3 text-sm font-medium">
            <RadioGroup :default-value="sortOrder" orientation="vertical">
                <div class="flex items-center space-x-2">
                    <Label
                        for="desc"
                        class="bg-off-white relative block w-full cursor-pointer rounded-[10px] py-2.5 pr-2.5 pl-10 leading-none"
                    >
                        <RadioGroupItem
                            id="desc"
                            value="desc"
                            class="absolute -translate-y-1/2 top-1/2 left-3"
                        />
                        <span>Newest cargo first</span>
                    </Label>
                </div>
                <div class="flex items-center space-x-2">
                    <Label
                        for="asc"
                        class="bg-off-white relative block w-full cursor-pointer rounded-[10px] py-2.5 pr-2.5 pl-10 leading-none"
                    >
                        <RadioGroupItem
                            id="asc"
                            value="asc"
                            class="absolute -translate-y-1/2 top-1/2 left-3"
                        />
                        <span>Oldest cargo first</span>
                    </Label>
                </div>
            </RadioGroup>
        </div>
    </div>

    <div class="relative">
        <!-- v-model="searchQuery" // @keydown.enter="handleSearchSubmit" // @click="handleSearchSubmit" -->
        <input
            type="text"
            class="bg-off-white text-gray-medium w-full rounded-xl py-3.5 pr-12 pl-3 font-medium"
            placeholder="Enter barcode"
        />
        <button
            class="bg-charcoal absolute top-1/2 right-1 -translate-y-1/2 cursor-pointer rounded-lg p-1.5 text-white"
            type="button"
        >
            <ChevronRightIcon />
        </button>
    </div>
</template>

<script lang="ts" setup>
import ChevronRightIcon from '@/Components/Icons/ChevronRightIcon.vue';
import Checkbox from '@/Components/ui/checkbox/Checkbox.vue';
import { Label } from '@/Components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/Components/ui/radio-group';
import { StatusData } from '@/types/data';
import { ref } from 'vue';

const props = defineProps<{
    statuses: StatusData[];
}>();

const sortOrder = ref<'asc' | 'desc'>('desc');
</script>
