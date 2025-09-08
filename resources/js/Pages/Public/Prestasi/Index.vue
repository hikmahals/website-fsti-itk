<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Link, Head } from '@inertiajs/vue3';
// PERBAIKAN: Tambahkan ArrowRight untuk tombol
import { Trophy, Award, Search, FileWarning, ArrowRight } from 'lucide-vue-next';

import type { Post } from '@/types';
// Definisikan tipe untuk data prestasi dari tabel 'achievements'
interface Achievement {
  id: number;
  student_name: string;
  competition_name: string;
  organizer: string;
  level: string;
  year: number;
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

const props = defineProps<{
  featuredAchievements: Post[];
  achievements: PaginatedAchievements;
  filters: Filters;
  years: string[];
  levels: string[];
}>();

const bannerImage = '/images/background-banner.png';
const googleFormUrl = 'https://forms.gle/your-google-form-link'; // Ganti dengan URL Google Form Anda

// State untuk filter tabel
const search = ref(props.filters.search || '');
const year = ref(props.filters.year || '');
const level = ref(props.filters.level || '');

// Terapkan filter saat nilai berubah
watch([search, year, level], debounce(() => {
    router.get(route('prestasi.index'), {
        search: search.value,
        year: year.value,
        level: level.value,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));
</script>

<template>
    <PublicLayout title="Prestasi Mahasiswa">
        <Head>
            <title>Prestasi Mahasiswa FSTI</title>
            <meta name="description" content="Lihat semua prestasi membanggakan dari mahasiswa Fakultas Sains dan Teknologi Informasi ITK.">
        </Head>
        
        <Banner title="Prestasi Mahasiswa" :background-image="bannerImage" />

        <div class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 mb-16">
                    
                    <div class="lg:col-span-2">
                        <section>
                            <!-- PERBAIKAN: Header section diubah untuk menyertakan tombol -->
                            <div class="flex justify-between items-center mb-8">
                                <div class="flex items-center">
                                    <Trophy class="w-10 h-10 text-[#4682A9]" />
                                    <h2 class="ml-4 text-4xl font-bold font-kulim-park text-[#4682A9]">Sorotan Prestasi</h2>
                                </div>
                                <Link :href="route('berita.index', { category: 'Prestasi' })" class="inline-flex items-center font-semibold text-white bg-[#133E87] border border-transparent rounded-full px-5 py-2 hover:bg-blue-800 transition-colors duration-300 shadow-sm text-sm">
                                    Lihat Semua
                                    <ArrowRight class="ml-2 h-4 w-4" />
                                </Link>
                            </div>
                            
                            <div v-if="featuredAchievements.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <AchievementCard v-for="post in featuredAchievements" :key="post.id" :post="post" />
                            </div>
                            <div v-else class="bg-white p-12 rounded-2xl shadow-lg border-2 border-gray-100 flex flex-col items-center justify-center text-center">
                                <FileWarning class="w-16 h-16 text-gray-400 mb-4" />
                                <h3 class="text-xl font-bold text-black">Belum Ada Sorotan</h3>
                                <p class="mt-2 max-w-sm text-gray-500">Saat ini belum ada berita prestasi terbaru yang dapat kami sorot. Silakan lihat daftar lengkap di bawah ini.</p>
                            </div>
                        </section>
                    </div>

                    <aside class="lg:col-span-1">
                        <div class="sticky top-24">
                            <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-gray-100 text-center">
                                <h3 class="text-2xl font-bold text-black">Punya Prestasi?</h3>
                                <p class="mt-4 text-gray-600">
                                    Bantu kami mendata dan mempublikasikan setiap capaian membanggakan dari mahasiswa FSTI.
                                </p>
                                <a :href="googleFormUrl" target="_blank" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#133E87] text-white font-bold px-6 py-3 text-base hover:bg-opacity-90 transition-transform transform hover:scale-105 duration-300 shadow-lg">
                                    <Award class="w-5 h-5" />
                                    Laporkan Prestasimu
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>

                <section>
                    <div class="flex items-center mb-8">
                         <h2 class="text-4xl font-bold font-kulim-park text-[#4682A9]">Daftar Lengkap Prestasi</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="relative">
                            <input 
                                type="text" 
                                v-model="search"
                                placeholder="Cari nama atau lomba..." 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            >
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        </div>
                        <select v-model="year" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tahun</option>
                            <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
                        </select>
                        <select v-model="level" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tingkat</option>
                            <option v-for="l in levels" :key="l" :value="l">{{ l }}</option>
                        </select>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Nama Mahasiswa</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Nama Lomba</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Penyelenggara</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Tingkat</th>
                                    <th class="p-4 text-sm font-semibold text-gray-600">Tahun</th>
                                </tr>
                            </thead>
                            <tbody v-if="achievements.data.length > 0">
                                <tr v-for="achievement in achievements.data" :key="achievement.id" class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="p-4 font-medium text-black">{{ achievement.student_name }}</td>
                                    <td class="p-4 text-gray-700">{{ achievement.competition_name }}</td>
                                    <td class="p-4 text-gray-700">{{ achievement.organizer }}</td>
                                    <td class="p-4 text-gray-700">{{ achievement.level }}</td>
                                    <td class="p-4 text-gray-700">{{ achievement.year }}</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5" class="text-center p-8 text-gray-500">
                                        Tidak ada prestasi yang cocok dengan filter Anda.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="achievements.links.length > 3" class="mt-8 flex justify-center items-center space-x-1">
                        <template v-for="(link, index) in achievements.links" :key="index">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                v-html="link.label"
                                class="px-4 py-2 text-sm font-semibold rounded-lg"
                                :class="{
                                    'bg-[#133E87] text-white': link.active,
                                    'text-black hover:bg-gray-200': !link.active,
                                }"
                            />
                            <span
                                v-else
                                v-html="link.label"
                                class="px-4 py-2 text-sm font-semibold rounded-lg text-black cursor-not-allowed"
                            />
                        </template>
                    </div>
                </section>
                
            </div>
        </div>
    </PublicLayout>
</template>

