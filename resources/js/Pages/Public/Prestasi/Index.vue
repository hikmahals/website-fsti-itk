<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'; // PERUBAHAN
import { router, Link, Head } from '@inertiajs/vue3';

// Layouts & Components
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import AchievementCard from '@/Components/AchievementCard.vue';

// Icons
import { Trophy, Award, Search, FileWarning, Medal, Star, BookOpen, Palette, Send, ChevronDown } from 'lucide-vue-next'; // PERUBAHAN

// Import AOS untuk animasi
import AOS from 'aos';
import 'aos/dist/aos.css';

// Types
import type { PaginatedAchievements, Filters } from '@/types';

const props = defineProps<{
  achievements: PaginatedAchievements;
  stats: {
    total_all_time: number;
    international: number;
    national: number;
    academic: number;
    non_academic: number;
  };
  filters: Filters;
  years: string[];
  levels: string[];
  categories: string[];
}>();

const bannerImage = '/images/background-banner.png';
const googleFormUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSfaToVEnR6vnZSTggEbH_IfAVbOpuPf1aCirsNTRb3m8aFL-Q/viewform?pli=1';

const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');
const selectedLevel = ref(props.filters.level || '');
const selectedCategory = ref(props.filters.category || '');

// --- LOGIKA BARU UNTUK 3 CUSTOM DROPDOWN ---
const isCategoryOpen = ref(false);
const isLevelOpen = ref(false);
const isYearOpen = ref(false);

const categoryBtnRef = ref<HTMLButtonElement | null>(null);
const levelBtnRef = ref<HTMLButtonElement | null>(null);
const yearBtnRef = ref<HTMLButtonElement | null>(null);

const categoryDropdownStyle = ref({});
const levelDropdownStyle = ref({});
const yearDropdownStyle = ref({});

// Fungsi generik untuk membuka dropdown dan mengatur posisi
const toggleDropdown = (type: 'category' | 'level' | 'year') => {
    const refs = { category: categoryBtnRef, level: levelBtnRef, year: yearBtnRef };
    const isOpenRefs = { category: isCategoryOpen, level: isLevelOpen, year: isYearOpen };
    const styleRefs = { category: categoryDropdownStyle, level: levelDropdownStyle, year: yearDropdownStyle };

    // Tutup semua dropdown lain
    Object.keys(isOpenRefs).forEach(key => {
        if (key !== type) isOpenRefs[key as keyof typeof isOpenRefs].value = false;
    });

    const isOpen = isOpenRefs[type];
    if (isOpen.value) {
        isOpen.value = false;
    } else {
        const button = refs[type].value;
        if (button) {
            const rect = button.getBoundingClientRect();
            styleRefs[type].value = {
                position: 'absolute',
                top: `${rect.bottom + window.scrollY + 4}px`,
                left: `${rect.left}px`,
                width: `${rect.width}px`,
            };
        }
        isOpen.value = true;
    }
};

// Fungsi untuk memilih opsi
function selectOption(type: 'category' | 'level' | 'year', value: string) {
    if (type === 'category') {
        selectedCategory.value = value;
        isCategoryOpen.value = false;
    } else if (type === 'level') {
        selectedLevel.value = value;
        isLevelOpen.value = false;
    } else if (type === 'year') {
        selectedYear.value = value;
        isYearOpen.value = false;
    }
}

// Menutup dropdown jika klik di luar
const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as Node;
    const check = (btnRef: typeof categoryBtnRef, menuId: string, isOpenRef: typeof isCategoryOpen) => {
        const menu = document.getElementById(menuId);
        if (btnRef.value && !btnRef.value.contains(target) && menu && !menu.contains(target)) {
            isOpenRef.value = false;
        }
    };
    check(categoryBtnRef, 'category-dropdown-menu', isCategoryOpen);
    check(levelBtnRef, 'level-dropdown-menu', isLevelOpen);
    check(yearBtnRef, 'year-dropdown-menu', isYearOpen);
};

onMounted(() => {
  AOS.init({ duration: 800, once: true });
  document.addEventListener('mousedown', handleClickOutside);
});
onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});
// --- END LOGIKA BARU ---

const applyFilters = () => {
    router.get(route('prestasi.index'), {
        search: search.value,
        year: selectedYear.value,
        level: selectedLevel.value,
        category: selectedCategory.value,
    }, {
        preserveState: true,
        replace: true,
        onFinish: () => { AOS.refresh(); } // Re-init AOS jika data berubah
    });
};
</script>

