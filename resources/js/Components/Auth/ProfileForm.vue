<template>
    <form @submit.prevent="submit">
        <div class="mb-4">
            <InputLabel for="surname" :value="$t('Your surname')" required />
            <TextInput
                id="surname"
                type="text"
                v-model="form.surname"
                :error="form.errors.surname"
                :placeholder="$t('Enter your surname')"
                required
            />
            <InputError :message="form.errors.surname" />
        </div>

        <div class="mb-4">
            <InputLabel for="name" :value="$t('Your name')" required />
            <TextInput
                id="name"
                type="text"
                v-model="form.name"
                :error="form.errors.name"
                :placeholder="$t('Enter your name')"
                required
            />
            <InputError :message="form.errors.name" />
        </div>

        <div class="mb-4">
            <InputLabel for="email" :value="$t('Your email')" required />
            <TextInput
                id="email"
                type="email"
                v-model="form.email"
                :error="form.errors.email"
                :placeholder="$t('Enter your email')"
                required
            />
            <InputError :message="form.errors.email" />
        </div>

        <div class="mb-4">
            <InputLabel
                for="phone_number"
                :value="$t('Your phone number')"
                required
            />
            <TextInput
                id="phone_number"
                type="text"
                v-model="form.phone_number"
                :error="form.errors.phone_number"
                :placeholder="$t('Enter your phone number')"
                required
            />
            <InputError :message="form.errors.phone_number" />
        </div>

        <div class="my-5 border-b border-gray-light"></div>

        <div class="mb-4">
            <InputLabel for="password" :value="$t('Password')" required />
            <TextInput
                id="password"
                type="password"
                v-model="form.password"
                :error="form.errors.password"
                :placeholder="$t('Your password')"
                required
            />
            <InputError :message="form.errors.password" />
        </div>

        <div class="mb-8">
            <InputLabel
                for="password_confirmation"
                :value="$t('Password confirmation')"
                required
            />
            <TextInput
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                :placeholder="$t('Write your password again')"
                required
            />
        </div>

        <FormButton type="submit" class="mb-6" :disabled="form.processing">
            {{ form.processing ? $t('Saving...') : $t('Submit') }}
        </FormButton>

        <slot />
    </form>
</template>

<script setup lang="ts">
import FormButton from '@/Components/Auth/FormButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ApiResponse, UserData } from '@/types/data';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: ApiResponse<UserData>;
}>();

const emit = defineEmits<{
    (e: 'success'): void;
}>();

const form = useForm({
    name: props.user.data.name,
    surname: props.user.data.surname,
    email: props.user.data.email,
    phone_number: props.user.data.phone_number,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('profile.complete.update'), {
        onSuccess: () => {
            emit('success');
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>
