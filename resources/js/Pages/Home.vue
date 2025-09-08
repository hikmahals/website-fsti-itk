<script setup lang="ts">
// Impor dari Vue
import { onMounted, ref } from 'vue';

// Impor komponen dan utilitas yang sudah ada
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HomeArticleCard from '@/Components/HomeArticleCard.vue';
import { Link } from '@inertiajs/vue3';
import { GraduationCap, Trophy, CheckSquare, Building2, BookOpen, UserCheck, Users, ArrowRight } from 'lucide-vue-next';
import type { Post } from '@/types';

// Impor GSAP dan ScrollTrigger untuk animasi
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

// Daftarkan plugin ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

// Props yang sudah ada
const props = defineProps<{
  latestPosts: Post[];
  latestAchievements: Post[];
  canLogin?: boolean;
  canRegister?: boolean;
}>();

// Buat refs untuk setiap section yang akan dianimasikan
const heroCardsRef = ref<HTMLDivElement | null>(null);
const aboutSectionRef = ref<HTMLDivElement | null>(null);
const newsSectionRef = ref<HTMLDivElement | null>(null);
const achievementSectionRef = ref<HTMLDivElement | null>(null);

// Logika animasi yang dijalankan setelah komponen dimuat
onMounted(() => {
    // Animasi untuk kartu di bawah hero
    if (heroCardsRef.value) {
        gsap.from(heroCardsRef.value.children, {
            scrollTrigger: { trigger: heroCardsRef.value, start: "top 85%" },
            opacity: 0, y: 50, duration: 0.6, stagger: 0.2, ease: "power2.out",
            clearProps: "all" // Hapus semua style setelah animasi selesai
        });
    }

    // Animasi sekuensial untuk section "About"
    if (aboutSectionRef.value) {
        const aboutTl = gsap.timeline({
            scrollTrigger: { trigger: aboutSectionRef.value, start: "top 75%" }
        });
        aboutTl.from(".about-title", { opacity: 0, y: 40, duration: 0.6, ease: "power3.out" })
               .from(".about-text", { opacity: 0, y: 40, duration: 0.6, ease: "power3.out" }, "-=0.4")
               .from(".about-stat", { opacity: 0, y: 40, duration: 0.5, stagger: 0.15, ease: "power2.out" }, "-=0.4");
    }

    // PERBAIKAN: Animasi sekuensial untuk section "Berita" dan kartu-kartunya
    if (newsSectionRef.value) {
        const newsTl = gsap.timeline({
            scrollTrigger: { trigger: newsSectionRef.value, start: "top 75%" }
        });
        const newsHeader = newsSectionRef.value.querySelector('.flex.justify-between');
        const newsCards = newsSectionRef.value.querySelector('.grid');

        if (newsHeader) {
            newsTl.from(newsHeader, { opacity: 0, y: 50, duration: 0.7, ease: "power3.out" });
        }
        if (newsCards) {
            newsTl.from(newsCards.children, {
                opacity: 0, y: 50, duration: 0.5, stagger: 0.2, ease: "power2.out"
            }, "-=0.4");
        }
    }

    // PERBAIKAN: Animasi sekuensial untuk section "Prestasi" dan kartu-kartunya
    if (achievementSectionRef.value) {
        const achievementTl = gsap.timeline({
            scrollTrigger: { trigger: achievementSectionRef.value, start: "top 75%" }
        });
        const achievementHeader = achievementSectionRef.value.querySelector('.flex.justify-between');
        const achievementCards = achievementSectionRef.value.querySelector('.grid');
        
        if (achievementHeader) {
            achievementTl.from(achievementHeader, { opacity: 0, y: 50, duration: 0.7, ease: "power3.out" });
        }
        if (achievementCards) {
            achievementTl.from(achievementCards.children, {
                opacity: 0, y: 50, duration: 0.5, stagger: 0.2, ease: "power2.out"
            }, "-=0.4");
        }
    }
});
</script>

<template>
    <PublicLayout>
        <!-- Div tersembunyi untuk memastikan Tailwind mengenali kelas warna -->
        <div class="hidden bg-[#CBDCEB]"></div>

        <!-- Section Hero -->
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
                <div ref="heroCardsRef" class="flex justify-center items-start gap-8 flex-wrap">
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

        <!-- Section Sekilas Tentang FSTI -->
        <section ref="aboutSectionRef" class="bg-white py-20 overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                    <div class="lg:w-1/2 text-left">
                        <h2 class="text-4xl font-bold font-kulim-park text-[#4682A9] about-title">
                            Sekilas Tentang FSTI ITK
                        </h2>
                        <p class="mt-6 text-gray-600 leading-relaxed about-text">
                            FSTI terus berkembang sebagai pusat pendidikan dan inovasi di bidang sains dan teknologi, dengan berbagai jurusan, program studi, dan civitas akademika yang mendukung perjalanan belajar, kreativitas, dan prestasi mahasiswa kami.
                        </p>
                        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat">
                                <Building2 :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">2</span>
                                <span class="block mt-1 text-sm">Jurusan</span>
                            </div>
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat">
                                <BookOpen :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">9</span>
                                <span class="block mt-1 text-sm">Program Studi</span>
                            </div>
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat">
                                <UserCheck :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">118</span>
                                <span class="block mt-1 text-sm">Dosen</span>
                            </div>
                            <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat">
                                <Users :size="28" class="mx-auto" />
                                <span class="block mt-2 text-3xl font-bold">6</span>
                                <span class="block mt-1 text-sm">Tendik</span>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2 about-text">
                        <div class="bg-[#749BC2] p-2 rounded-xl shadow-xl">
                            <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Berita Terbaru -->
        <section 
          ref="newsSectionRef"
          v-if="latestPosts.length > 0"
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
                    <!-- Kartu berita menggunakan HomeArticleCard -->
                    <HomeArticleCard v-for="post in latestPosts" :key="post.id" :post="post" />
                </div>
            </div>
        </section>

        <!-- Section Prestasi Terbaru -->
        <section 
          ref="achievementSectionRef"
          v-if="latestAchievements.length > 0"
          class="relative py-20 overflow-hidden bg-white"
        >
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-5xl font-bold font-kulim-park text-[#4682A9]">Prestasi Terbaru</h2>
                        <p class="mt-2 text-black">Capaian membanggakan dari Mahasiswa FSTI ITK</p>
                    </div>
                    <Link :href="route('berita.index', { category: 'Prestasi' })" class="inline-flex items-center font-semibold text-white bg-[#133E87] border border-transparent rounded-full px-5 py-2 hover:bg-blue-800 transition-colors duration-300 shadow-sm">
                        Lihat Semua
                        <ArrowRight class="ml-2 h-4 w-4" />
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Kartu prestasi menggunakan HomeArticleCard dengan warna kustom -->
                    <HomeArticleCard 
                        v-for="post in latestAchievements" 
                        :key="post.id" 
                        :post="post" 
                        bg-color-class="bg-[#CBDCEB]"
                    />
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

