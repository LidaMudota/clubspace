<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        title?: string;
        subtitle?: string;
    }>(),
    {
        title: 'Clubspace',
        subtitle: '',
    },
);

const page = usePage();
</script>

<template>
    <div class="min-h-screen bg-stone-50 text-slate-900">
        <Head :title="title" />

        <header class="sticky top-0 z-50 border-b border-stone-200/80 bg-stone-50/90 backdrop-blur-xl">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 lg:px-8">
                <Link href="/" class="text-lg font-semibold tracking-tight">Clubspace</Link>
                <nav class="hidden items-center gap-6 text-sm text-slate-600 lg:flex">
                    <Link href="/events" class="hover:text-slate-900">Мероприятия</Link>
                    <Link href="/news" class="hover:text-slate-900">Новости</Link>
                    <Link href="/albums" class="hover:text-slate-900">Фотоальбомы</Link>
                    <Link href="/about" class="hover:text-slate-900">О сообществе</Link>
                    <Link href="/contacts" class="hover:text-slate-900">Контакты</Link>
                </nav>
                <Link
                    :href="page.props.auth?.user ? '/account/events' : '/login'"
                    class="rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700"
                >
                    {{ page.props.auth?.user ? 'Личный кабинет' : 'Войти' }}
                </Link>
            </div>
        </header>

        <main>
            <section v-if="subtitle" class="mx-auto max-w-6xl px-4 pt-10 lg:px-8">
                <p class="text-sm uppercase tracking-[0.2em] text-amber-700">Premium community</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight lg:text-5xl">{{ title }}</h1>
                <p class="mt-4 max-w-3xl text-slate-600">{{ subtitle }}</p>
            </section>

            <slot />
        </main>

        <footer class="mt-20 border-t border-stone-200 bg-white">
            <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 text-sm text-slate-600 lg:grid-cols-3 lg:px-8">
                <div>
                    <p class="font-semibold text-slate-900">Clubspace</p>
                    <p class="mt-3">Закрытое сообщество для людей, которые выбирают качественные события и сильные связи.</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">Разделы</p>
                    <div class="mt-3 space-y-2">
                        <Link href="/events" class="block hover:text-slate-900">Каталог мероприятий</Link>
                        <Link href="/news" class="block hover:text-slate-900">Новости</Link>
                        <Link href="/albums" class="block hover:text-slate-900">Фотоальбомы</Link>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">Контакты</p>
                    <p class="mt-3">{{ page.props?.appName ?? 'Clubspace' }} · support@clubspace.local</p>
                </div>
            </div>
        </footer>
    </div>
</template>
