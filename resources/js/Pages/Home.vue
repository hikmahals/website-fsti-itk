<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { X, Plus } from 'lucide-vue-next'; // 👉 icon untuk modal & tombol +
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HomeArticleCard from '@/Components/HomeArticleCard.vue';
import AchievementCard from '@/Components/AchievementCard.vue';
import { Link } from '@inertiajs/vue3';
import { GraduationCap, Trophy, CheckSquare, Building2, BookOpen, UserCheck, Users, ArrowRight } from 'lucide-vue-next';
import type { Post, Achievement } from '@/types';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const props = defineProps<{
  latestPosts: Post[];
  latestAchievements: Achievement[];
  canLogin?: boolean;
  canRegister?: boolean;
}>();

// refs animasi
const heroSectionRef = ref(null);
const heroTitle1Ref = ref(null);
const heroTitle2Ref = ref(null);
const heroButtonRef = ref(null);
const heroCardsRef = ref<HTMLDivElement | null>(null);
const aboutSectionRef = ref<HTMLDivElement | null>(null);
const aboutImageRef = ref(null);
const aboutStatsRef = ref<HTMLDivElement | null>(null);
const newsSectionRef = ref<HTMLDivElement | null>(null);
const achievementSectionRef = ref<HTMLDivElement | null>(null);

// 👉 state modal
const showModal = ref(false);

const openModal = () => {
  showModal.value = true;
};
const closeModal = () => {
  showModal.value = false;
};

// fungsi hover animasi
const addHoverAnimation = (elements: Element[]) => {
  elements.forEach(el => {
    el.addEventListener('mouseenter', () => {
      gsap.to(el, { scale: 1.05, duration: 0.3, ease: 'power2.out' });
    });
    el.addEventListener('mouseleave', () => {
      gsap.to(el, { scale: 1, duration: 0.3, ease: 'power2.out' });
    });
  });
};

onMounted(() => {
  // Animasi Hero
  const heroTl = gsap.timeline({ defaults: { ease: "power3.out" } });
  heroTl.from([heroTitle1Ref.value, heroTitle2Ref.value], { opacity: 0, y: 40, duration: 1, stagger: 0.2 })
        .from(heroButtonRef.value, { opacity: 0, y: 20, duration: 0.8 }, "-=0.5");

  gsap.to(".hero-image", {
    scale: 1.1,
    scrollTrigger: { trigger: heroSectionRef.value, start: "top top", end: "bottom top", scrub: 1.5 }
  });

  const heroCardsElement = heroCardsRef.value;
  if (heroCardsElement) {
    const cards = Array.from(heroCardsElement.children);
    gsap.set(cards, { opacity: 0, y: 60 });
    gsap.to(cards, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.2,
      ease: "power3.out",
      scrollTrigger: {
        trigger: heroCardsElement,
        start: "top 90%",
      }
    });
    addHoverAnimation(cards);
  }

  if (aboutSectionRef.value) {
    const aboutTl = gsap.timeline({ scrollTrigger: { trigger: aboutSectionRef.value, start: "top 70%" } });
    aboutTl.from(".about-title", { opacity: 0, x: -50, duration: 0.8, ease: "power3.out" })
           .from(".about-text", { opacity: 0, x: -50, duration: 0.8, ease: "power3.out" }, "-=0.6")
           .from(".about-stat", { opacity: 0, y: 30, scale: 0.95, duration: 0.6, stagger: 0.15, ease: "back.out(1.4)" }, "-=0.6")
           .from(aboutImageRef.value, { opacity: 0, x: 50, scale: 0.9, duration: 1.2, ease: "power3.out" }, "<");

    const aboutStatsElement = aboutStatsRef.value;
    if (aboutStatsElement) {
      addHoverAnimation(Array.from(aboutStatsElement.children));
    }
  }

  if (newsSectionRef.value) {
    const newsCards = newsSectionRef.value.querySelectorAll('.grid > *');
    const newsTl = gsap.timeline({
      scrollTrigger: { trigger: newsSectionRef.value, start: "top 70%" }
    });
    newsTl.from(newsSectionRef.value.querySelector('.news-header'), {
      opacity: 0, y: 50, duration: 0.8, ease: "power3.out"
    }).from(newsCards, {
      opacity: 0, y: 50, duration: 0.7, stagger: 0.2, ease: "power3.out"
    }, "-=0.5");
    addHoverAnimation(Array.from(newsCards));
    gsap.to(".news-background-pattern", {
      yPercent: -20,
      ease: "none",
      scrollTrigger: {
        trigger: newsSectionRef.value,
        start: "top bottom",
        end: "bottom top",
        scrub: true,
      }
    });
  }

  if (achievementSectionRef.value) {
    const achievementCards = achievementSectionRef.value.querySelectorAll('.grid > *');
    const achievementTl = gsap.timeline({
      scrollTrigger: { trigger: achievementSectionRef.value, start: "top 70%" }
    });
    achievementTl.from(achievementSectionRef.value.querySelector('.flex.justify-between'), {
      opacity: 0, y: 50, duration: 0.8, ease: "power3.out"
    }).from(achievementCards, {
      opacity: 0, y: 50, duration: 0.7, stagger: 0.2, ease: "power3.out"
    }, "-=0.5");
    addHoverAnimation(Array.from(achievementCards));
  }

  setTimeout(() => {
    ScrollTrigger.refresh();
  }, 500);
});
</script>

