<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { GraduationCap, Trophy, CheckSquare, Building2, BookOpen, UserCheck, Users, ArrowRight } from 'lucide-vue-next';

// Data untuk section Berita Terbaru
const beritaList = [
    {
        image: '/images/berita1.png', // Ganti dengan path gambar Anda
        tag: 'Kegiatan',
        date: '18 Agustus 2025',
        title: 'Prodi Fisika FSTI ikuti Pertemuan Ilmiah Nasional Fisika Medis & Biofisika VIII di Surabaya',
        excerpt: 'Pada 7-9 Agustus 2025, Program Studi Fisika Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan (ITK), berpartisipasi dalam Pertemuan Ilmiah Tahunan Nasional Fisika Medis dan Biofisika ke-VIII yang diselenggarakan di Surabaya.',
        href: '#'
    },
    {
        image: '/images/berita2.png', // Ganti dengan path gambar Anda
        tag: 'Kegiatan',
        date: '21 Agustus 2025',
        title: 'Orientasi Akademik Mahasiswa Baru Magister MMT FSTI',
        excerpt: 'FSTI ITK sukses menggelar Orientasi Akademik bagi mahasiswa baru Program Magister Manajemen Teknologi pada 19 Agustus 2025. Kegiatan hype ini memperkenalkan sistem akademik, layanan kampus, serta kurikulum MMT untuk mendukung kesiapan studi pascasarjana.',
        href: '#'
    },
    {
        image: '/images/berita3.png', // Ganti dengan path gambar Anda
        tag: 'Kegiatan',
        date: '21 Agustus 2025',
        title: 'FSTI ITK Jalin Kerja Sama Strategis dengan Universitas Kristen Maranatha',
        excerpt: 'FSTI ITK menerima kunjungan resmi dari Universitas Kristen Maranatha pada 28 Juli 2025 untuk menjajaki kolaborasi akademik dan riset. Fokus kerja sama meliputi AI, Smart Campus, Smart Home, Multimedia, hingga Transportation Safety. Nota kesepahaman awal ditandatangani sebagai langkah menuju implementasi bersama.',
        href: '#'
    }
];
</script>

<template>
    <PublicLayout>
        <!-- SECTION 1: HERO -->
        <div class="relative bg-white pb-24">
            <!-- Kontainer utama yang akan diberi bentuk lengkung -->
            <section 
                class="relative w-full h-[600px] bg-gray-500"
                style="clip-path: ellipse(120% 100% at 50% 0%);"
            >
                <!-- Gambar Latar Belakang -->
                <img 
                src="/images/gambar-beranda-1.jpeg" 
                alt="Suasana FSTI ITK" 
                class="absolute inset-0 w-full h-full object-cover object-[center_68%]"
            >
                <!-- Overlay Warna Transparan -->
                <div class="absolute inset-0 bg-[#91C8E4] opacity-60"></div>

                <!-- Konten di atas gambar -->
                <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center -mt-16">
                    <!-- Judul dengan Font dan Stroke Kustom -->
                    <h1 class="font-kulim-park text-5xl md:text-6xl font-bold text-white text-stroke-custom text-shadow-custom tracking-wider -mt-16">
                        FAKULTAS SAINS DAN TEKNOLOGI INFORMASI
                    </h1>
                    <h2 class="mt-4 font-kulim-park text-3xl md:text-5xl font-bold text-white text-stroke-custom text-shadow-custom tracking-wider">
                        INSTITUT TEKNOLOGI KALIMANTAN
                    </h2>

                    <!-- Tombol Aksi (CTA) -->
                    <div class="mt-10">
                        <a href="#" class="inline-block bg-white text-black-800 font-bold text-lg px-6 py-2 rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 duration-300 -mt-16">
                            Tentang FSTI
                        </a>
                    </div>
                </div>
            </section>

            <!-- 3 Kartu Fungsional (diposisikan di atas lengkungan) -->
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center items-center gap-8 flex-wrap">
                    <!-- Kartu Program Studi -->
                    <div class="w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl transform hover:-translate-y-2 transition-transform duration-300 cursor-pointer">
                        <GraduationCap :size="80" class="mx-auto" />
                        <h3 class="mt-4 text-xl font-bold font-kulim-park">Program Studi</h3>
                    </div>
                    <!-- Kartu Prestasi Mahasiswa -->
                    <div class="w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl transform hover:-translate-y-2 transition-transform duration-300 cursor-pointer">
                        <Trophy :size="80" class="mx-auto" />
                        <h3 class="mt-4 text-xl font-bold font-kulim-park">Prestasi Mahasiswa</h3>
                    </div>
                    <!-- Kartu Layanan Mahasiswa -->
                    <div class="w-[255px] h-[237px] bg-[#749BC2] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl transform hover:-translate-y-2 transition-transform duration-300 cursor-pointer">
                        <CheckSquare :size="80" class="mx-auto" />
                        <h3 class="mt-4 text-xl font-bold font-kulim-park">Layanan Mahasiswa</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Sekilas Tentang FSTI ITK-->
        <section class="bg-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            
            <div class="lg:w-1/2 text-left">
                <h2 class="text-4xl font-bold font-kulim-park text-[#4682A9]">
                    Sekilas Tentang FSTI ITK
                </h2>
                <p class="mt-6 text-black-600 leading-relaxed">
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

<!-- Section Berita Terbaru -->
<section class="relative bg-gray-100 py-20 overflow-hidden">
    <div class="absolute -top-20 -left-40 z-0">
        <img src="/images/decoration-lines.svg" alt="decoration" class="w-[500px] h-auto opacity-10">
    </div>
    <div class="absolute -bottom-20 -right-40 z-0">
        <img src="/images/decoration-lines.svg" alt="decoration" class="w-[500px] h-auto opacity-10 transform rotate-180">
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl font-bold font-kulim-park text-gray-800">Berita Terbaru</h2>
                <p class="mt-2 text-gray-500">Informasi terkini seputar FSTI</p>
            </div>
            <a href="#" class="inline-flex items-center font-semibold text-blue-600 border border-gray-300 rounded-full px-4 py-2 hover:bg-blue-50 transition-colors duration-300">
                Lihat Semua
                <ArrowRight class="ml-2 h-4 w-4" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-for="berita in beritaList" :key="berita.title" class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transition-transform transform hover:-translate-y-2 duration-300">
                <img :src="berita.image" :alt="berita.title" class="w-full h-48 object-cover">
                
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span class="border border-gray-300 rounded px-2 py-1">{{ berita.tag }}</span>
                        <span>{{ berita.date }}</span>
                    </div>
                    
                    <h3 class="mt-4 text-lg font-bold text-gray-800 leading-snug">{{ berita.title }}</h3>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed flex-grow">{{ berita.excerpt }}</p>

                    <div class="mt-6">
                        <a :href="berita.href" class="inline-block bg-blue-800 text-white font-bold px-6 py-3 rounded-full hover:bg-blue-900 transition-colors duration-300">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    </PublicLayout>
</template>

<style scoped>
.text-stroke-custom {
  -webkit-text-stroke: 2px #4682A9;
  color: white; /* Pastikan warna fill teks tetap putih */
}

.text-shadow-custom {
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
}

</style>