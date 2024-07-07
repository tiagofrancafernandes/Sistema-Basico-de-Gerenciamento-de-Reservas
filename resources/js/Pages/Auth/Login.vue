<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { computed, ref } from "vue";
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    demoUsers: {
        type: Object,
    },
    demoMode: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const computedDemoUsers = computed(() => {
    if (!props?.demoMode) {
        return [];
    }

    let demoUsers = props?.demoUsers ?? [];

    return demoUsers;
});

const setInputs = (userData = null) => {
    userData = typeof userData === 'object' ? userData : {};
    form.email = userData['email'] ?? '';
    form.password = userData['password'] ?? '';
}

</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>

            <div
                v-if="demoMode"
                class="flex items-center justify-center mt-8 mb-2"
            >
                <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <div class="block w-full px-4 py-2 text-white bg-blue-700 border-b border-gray-200 rounded-t-lg cursor-pointer dark:bg-gray-800 dark:border-gray-600">
                        Demo Users
                    </div>
                    <template
                        v-for="(demoUser, demoUserIndex) in computedDemoUsers"
                        :key="demoUserIndex"
                    >
                        <button
                            type="button"
                            class="text-left block w-full px-4 py-1.5 border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white"
                            v-on:click="setInputs(demoUser)"
                        >
                            <div class="w-full flex flex-col">
                                <div class="w-full">
                                    <div class="w-full flex justify-between">
                                        <span>Name: {{ demoUser.name }}</span>
                                        <span
                                            v-if="demoUser.role"
                                            class="bg-blue-100 text-blue-800 text-2xs font-semibold ml-2 px-1.5 py-0.1 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-100 dark:border-blue-400"
                                        >{{ demoUser.role }}</span>
                                    </div>
                                </div>
                                <div class="w-full flex flex-col">
                                    <span>E-mail: {{ demoUser.email }}</span>
                                    <span>Password: {{ demoUser.password }}</span>
                                </div>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
