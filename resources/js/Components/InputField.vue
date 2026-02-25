<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

const model = defineModel<string>({ required: true });

const props = defineProps<{
    error?: string;
    multiline?: boolean;
}>();

const input = ref<HTMLInputElement | HTMLTextAreaElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });

const inputClass = computed(() => [
    'border w-full p-3 font-medium bg-off-white text-gray-medium rounded-xl',
    props.multiline ? 'min-h-33.5 resize-none' : '',
    props.error ? 'border-red-brand' : 'border-off-white',
]);
</script>

<template>
    <textarea
        v-if="multiline"
        :class="inputClass"
        v-model="model"
        ref="input"
        v-bind="$attrs"
    />
    <input
        v-else
        :class="inputClass"
        v-model="model"
        ref="input"
        v-bind="$attrs"
    />
</template>
