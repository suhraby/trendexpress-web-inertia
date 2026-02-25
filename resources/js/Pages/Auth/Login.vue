<template>
    <AuthenticationLayout
        :title="$t('Log in')"
        :header="$t('Login or create account to track your cargos')"
    >
        <div class="pb-5 text-sm md:pb-7 lg:pb-10">
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <InputLabel
                        for="identifier"
                        :value="$t('ID, email or phone number')"
                        required
                    />
                    <TextInput
                        id="identifier"
                        type="text"
                        name="identifier"
                        :placeholder="
                            $t('Enter your ID, email or phone number')
                        "
                        required
                        v-model="form.identifier"
                        autocomplete="identifier"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="password"
                        :value="$t('Password')"
                        required
                    />
                    <TextInput
                        type="password"
                        id="password"
                        name="password"
                        :placeholder="$t('Enter your password')"
                        required
                        v-model="form.password"
                        autocomplete="current-password"
                        :error="form.errors.identifier"
                    />
                    <InputError
                        :message="
                            form.errors.identifier || form.errors.password
                        "
                    />
                </div>

                <div
                    class="flex justify-between mb-8 text-center text-medium text-gray-medium"
                >
                    <label class="flex items-center">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ms-2">{{ $t('Remember me') }}</span>
                    </label>

                    <a href="/#contact" class="hover:text-red-brand">
                        {{ $t('I forgot my password') }}
                    </a>
                </div>

                <FormButton type="submit" class="mb-8">
                    {{ $t('Log In') }}
                </FormButton>

                <ContactLink :question="$t('Don\'t have an account?')" />
            </form>
        </div>
    </AuthenticationLayout>
</template>

<script setup lang="ts">
import ContactLink from '@/Components/Auth/ContactLink.vue';
import FormButton from '@/Components/Auth/FormButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue';
import { useForm } from '@inertiajs/vue3';

defineProps<{
    // canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    identifier: '',
    password: '',
    remember: false,
});

const handleSubmit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>
