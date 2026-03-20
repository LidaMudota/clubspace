<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

defineProps<{ payments: { data: Array<any> } }>();
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-5xl px-4 py-10">
            <h1 class="text-2xl font-semibold">Платежи</h1>
            <div v-if="payments.data.length" class="mt-6 space-y-4">
                <div v-for="payment in payments.data" :key="payment.id" class="rounded-2xl border border-stone-200 bg-white p-5">
                    <p class="font-medium">{{ payment.booking?.event?.title }}</p>
                    <p class="mt-1 text-sm text-slate-600">Статус: {{ payment.status }}</p>
                    <p class="text-sm text-slate-600">Сумма: {{ payment.amount }} {{ payment.currency }}</p>
                </div>
            </div>
            <div v-else class="mt-6 rounded-2xl border border-dashed border-stone-300 bg-white p-8 text-center text-slate-600">Пока нет платежей.</div>
        </div>
    </AppLayout>
</template>
