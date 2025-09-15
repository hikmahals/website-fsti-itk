<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <PublicLayout>
        <Banner
        title="KONTAK"
        subtitle="KONTAK"
        background-image="/images/background-banner.png"
    />

        <div class="bg-white py-12 md:py-24">
            <div class="container mx-auto -mt-5 px-6 lg:px-8">

                <div class="text-center mb-12" data-aos="fade-up">
                    <h1 class="font-kulim-park-bold text-[#4682A9] text-4xl md:text-5xl font-bold">
                        Alamat & Jam Operasional
                    </h1>
                    <p class="font-inter-semibold text-black mt-4 text-lg">
                        Temukan lokasi FSTI ITK beserta jam layanan yang dapat Anda kunjungi.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    <div class="flex flex-col gap-8" data-aos="fade-right" data-aos-delay="200">
                        <div class="bg-[#CBDCEB] rounded-xl p-6 flex items-start space-x-5">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#133E87]">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold">Alamat</h3>
                                <hr class="border-t-2 border-[#133E87] mt-2 mb-3">
                                <p class="text-black font-inter-regular">
                                    Kampus ITK Gedung B, Lantai 1, Ruang B110<br>
                                    Jl. Soekarno Hatta KM 15, Karang Joang,<br>
                                    Balikpapan Utara, Kalimantan Timur, 76127
                                </p>
                            </div>
                        </div>

                        <div class="bg-[#CBDCEB] rounded-xl p-6 flex items-start space-x-5">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#133E87]">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold">Jam Operasional</h3>
                                <hr class="border-t-2 border-[#133E87] mt-2 mb-3">
                                <p class="text-black font-inter-regular">
                                    Senin - Jumat: 07:30 - 16:30 WITA<br>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#CBDCEB] rounded-xl p-6 flex flex-col" data-aos="fade-left" data-aos-delay="200">
                        <div class="flex items-start space-x-5">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#133E87]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-icon lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold">Google Maps</h3>
                                <hr class="border-t-2 border-[#133E87] mt-2 mb-3">
                            </div>
                        </div>

                        <div class="mt-4 w-full flex-grow rounded-lg overflow-hidden min-h-[340px]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8825835948343!2d116.85221921475399!3d-1.237913399097561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df1611a9117b6ab%3A0x9212111d4e10711!2sInstitut%20Teknologi%20Kalimantan!5e0!3m2!1sen!2sid!4v1693820843450!5m2!1sen!2sid5"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-[#CBDCEB] py-12 md:py-24">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h1 class="font-kulim-park-bold text-[#133E87] text-4xl md:text-5xl font-bold">
                        Layanan Komunikasi & Konsultasi
                    </h1>
                    <p class="font-inter-semibold text-black mt-4 text-lg max-w-3xl mx-auto">
                        Hubungi kami untuk pertanyaan akademik, keuangan, maupun informasi resmi lainnya
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto">
                    <a href="https://wa.me/6285172302157" target="_blank" rel="noopener noreferrer" class="block transition-transform hover:scale-105" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-white rounded-xl p-6 flex items-start space-x-5 h-full transition-transform hover:scale-105 duration-300 ease-in-out">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#133E87]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold">Layanan Akademik</h3>
                                <hr class="border-t-2 border-[#133E87] mt-2 mb-3">
                                <p class="text-black font-inter-regular text-lg">
                                    0851-7230-2157
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="https://wa.me/6285172312157" target="_blank" rel="noopener noreferrer" class="block transition-transform hover:scale-105" data-aos="fade-up" data-aos-delay="300">
                        <div class="bg-white rounded-xl p-6 flex items-start space-x-5 h-full transition-transform hover:scale-105 duration-300 ease-in-out">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#133E87]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold">Layanan Keuangan</h3>
                                <hr class="border-t-2 border-[#133E87] mt-2 mb-3">
                                <p class="text-black font-inter-regular text-lg">
                                    0851-7231-2157
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="flex justify-center mt-8">
                    <div class="w-full md:w-1/2 lg:w-[48.5%]" data-aos="fade-up" data-aos-delay="400">
                        <a href="mailto:fsti@itk.ac.id" class="block transition-transform hover:scale-105">
                            <div class="bg-white rounded-xl p-6 flex items-start space-x-5">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-[#133E87]">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="w-full">
                                    <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold">Email</h3>
                                    <hr class="border-t-2 border-[#133E87] mt-2 mb-3">
                                    <p class="text-black font-inter-regular text-lg break-all">
                                        fsti@itk.ac.id
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Sosial -->
<div class="bg-white py-12 md:py-24">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="font-kulim-park-bold text-[#4682A9] text-4xl md:text-5xl font-bold">
                Media Sosial Resmi
            </h1>
            <p class="font-inter-semibold text-black mt-4 text-lg max-w-3xl mx-auto">
                Ikuti akun resmi FSTI ITK untuk update kegiatan, aktivitas mahasiswa, dan konten menarik lainnya
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto">
            <!-- Instagram -->
            <a href="https://www.instagram.com/fsti.itk" target="_blank" rel="noopener noreferrer" 
               class="block overflow-hidden transition-transform duration-300 ease-in-out hover:scale-105">
                <div class="bg-[#CBDCEB] rounded-xl p-8 flex flex-col items-center text-center">
                    <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-[#133E87]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                        </svg>
                    </span>
                    <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold mt-4">Instagram</h3>
                    <hr class="w-1/2 border-t-2 border-[#133E87] my-3 mx-auto">
                    <p class="text-black font-inter-regular text-lg">@fsti.itk</p>
                </div>
            </a>

            <!-- TikTok -->
            <a href="https://www.tiktok.com/@fsti.itk" target="_blank" rel="noopener noreferrer" 
               class="block overflow-hidden transition-transform duration-300 ease-in-out hover:scale-105">
                <div class="bg-[#CBDCEB] rounded-xl p-8 flex flex-col items-center text-center">
                    <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-[#133E87]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" viewBox="0 0 449.45 515.38" fill="currentColor">
                            <path d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z"/>
                        </svg>
                    </span>
                    <h3 class="text-[#133E87] font-inter-bold text-2xl font-bold mt-4">TikTok</h3>
                    <hr class="w-1/2 border-t-2 border-[#133E87] my-3 mx-auto">
                    <p class="text-black font-inter-regular text-lg">@fsti.itk</p>
                </div>
            </a>
        </div>
    </div>
</div>


    </PublicLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Kulim+Park:wght@700&display=swap');

.font-kulim-park-bold {
    font-family: 'Kulim Park', sans-serif;
    font-weight: 700;
}

.font-inter-regular {
    font-family: 'Inter', sans-serif;
    font-weight: 400;
}

.font-inter-semibold {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
}

.font-inter-bold {
    font-family: 'Inter', sans-serif;
    font-weight: 700;
}
</style>