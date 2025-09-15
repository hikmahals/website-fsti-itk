<script setup>
import { shallowRef, ref } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Target, Goal, CheckCircle, BookCheck, BadgeCheck, Globe, ZoomIn } from 'lucide-vue-next';

// Data Visi, Misi, Tujuan
const visi = "Program Studi Matematika menjadi pusat pengembangan keilmuan Matematika dalam bidang industri dan lingkungan di Kalimantan Timur pada tahun 2035 melalui pemberdayaan potensi daerah.";
const misi = [
    "Menyelenggarakan pendidikan matematika yang berkualitas untuk menghasilkan lulusan yang berkompeten, sesuai kebutuhan pasar, siap melanjutkan pendidikan ke jenjang yang lebih tinggi, serta mampu memberikan sumbangsih bagi pembangunan nasional;",
    "Meningkatkan kegiatan penelitian matematika di bidang industri dan lingkungan sehingga mampu menjadi pusat pengembangan keilmuan matematika di Kalimantan Timur.",
    "Menerapkan ilmu matematika dan terapannya sebagai solusi masalah masyarakat dalam rangka pengabdian kepada masyarakat;",
    "Menjalin kerjasama dengan perguruan tinggi lain, industri, masyarakat, dan pemerintah."
];
const tujuan = "Menjadi wadah pengembangan keilmuan matematika dan proses pembelajaran yang berkualitas untuk meningkatkan kompetensi mahasiswa matematika sehingga menghasilkan sarjana yang mampu memahami sepenuhnya konsep dasar matematika, serta beretos kerja tinggi dalam berkarya dan berkontribusi.";

// Profil Lulusan
const profilLulusan = [
    { icon: BookCheck, text: 'Data Analyst' },
    { icon: BookCheck, text: 'Data Scientist' },
    { icon: BookCheck, text: 'Praktisi Industri dan Pemerintahan' },
    { icon: BookCheck, text: 'Akademisi dan Peneliti' },
    { icon: BookCheck, text: 'Business Analyst' },
    { icon: BookCheck, text: 'Aktuaris' },
    { icon: BookCheck, text: 'Konsultan' },
    { icon: BookCheck, text: 'Analisis Keuangan' },
];

// Modal Gambar
const modalImage = ref(null);
const isModalOpen = ref(false);

function openModal(imageUrl) {
    modalImage.value = imageUrl;
    isModalOpen.value = true;
}

function closeModal() {
    isModalOpen.value = false;
    modalImage.value = null;
}
</script>

<style scoped>
.text-stroke {
    -webkit-text-stroke-width: 5px;
    -webkit-text-stroke-color: #133E87;
    paint-order: stroke fill;
}

.image-container {
    position: relative;
    cursor: pointer;
}

.zoom-icon {
    position: absolute;
    top: 8px;
    right: 8px;
    background-color: rgba(255,255,255,0.8);
    border-radius: 9999px;
    padding: 4px;
    transition: background-color 0.2s;
}

.zoom-icon:hover {
    background-color: rgba(255,255,255,1);
}

