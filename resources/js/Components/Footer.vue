=<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

// State untuk tombol "Back to Top"
const showScrollTop = ref(false);

// Fungsi untuk scroll ke atas
const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Event listener untuk menampilkan/menyembunyikan tombol
const handleScroll = () => {
  if (window.scrollY > 400) {
    showScrollTop.value = true;
  } else {
    showScrollTop.value = false;
  }
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <footer class="relative font-inter text-black">
        <div class="absolute bottom-0 left-0 w-full h-[95%] bg-[#CBDCEB] rounded-t-[200px]"></div>

        <div 
            class="absolute top-0 left-0 w-full h-32" 
            style="clip-path: ellipse(80% 100% at 50% 100%);">
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-7xl mx-auto bg-white rounded-full p-6 md:px-10 md:py-8 flex flex-col md:flex-row items-center justify-between text-center md:text-left mb-16 shadow-lg border-2" style="border-color: #133E87;">
                <div>
                    <h2 class="font-kulim-park text-2xl md:text-4xl font-bold" style="color: #4682A9;">Terhubung dengan FSTI ITK</h2>
                    <p class="text-black mt-1">Ikuti kami di media sosial untuk pembaruan terkini.</p>
                </div>
                <div class="flex items-center gap-4 mt-6 md:mt-0">
                    <a href="https://www.instagram.com/fsti.itk" target="_blank" rel="noopener noreferrer" class="bg-[#1e3a8a] p-3 rounded-full shadow-md hover:opacity-90 transition-opacity">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="https://www.tiktok.com/@fsti.itk" target="_blank" rel="noopener noreferrer" class="bg-[#1e3a8a] p-3 rounded-full shadow-md hover:opacity-90 transition-opacity">
                        <svg class="h-8 w-8 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3v178.7a162.5 162.5 0 1 1 -162.5-162.5v99.9a74.6 74.6 0 1 0 74.6 74.6v-249a121.2 121.2 0 0 0 -1.9-22.2h0A121.2 121.2 0 0 0 240.1 0H288v50.2a176.8 176.8 0 0 1 -52.2 4.2v0a122.2 122.2 0 0 0 102.4 122.2 121.4 121.4 0 0 0 67 20.1z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 ml-20 py-1 pb-12 text-black">
                <div class="space-y-4 lg:col-span-1">
                    <div class="flex items-center space-x-3">
                         <div class="bg-white p-1 rounded shadow-sm">
                            <img src="/images/logofsti.png" alt="Logo FSTI" class="h-10">
                         </div>
                         <div>
                            <p class="font-bold leading-tight">Fakultas Sains dan Teknologi Informasi</p>
                            <p class="text-sm">Institut Teknologi Kalimantan</p>
                         </div>
                    </div>
                    <p class="text-sm">Membentuk talenta digital inovatif dan berdaya saing global untuk memajukan Kalimantan dan Indonesia.</p>
                </div>

                <div class="space-y-4 ml-5">
                    <h3 class="text-base font-bold">Informasi Kontak</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <div class="mt-1 flex-shrink-0"><svg class="h-5 w-5 text-[#133E87]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg></div>
                            <div>
                                <p class="font-semibold">Alamat</p>
                                <p>Kampus ITK, Jl. Soekarno Hatta KM 15, Karang Joang, Balikpapan Utara, Kalimantan Timur, 76127</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                             <div class="mt-1 flex-shrink-0"><svg class="h-5 w-5 text-[#133E87]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></div>
                            <div>
                                <p class="font-semibold">Email</p>
                                <a href="mailto:fsti@itk.ac.id" class="hover:text-[#133E87]">fsti@itk.ac.id</a>
                            </div>
                        </li>
                         <li class="flex items-start gap-3">
                            <div class="mt-1 flex-shrink-0"><svg class="h-5 w-5 text-[#133E87]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.415L11 9.586V6z" clip-rule="evenodd" /></svg></div>
                            <div>
                                <p class="font-semibold">Jam Operasional</p>
                                <p>Senin - Jum'at, 07.30 - 16.00 WITA</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h3 class="text-base font-bold">Tautan Penting</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="https://itk.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:text-[#133E87]">Website Utama ITK</a></li>
                        <li><a href="https://pmb.itk.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:text-[#133E87]">Penerimaan Mahasiswa Baru ITK</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 transform translate-y-2"
            enter-to-class="opacity-100 transform translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 transform translate-y-0"
            leave-to-class="opacity-0 transform translate-y-2"
        >
            <button v-if="showScrollTop" @click="scrollToTop" class="fixed bottom-6 right-6 bg-white text-[#4682A9]  p-3 rounded-full shadow-lg border border-gray-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
            </button>
        </transition>
    </footer>
</template>