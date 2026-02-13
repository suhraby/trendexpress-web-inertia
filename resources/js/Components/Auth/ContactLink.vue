<template>
    <div class="text-center">
        <span class="text-gray-medium"> {{ question }} </span>
        <a href="#" class="text-charcoal hover:text-red-brand">
            Get in touch with us
        </a>
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    question: string;
}>();
</script>
