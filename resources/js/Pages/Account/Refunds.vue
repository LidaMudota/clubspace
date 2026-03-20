<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{ refunds: { data: Array<any> }; eligiblePayments: Array<any> }>();
const form = useForm({ payment_id: '', reason: '' });
const submit = () => form.post('/refunds', { preserveScroll: true, onSuccess: () => form.reset('reason') });
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-5xl px-4 py-10">
            <h1 class="text-2xl font-semibold">Возвраты</h1>
            <form class="mt-6 rounded-2xl border border-stone-200 bg-white p-6" @submit.prevent="submit">
                <p class="font-medium">Запросить возврат</p>
                <select v-model="form.payment_id" class="mt-3 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
                    <option disabled value="">Выберите платеж</option>
                    <option v-for="payment in props.eligiblePayments" :key="payment.id" :value="payment.id">#{{ payment.id }} — {{ payment.booking?.event?.title }}</option>
                </select>
                <textarea v-model="form.reason" rows="4" class="mt-3 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm" placeholder="Причина" />
                <button class="mt-3 rounded-xl bg-slate-900 px-5 py-2 text-sm font-medium text-white" :disabled="form.processing">Отправить запрос</button>
            </form>

            <div class="mt-6 space-y-4">
                <div v-for="refund in refunds.data" :key="refund.id" class="rounded-2xl border border-stone-200 bg-white p-5">
                    <p class="font-medium">{{ refund.payment?.booking?.event?.title }}</p>
                    <p class="mt-1 text-sm text-slate-600">Статус: {{ refund.status }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ refund.reason }}</p>
                </div>
                <div v-if="!refunds.data.length" class="rounded-2xl border border-dashed border-stone-300 bg-white p-8 text-center text-slate-600">Заявок на возврат пока нет.</div>
            </div>
        </div>
    </AppLayout>
</template>
