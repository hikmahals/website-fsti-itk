<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Post } from '@/types';

defineProps<{
  post: Post;
}>();
</script>

<template>
  <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-2 duration-300">
    <Link :href="route('berita.show', post.slug)">
      <img 
        v-if="post.image_url"
        :src="post.image_url" 
        :alt="post.title" 
        class="w-full h-48 object-cover"
      >
      <div v-else class="w-full h-48 bg-gray-200"></div>
    </Link>
    
    <div class="p-4 flex flex-col flex-grow">
      <div class="flex justify-between items-center text-sm text-black">
        <span class="border border-[#133E87] rounded px-2 py-1 text-xs font-medium">{{ post.category }}</span>
        <span>{{ new Date(post.published_at || post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
      </div>
      
      <h3 class="mt-4 text-lg font-bold text-black leading-snug">
        <Link :href="route('berita.show', post.slug)" class="hover:text-[#133E87]">
          {{ post.title }}
        </Link>
      </h3>

      <p class="mt-2 text-black text-sm leading-relaxed flex-grow line-clamp-3">
        {{ post.excerpt }}
      </p>

      <div class="mt-6 text-right">
        <Link :href="route('berita.show', post.slug)" class="inline-block bg-[#133E87] text-white font-bold px-6 py-2 rounded-full hover:bg-opacity-90 transition-colors duration-300 text-sm">
          Baca Selengkapnya
        </Link>
      </div>
    </div>
  </div>
</template>