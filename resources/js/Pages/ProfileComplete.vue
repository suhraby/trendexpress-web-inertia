<template>
    <AuthenticationLayout
        title="Complete Profile"
        header="Please complete you profile data and change the default password to enter the dashboard"
    >
        <div class="pb-5 text-sm md:pb-7 lg:pb-10">
            <ProfileForm :user>
                <ContactLink question="Do you have problem?" />
            </ProfileForm>
        </div>
    </AuthenticationLayout>
</template>

<script lang="ts" setup>
import ContactLink from '@/Components/Auth/ContactLink.vue';
import ProfileForm from '@/Components/Auth/ProfileForm.vue';
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
</script>
