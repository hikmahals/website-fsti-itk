<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Calendar } from 'lucide-vue-next';
import { gsap } from 'gsap';
import type { Post } from '@/types';

const props = withDefaults(defineProps<{
  post: Post;
  bgColorClass?: string;
}>(), {
  bgColorClass: 'bg-white',
});

const formattedDate = computed(() => {
  if (!props.post.published_at) {
    return "Tanggal tidak tersedia";
  }
  return new Date(props.post.published_at).toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });
});

const cardRef = ref<HTMLDivElement | null>(null);

onMounted(() => {
  const cardElement = cardRef.value;
  if (cardElement) {
    const image = cardElement.querySelector('img');

    cardElement.addEventListener('mouseenter', () => {
      gsap.to(cardElement, {
        y: -10,
        scale: 1.03,
        boxShadow: "0px 25px 40px -15px rgba(0,0,0,0.2)",
        duration: 0.3,
        ease: 'power2.out'
      });
      if (image) {
        gsap.to(image, { scale: 1.1, duration: 0.3, ease: 'power2.out' });
      }
    });

    cardElement.addEventListener('mouseleave', () => {
      gsap.to(cardElement, {
        y: 0,
        scale: 1,
        boxShadow: "0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)",
        duration: 0.3,
        ease: 'power2.out'
      });
      if (image) {
        gsap.to(image, { scale: 1, duration: 0.3, ease: 'power2.out' });
      }
    });
  }
});
</script>

<template>
  <div
    ref="cardRef"
    class="rounded-xl overflow-hidden shadow-md flex flex-col h-full"
    :class="bgColorClass"
  >
    <!-- Gambar -->
    <Link :href="route('berita.show', post.slug)">
      <div class="aspect-video overflow-hidden">
        <img
          v-if="post.image_url"
          :src="post.image_url"
          :alt="post.title"
          class="w-full h-full object-cover"
        >
        <div v-else class="w-full h-56 bg-gray-200 flex items-center justify-center">
          <span class="text-gray-400">Gambar tidak tersedia</span>
        </div>
      </div>
    </Link>

    <!-- Konten -->
    <div class="p-6 flex flex-col flex-grow">
      <!-- Kategori & Tanggal -->
      <div class="flex justify-between items-center text-sm text-black mb-4">
        <span class="border border-[#133E87] rounded-md px-3 py-1 text-xs font-semibold">
          {{ post.category }}
        </span>
        <span class="flex items-center gap-2 text-black">
          <Calendar class="w-4 h-4" />
          {{ formattedDate }}
        </span>
      </div>

      <!-- Judul -->
      <h3 class="text-xl font-bold text-black leading-snug">
        <Link :href="route('berita.show', post.slug)" class="hover:text-[#133E87] transition-colors duration-300">
          {{ post.title }}
        </Link>
      </h3>

      <!-- Ringkasan -->
      <p class="mt-2 text-black text-base leading-relaxed flex-grow line-clamp-3">
        {{ post.excerpt }}
      </p>

      <!-- Tombol -->
      <div class="mt-6 text-right">
        <Link
          :href="route('berita.show', post.slug)"
          class="inline-block bg-[#133E87] text-white font-bold px-6 py-2 rounded-full hover:bg-opacity-90 transition-colors duration-300 text-sm"
        >
          Baca Selengkapnya
        </Link>
      </div>
    </div>
  </div>
</template>
