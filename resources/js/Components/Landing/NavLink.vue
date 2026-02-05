<script lang="ts" setup>
interface Props {
  link: string
  context: string
}

defineProps<Props>()
</script>

<template>
  <a
    :href="link"
    class="block p-3 font-medium transition duration-300 lg:inline-block text-charcoal hover:text-gray-medium bg-off-white lg:bg-transparent rounded-[10px] w-full lg:w-auto text-left lg:text-center"
  >
    {{ context }}
  </a>
</template>
