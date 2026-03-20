<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

defineProps<{ bookings: { data: Array<any> } }>();
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-5xl px-4 py-10">
            <h1 class="text-2xl font-semibold">Мои мероприятия</h1>
            <div v-if="bookings.data.length" class="mt-6 space-y-4">
                <div v-for="booking in bookings.data" :key="booking.id" class="rounded-2xl border border-stone-200 bg-white p-5">
                    <p class="font-medium">{{ booking.event?.title }}</p>
                    <p class="mt-1 text-sm text-slate-600">Статус: {{ booking.status }}</p>
                    <p class="text-sm text-slate-600">Сумма: {{ booking.amount }} ₽</p>
                </div>
            </div>
            <div v-else class="mt-6 rounded-2xl border border-dashed border-stone-300 bg-white p-8 text-center text-slate-600">У вас пока нет активных записей.</div>
        </div>
    </AppLayout>
</template>
