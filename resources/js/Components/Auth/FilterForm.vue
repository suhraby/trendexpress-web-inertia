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
                    <Checkbox
                        id="all"
                        class="absolute -translate-y-1/2 top-1/2 left-3"
                        :model-value="isAllSelected"
                        @update:model-value="handleAllStatuses"
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
                            :model-value="isStatusSelected(status.id)"
                            @update:model-value="
                                (checked: boolean | 'indeterminate') =>
                                    handleStatusChange(status.id, checked)
                            "
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
            <RadioGroup
                :default-value="sortOrder"
                orientation="vertical"
                @update:model-value="handleSortOrderChange"
            >
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
        <input
            type="text"
            class="bg-off-white text-gray-medium w-full rounded-xl py-3.5 pr-12 pl-3 font-medium"
            placeholder="Enter barcode"
            v-model="searchQuery"
            @keydown.enter="handleSearchSubmit"
        />
        <button
            class="bg-charcoal absolute top-1/2 right-1 -translate-y-1/2 cursor-pointer rounded-lg p-1.5 text-white"
            type="button"
            @click="handleSearchSubmit"
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
import { computed, nextTick, ref, watch } from 'vue';

const selectedStatusIds = ref<number[]>([]);
const isAllSelected = ref<boolean>(true);
const sortOrder = ref<'asc' | 'desc'>('desc');
const searchQuery = ref<string>('');
let searchTimeout: ReturnType<typeof setTimeout> | null = null;

const props = defineProps<{
    statuses: StatusData[];
}>();

const emit = defineEmits<{
    filterChange: [
        filters: {
            statusIds: number[];
            sortOrder: 'asc' | 'desc';
            search: string;
        },
    ];
}>();

// status methods start
const allStatusIds = computed(() => props.statuses.map((status) => status.id));

// console.log(allStatusIds.value);

const handleStatusChange = (
    statusId: number,
    checked: boolean | 'indeterminate',
) => {
    if (checked) {
        if (!selectedStatusIds.value.includes(statusId)) {
            selectedStatusIds.value.push(statusId);
        }
    } else {
        selectedStatusIds.value = selectedStatusIds.value.filter(
            (id) => id !== statusId,
        );
    }

    nextTick(() => {
        emitFilterChange();
    });
};

const handleAllStatuses = (checked: boolean | 'indeterminate') => {
    const isChecked = checked === true;
    isAllSelected.value = isChecked;

    if (checked) {
        selectedStatusIds.value = [];
    }

    nextTick(() => {
        emitFilterChange();
    });
};
// end

const handleSortOrderChange = (value: string) => {
    sortOrder.value = value as 'asc' | 'desc';
};

const handleSearchSubmit = () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
        searchTimeout = null;
    }

    emitFilterChange();
};

const emitFilterChange = () => {
    const filters = {
        statusIds: isAllSelected.value ? [] : selectedStatusIds.value,
        sortOrder: sortOrder.value,
        search: searchQuery.value.trim(),
    };
    emit('filterChange', filters);
};

const isStatusSelected = (statusId: number) => {
    return selectedStatusIds.value.includes(statusId);
};

watch(
    selectedStatusIds,
    (newSelectedIds) => {
        if (newSelectedIds.length === 0) {
            isAllSelected.value = true;
        } else if (newSelectedIds.length === allStatusIds.value.length) {
            isAllSelected.value = true;
        } else {
            isAllSelected.value = false;
        }
    },
    { deep: true },
);

watch(isAllSelected, (newIsAllSelected) => {
    if (newIsAllSelected) {
        selectedStatusIds.value = [];
    }
});

watch(sortOrder, () => {
    nextTick(() => {
        emitFilterChange();
    });
});

watch(searchQuery, () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(() => {
        emitFilterChange();
    }, 300);
});
</script>
