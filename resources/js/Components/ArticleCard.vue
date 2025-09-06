<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Tag, Calendar, Eye, ImageIcon } from 'lucide-vue-next';
import type { Post } from '@/types';

defineProps<{
  post: Post;
}>();
</script>

<template>
  <div class="bg-[#CBD5E1] rounded-xl overflow-hidden border-2 border-[#133E87] shadow-lg">
    <div class="relative">
      
      <img 
        v-if="post.image_url" 
        class="w-full h-64 object-cover" 
        :src="post.image_url" 
        :alt="post.title"
      >
      <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center">
        <ImageIcon class="w-16 h-16 text-black" />
      </div>

      <span v-if="post.category" class="absolute top-4 left-4 bg-white text-black text-sm font-semibold px-4 py-1 rounded-full shadow">
        {{ post.category }}
      </span>
    </div>

    <div class="p-6 border-t-2 border-[#133E87]">
      <h2 class="text-2xl font-bold text-black mb-3 leading-tight">
        {{ post.title }}
      </h2>
      <div class="flex items-center text-sm text-black mb-4 space-x-6">
        <div class="flex items-center">
          <Calendar class="w-4 h-4 mr-2" />
          <span>{{ new Date(post.published_at || post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</span>
        </div>
        <div class="flex items-center">
          <Eye class="w-4 h-4 mr-2" />
          <span>{{ post.views }} dilihat</span>
        </div>
      </div>
      <p class="text-black text-base mb-5">
        {{ post.excerpt }}
      </p>
      <div v-if="post.tags" class="flex items-center text-sm text-black mb-6">
        <Tag class="w-4 h-4 mr-2" />
        <span class="font-semibold mr-2">Tags:</span>
        <span class="italic">{{ post.tags }}</span>
      </div>
      <div class="text-right mt-8">
        <Link :href="route('berita.show', post.slug)" class="inline-block bg-[#133E87] text-white text-sm font-bold px-8 py-3 rounded-full hover:bg-opacity-90 transition-colors">
          Baca Selengkapnya
        </Link>
      </div>
    </div>
  </div>
</template>