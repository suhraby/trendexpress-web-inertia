<script setup lang="ts">
import Navbar from '@/Components/Auth/Navbar.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

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

<template>
    <Head title="Log in | TrendExpress" />
    <Navbar />

    <main
        class="container-auth relative my-10 flex h-[calc(100vh-177px)] items-center text-sm"
    >
        <img
            src="/assets/images/login-pattern.png"
            alt="Pattern image"
            class="absolute -top-10 left-1/2 z-0 -translate-x-1/2"
        />

        <div class="static z-10 mx-auto w-full sm:w-100">
            <div class="mb-8 text-center">
                <img
                    src="/assets/images/auth-header.png"
                    alt="Auth header icon"
                    class="mx-auto mb-4"
                />
                <h2 class="h2 mb-1">Trend Express</h2>
                <div class="text-gray-medium font-normal">
                    Login or create account to track your cargos
                </div>
            </div>

            <div class="pb-5 md:pb-7 lg:pb-10">
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

                    <div class="mb-8 flex justify-between text-center">
                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.remember"
                            />
                            <span class="ms-2 text-sm text-gray-600"
                                >Remember me</span
                            >
                        </label>

                        <a
                            href="#"
                            class="text-medium text-gray-medium hover:text-red-brand"
                            >I forgot my password</a
                        >
                    </div>

                    <button
                        type="submit"
                        class="bg-red-brand mb-8 block w-full cursor-pointer rounded-[10px] py-2.5 text-center text-sm font-semibold text-white 2xl:text-base"
                    >
                        Log in
                    </button>

                    <div class="text-center">
                        <span class="text-gray-medium">
                            Don't have an account?
                        </span>
                        <a href="#" class="text-charcoal hover:text-red-brand">
                            Get in touch with us
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>
