<script lang="ts" setup>
interface Props {
    link: string;
}

defineProps<Props>();
</script>

<template>
    <a
        :href="link"
        class="text-charcoal hover:text-gray-medium bg-off-white block w-full rounded-[10px] p-3 text-left font-medium transition duration-300 lg:inline-block lg:w-auto lg:bg-transparent lg:text-center"
    >
        <slot></slot>
    </a>
</template>
