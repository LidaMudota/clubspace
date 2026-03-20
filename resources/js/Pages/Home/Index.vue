<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

defineProps<{
    featuredEvents: Array<any>;
    latestNews: Array<any>;
    featuredAlbums: Array<any>;
    stats: { events: number; members: number; albums: number };
}>();

const currency = new Intl.NumberFormat('ru-RU');
</script>

<template>
    <PublicLayout title="Clubspace" subtitle="Платформа премиального сообщества: мероприятия, нетворкинг, личный кабинет и качественный сервис.">
        <Head title="Главная" />

        <section class="mx-auto mt-8 max-w-6xl px-4 lg:px-8">
            <div class="rounded-3xl bg-slate-900 p-8 text-white lg:p-14">
                <p class="text-sm uppercase tracking-[0.2em] text-amber-300">Private members club</p>
                <h2 class="mt-5 max-w-3xl text-3xl font-semibold tracking-tight lg:text-6xl">События и связи, которые двигают вас вперёд.</h2>
                <p class="mt-5 max-w-2xl text-slate-200">Выбирайте мероприятия, оплачивайте участие онлайн и управляйте всеми активностями из личного кабинета.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <Link href="/events" class="rounded-full bg-amber-400 px-6 py-3 font-semibold text-slate-900">Смотреть мероприятия</Link>
                    <Link href="/register" class="rounded-full border border-white/40 px-6 py-3">Стать участником</Link>
                </div>
            </div>
        </section>

        <section class="mx-auto mt-14 grid max-w-6xl gap-4 px-4 lg:grid-cols-3 lg:px-8">
            <div class="rounded-2xl border border-stone-200 bg-white p-6"><p class="text-3xl font-semibold">{{ stats.events }}</p><p class="mt-1 text-sm text-slate-600">Активных мероприятий</p></div>
            <div class="rounded-2xl border border-stone-200 bg-white p-6"><p class="text-3xl font-semibold">{{ stats.members }}</p><p class="mt-1 text-sm text-slate-600">Участников сообщества</p></div>
            <div class="rounded-2xl border border-stone-200 bg-white p-6"><p class="text-3xl font-semibold">{{ stats.albums }}</p><p class="mt-1 text-sm text-slate-600">Фотоальбомов</p></div>
        </section>

        <section class="mx-auto mt-16 max-w-6xl px-4 lg:px-8">
            <div class="mb-6 flex items-center justify-between"><h3 class="text-2xl font-semibold">Ближайшие мероприятия</h3><Link href="/events" class="text-sm text-slate-600">Все мероприятия →</Link></div>
            <div class="grid gap-5 lg:grid-cols-3">
                <article v-for="event in featuredEvents" :key="event.id" class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.14em] text-amber-700">{{ new Date(event.starts_at).toLocaleDateString('ru-RU') }}</p>
                    <h4 class="mt-3 text-xl font-semibold">{{ event.title }}</h4>
                    <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ event.excerpt || 'Камерная встреча для участников сообщества.' }}</p>
                    <div class="mt-4 flex items-center justify-between"><span class="font-medium">{{ currency.format(event.price) }} ₽</span><Link :href="`/events/${event.slug}`" class="rounded-full border px-4 py-2 text-sm">Подробнее</Link></div>
                </article>
            </div>
        </section>

        <section class="mx-auto mt-16 max-w-6xl px-4 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2">
                <div>
                    <div class="mb-4 flex items-center justify-between"><h3 class="text-2xl font-semibold">Последние новости</h3><Link href="/news" class="text-sm text-slate-600">Все новости →</Link></div>
                    <div class="space-y-4">
                        <Link v-for="post in latestNews" :key="post.id" :href="`/news/${post.slug}`" class="block rounded-2xl border border-stone-200 bg-white p-5 transition hover:shadow-md">
                            <p class="text-xs text-slate-500">{{ new Date(post.published_at).toLocaleDateString('ru-RU') }}</p>
                            <h4 class="mt-1 font-semibold">{{ post.title }}</h4>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ post.excerpt }}</p>
                        </Link>
                    </div>
                </div>
                <div>
                    <div class="mb-4 flex items-center justify-between"><h3 class="text-2xl font-semibold">Фотоальбомы</h3><Link href="/albums" class="text-sm text-slate-600">Все альбомы →</Link></div>
                    <div class="grid grid-cols-2 gap-4">
                        <Link v-for="album in featuredAlbums" :key="album.id" :href="`/albums/${album.slug}`" class="rounded-2xl border border-stone-200 bg-white p-4">
                            <div class="h-24 rounded-xl bg-gradient-to-br from-slate-200 to-stone-100" />
                            <p class="mt-3 line-clamp-1 text-sm font-medium">{{ album.title }}</p>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
