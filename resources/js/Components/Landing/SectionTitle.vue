<script lang="ts" setup>
import DiamondSignIcon from '@/Components/Icons/DiamondSignIcon.vue';

defineProps<{
    title: string | undefined;
    spanClass?: string;
}>();
</script>

<template>
    <div class="flex items-center space-x-2">
        <span :class="spanClass">
            <DiamondSignIcon />
        </span>
        <span class="text-lg font-medium">{{ title }}</span>
    </div>
</template>
