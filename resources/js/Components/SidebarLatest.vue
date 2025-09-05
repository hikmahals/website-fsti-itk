<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Post {
  id: number;
  slug: string;
  title: string;
  image_url: string;
  created_at: string;
}

defineProps<{
  latestPosts: Post[];
}>();
</script>

<template>
  <div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Berita Terbaru</h3>
    <ul class="space-y-4">
      <li v-for="post in latestPosts" :key="post.id">
        <Link :href="route('berita.show', post.slug)" class="flex items-start space-x-4 group">
          <img :src="post.image_url" :alt="post.title" class="w-20 h-16 object-cover rounded-md">
          <div class="flex-1">
            <p class="text-sm font-semibold text-gray-800 group-hover:text-[#133E87] transition-colors line-clamp-2 leading-tight">
              {{ post.title }}
            </p>
            <p class="text-xs text-gray-500 mt-1">
              {{ new Date(post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long' }) }}
            </p>
          </div>
        </Link>
      </li>
    </ul>
  </div>
</template>