<script lang="ts" setup>
// import { useLanguage } from '@/composables/useLanguage'
// import type { ContactInfoData, MessageCredentials, SectionData } from '@/types/data'
import SectionTitle from '@/components/Landing/SectionTitle.vue';
import type { ContactInfoData, SectionData } from '@/types/data';
// import { useMessage } from '@/composables/useMessage'
// import { toast } from 'vue-sonner'

// const { t, tApi } = useLanguage()

interface Props {
    data: SectionData;
    contactData: ContactInfoData[];
}

defineProps<Props>();

// const { resCode, loading, error, postMessage } = useMessage()

// const form = ref<MessageCredentials>({
//   name: '',
//   surname: '',
//   email: '',
//   phone_number: '',
//   body: '',
// })

// const isFormValid = computed(
//   () =>
//     form.value.name.trim() !== '' &&
//     form.value.surname.trim() !== '' &&
//     form.value.email.trim() !== '' &&
//     form.value.phone_number.trim() !== '' &&
//     form.value.body.trim() !== '',
// )

// const handleSubmit = async (): Promise<void> => {
//   if (!isFormValid.value) return

//   try {
//     await postMessage(form.value)

//     form.value = {
//       name: '',
//       surname: '',
//       email: '',
//       phone_number: '',
//       body: '',
//     }

//     if (resCode.value === 201) {
//       toast(t('common.message_send_successfully'), {
//         description: t('common.thanks_message'),
//         action: {
//           label: 'OK',
//           onClick: () => console.log('Message toasted'),
//         },
//       })
//     }
//   } catch (err) {
//     console.error('Failed to send message :', err)
//   }
// }
</script>

<template>
    <div id="contact" class="container-fluid py-10 md:py-20">
        <div
            class="flex flex-col justify-between space-y-10 lg:flex-row lg:space-y-0"
        >
            <div class="relative w-full">
                <SectionTitle
                    :title="data.header?.en"
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
                            <span>{{ contact.value_localization.en }}</span>
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
                    v-html="data.description?.en"
                ></h1>

                <!-- <div v-if="error" class="error-message">{{ error }}</div> -->

                <!-- @submit.prevent="handleSubmit" -->
                <form>
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <!-- v-model="form.name" :disabled="loading" -->
                            <input
                                type="text"
                                name="name"
                                class="bg-off-white text-gray-medium w-full rounded-xl p-3 font-medium"
                                placeholder="Name"
                                required
                            />
                        </div>

                        <div>
                            <input
                                type="text"
                                name="surname"
                                class="bg-off-white text-gray-medium w-full rounded-xl p-3 font-medium"
                                placeholder="Surname"
                                required
                            />
                        </div>

                        <div>
                            <input
                                type="email"
                                name="email"
                                class="bg-off-white text-gray-medium w-full rounded-xl p-3 font-medium"
                                placeholder="Email"
                                required
                            />
                        </div>

                        <div>
                            <input
                                type="tel"
                                name="phone_number"
                                class="bg-off-white text-gray-medium w-full rounded-xl p-3 font-medium"
                                placeholder="Phone number"
                                required
                            />
                        </div>

                        <div class="col-span-2">
                            <textarea
                                name="body"
                                class="bg-off-white text-gray-medium min-h-33.5 w-full resize-none rounded-xl p-3 font-medium"
                                placeholder="Your message"
                            ></textarea>
                        </div>
                    </div>

                    <!-- :disabled="loading" -->
                    <button
                        type="submit"
                        class="bg-red-brand cursor-pointer rounded-xl px-6 py-3 text-sm text-white xl:text-base"
                    >
                        <span class="inline-block font-semibold">
                            Send message
                        </span>
                        <span class="ml-4 inline-block align-middle">
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
