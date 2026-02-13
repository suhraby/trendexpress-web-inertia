<template>
    <AuthenticationLayout
        title="Complete Profile"
        header="Please complete you profile data and change the default password to enter the dashboard"
    >
        <div class="pb-5 text-sm md:pb-7 lg:pb-10">
            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <InputLabel for="name" value="Your name" required />
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Enter name"
                        required
                        v-model="form.name"
                        autocomplete="name"
                        :error="form.errors.name"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="surname" value="Your surname" required />
                    <TextInput
                        id="surname"
                        type="text"
                        name="surname"
                        placeholder="Enter your surname"
                        required
                        v-model="form.surname"
                        autocomplete="surname"
                        :error="form.errors.surname"
                    />
                    <InputError :message="form.errors.surname" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" value="Your email" required />
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                        v-model="form.email"
                        autocomplete="email"
                        :error="form.errors.email"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="mb-4">
                    <InputLabel
                        for="phone_number"
                        value="Your phone number"
                        required
                    />
                    <TextInput
                        id="phone_number"
                        type="tel"
                        name="phone_number"
                        placeholder="Enter your phone number"
                        required
                        v-model="form.phone_number"
                        autocomplete="phone_number"
                        :error="form.errors.phone_number"
                    />
                    <InputError :message="form.errors.phone_number" />
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
                        :error="form.errors.password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="mb-8">
                    <InputLabel
                        for="password_confirmation"
                        value="Password confirmation"
                        required
                    />
                    <TextInput
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repeat the password"
                        required
                        v-model="form.password_confirmation"
                    />
                </div>

                <FormButton type="submit" class="mb-6">Submit</FormButton>

                <ContactLink question="Do you have problem?" />
            </form>
        </div>
    </AuthenticationLayout>
</template>

<script lang="ts" setup>
import ContactLink from '@/Components/Auth/ContactLink.vue';
import FormButton from '@/Components/Auth/FormButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue';
import { ApiResponse, UserData } from '@/types/data';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: ApiResponse<UserData>;
}>();

const form = useForm({
    name: props.user.data.name,
    surname: props.user.data.surname,
    email: props.user.data.email,
    phone_number: props.user.data.phone_number,
    password: '',
    password_confirmation: '',
});

const handleSubmit = () => {
    form.post(route('profile.complete.update'), {
        onError: (errors) => {
            console.log(errors);
        },
    });
};
</script>
