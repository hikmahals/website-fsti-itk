<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';

// Karena AOS sudah menangani animasi, kita hanya perlu data statis.
const pimpinan = [
    { name: 'Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D.', title: 'Dekan Fakultas Sains dan Teknologi Informasi', image: '/images/pimpinan-fakultas/dekan.png' },
    { name: 'Irma Fitria, S.Si., M.Si.', title: 'Wakil Dekan I (Akademik dan Kemahasiswaan)', image: '/images/pimpinan-fakultas/wd1.png' },
    { name: 'Yun Tonce Kusuma Priyanto, S.T., M.T.', title: 'Wakil Dekan II (Umum dan Keuangan)', image: '/images/pimpinan-fakultas/wd2.png' },
    { name: 'Desy Ridho Rahayu, S.Si', title: 'Kepala Sub Bagian Umum', image: '/images/pimpinan-fakultas/kasubbag.png' },
];
</script>

<template>
    <PublicLayout>
        <Banner
            title="PIMPINAN FAKULTAS"
            subtitle="PIMPINAN FAKULTAS"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white pb-16 md:pb-24 overflow-x-hidden">
            <div class="flex flex-col">
                
                <template v-for="(p, index) in pimpinan" :key="p.name">
                    <div v-if="index > 0" class="h-3 bg-white"></div>

                    <div
                        :data-aos="index % 2 === 0 ? 'fade-left' : 'fade-right'"
                        class="flex h-full md:h-[40rem] bg-white shadow-xl overflow-hidden flex-col md:flex-row"
                        :class="{ 'md:flex-row-reverse': index % 2 === 0 }"
                    >
                        <div class="w-full md:w-2/5 flex-shrink-0">
                            <img :src="p.image" :alt="p.name" class="w-full h-64 md:h-full object-cover object-top">
                        </div>

                        <div class="w-full h-3 md:w-3 md:h-auto bg-white flex-shrink-0"></div>

                        <div class="w-full md:w-3/5 flex-grow flex flex-col justify-center text-center md:text-left p-8 bg-[#CBDCEB] px-4 md:px-10 min-h-[26rem]">
                            <h3 class="font-kulim-park font-bold text-3xl lg:text-4xl text-[#133E87]">
                                {{ p.name }}
                            </h3>
                            <hr class="my-3 border-t-2 w-1/2 border-[#133E87] mx-auto md:mx-0">
                            <p class="font-kulim-park text-xl text-[#133E87]">
                                {{ p.title }}
                            </p>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </PublicLayout>
</template>