<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Bagan Organisasi" />
    <PublicLayout>
        <Banner
            title="BAGAN ORGANISASI"
            subtitle="BAGAN ORGANISASI"
            background-image="/images/background-banner.png"
        />

        <div class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-6 md:px-8 max-w-[1185px]">
                <div>
                    <h2
                        class="text-4xl md:text-5xl font-kulim-park font-bold text-[#4682A9] mb-8"
                        data-aos="fade-right"
                    >
                        Bagan Organisasi FSTI
                    </h2>

                    <div
                        class="bg-[#CBDCEB] rounded-xl shadow-lg overflow-hidden transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-[1.02]"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 bg-[#4682A9] self-stretch"></div>

                            <div class="flex-grow p-6 md:p-8">
                                <div class="flex justify-center">
                                    <img
                                        src="/images/bagan-organisasi.webp"
                                        alt="Bagan Organisasi FSTI ITK"
                                        class="w-full h-auto object-contain"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>