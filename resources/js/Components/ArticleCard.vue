<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Tag, Calendar, Eye, ImageIcon } from 'lucide-vue-next'; // Menambahkan ImageIcon
import type { Post } from '@/types';

defineProps<{
  post: Post;
}>();
</script>

<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1">
    <div class="relative">
      <img 
        v-if="post.image_url" 
        class="w-full h-64 object-cover" 
        :src="post.image_url" 
        :alt="post.title"
      >
      <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center">
        <ImageIcon class="w-16 h-16 text-gray-400" />
      </div>

      <span v-if="post.category" class="absolute top-4 left-4 bg-[#133E87] text-white text-xs font-semibold px-3 py-1 rounded-full">{{ post.category }}</span>
    </div>
    <div class="p-6">
      <h2 class="text-xl font-bold text-gray-800 mb-2 leading-tight">
        {{ post.title }}
      </h2>
      <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
        <div class="flex items-center">
          <Calendar class="w-4 h-4 mr-1.5" />
          <span>{{ new Date(post.published_at || post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
        </div>
        <div class="flex items-center">
          <Eye class="w-4 h-4 mr-1.5" />
          <span>{{ post.views }} dilihat</span>
        </div>
      </div>
      <p class="text-gray-600 text-sm mb-4 line-clamp-3">
        {{ post.excerpt }}
      </p>
      <div v-if="post.tags" class="flex items-center text-xs text-gray-500 mb-6">
        <Tag class="w-4 h-4 mr-1.5" />
        <span class="italic">Tags: {{ post.tags }}</span>
      </div>
      <div class="text-right">
        <Link :href="route('berita.show', post.slug)" class="inline-block bg-[#133E87] text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-opacity-90 transition-colors">
          Baca Selengkapnya
        </Link>
      </div>
    </div>
  </div>
</template>