<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import SidebarLatest from '@/Components/SidebarLatest.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Calendar, Eye, Tag, Copy } from 'lucide-vue-next';
import type { Post } from '@/types';
import { ref, onMounted } from 'vue';

// Import AOS untuk animasi
import AOS from 'aos';
import 'aos/dist/aos.css';

// Terima data 'post' dan 'recentPosts' dari controller
const props = defineProps<{
  post: Post;
  recentPosts: Post[];
}>();

// Gambar banner default
const bannerImage = '/images/background-banner.png';

// State untuk notifikasi "Link disalin"
const notificationText = ref('');
const showNotification = ref(false);

// Siapkan variabel reaktif untuk URL berbagi
const whatsAppUrl = ref('#');
const facebookUrl = ref('#');
const twitterUrl = ref('#');

// Gunakan onMounted untuk mengakses 'window' dengan aman
onMounted(() => {
  // Inisialisasi AOS saat komponen dimuat
  AOS.init({
    duration: 800, // Durasi animasi dalam milidetik
    once: true,     // Animasi hanya berjalan sekali
  });

  const currentUrl = window.location.href;
  whatsAppUrl.value = `https://wa.me/?text=${encodeURIComponent(props.post.title + ' - ' + currentUrl)}`;
  facebookUrl.value = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
  twitterUrl.value = `https://twitter.com/intent/tweet?text=${encodeURIComponent(props.post.title)}&url=${encodeURIComponent(currentUrl)}`;
});

// Fungsi notifikasi umum
const triggerNotification = (message: string) => {
    notificationText.value = message;
    showNotification.value = true;
    setTimeout(() => showNotification.value = false, 2500);
};

// Fungsi untuk menyalin URL berita ke clipboard
const copyToClipboard = () => {
    const textArea = document.createElement("textarea");
    textArea.value = window.location.href;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        triggerNotification('Tautan berhasil disalin!');
    } catch (err) {
        console.error('Gagal menyalin teks: ', err);
        triggerNotification('Gagal menyalin tautan.');
    }
    document.body.removeChild(textArea);
};

// Fungsi khusus untuk Instagram
const shareToInstagram = () => {
    copyToClipboard();
    // Beri notifikasi yang lebih spesifik untuk Instagram
    setTimeout(() => {
      triggerNotification('Tautan disalin, tempel di Instagram!');
    }, 100); 
};


// Fungsi untuk memformat tanggal
const formatDate = (dateString: string | null) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};

// Memisahkan tag menjadi array
const tags = props.post.tags ? props.post.tags.split(',').map(tag => tag.trim()) : [];

</script>

<template>
    <PublicLayout :title="post.title">
        <Head>
            <title>{{ post.title }}</title>
            <meta name="description" :content="post.excerpt">
        </Head>

        <Banner title="Berita" :background-image="bannerImage" />

        <div class="bg-white py-12 md:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                    
                    <div class="lg:col-span-2">
                        <div class="bg-[#CBD5E1] p-6 md:p-8 rounded-2xl shadow-lg border-2 border-[#133E87]" data-aos="fade-up">
                            <h1 class="text-3xl md:text-4xl font-bold text-black leading-tight mb-4" data-aos="fade-up" data-aos-delay="100">
                                {{ post.title }}
                            </h1>
                            <div class="flex items-center space-x-6 text-sm text-black mb-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="flex items-center">
                                    <Calendar class="w-4 h-4 mr-2" />
                                    <span>{{ formatDate(post.published_at) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <Eye class="w-4 h-4 mr-2" />
                                    <span>{{ post.views }} dilihat</span>
                                </div>
                            </div>
                            <hr class="my-6 border-black" data-aos="fade-up" data-aos-delay="300"/>
                            <div class="mb-8 rounded-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="400">
                                <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="w-full h-auto object-cover">
                            </div>

                            <div class="prose max-w-none text-black" v-html="post.content" data-aos="fade-up" data-aos-delay="500"></div>

                            <div class="mt-10 pt-6 border-t border-black flex flex-col sm:flex-row items-center justify-between gap-4" data-aos="fade-up" data-aos-delay="100">
                                <div v-if="tags.length > 0" class="flex items-center gap-2 flex-wrap">
                                    <Tag class="w-5 h-5 text-black flex-shrink-0" />
                                    <span v-for="tag in tags" :key="tag" class="bg-gray-100 text-black text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ tag }}
                                    </span>
                                </div>
                                <div v-else></div>

                                <div class="flex items-center gap-1 relative">
                                    <span class="text-sm font-semibold text-black mr-2">Bagikan:</span>
                                    <button @click="copyToClipboard" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Salin Tautan">
                                        <Copy class="w-5 h-5 text-black" />
                                    </button>
                                    <a :href="whatsAppUrl" target="_blank" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Bagikan ke WhatsApp">
                                        <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                    </a>
                                    <a :href="facebookUrl" target="_blank" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Bagikan ke Facebook">
                                        <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                                    </a>
                                    <a :href="twitterUrl" target="_blank" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Bagikan ke Twitter">
                                        <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                                    </a>
                                    <button @click="shareToInstagram" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Bagikan ke Instagram (Salin Tautan)">
                                        <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9 26.3 26.2 58 34.4 93.9 36.2 37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                    </button>
                                    
                                    <transition
                                        enter-active-class="transition ease-out duration-200"
                                        enter-from-class="opacity-0 translate-y-2"
                                        enter-to-class="opacity-100 translate-y-0"
                                        leave-active-class="transition ease-in duration-150"
                                        leave-from-class="opacity-100 translate-y-0"
                                        leave-to-class="opacity-0 translate-y-2"
                                    >
                                        <div v-if="showNotification" class="absolute bottom-full mb-2 right-0 bg-black text-white text-xs rounded-md px-3 py-1.5 shadow-lg">
                                            {{ notificationText }}
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="sticky top-24" data-aos="fade-left" data-aos-delay="200">
                            <SidebarLatest :recent-posts="recentPosts" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>

<style>
/* Styling untuk konten HTML yang berasal dari Tiptap/database */
.prose {
    line-height: 1.75;
}
.prose h2, .prose h3 {
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 1em;
}
.prose p {
    margin-bottom: 1.25em;
}
.prose ul, .prose ol {
    margin-left: 1.25rem;
    margin-bottom: 1.25em;
}
.prose li {
    margin-bottom: 0.5em;
}
.prose a {
    color: #133E87;
    text-decoration: underline;
    transition: color 0.2s;
}
.prose a:hover {
    color: #4682A9;
}
.prose blockquote {
    border-left: 4px solid #CBDCEB;
    padding-left: 1rem;
    font-style: italic;
    color: #4A5568;
}
</style>