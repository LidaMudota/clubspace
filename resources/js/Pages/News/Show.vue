<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '../Shared/PublicLayout.vue';

defineProps<{ post: any; related: Array<any> }>();
</script>

<template>
    <PublicLayout :title="post.title" :subtitle="post.excerpt">
        <Head :title="post.title" />
        <section class="mx-auto mt-10 grid max-w-6xl gap-8 px-4 lg:grid-cols-3 lg:px-8">
            <article class="prose prose-slate max-w-none rounded-2xl border border-stone-200 bg-white p-8 lg:col-span-2">
                <p class="text-sm text-slate-500">{{ new Date(post.published_at).toLocaleString('ru-RU') }}</p>
                <div class="mt-5 whitespace-pre-line text-slate-700">{{ post.content }}</div>
            </article>
            <aside class="space-y-4">
                <p class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">Ещё материалы</p>
                <Link v-for="item in related" :key="item.id" :href="`/news/${item.slug}`" class="block rounded-2xl border border-stone-200 bg-white p-5">
                    <p class="font-medium">{{ item.title }}</p>
                </Link>
            </aside>
        </section>
    </PublicLayout>
</template>
