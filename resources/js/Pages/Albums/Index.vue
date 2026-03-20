<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

defineProps<{ albums: { data: Array<any> } }>();
</script>

<template>
    <PublicLayout title="Фотоальбомы" subtitle="Архив атмосферных моментов клубной жизни.">
        <Head title="Фотоальбомы" />
        <section class="mx-auto mt-10 max-w-6xl px-4 lg:px-8">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <Link v-for="album in albums.data" :key="album.id" :href="`/albums/${album.slug}`" class="rounded-2xl border border-stone-200 bg-white p-4">
                    <div class="h-40 rounded-xl bg-gradient-to-br from-slate-200 to-stone-100" />
                    <h3 class="mt-4 font-semibold">{{ album.title }}</h3>
                    <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ album.description }}</p>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
