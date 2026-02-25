<template>
    <template v-if="isMobile">
        <div class="text-lg font-semibold">{{ $t('Language') }}</div>
        <div class="space-y-2">
            <a
                v-for="loc in locales"
                :key="loc.code"
                @click="switchLocale(loc.code, true)"
                :class="[
                    'bg-off-white w-full rounded-[10px] px-3 py-3 font-medium lg:w-auto',
                    currentLocale?.label === loc.label
                        ? 'text-red-brand flex flex-row justify-between'
                        : 'text-charcoal block',
                ]"
            >
                <span>{{ loc.label }}</span>
                <CheckIconRed v-show="currentLocale?.label === loc.label" />
            </a>
        </div>
    </template>

    <template v-else>
        <DropdownMenu :modal="false">
            <DropdownMenuTrigger
                class="inline-flex items-center justify-center w-full py-3 space-x-1 font-medium transition duration-300 cursor-pointer"
            >
                <GlobeIcon v-if="showIcon" />
                <span>{{ currentLocale?.label }}</span>
                <ChevronDownIcon />
            </DropdownMenuTrigger>
            <DropdownMenuContent
                class="px-2 font-medium border-none rounded-xl bg-white/20 backdrop-blur-md"
            >
                <DropdownMenuItem
                    v-for="loc in locales"
                    :key="loc.code"
                    @click="switchLocale(loc.code, false)"
                    :class="{
                        'font-bold': getActiveLanguage() === loc.code,
                        'cursor-pointer': getActiveLanguage() !== loc.code,
                    }"
                    class="language-item"
                >
                    {{ loc.label }}
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </template>
</template>

<script lang="ts" setup>
import CheckIconRed from '@/Components/Icons/CheckIconRed.vue';
import ChevronDownIcon from '@/Components/Icons/ChevronDownIcon.vue';
import GlobeIcon from '@/Components/Icons/GlobeIcon.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { useLocale } from '@/composables/useLocale';
import { LocaleKey } from '@/types/data';
import axios from 'axios';
import { getActiveLanguage, loadLanguageAsync } from 'laravel-vue-i18n';
import { computed } from 'vue';

const { lang, setLang } = useLocale();

withDefaults(
    defineProps<{
        showIcon?: boolean;
        isMobile?: boolean;
    }>(),
    {
        showIcon: true,
        isMobile: false,
    },
);

const emit = defineEmits<{
    switched: [];
}>();

const locales = [
    { code: 'en', label: 'English' },
    { code: 'tm', label: 'Turkmençe' },
    { code: 'ru', label: 'Русский' },
];

const currentLocale = computed(() =>
    locales.find((loc) => loc.code === lang.value),
);

const switchLocale = async (code: string, mobile: boolean = false) => {
    await loadLanguageAsync(code);
    setLang(code as LocaleKey);
    await axios.post(route('locale.switch'), { locale: code });
    if (mobile) emit('switched');
};
</script>
