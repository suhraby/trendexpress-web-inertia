<template>
    <a
        @click="showItemImages(images)"
        class="bg-charcoal flex cursor-pointer items-center justify-center rounded-xl px-6 py-3.75 text-sm font-semibold text-white lg:inline 2xl:py-4 2xl:text-base"
    >
        <ImageIcon class="inline mr-1" />
        <span class="align-middle">
            {{ $t('See all images') }} ({{ images.length }})
        </span>
    </a>
    <div class="hidden">
        <template v-for="(image, key) in images" :key>
            <a :href="image.src" :data-fancybox="`item-${cargoIndex}-images`">
                <img
                    :src="image.src"
                    :alt="`item-${cargoIndex} image ${key + 1}`"
                />
            </a>
        </template>
    </div>
</template>

<script lang="ts" setup>
import ImageIcon from '@/Components/Icons/ImageIcon.vue';
import { CargoImageData } from '@/types/data';
import { Fancybox } from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';
import { onMounted, onUnmounted } from 'vue';

defineProps<{
    images: CargoImageData[];
    cargoIndex: number;
}>();

const showItemImages = (images: CargoImageData[]): void => {
    const imageSlides = images.map((image) => ({
        src: image.src,
        thumb: image.src,
    }));

    Fancybox.show(imageSlides, {
        infinite: true,
        Toolbar: {
            display: {
                left: ['infobar'],
                middle: ['zoomIn', 'zoomOut', 'toggle1to1', 'rotateCW'],
                right: ['slideshow', 'thumbs', 'close'],
            },
        },
        Thumbs: {
            autoStart: true,
        },
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } as any); // Type assertion
};

onMounted(() => {
    // Bind Fancybox to all gallery groups
    Fancybox.bind('[data-fancybox]', {
        Toolbar: {
            display: {
                left: ['infobar'],
                middle: [
                    'zoomIn',
                    'zoomOut',
                    'toggle1to1',
                    'rotateCW',
                    'rotateCCW',
                    'flipX',
                    'flipY',
                ],
                right: ['slideshow', 'thumbs', 'close'],
            },
        },
        Thumbs: {
            autoStart: true,
        },
        animated: true,
        hideScrollbar: true,
        infinite: true,
        keyboard: {
            Escape: 'close',
            Delete: 'close',
            Backspace: 'close',
            PageUp: 'next',
            PageDown: 'prev',
            ArrowUp: 'prev',
            ArrowDown: 'next',
            ArrowRight: 'next',
            ArrowLeft: 'prev',
        },
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } as any); // Type assertion
});

onUnmounted(() => {
    Fancybox.destroy();
});
</script>
