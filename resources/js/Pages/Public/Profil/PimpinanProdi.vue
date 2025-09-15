=<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';

// Data untuk pimpinan prodi, dikelompokkan berdasarkan jurusan
const departments = [
    {
        jurusan: ['Koordinator Program Studi', 'Jurusan Sains dan Analitika Data'],
        pimpinan: [
            { name: 'Febrian Dedi Sastrawan, S.Si., M.Sc', title: 'Koordinator Program Studi Fisika', image: '/images/pimpinan-prodi/koorpro-fis.png' },
            { name: 'Kartika Nugraheni, S.Si., M.Si.', title: 'Koordinator Program Studi Matematika', image: '/images/pimpinan-prodi/koorpro-mat.png' },
            { name: 'Diana Nurlaily, S.Si., M.Stat', title: 'Koordinator Program Studi Statistika', image: '/images/pimpinan-prodi/koorpro-stat.png' },
            { name: 'Muhammad Azka, S.Si., M.Sc', title: 'Koordinator Program Studi Ilmu Aktuaria', image: '/images/pimpinan-prodi/koorpro-akt.png' },
        ]
    },
    {
        jurusan: ['Koordinator Program Studi', 'Jurusan Teknik Elektro, Informatika, dan Bisnis'],
        pimpinan: [
            { name: 'Kharis Sugiarto, S.T., M.T', title: 'Koordinator Program Studi Teknik Elektro', image: '/images/pimpinan-prodi/koorpro-te.png' },
            { name: 'Sri Rahayu Natasia, S.Komp., M.Si., M.Sc', title: 'Koordinator Program Studi Sistem Informasi', image: '/images/pimpinan-prodi/koorpro-si.png' },
            { name: 'Nisa Rizqiya Fadhliana, S.Kom., M.T', title: 'Koordinator Program Studi Informatika', image: '/images/pimpinan-prodi/koorpro-if.png' },
            { name: 'Deli Yansyah, S.E., M.Acc., Ak., CA', title: 'Koordinator Program Studi Bisnis Digital', image: '/images/pimpinan-prodi/koorpro-bd.png' },
            { name: 'Bima Prihasto, Ph.D.', title: 'Koordinator Program Studi Magister Manajemen Teknologi', image: '/images/pimpinan-prodi/koorpro-mmt.png' },
        ]
    }
];
</script>

<template>
    <PublicLayout>
        <Banner
            title="PIMPINAN PRODI"
            subtitle="PIMPINAN PRODI"
            background-image="/images/background-banner.png"
        />

        <div class="pt-12 pb-16 md:pb-24 bg-white overflow-x-hidden">
            <div>
                <div v-for="(dept, index) in departments" :key="index" class="mb-12">
                    
                    <div class="bg-[#CBDCEB] text-center p-6 shadow-md mb-10" data-aos="fade-up">
                        <h2 class="text-2xl md:text-3xl font-kulim-park font-bold text-[#133E87]">
                            {{ dept.jurusan[0] }} <br> {{ dept.jurusan[1] }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 container mx-auto px-4">
                        <div
                            v-for="(p, pIndex) in dept.pimpinan"
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