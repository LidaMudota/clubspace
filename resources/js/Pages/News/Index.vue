<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

defineProps<{ posts: { data: Array<any>; links: Array<any> } }>();
</script>

<template>
    <PublicLayout title="Новости" subtitle="О ключевых событиях сообщества и ближайших запусках.">
        <Head title="Новости" />
        <section class="mx-auto mt-10 max-w-6xl px-4 lg:px-8">
            <div class="grid gap-5 lg:grid-cols-3">
                <Link v-for="post in posts.data" :key="post.id" :href="`/news/${post.slug}`" class="rounded-2xl border border-stone-200 bg-white p-6">
                    <p class="text-xs text-slate-500">{{ new Date(post.published_at).toLocaleDateString('ru-RU') }}</p>
                    <h3 class="mt-2 text-lg font-semibold">{{ post.title }}</h3>
                    <p class="mt-3 line-clamp-3 text-sm text-slate-600">{{ post.excerpt }}</p>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
