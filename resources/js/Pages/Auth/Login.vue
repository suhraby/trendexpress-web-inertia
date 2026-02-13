<template>
    <AuthenticationLayout
        title="Log in"
        header="Login or create account to track your cargos"
    >
        <div class="pb-5 text-sm md:pb-7 lg:pb-10">
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <InputLabel
                        for="identifier"
                        value="ID, email or phone number"
                        required
                    />
                    <TextInput
                        id="identifier"
                        type="text"
                        name="identifier"
                        placeholder="Enter your ID, email or phone number"
                        required
                        v-model="form.identifier"
                        autocomplete="identifier"
                    />
                </div>

                <div class="mb-4">
                    <InputLabel for="password" value="Password" required />
                    <TextInput
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
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
                    class="text-medium text-gray-medium mb-8 flex justify-between text-center"
                >
                    <label class="flex items-center">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ms-2">Remember me</span>
                    </label>

                    <a href="#" class="hover:text-red-brand"
                        >I forgot my password</a
                    >
                </div>

                <FormButton type="submit" class="mb-8">Log in</FormButton>

                <ContactLink question="Don't have an account?" />
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
