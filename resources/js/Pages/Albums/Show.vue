<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PublicLayout from '../Shared/PublicLayout.vue';

const props = defineProps<{ album: any }>();
const active = ref<number | null>(null);
</script>

<template>
    <PublicLayout :title="album.title" :subtitle="album.description">
        <Head :title="album.title" />
        <section class="mx-auto mt-10 max-w-6xl px-4 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <button v-for="(photo, index) in album.photos" :key="photo.id" class="h-52 rounded-2xl border border-stone-200 bg-gradient-to-br from-slate-200 to-stone-100 text-left" @click="active = index">
                    <span class="sr-only">Открыть фото</span>
                </button>
            </div>
            <p v-if="album.photos.length === 0" class="rounded-2xl border border-dashed border-stone-300 bg-white p-10 text-center text-slate-600">Пока фотографий нет.</p>
        </section>

        <div v-if="active !== null" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-6" @click.self="active = null">
            <div class="w-full max-w-3xl rounded-2xl bg-white p-6">
                <p class="text-sm text-slate-500">Фото {{ active + 1 }} из {{ album.photos.length }}</p>
                <div class="mt-4 h-80 rounded-xl bg-gradient-to-br from-slate-200 to-stone-100" />
                <p class="mt-3 text-sm text-slate-600">{{ album.photos[active]?.caption }}</p>
            </div>
        </div>
    </PublicLayout>
</template>
