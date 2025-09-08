<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Post } from '@/types';

// Prop 'bgColorClass' untuk menerima kelas warna latar belakang dinamis
const props = defineProps<{
  post: Post;
  bgColorClass?: string;
}>();

// Fungsi untuk memformat tanggal
const formatDate = (dateString: string | null) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};
</script>

<template>
    <!-- Kontainer utama kartu -->
    <div 
        class="rounded-xl shadow-md overflow-hidden flex flex-col transition-transform transform hover:-translate-y-1 duration-300 group"
        :class="[bgColorClass || 'bg-white']"
    >
        <!-- Gambar Berita -->
        <Link :href="route('berita.show', post.slug)">
            <img 
                v-if="post.image_url"
                :src="post.image_url" 
                :alt="post.title" 
                class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105"
            >
            <div v-else class="w-full h-56 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-400">Gambar tidak tersedia</span>
            </div>
        </Link>
        
        <!-- Konten Kartu -->
        <div class="p-6 flex flex-col flex-grow">
            <!-- Kategori & Tanggal -->
            <div class="flex justify-between items-center text-sm text-black mb-4">
                <span class="border border-[#133E87] rounded-md px-3 py-1 text-xs font-semibold">
                    {{ post.category }}
                </span>
                <span>{{ formatDate(post.published_at) }}</span>
            </div>
            
            <!-- Judul -->
            <h3 class="text-xl font-bold text-black leading-snug">
                <Link :href="route('berita.show', post.slug)" class="group-hover:text-[#133E87] transition-colors duration-300">
                    {{ post.title }}
                </Link>
            </h3>

            <!-- Ringkasan (Excerpt) -->
            <p class="mt-2 text-black text-base leading-relaxed flex-grow line-clamp-3">
                {{ post.excerpt }}
            </p>

            <!-- Tombol Baca Selengkapnya -->
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

