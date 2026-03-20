<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

const props = defineProps<{ contacts: { email: string; telegram: string | null; address: string; working_hours: string } }>();

const form = useForm({ name: '', email: '', message: '' });
const send = () => form.post('/contacts/feedback', { preserveScroll: true, onSuccess: () => form.reset('message') });
</script>

<template>
    <PublicLayout title="Контакты" subtitle="Свяжитесь с командой Clubspace по любому организационному вопросу.">
        <Head title="Контакты" />

        <section class="mx-auto mt-10 grid max-w-6xl gap-8 px-4 lg:grid-cols-2 lg:px-8">
            <div class="rounded-2xl border border-stone-200 bg-white p-8">
                <p class="text-sm text-slate-500">Email</p><p class="mt-1 font-medium">{{ props.contacts.email }}</p>
                <p class="mt-5 text-sm text-slate-500">Telegram</p><p class="mt-1 font-medium">{{ props.contacts.telegram || 'Укажите TELEGRAM_CHAT_ID в .env' }}</p>
                <p class="mt-5 text-sm text-slate-500">Адрес</p><p class="mt-1 font-medium">{{ props.contacts.address }}</p>
                <p class="mt-5 text-sm text-slate-500">Часы работы</p><p class="mt-1 font-medium">{{ props.contacts.working_hours }}</p>
            </div>

            <form class="rounded-2xl border border-stone-200 bg-white p-8" @submit.prevent="send">
                <h3 class="text-xl font-semibold">Форма обратной связи</h3>
                <div class="mt-5 space-y-3">
                    <input v-model="form.name" type="text" placeholder="Ваше имя" class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm" />
                    <input v-model="form.email" type="email" placeholder="Email" class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm" />
                    <textarea v-model="form.message" rows="5" placeholder="Сообщение" class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm" />
                </div>
                <button class="mt-5 rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white" :disabled="form.processing">Отправить</button>
            </form>
        </section>
    </PublicLayout>
</template>