<template>
  <PublicLayout>
    <div class="hidden bg-[#CBDCEB]"></div>

    <!-- HERO -->
    <div class="relative bg-white pb-24">
      <section 
        ref="heroSectionRef"
        class="relative w-full h-[600px] bg-gray-500 overflow-hidden"
        style="clip-path: ellipse(120% 100% at 50% 0%);"
      >
        <img src="/images/gambar-beranda-1.jpeg" alt="Suasana FSTI ITK" class="hero-image absolute inset-0 w-full h-full object-cover object-[center_68%]">
        <div class="absolute inset-0 bg-[#91C8E4] opacity-60"></div>
        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center -mt-16">
          <h1 ref="heroTitle1Ref" class="font-kulim-park text-5xl md:text-6xl font-bold text-white text-stroke-custom text-shadow-custom tracking-wider mt-8">
            FAKULTAS SAINS DAN TEKNOLOGI INFORMASI
          </h1>
          <h2 ref="heroTitle2Ref" class="mt-4 font-kulim-park text-3xl md:text-5xl font-bold text-white text-stroke-custom text-shadow-custom tracking-wider">
            INSTITUT TEKNOLOGI KALIMANTAN
          </h2>
          <div ref="heroButtonRef" class="mt-10">
            <a href="#" class="inline-block bg-white text-black font-bold text-lg px-6 py-2 rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 duration-300 -mt-16">
              Tentang FSTI
            </a>
          </div>
        </div>
      </section>

      <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full container mx-auto px-4 sm:px-6 lg:px-8">
        <div ref="heroCardsRef" class="flex justify-center items-start gap-8 flex-wrap">
          <Link 
            :href="route('profil.pimpinan-prodi')" 
            class="block w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl"
          >
            <GraduationCap :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-kulim-park">Program Studi</h3>
          </Link>
          <Link 
            :href="route('prestasi.index')" 
            class="block w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl"
          >
            <Trophy :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-kulim-park">Prestasi Mahasiswa</h3>
          </Link>
          <a 
            href="https://layanan-fsti.myst-tech.com/" 
            target="_blank" 
            rel="noopener noreferrer"
            class="block w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl"
          >
            <CheckSquare :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-kulim-park">Layanan Mahasiswa</h3>
          </a>
        </div>
      </div>
    </div>

    <!-- SEKILAS TENTANG -->
    <section ref="aboutSectionRef" class="bg-white py-20 overflow-hidden">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
          <div class="lg:w-1/2 text-left">
            <h2 class="text-4xl font-bold font-kulim-park text-[#4682A9] about-title">
              Sekilas Tentang FSTI ITK
            </h2>
            <p class="mt-6 text-black leading-relaxed about-text">
              FSTI terus berkembang sebagai pusat pendidikan dan inovasi di bidang sains dan teknologi, dengan berbagai jurusan, program studi, dan civitas akademika yang mendukung perjalanan belajar, kreativitas, dan prestasi mahasiswa kami.
            </p>
            <div ref="aboutStatsRef" class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
              <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <Building2 :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold">2</span>
                <span class="block mt-1 text-sm">Jurusan</span>
              </div>
              <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <BookOpen :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold">9</span>
                <span class="block mt-1 text-sm">Program Studi</span>
              </div>
              <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <UserCheck :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold">118</span>
                <span class="block mt-1 text-sm">Dosen</span>
              </div>
              <div class="bg-[#CBDCEB] text-[#133E87] p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <Users :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold">6</span>
                <span class="block mt-1 text-sm">Tendik</span>
              </div>
            </div>
          </div>

          <!-- Gambar + tombol + -->
          <div ref="aboutImageRef" class="lg:w-1/2 relative">
            <div class="bg-[#749BC2] p-2 rounded-xl shadow-xl relative">
              <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full">
              <!-- Tombol + di kanan atas -->
              <button 
                @click="openModal" 
                class="absolute top-3 right-3 bg-white rounded-full p-2 shadow hover:bg-gray-100 transition"
              >
                <Plus :size="20" class="text-[#133E87]" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal -->
    <div 
      v-if="showModal" 
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 transition-opacity"
    >
      <div class="relative bg-white rounded-lg shadow-xl p-4 max-w-3xl w-full">
        <!-- Tombol close -->
        <button 
          @click="closeModal" 
          class="absolute top-2 right-2 bg-gray-100 rounded-full p-1 hover:bg-gray-200 transition"
        >
          <X :size="20" />
        </button>
        <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full max-h-[80vh] object-contain">
      </div>
    </div>

    <!-- BERITA -->
    <section 
      ref="newsSectionRef"
      v-if="latestPosts.length > 0"
      class="relative py-20 overflow-hidden bg-[#CBDCEB]"
    >
      <div 
        class="news-background-pattern absolute top-[-40%] left-0 w-full h-[180%] z-0 bg-repeat"
        :style="{ backgroundImage: `url('/images/pattern-berita.png')` }"
      ></div>
      
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center mb-12 news-header">
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

    <!-- PRESTASI -->
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
          <Link :href="route('prestasi.index')" class="inline-flex items-center font-semibold text-white bg-[#133E87] border border-transparent rounded-full px-5 py-2 hover:bg-blue-800 transition-colors duration-300 shadow-sm">
            Lihat Semua
            <ArrowRight class="ml-2 h-4 w-4" />
          </Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 -mt-10">
          <AchievementCard 
            v-for="achievement in latestAchievements" 
            :key="achievement.id" 
            :achievement="achievement" 
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
