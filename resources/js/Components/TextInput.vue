<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

const model = defineModel<string>({ required: true });

const props = defineProps<{
    error?: string;
}>();

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });

const inputClass = computed(() => [
    'block w-full rounded-[10px] border px-3 py-2.5 bg-white text-gray-medium',
    props.error ? 'border-red-brand' : 'border-gray-light',
]);
</script>

<template>
    <input :class="inputClass" v-model="model" ref="input" v-bind="$attrs" />
</template>
