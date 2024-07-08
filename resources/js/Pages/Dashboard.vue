<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import { useToast } from "primevue/usetoast";

import DashboardStats from "@/Pages/FakeStats.vue";

const toast = useToast();

const date = ref();
const show = () => {
    // toast.add({ severity: 'info', summary: 'Info', detail: 'Message Content', life: 3000 });
    // toast.add({ severity: 'warn', summary: 'Warn Message', detail: 'Message Content', life: 300000 });
    // toast.add({ severity: 'info', summary: 'Info', detail: 'Message Content', life: 300000 });
    // toast.add({ severity: 'success', summary: 'Success Message', detail: 'Message Content', life: 300000 });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-4">
            <ThemeSwitcher />

            <Button label="Show" @click="show()" />
        </div>

        <div class="bg-cyan-100">aaa</div>

        <DashboardStats/>

        <div class="py-4">
            <div class="w-full max-w-full mx-auto sm:px-4 lg:px-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
