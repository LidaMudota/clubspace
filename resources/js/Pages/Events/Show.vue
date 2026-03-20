<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

const props = defineProps<{ event: any; available_seats: number; is_booked: boolean; related: Array<any> }>();

const form = useForm({ event_id: props.event.id });
const book = () => form.post('/bookings');
const money = new Intl.NumberFormat('ru-RU');
</script>

<template>
    <PublicLayout :title="event.title" :subtitle="event.excerpt || 'Авторская программа для участников сообщества.'">
        <Head :title="event.title" />

        <section class="mx-auto mt-10 grid max-w-6xl gap-8 px-4 lg:grid-cols-3 lg:px-8">
            <div class="lg:col-span-2">
                <div class="h-72 rounded-3xl bg-gradient-to-br from-slate-300 to-stone-100" />
                <div class="mt-6 rounded-2xl border border-stone-200 bg-white p-6">
                    <h2 class="text-2xl font-semibold">О событии</h2>
                    <p class="mt-4 whitespace-pre-line text-slate-700">{{ event.description || 'Описание будет опубликовано организатором в ближайшее время.' }}</p>
                </div>
            </div>
            <aside class="space-y-4">
                <div class="rounded-2xl border border-stone-200 bg-white p-6">
                    <p class="text-sm text-slate-500">Дата</p>
                    <p class="mt-1 font-medium">{{ new Date(event.starts_at).toLocaleString('ru-RU') }}</p>
                    <p class="mt-4 text-sm text-slate-500">Место</p>
                    <p class="mt-1 font-medium">{{ event.venue || 'Локация уточняется' }}</p>
                    <p class="mt-4 text-sm text-slate-500">Стоимость</p>
                    <p class="mt-1 text-2xl font-semibold">{{ money.format(event.price) }} ₽</p>
                    <p class="mt-3 inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs text-emerald-700">Свободных мест: {{ available_seats }}</p>

                    <button v-if="!is_booked && available_seats > 0" class="mt-5 w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-medium text-white" :disabled="form.processing" @click="book">Записаться и оплатить</button>
                    <p v-else-if="is_booked" class="mt-5 rounded-xl bg-slate-100 px-4 py-3 text-sm text-slate-600">Вы уже записаны на это мероприятие.</p>
                    <p v-else class="mt-5 rounded-xl bg-rose-50 px-4 py-3 text-sm text-rose-700">Свободных мест нет.</p>
                </div>
                <Link href="/account/events" class="block rounded-2xl border border-stone-200 bg-white p-5 text-sm text-slate-600">История ваших участий и статусов оплаты →</Link>
            </aside>
        </section>

        <section class="mx-auto mt-16 max-w-6xl px-4 lg:px-8">
            <h3 class="text-2xl font-semibold">Похожие мероприятия</h3>
            <div class="mt-5 grid gap-4 lg:grid-cols-3">
                <Link v-for="item in related" :key="item.id" :href="`/events/${item.slug}`" class="rounded-2xl border border-stone-200 bg-white p-5">
                    <p class="text-xs text-slate-500">{{ new Date(item.starts_at).toLocaleDateString('ru-RU') }}</p>
                    <p class="mt-2 font-semibold">{{ item.title }}</p>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
