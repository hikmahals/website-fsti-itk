<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ImageIcon } from 'lucide-vue-next';
import type { Post } from '@/types';

defineProps<{
  recentPosts: Post[];
}>();
</script>

<template>
  <div class="bg-white rounded-lg border-2 border-[#133E87] overflow-hidden shadow-lg">
    
    <h3 class="text-lg font-bold text-black bg-[#CBDCEB] p-4 text-center border-b-2 border-[#133E87]">
      Berita Terbaru
    </h3>

    <ul class="p-6">
      <li 
        v-for="(post, index) in recentPosts" 
        :key="post.id"
      >
        <hr v-if="index > 0" class="border-t border-[#133E87] my-4 w-12/12 mx-auto">
      
        <Link :href="route('berita.show', post.slug)" class="flex items-start space-x-4 group">
          <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="w-20 h-16 object-cover rounded-md flex-shrink-0">
          <div v-else class="w-20 h-16 bg-gray-200 rounded-md flex items-center justify-center flex-shrink-0">
            <ImageIcon class="w-8 h-8 text-gray-400" />
          </div>
          <div class="flex-1">
            <p class="text-sm font-semibold text-black group-hover:text-[#133E87] transition-colors line-clamp-2 leading-tight">
              {{ post.title }}
            </p>
            <p class="text-xs text-gray-500 mt-1">
              {{ new Date(post.published_at || post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
            </p>
          </div>
        </Link>
      </li>
    </ul>
  </div>
</template>