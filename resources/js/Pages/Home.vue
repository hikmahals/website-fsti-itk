<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HomeArticleCard from '@/Components/HomeArticleCard.vue';
import { Link } from '@inertiajs/vue3';
import { GraduationCap, Trophy, CheckSquare, Building2, BookOpen, UserCheck, Users, ArrowRight } from 'lucide-vue-next';
import type { Post } from '@/types';

// Terima data 'latestPosts' dari controller
const props = defineProps<{
  latestPosts: Post[];
  canLogin?: boolean;
  canRegister?: boolean;
  laravelVersion?: string;
  phpVersion?: string;
}>();
</script>

<template>
    <PublicLayout>
        <div class="relative bg-white pb-24">
            <section 
                class="relative w-full h-[600px] bg-gray-500"
                style="clip-path: ellipse(120% 100% at 50% 0%);"
            >
                <img src="/images/gambar-beranda-1.jpeg" alt="Suasana FSTI ITK" class="absolute inset-0 w-full h-full object-cover object-[center_68%]">
                <div class="absolute inset-0 bg-[#91C8E4] opacity-60"></div>
                <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center -mt-16">
                    <h1 class="font-kulim-park text-5xl md:text-6xl font-bold text-white text-stroke-custom text-shadow-custom tracking-wider -mt-16">
                        FAKULTAS SAINS DAN TEKNOLOGI INFORMASI
                    </h1>
                    <h2 class="mt-4 font-kulim-park text-3xl md:text-5xl font-bold text-white text-stroke-custom text-shadow-custom tracking-wider">
                        INSTITUT TEKNOLOGI KALIMANTAN
                    </h2>
                    <div class="mt-10">
                        <a href="#" class="inline-block bg-white text-black font-bold text-lg px-6 py-2 rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 duration-300 -mt-16">
                            Tentang FSTI
                        </a>
                    </div>
                </div>
            </section>

            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center items-center gap-8 flex-wrap">
                    <div class="w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl transform hover:-translate-y-2 transition-transform duration-300 cursor-pointer">
                        <GraduationCap :size="80" class="mx-auto" />
                        <h3 class="mt-4 text-xl font-bold font-kulim-park">Program Studi</h3>
                    </div>
                    <div class="w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl transform hover:-translate-y-2 transition-transform duration-300 cursor-pointer">
                        <Trophy :size="80" class="mx-auto" />
                        <h3 class="mt-4 text-xl font-bold font-kulim-park">Prestasi Mahasiswa</h3>
                    </div>
                    <div class="w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl transform hover:-translate-y-2 transition-transform duration-300 cursor-pointer">
                        <CheckSquare :size="80" class="mx-auto" />
                        <h3 class="mt-4 text-xl font-bold font-kulim-park">Layanan Mahasiswa</h3>
                    </div>
                </div>
            </div>
        </div>

        <section class="bg-white py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                    <div class="lg:w-1/2 text-left">
                        <h2 class="text-4xl font-bold font-kulim-park text-[#4682A9]">
                            Sekilas Tentang FSTI ITK
                        </h2>
                        <p class="mt-6 text-gray-600 leading-relaxed">
                            FSTI terus berkembang sebagai pusat pendidikan dan inovasi di bidang sains dan teknologi, dengan berbagai jurusan, program studi, dan civitas akademika yang mendukung perjalanan belajar, kreativitas, dan prestasi mahasiswa kami.
                        </p>
                        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center">
                                <Building2 :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">2</span>
                                <span class="block mt-1 text-sm">Jurusan</span>
                            </div>
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center">
                                <BookOpen :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">9</span>
                                <span class="block mt-1 text-sm">Program Studi</span>
                            </div>
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center">
                                <UserCheck :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">118</span>
                                <span class="block mt-1 text-sm">Dosen</span>
                            </div>
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center">
                                <Users :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">6</span>
                                <span class="block mt-1 text-sm">Tendik</span>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="bg-[#749BC2] p-2 rounded-xl shadow-xl">
                            <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section 
          class="relative py-20 overflow-hidden bg-[#CBDCEB]"
          :style="{ backgroundImage: `url('/images/pattern-berita.png')` }"
        >
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-5xl font-bold font-kulim-park text-[#4682A9]">Berita Terbaru</h2>
                        <p class="mt-2 text-black">Informasi terkini seputar FSTI</p>
                    </div>
                    <Link :href="route('berita.index')" class="inline-flex items-center font-semibold text-black bg-white border border-gray-300 rounded-full px-5 py-2 hover:bg-gray-100 transition-colors duration-300 shadow-sm">
                        Lihat Semua
                        <ArrowRight class="ml-2 h-4 w-4" />
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <HomeArticleCard v-for="post in latestPosts" :key="post.id" :post="post" />
                </div>
            </div>
        </section>

    </PublicLayout>
</template>

<style scoped>
.text-stroke-custom {
  -webkit-text-stroke: 2px #4682A9;
  color: white;
}
.text-shadow-custom {
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
}
</style>