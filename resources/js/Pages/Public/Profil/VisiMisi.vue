<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';

const visiText = "Pada tahun 2029, Fakultas Sains dan Teknologi Informasi (FSTI) ITK akan menjadi pusat keunggulan akademik dan inovasi, menghasilkan lulusan yang kompeten, adaptif, berdaya saing global, dan karya-karya dalam bidang sains dan teknologi informasi yang berdampak bagi kemajuan Kalimantan dan Indonesia.";

const misiItems = [
    {
        title: 'Pendidikan Berkualitas',
        description: 'Menyelenggarakan pendidikan tinggi yang berkualitas dan relevan dengan kebutuhan industri serta masyarakat di bidang sains dan teknologi informasi.'
    },
    {
        title: 'Penelitian Inovatif',
        description: 'Melaksanakan penelitian dan pengembangan ilmu pengetahuan dan teknologi terapan yang inovatif dan berwawasan lingkungan.'
    },
    {
        title: 'Pengabdian Masyarakat',
        description: 'Menyelenggarakan pengabdian kepada masyarakat yang berbasis pada hasil penelitian dan pengembangan ilmu pengetahuan dan teknologi terapan.'
    },
    {
        title: 'Kerjasama Strategis',
        description: 'Membangun jejaring kerjasama yang kokoh dengan berbagai pihak, baik di tingkat nasional maupun internasional, untuk mendukung pelaksanaan tridharma perguruan tinggi.'
    }
];
</script>

<template>
    <Head title="Visi & Misi" />
    <PublicLayout>
        <Banner
            title="VISI MISI"
            subtitle="VISI MISI"
            background-image="/images/background-banner.png"
        />

        <div class="py-16 md:py-24 bg-white font-sans overflow-x-hidden">
            <div class="container mx-auto px-6 md:px-8 max-w-[1185px]">

                <section class="mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-kulim-park font-bold text-[#4682A9] mb-8"
                        data-aos="fade-right"
                    >
                        VISI
                    </h2>
                    <div
                        class="bg-[#CBDCEB] rounded-xl shadow-lg p-6 md:p-8"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <p class="text-gray-900 text-center font-bold text-lg leading-relaxed">
                            {{ visiText }}
                        </p>
                    </div>
                </section>

                <section>
                    <h2
                        class="text-4xl md:text-5xl font-kulim-park font-bold text-[#4682A9] mb-8"
                        data-aos="fade-right"
                        data-aos-delay="200"
                    >
                        MISI
                    </h2>

                    <div class="space-y-6">
                        <div
                            v-for="(misi, index) in misiItems"
                            :key="index"
                            class="bg-[#CBDCEB] rounded-xl shadow-lg p-6 md:p-8"
                            data-aos="fade-up"
                            :data-aos-delay="100 * index"
                        >
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-2 bg-[#749BC2] self-stretch mr-5"></div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-xl">
                                        {{ misi.title }}
                                    </h3>
                                    <p class="text-gray-900 leading-relaxed mt-1">
                                        {{ misi.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </PublicLayout>
</template>