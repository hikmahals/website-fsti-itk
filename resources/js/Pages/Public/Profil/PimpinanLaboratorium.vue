<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';

// Data untuk pimpinan laboratorium (hanya satu kelompok)
const pimpinanLab = [
    { name: 'Meidi Arisalwadi, S.Si., M.Si', title: 'Kepala Laboratorium Fisika Lanjut', image: '/images/pimpinan-laboratorium/kalab-fisika-lanjut.png' },
    { name: 'Fadli Robiandi, S.Si., M.Si', title: 'Kepala Laboratorium Fisika Dasar', image: '/images/pimpinan-laboratorium/kalab-fisika-dasar.png' },
    { name: 'Dr. Moh. Januar Ismail Burhan, S.Si., M.Si', title: 'Kepala Laboratorium Komputasi dan Data', image: '/images/pimpinan-laboratorium/kalab-komputasi-data.png' },
    { name: 'Aidil Saputra Kirsan, S.ST., M.Tr.Kom.', title: 'Kepala Laboratorium Inovasi Digital', image: '/images/pimpinan-laboratorium/kalab-inovasi-digital.png' },
    { name: 'Boby Mugi Pratama, S.Si., M.Han', title: 'Kepala Laboratorium Sistem Cerdas', image: '/images/pimpinan-laboratorium/kalab-sistem-cerdas.png' },
];
</script>

<template>
    <PublicLayout>
        <Banner
            title="PIMPINAN LABORATORIUM"
            subtitle="PIMPINAN LABORATORIUM"
            background-image="/images/background-banner.png"
        />

        <div class="pt-12 pb-16 md:pb-24 bg-white overflow-x-hidden">
            <div>
                <div class="mb-12">
                    
                    <div class="bg-[#CBDCEB] text-center p-6 shadow-md mb-10" data-aos="fade-up">
                        <h2 class="text-2xl md:text-3xl font-kulim-park font-bold text-[#133E87]">
                            Pimpinan Laboratorium <br> Fakultas Sains dan Teknologi Informasi
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 container mx-auto px-4">
                        <div
                            v-for="(p, pIndex) in pimpinanLab"
                            :key="pIndex"
                            data-aos="fade-up"
                            :data-aos-delay="pIndex * 100"
                        >
                            <div
                                class="bg-[#CBDCEB] rounded-lg shadow-lg p-8 text-center flex flex-col items-center h-full
                                       transform transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div class="w-48 h-48 rounded-full border-2 border-[#133E87] p-1 mb-6 flex-shrink-0">
                                    <img :src="p.image" :alt="p.name" class="w-full h-full object-cover rounded-full">
                                </div>
                                
                                <h3 class="font-kulim-park font-bold text-xl text-[#133E87]">
                                    {{ p.name }}
                                </h3>
                                
                                <hr class="my-2 border-t-2 w-1/2 border-[#133E87]">
                                
                                <p class="font-kulim-park text-base text-[#133E87]">
                                    {{ p.title }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </PublicLayout>
</template>