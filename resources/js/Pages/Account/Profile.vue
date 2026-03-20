<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const page = usePage();
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-5xl px-4 py-10">
            <h1 class="text-2xl font-semibold">Профиль</h1>
            <div class="mt-6 rounded-2xl border border-stone-200 bg-white p-6">
                <p class="text-sm text-slate-500">Имя</p>
                <p class="mt-1 font-medium">{{ page.props.auth.user?.name }}</p>
                <p class="mt-4 text-sm text-slate-500">Email</p>
                <p class="mt-1 font-medium">{{ page.props.auth.user?.email || 'Не указан' }}</p>
                <p class="mt-4 text-sm text-slate-500">Телефон</p>
                <p class="mt-1 font-medium">{{ page.props.auth.user?.phone || 'Не указан' }}</p>
            </div>
        </div>
    </AppLayout>
</template>