.modal-backdrop {
    position: fixed;
    inset: 0;
    background-color: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-image {
    max-width: 90vw;
    max-height: 90vh;
    border-radius: 0.5rem;
}
</style>

<template>
<PublicLayout>
    <Banner
        title="PROGRAM STUDI"
        subtitle="PROGRAM STUDI"
        background-image="/images/background-banner.png"
    />

    <div class="bg-white">
        <!-- Sub Header -->
        <div class="relative pt-12 pb-16 flex items-center mt-8">
            <img 
                src="/images/prodi/matematika/subheader-matematika.png" 
                alt="Sub Header Program Studi Matematika" 
                class="absolute inset-0 w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-[#CBDCEB] opacity-75"></div>
            
            <div class="relative z-10 container mx-auto px-4 text-left" data-aos="fade-right">
                <p class="font-kulim-park font-bold text-2xl md:text-3xl text-[#133E87]">Program Studi</p>
                <h1 class="font-kulim-park font-bold text-6xl md:text-8xl text-white text-stroke leading-tight my-2">
                    MATEMATIKA
                </h1>
                <div class="w-24 mt-3 h-1.5 bg-[#133E87] rounded"></div>
            </div>
        </div>

        <!-- Profil Ringkas -->
        <div class="container mx-auto px-4 pt-12 md:pt-16">
            <div class="bg-[#CBDCEB] rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row items-stretch" data-aos="fade-up">
                <div class="w-full md:w-1/3 flex-shrink-0 relative min-h-[300px] image-container">
                    <img src="/images/prodi/matematika/profil-matematika.jpg" alt="Profil Prodi Matematika" class="w-full h-full object-cover rounded-lg" />
                    <div class="zoom-icon" @click="openModal('/images/prodi/matematika/profil-matematika.jpg')">
                        <ZoomIn class="w-6 h-6 text-[#133E87]" />
                    </div>
                </div>
                <div class="p-8 md:p-10 w-full md:w-2/3">
                    <h2 class="font-kulim-park font-bold text-3xl text-[#133E87] mb-4">Profil Ringkas</h2>
                    <p class="font-inter font-semibold text-black text-justify">
                        Program Studi Matematika ITK berdiri sejak 2013 dan kini telah terakreditasi BAIK oleh LAMSAMA. Prodi ini mempelajari serta mengaplikasikan konsep matematis untuk mendukung perkembangan sains, teknologi, keuangan, asuransi, lingkungan, kesehatan, industri, dan pendidikan. Mahasiswa dapat memperdalam keilmuan melalui dua bidang keahlian utama, yaitu Matematika Terapan serta Analisis dan Aljabar.
                    </p>
                </div>
            </div>
        </div>

        <!-- Visi, Misi, Tujuan -->
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                <div class="space-y-8 flex flex-col" data-aos="fade-right">
                    <div>
                        <h2 class="text-3xl font-kulim-park font-bold text-[#133E87] mb-4">Visi</h2>
                        <div class="bg-[#CBDCEB] p-6 rounded-lg shadow-md flex items-center min-h-[141px]">
                            <p class="font-inter text-black text-justify">{{ visi }}</p>
                        </div>
                    </div>
                    <div class="flex-grow flex flex-col">
                        <h2 class="text-3xl font-kulim-park font-bold text-[#133E87] mb-4">Tujuan</h2>
                        <div class="bg-[#CBDCEB] p-6 rounded-lg shadow-md flex-grow flex items-center">
                            <p class="font-inter text-black text-justify">{{ tujuan }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col" data-aos="fade-left">
                    <h2 class="text-3xl font-kulim-park font-bold text-[#133E87] mb-4">Misi</h2>
                    <div class="bg-[#CBDCEB] p-6 rounded-lg shadow-md flex-grow">
                        <ul class="list-decimal list-inside space-y-4 font-inter text-black text-justify">
                            <li v-for="item in misi" :key="item">{{ item }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profil Lulusan -->
        <div class="container mx-auto px-4 pb-16 md:pb-24">
            <div class="flex items-center mb-8" data-aos="fade-up">
                <h2 class="text-3xl font-kulim-park font-bold text-[#133E87] mr-6 flex-shrink-0">Profil Lulusan</h2>
                <div class="w-full h-1 bg-[#133E87]"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="200">
                <div 
                    v-for="(profil, index) in profilLulusan" 
                    :key="index" 
                    class="bg-[#CBDCEB] rounded-lg shadow-md p-6 flex items-center text-left space-x-4 transform transition-transform duration-300 hover:scale-105 hover:shadow-xl cursor-pointer"
                >
                    <component :is="profil.icon" class="w-8 h-8 text-[#133E87] mb-1" />
                    <p class="text-black font-semibold">{{ profil.text }}</p>
                </div>
            </div>
        </div>

        <!-- Akreditasi -->
         <div class="container mx-auto px-4 pb-16 md:pb-24 mt-5">
         <div class="flex items-center mb-8" data-aos="fade-up">
                <h2 class="text-3xl font-kulim-park font-bold text-[#133E87] mr-6 flex-shrink-0">Sertifikat Akreditasi</h2>
                <div class="w-full h-1 bg-[#133E87]"></div>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center" data-aos="fade-up" data-aos-delay="200">
                <div class="image-container">
                    <img src="/images/prodi/matematika/sertifikat-matematika.jpg" alt="Sertifikat Akreditasi" class="rounded-lg shadow-lg w-full" />
                    <div class="zoom-icon" @click="openModal('/images/prodi/matematika/sertifikat-matematika.jpg')">
                        <ZoomIn class="w-6 h-6 text-[#133E87]" />
                    </div>
                </div>
                <div class="flex flex-col items-center text-center">
                    <BadgeCheck class="w-20 h-20 text-[#60D669] mb-4" />
                    <p class="font-inter text-lg">
                        Pada level nasional, Program Sarjana Matematika Institut Teknologi Kalimantan telah terakreditasi oleh<span class="font-bold"> Lembaga Akreditasi Mandiri Sains Alam dan Ilmu Formal (LAMSAMA) </span> dengan peringkat <span class="font-bold">Baik</span>.
                    </p>
                </div>
            </div>
        </div>
    </div>

        <!-- Info Tambahan -->
        <div class="container mx-auto px-4 pb-16 md:pb-24">
            <div class="bg-[#CBDCEB] rounded-3xl shadow-xl p-8 md:p-12 text-center" data-aos="zoom-in">
                <h2 class="font-kulim-park font-bold text-3xl text-[#133E87] mb-4">
                    Ingin tahu lebih banyak tentang Prodi Matematika ITK?
                </h2>
                <p class="font-inter font-semibold text-[#133E87] max-w-3xl mx-auto mb-8">
                    Temukan informasi lengkap mengenai kurikulum, bidang minat, kegiatan mahasiswa, penelitian, serta peluang karier lulusan melalui website resmi Program Studi Matematika ITK.
                </p>
                <a 
                    href="https://math.itk.ac.id/" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="inline-flex items-center px-8 py-3 bg-white text-[#133E87] text-lg font-inter font-bold rounded-full hover:bg-gray-200 transition shadow-md"
                >
                    <Globe class="w-6 h-6 mr-3" />
                    Kunjungi Website Resmi
                </a>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="isModalOpen" class="modal-backdrop" @click.self="closeModal">
            <div class="relative">
                <img :src="modalImage" class="modal-image" />
                <button @click="closeModal" class="absolute top-2 right-2 text-white text-3xl font-bold">&times;</button>
            </div>
        </div>
</PublicLayout>
</template>