<template>
    <PublicLayout title="Prestasi Mahasiswa">
        <Head>
            <title>Prestasi Mahasiswa FSTI</title>
            <meta name="description" content="Jelajahi galeri prestasi membanggakan dari mahasiswa Fakultas Sains dan Teknologi Informasi ITK.">
        </Head>

        <Banner title="Prestasi Mahasiswa" :background-image="bannerImage" />

        <div class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                <section class="mb-20" data-aos="fade-up">
                    <h2 class="text-3xl font-bold font-kulim-park text-[#4682A9]">Statistik Prestasi</h2>
                    <p class="text-black mt-2">Ringkasan capaian mahasiswa berdasarkan tingkat dan kategori prestasi</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-8">
    
                        <div class="bg-[#CBDCEB] p-6 rounded-lg text-[#133E87] text-center transition-transform duration-300 ease-out hover:shadow-2xl hover:animate-[zoomPulse_0.8s_ease-in-out]" data-aos="fade-up" data-aos-delay="100">
                            <Trophy class="w-8 h-8 mx-auto mb-3"/>
                            <p class="text-4xl font-bold">{{ stats.total_all_time }}</p>
                            <p class="font-semibold mt-1 text-sm">Total Prestasi</p>
                        </div>

                        <div class="bg-[#CBDCEB] p-6 rounded-lg text-[#133E87] text-center transition-transform duration-300 ease-out hover:shadow-2xl hover:animate-[zoomPulse_0.8s_ease-in-out]" data-aos="fade-up" data-aos-delay="200">
                            <Medal class="w-8 h-8 mx-auto mb-3"/>
                            <p class="text-4xl font-bold">{{ stats.international }}</p>
                            <p class="font-semibold mt-1 text-sm">Prestasi Internasional</p>
                        </div>

                        <div class="bg-[#CBDCEB] p-6 rounded-lg text-[#133E87] text-center transition-transform duration-300 ease-out hover:shadow-2xl hover:animate-[zoomPulse_0.8s_ease-in-out]" data-aos="fade-up" data-aos-delay="300">
                            <Award class="w-8 h-8 mx-auto mb-3"/>
                            <p class="text-4xl font-bold">{{ stats.national }}</p>
                            <p class="font-semibold mt-1 text-sm">Prestasi Nasional</p>
                        </div>

                        <div class="bg-[#CBDCEB] p-6 rounded-lg text-[#133E87] text-center transition-transform duration-300 ease-out hover:shadow-2xl hover:animate-[zoomPulse_0.8s_ease-in-out]" data-aos="fade-up" data-aos-delay="400">
                            <Star class="w-8 h-8 mx-auto mb-3"/>
                            <p class="text-4xl font-bold">{{ stats.academic }}</p>
                            <p class="font-semibold mt-1 text-sm">Prestasi Akademik</p>
                        </div>

                        <div class="bg-[#CBDCEB] p-6 rounded-lg text-[#133E87] text-center transition-transform duration-300 ease-out hover:shadow-2xl hover:animate-[zoomPulse_0.8s_ease-in-out]" data-aos="fade-up" data-aos-delay="500">
                            <Trophy class="w-8 h-8 mx-auto mb-3"/>
                            <p class="text-4xl font-bold">{{ stats.non_academic }}</p>
                            <p class="font-semibold mt-1 text-sm">Prestasi Non-Akademik</p>
                        </div>
                    </div>
                </section>

                <section class="mb-16" data-aos="fade-up">
                    <h2 class="text-3xl font-bold font-kulim-park text-[#4682A9]">Jelajahi Prestasi</h2>
                    <p class="text-black mt-2">Temukan data prestasi mahasiswa berdasarkan kategori, tingkat, atau tahun</p>
                    <form @submit.prevent="applyFilters" class="mt-8 bg-[#CBDCEB] p-6 rounded-lg space-y-4">
                        <div class="relative w-full">
                            <input type="text" v-model="search" placeholder="Cari berdasarkan nama, prestasi, dll" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 transition">
                            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-end gap-4">
                            <div class="w-full md:w-1/3">
                                <label class="font-inter font-bold text-sm text-black mb-2 block">Kategori Prestasi</label>
                                <button ref="categoryBtnRef" @click="toggleDropdown('category')" type="button" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-left flex items-center justify-between focus:ring-2 focus:ring-blue-500 transition">
                                    <span class="text-black">{{ selectedCategory || 'Semua' }}</span>
                                    <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isCategoryOpen}" />
                                </button>
                            </div>
                            <div class="w-full md:w-1/3">
                                <label class="font-inter font-bold text-sm text-black mb-2 block">Tingkat Prestasi</label>
                                <button ref="levelBtnRef" @click="toggleDropdown('level')" type="button" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-left flex items-center justify-between focus:ring-2 focus:ring-blue-500 transition">
                                    <span class="text-black">{{ selectedLevel || 'Semua' }}</span>
                                    <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isLevelOpen}" />
                                </button>
                            </div>
                            <div class="w-full md:w-1/3">
                                <label class="font-inter font-bold text-sm text-black mb-2 block">Tahun Prestasi</label>
                                <button ref="yearBtnRef" @click="toggleDropdown('year')" type="button" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-left flex items-center justify-between focus:ring-2 focus:ring-blue-500 transition">
                                    <span class="text-black">{{ selectedYear || 'Semua' }}</span>
                                    <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isYearOpen}" />
                                </button>
                            </div>
                            <button type="submit" class="w-full md:w-auto bg-[#133E87] text-white font-semibold px-8 py-3 rounded-lg hover:bg-opacity-90 transition">
                                Terapkan
                            </button>
                        </div>
                    </form>
                </section>

                <section class="mb-20" data-aos="fade-up">
                    <h2 class="text-3xl font-bold font-kulim-park text-[#4682A9]">Potret Mahasiswa Berprestasi</h2>
                    <p class="text-black mt-2">Kumpulan mahasiswa berprestasi yang membanggakan FSTI ITK</p>
                    <div v-if="achievements.data.length > 0" class="mt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div
                                v-for="(achievement, index) in achievements.data"
                                :key="achievement.id"
                                data-aos="zoom-in"
                                :data-aos-delay="index * 100"
                                class="transition-transform transition-shadow duration-300 ease-out hover:scale-[1.02] hover:-translate-y-1 hover:shadow-xl rounded-2xl"
                            >
                                <AchievementCard 
                                    :achievement="achievement"
                                />
                            </div>
                        </div>
                        <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-4">
                            <p class="text-sm text-black">
                                Menampilkan <span class="font-semibold">{{ achievements.from }}</span> sampai <span class="font-semibold">{{ achievements.to }}</span> dari <span class="font-semibold">{{ achievements.total }}</span> prestasi
                            </p>
                            <div v-if="achievements.links.length > 3" class="flex items-center space-x-1">
                                <template v-for="(link, index) in achievements.links" :key="index">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                        class="px-3 py-1.5 text-sm font-semibold rounded-lg transition"
                                        :class="{'bg-[#133E87] text-white shadow-md': link.active, 'bg-gray-200 text-black hover:bg-gray-300': !link.active}"
                                    />
                                    <span v-else v-html="link.label" class="px-3 py-1.5 text-sm font-semibold rounded-lg text-gray-400 cursor-not-allowed"/>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-16 bg-gray-50 rounded-lg mt-8">
                        <FileWarning class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                        <h3 class="text-xl font-bold text-black">Tidak Ada Prestasi Ditemukan</h3>
                        <p class="mt-2 text-gray-500">Coba ubah atau hapus filter yang Anda gunakan.</p>
                    </div>
                </section>
                
                <section class="bg-[#CBDCEB] p-12 rounded-lg text-center" data-aos="fade-up">
                    <Trophy class="w-12 h-12 text-[#133E87] mx-auto mb-4"/>
                    <h2 class="text-2xl font-bold font-kulim-park text-[#133E87]">Jangan Biarkan Prestasi Anda Terlewat!</h2>
                    <p class="mt-3 max-w-2xl mx-auto text-[#133E87]">
                        Bagikan pencapaian Anda kepada fakultas agar dapat dipublikasikan dan menjadi inspirasi bagi mahasiswa lain.
                    </p>
                    <a :href="googleFormUrl" target="_blank" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white text-[#133E87] font-bold px-8 py-3 text-base hover:bg-gray-200 transition-transform transform hover:scale-105 duration-300 shadow-lg">
                        <Send class="w-5 h-5" />
                        Laporkan Prestasi
                    </a>
                </section>
            </div>
        </div>
    </PublicLayout>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isCategoryOpen" id="category-dropdown-menu" :style="categoryDropdownStyle" class="z-[9999] bg-white rounded-md shadow-lg border border-gray-200 py-1">
                <a @click="selectOption('category', '')" class="block px-4 py-2 text-black hover:bg-gray-100 cursor-pointer">Semua</a>
                <a v-for="c in categories" :key="c" @click="selectOption('category', c)" class="block px-4 py-2 text-black hover:bg-gray-100 cursor-pointer">{{ c }}</a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isLevelOpen" id="level-dropdown-menu" :style="levelDropdownStyle" class="z-[9999] bg-white rounded-md shadow-lg border border-gray-200 py-1">
                <a @click="selectOption('level', '')" class="block px-4 py-2 text-black hover:bg-gray-100 cursor-pointer">Semua</a>
                <a v-for="l in levels" :key="l" @click="selectOption('level', l)" class="block px-4 py-2 text-black hover:bg-gray-100 cursor-pointer">{{ l }}</a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isYearOpen" id="year-dropdown-menu" :style="yearDropdownStyle" class="z-[9999] bg-white rounded-md shadow-lg border border-gray-200 py-1">
                <a @click="selectOption('year', '')" class="block px-4 py-2 text-black hover:bg-gray-100 cursor-pointer">Semua</a>
                <a v-for="y in years" :key="y" @click="selectOption('year', y)" class="block px-4 py-2 text-black hover:bg-gray-100 cursor-pointer">{{ y }}</a>
            </div>
        </transition>
    </Teleport>

</template>

<style>
@keyframes zoomPulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.08);
  }
}
</style>