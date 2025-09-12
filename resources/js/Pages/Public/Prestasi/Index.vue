<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';
import { debounce } from 'lodash';

// Layouts & Components
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import HomeArticleCard from '@/Components/HomeArticleCard.vue';
import AchievementCard from '@/Components/AchievementCard.vue'; // Komponen baru kita

// Icons
import { Trophy, Award, Search, FileWarning, ArrowRight, BarChart2, Globe, Flag } from 'lucide-vue-next';

// Types
import type { Post } from '@/types';

interface Achievement {
  id: number;
  student_name: string;
  competition_name: string;
  organizer: string;
  level: string;
  year: number;
  photo_url?: string;
}
interface PaginatedAchievements {
  data: Achievement[];
  links: { url: string | null; label: string; active: boolean }[];
  from: number;
  to: number;
  total: number;
}
interface Filters {
  search?: string;
  year?: string;
  level?: string;
}
interface Stats {
    total_this_year: number;
    international: number;
    national: number;
}

const props = defineProps<{
  featuredAchievements: Post[];
  achievements: PaginatedAchievements;
  stats: Stats;
  filters: Filters;
  years: string[];
  levels: string[];
}>();

const bannerImage = '/images/background-banner.png';
const googleFormUrl = 'https://forms.gle/your-google-form-link';

// State untuk filter
const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');
const selectedLevel = ref(props.filters.level || '');

// Terapkan filter saat nilai berubah
watch([search, selectedYear, selectedLevel], debounce(() => {
    router.get(route('prestasi.index'), {
        search: search.value,
        year: selectedYear.value,
        level: selectedLevel.value,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

</script>

<template>
    <PublicLayout title="Prestasi Mahasiswa">
        <Head>
            <title>Galeri Prestasi Mahasiswa FSTI</title>
            <meta name="description" content="Jelajahi galeri prestasi membanggakan dari mahasiswa Fakultas Sains dan Teknologi Informasi ITK.">
        </Head>
        
        <Banner title="Galeri Prestasi" :background-image="bannerImage" />

        <div class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Bagian Sorotan Prestasi -->
                <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 mb-20">
                    <div class="lg:col-span-2">
                        <div class="flex justify-between items-center mb-8">
                            <div class="flex items-center">
                                <Trophy class="w-10 h-10 text-[#4682A9]" />
                                <h2 class="ml-4 text-4xl font-bold font-kulim-park text-[#4682A9]">Sorotan Prestasi</h2>
                            </div>
                            <Link :href="route('berita.index', { category: 'Prestasi' })" class="inline-flex items-center font-semibold text-white bg-[#133E87] border border-transparent rounded-full px-5 py-2 hover:bg-blue-800 transition-colors duration-300 shadow-sm text-sm">
                                Lihat Semua Berita
                                <ArrowRight class="ml-2 h-4 w-4" />
                            </Link>
                        </div>
                        
                        <div v-if="featuredAchievements.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <HomeArticleCard v-for="post in featuredAchievements" :key="post.id" :post="post" />
                        </div>
                        <div v-else class="bg-white p-12 rounded-2xl shadow-lg border-2 border-gray-100 flex flex-col items-center justify-center text-center">
                            <FileWarning class="w-16 h-16 text-gray-400 mb-4" />
                            <h3 class="text-xl font-bold text-black">Belum Ada Sorotan</h3>
                            <p class="mt-2 max-w-sm text-gray-500">Saat ini belum ada berita prestasi terbaru yang dapat kami sorot.</p>
                        </div>
                    </div>

                    <aside class="lg:col-span-1">
                        <div class="sticky top-24 bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 text-center">
                            <h3 class="text-2xl font-bold text-black">Punya Prestasi?</h3>
                            <p class="mt-4 text-gray-600">Bantu kami mendata dan mempublikasikan setiap capaian membanggakan dari mahasiswa FSTI.</p>
                            <a :href="googleFormUrl" target="_blank" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#133E87] text-white font-bold px-6 py-3 text-base hover:bg-opacity-90 transition-transform transform hover:scale-105 duration-300 shadow-lg">
                                <Award class="w-5 h-5" />
                                Laporkan Prestasimu
                            </a>
                        </div>
                    </aside>
                </section>

                <!-- Bagian Statistik Prestasi -->
                <section class="mb-20">
                    <div class="flex items-center mb-8">
                         <BarChart2 class="w-10 h-10 text-[#4682A9]" />
                         <h2 class="ml-4 text-4xl font-bold font-kulim-park text-[#4682A9]">Statistik Pencapaian</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 text-center">
                            <Trophy class="w-12 h-12 text-yellow-500 mx-auto mb-4"/>
                            <p class="text-5xl font-bold text-black">{{ stats.total_this_year }}</p>
                            <p class="text-gray-500 font-semibold mt-2">Total Prestasi Tahun Ini</p>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 text-center">
                            <Globe class="w-12 h-12 text-blue-600 mx-auto mb-4"/>
                            <p class="text-5xl font-bold text-black">{{ stats.international }}</p>
                            <p class="text-gray-500 font-semibold mt-2">Prestasi Internasional</p>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 text-center">
                            <Flag class="w-12 h-12 text-red-600 mx-auto mb-4"/>
                            <p class="text-5xl font-bold text-black">{{ stats.national }}</p>
                            <p class="text-gray-500 font-semibold mt-2">Prestasi Nasional</p>
                        </div>
                    </div>
                </section>

                <!-- Bagian Galeri Prestasi -->
                <section>
                    <h2 class="text-4xl font-bold font-kulim-park text-[#4682A9] mb-8 text-center">Galeri Prestasi Mahasiswa</h2>
                    
                    <!-- Filter Modern -->
                    <div class="flex flex-col md:flex-row items-center justify-center gap-4 mb-12">
                         <div class="relative w-full md:w-1/3">
                            <input 
                                type="text" 
                                v-model="search"
                                placeholder="Cari nama atau lomba..." 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 transition"
                            >
                            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        </div>
                        <div class="flex gap-2">
                             <select v-model="selectedYear" class="px-4 py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">Semua Tahun</option>
                                <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
                            </select>
                             <select v-model="selectedLevel" class="px-4 py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">Semua Tingkat</option>
                                <option v-for="l in levels" :key="l" :value="l">{{ l }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Grid Kartu Prestasi -->
                    <div v-if="achievements.data.length > 0">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <AchievementCard v-for="achievement in achievements.data" :key="achievement.id" :achievement="achievement"/>
                        </div>
                        
                        <!-- Paginasi -->
                        <div v-if="achievements.links.length > 3" class="mt-12 flex justify-center items-center space-x-1">
                            <template v-for="(link, index) in achievements.links" :key="index">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    v-html="link.label"
                                    class="px-4 py-2 text-sm font-semibold rounded-lg transition"
                                    :class="{
                                        'bg-[#133E87] text-white shadow-md': link.active,
                                        'text-black hover:bg-gray-200': !link.active,
                                    }"
                                />
                                <span v-else v-html="link.label" class="px-4 py-2 text-sm font-semibold rounded-lg text-gray-400 cursor-not-allowed"/>
                            </template>
                        </div>
                    </div>

                    <!-- Pesan Jika Tidak Ditemukan -->
                    <div v-else class="text-center py-16">
                        <FileWarning class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                        <h3 class="text-xl font-bold text-black">Tidak Ada Prestasi Ditemukan</h3>
                        <p class="mt-2 text-gray-500">Coba ubah atau hapus filter yang Anda gunakan.</p>
                    </div>

                </section>
            </div>
        </div>
    </PublicLayout>
</template>
