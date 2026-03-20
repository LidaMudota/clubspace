<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import PublicLayout from '../Shared/PublicLayout.vue';

type LinkItem = { url: string | null; label: string; active: boolean };
type EventPage = { data: Array<any>; links: LinkItem[] };

const props = defineProps<{ events: EventPage; filters: Record<string, string | null> }>();

const filters = reactive({
    search: props.filters.search ?? '',
    period: props.filters.period ?? 'all',
    sort: props.filters.sort ?? 'starts_at',
    price_from: props.filters.price_from ?? '',
    price_to: props.filters.price_to ?? '',
});

const apply = () => router.get('/events', filters, { preserveState: true, replace: true });
const price = new Intl.NumberFormat('ru-RU');
</script>

<template>
    <PublicLayout title="Каталог мероприятий" subtitle="Поиск, фильтры и прозрачное количество свободных мест в реальном времени.">
        <Head title="Мероприятия" />

        <section class="mx-auto mt-10 max-w-6xl px-4 lg:px-8">
            <div class="grid gap-3 rounded-2xl border border-stone-200 bg-white p-4 lg:grid-cols-5">
                <input v-model="filters.search" type="text" placeholder="Поиск" class="rounded-xl border border-stone-200 px-3 py-2 text-sm" />
                <select v-model="filters.period" class="rounded-xl border border-stone-200 px-3 py-2 text-sm">
                    <option value="all">Любой период</option>
                    <option value="week">На этой неделе</option>
                    <option value="month">В этом месяце</option>
                </select>
                <select v-model="filters.sort" class="rounded-xl border border-stone-200 px-3 py-2 text-sm">
                    <option value="starts_at">По дате</option>
                    <option value="price_asc">Сначала дешевле</option>
                    <option value="price_desc">Сначала дороже</option>
                    <option value="newest">Сначала новые</option>
                </select>
                <input v-model="filters.price_from" type="number" min="0" placeholder="Цена от" class="rounded-xl border border-stone-200 px-3 py-2 text-sm" />
                <div class="flex gap-2">
                    <input v-model="filters.price_to" type="number" min="0" placeholder="Цена до" class="w-full rounded-xl border border-stone-200 px-3 py-2 text-sm" />
                    <button class="rounded-xl bg-slate-900 px-4 text-sm font-medium text-white" @click="apply">Применить</button>
                </div>
            </div>

            <div class="mt-8 grid gap-5 lg:grid-cols-3">
                <article v-for="event in events.data" :key="event.id" class="rounded-2xl border border-stone-200 bg-white p-6">
                    <p class="text-xs uppercase tracking-[0.14em] text-amber-700">{{ new Date(event.starts_at).toLocaleString('ru-RU') }}</p>
                    <h3 class="mt-3 text-lg font-semibold">{{ event.title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ event.venue || 'Локация уточняется' }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <span>{{ price.format(event.price) }} ₽</span>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-emerald-700">Свободно: {{ event.available_seats }}</span>
                    </div>
                    <Link :href="`/events/${event.slug}`" class="mt-5 inline-flex rounded-full border px-4 py-2 text-sm">Перейти</Link>
                </article>
            </div>

            <div v-if="events.data.length === 0" class="mt-10 rounded-2xl border border-dashed border-stone-300 bg-white p-10 text-center text-slate-600">
                По вашему запросу мероприятий не найдено.
            </div>

            <div class="mt-8 flex flex-wrap gap-2">
                <Link
                    v-for="link in events.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    :class="[
                        'rounded-lg px-3 py-2 text-sm',
                        link.active ? 'bg-slate-900 text-white' : 'border border-stone-200 bg-white text-slate-600',
                        !link.url && 'pointer-events-none opacity-50',
                    ]"
                    v-html="link.label"
                />
            </div>
        </section>
    </PublicLayout>
</template>
