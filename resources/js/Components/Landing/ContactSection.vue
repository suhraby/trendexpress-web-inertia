<template>
    <div id="contact" class="py-10 container-fluid md:py-20">
        <div
            class="flex flex-col justify-between space-y-10 lg:flex-row lg:space-y-0"
        >
            <div class="relative w-full">
                <SectionTitle
                    :title="data.header?.[lang]"
                    span-class="text-red-brand"
                    class="mb-6"
                />

                <div
                    class="static space-y-6 font-medium lg:absolute lg:bottom-0 lg:left-0"
                >
                    <div v-for="(contact, key) in contactData" :key>
                        <div
                            class="flex items-center space-x-2"
                            v-if="contact.type === 'address'"
                        >
                            <span v-html="contact.icon"></span>
                            <span>{{ contact.value_localization[lang] }}</span>
                        </div>

                        <div
                            class="flex items-center space-x-2"
                            v-if="contact.type === 'email'"
                        >
                            <a
                                :href="`mailto:${contact.value}`"
                                target="_blank"
                                class="flex items-center space-x-2"
                            >
                                <span v-html="contact.icon"></span>
                                <span>{{ contact.value }}</span>
                            </a>
                        </div>

                        <div
                            class="flex items-center space-x-2"
                            v-if="contact.type === 'phone'"
                        >
                            <a
                                :href="`tel:${contact.value}`"
                                target="_blank"
                                class="flex items-center space-x-2"
                            >
                                <span v-html="contact.icon"></span>
                                <span>{{ contact.value }}</span>
                            </a>
                        </div>

                        <div
                            class="flex items-center space-x-2"
                            v-if="
                                contact.type === 'instagram' ||
                                contact.type === 'whatsapp'
                            "
                        >
                            <a
                                :href="contact.value"
                                target="_blank"
                                class="flex items-center space-x-2"
                            >
                                <span v-html="contact.icon"></span>
                                <span>{{ contact.context }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-163.75">
                <h1
                    class="h1 mb-8 w-full md:w-127.5"
                    v-html="data.description?.[lang]"
                ></h1>

                <form @submit.prevent="onSubmit">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <InputField
                                type="text"
                                name="surname"
                                v-model="form.surname"
                                :error="form.errors.surname"
                                :placeholder="$t('Surname')"
                                required
                            />
                            <InputError :message="form.errors.surname" />
                        </div>

                        <div>
                            <InputField
                                type="text"
                                name="name"
                                v-model="form.name"
                                :error="form.errors.name"
                                :placeholder="$t('Name')"
                                required
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div>
                            <InputField
                                type="email"
                                name="email"
                                v-model="form.email"
                                :error="form.errors.email"
                                :placeholder="$t('Email')"
                                required
                            />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div>
                            <InputField
                                type="tel"
                                name="phone_number"
                                v-model="form.phone_number"
                                :error="form.errors.phone_number"
                                :placeholder="$t('Phone number')"
                                required
                            />
                            <InputError :message="form.errors.phone_number" />
                        </div>

                        <div class="col-span-2">
                            <InputField
                                name="body"
                                v-model="form.body"
                                :error="form.errors.body"
                                :multiline="true"
                                :placeholder="$t('Your message')"
                            />
                            <InputError :message="form.errors.body" />
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="px-6 py-3 text-sm text-white cursor-pointer bg-red-brand rounded-xl xl:text-base"
                    >
                        <span class="inline-block font-semibold">
                            {{
                                form.processing
                                    ? $t('Saving...')
                                    : $t('Send message')
                            }}
                        </span>
                        <span class="inline-block ml-4 align-middle">
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M5.3335 4.16671C5.3335 3.70647 5.70659 3.33337 6.16683 3.33337H11.8335C12.2938 3.33337 12.6668 3.70647 12.6668 4.16671V9.83337C12.6668 10.2936 12.2938 10.6667 11.8335 10.6667C11.3732 10.6667 11.0002 10.2936 11.0002 9.83337V6.17855L4.75608 12.4226C4.43065 12.748 3.90301 12.748 3.57758 12.4226C3.25214 12.0972 3.25214 11.5696 3.57758 11.2441L9.82163 5.00004H6.16683C5.70659 5.00004 5.3335 4.62695 5.3335 4.16671Z"
                                    fill="white"
                                />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import SectionTitle from '@/Components/Landing/SectionTitle.vue';
import { useLocale } from '@/composables/useLocale';
import type { ContactInfoData, SectionData } from '@/types/data';
import { useForm } from '@inertiajs/vue3';
import InputError from '../InputError.vue';
import InputField from '../InputField.vue';

const { lang } = useLocale();

const form = useForm({
    name: '',
    surname: '',
    email: '',
    phone_number: '',
    body: '',
});

interface Props {
    data: SectionData;
    contactData: ContactInfoData[];
}

defineProps<Props>();

const onSubmit = () => {
    form.post(route('message'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
