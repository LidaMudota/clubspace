<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

defineProps<{ stats: { events: number; members: number; news: number } }>();
</script>

<template>
    <PublicLayout title="О сообществе" subtitle="Clubspace объединяет людей, которые выбирают качество, развитие и круг сильных единомышленников.">
        <Head title="О сообществе" />
        <section class="mx-auto mt-10 max-w-6xl px-4 lg:px-8">
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="rounded-2xl border border-stone-200 bg-white p-6"><p class="text-3xl font-semibold">{{ stats.members }}</p><p class="text-sm text-slate-600">Резидентов</p></div>
                <div class="rounded-2xl border border-stone-200 bg-white p-6"><p class="text-3xl font-semibold">{{ stats.events }}</p><p class="text-sm text-slate-600">Проведённых событий</p></div>
                <div class="rounded-2xl border border-stone-200 bg-white p-6"><p class="text-3xl font-semibold">{{ stats.news }}</p><p class="text-sm text-slate-600">Публикаций</p></div>
            </div>
            <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-8 text-slate-700">
                <p>Мы создаём среду, где события становятся катализатором личного и профессионального роста. Форматы — от камерных встреч до закрытых премьер.</p>
                <p class="mt-4">Вступайте в сообщество и выбирайте мероприятия с удобной онлайн-оплатой и прозрачной историей участия.</p>
                <Link href="/events" class="mt-6 inline-flex rounded-full bg-slate-900 px-5 py-2 text-sm font-medium text-white">Перейти в каталог</Link>
            </div>
        </section>
    </PublicLayout>
</template>
