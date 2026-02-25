import type { LocaleKey } from '@/types/data';
import { getActiveLanguage } from 'laravel-vue-i18n';
import { ref } from 'vue';

const lang = ref<LocaleKey>(getActiveLanguage() as LocaleKey);

export function useLocale() {
    const setLang = (code: LocaleKey) => {
        lang.value = code;
    };

    return { lang, setLang };
}
