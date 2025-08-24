<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronDown, Search } from 'lucide-vue-next';

// --- Data untuk Menu Navigasi ---
// Menyimpan data menu dalam sebuah array membuatnya lebih mudah dikelola.
const navigationMenu = [
    { name: 'Beranda', href: '#' },
    {
        name: 'Profil',
        href: '#',
        sublinks: [
            { name: 'Visi Misi', href: '#' },
            {
                name: 'Struktur Organisasi',
                href: '#',
                sublinks: [
                    { name: 'Bagan Organisasi', href: '#' },
                    { name: 'Pimpinan Fakultas', href: '#' },
                    { name: 'Pimpinan Jurusan', href: '#' },
                    { name: 'Pimpinan Prodi', href: '#' },
                    { name: 'Pimpinan Laboratorium', href: '#' },
                ],
            },
            {
                name: 'Civitas Akademika',
                href: '#',
                sublinks: [
                    { name: 'Dosen', href: '#' },
                    { name: 'Tenaga Kependidikan', href: '#' },
                ],
            },
        ],
    },
    {
        name: 'Program Studi',
        href: '#',
        megaMenu: true, // Tandai untuk layout mega menu
        columns: [
            {
                title: 'Jurusan Teknik Elektro, Informatika, dan Bisnis',
                links: [
                    { name: 'Program Studi Teknik Elektro', href: '#' },
                    { name: 'Program Studi Sistem Informasi', href: '#' },
                    { name: 'Program Studi Informatika', href: '#' },
                    { name: 'Program Studi Bisnis Digital', href: '#' },
                    { name: 'Magister Manajemen Teknologi', href: '#' },
                ],
            },
            {
                title: 'Jurusan Sains dan Analitika Data',
                links: [
                    { name: 'Program Studi Fisika', href: '#' },
                    { name: 'Program Studi Matematika', href: '#' },
                    { name: 'Program Studi Statistika', href: '#' },
                    { name: 'Program Studi Ilmu Aktuaria', href: '#' },
                ],
            },
        ],
    },
    {
        name: 'Kemahasiswaan',
        href: '#',
        sublinks: [
            { name: 'Prestasi Mahasiswa', href: '#' },
            { name: 'Portal Layanan Mahasiswa', href: '#' },
        ],
    },
    { name: 'Berita', href: '#' },
    { name: 'Kontak', href: '#' },
];

// --- State untuk mengontrol visibilitas dropdown ---
// Menggunakan ref untuk membuat variabel reaktif.
const activeDropdown = ref<string | null>(null);

// --- Fungsi untuk menampilkan dan menyembunyikan dropdown ---
function showDropdown(menuName: string) {
    activeDropdown.value = menuName;
}

function hideDropdown() {
    activeDropdown.value = null;
}
</script>

<template>
    <!-- Header utama -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <Link href="/" class="flex items-center space-x-2">
                        <!-- Ganti dengan SVG atau <img> logo Anda -->
                        <svg class="h-10 w-auto" viewBox="0 0 165 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <text font-family="Arial, sans-serif" font-size="24" font-weight="bold" fill="#003366">
                                <tspan x="0" y="24">#FSTI</tspan>
                            </text>
                            <text font-family="Arial, sans-serif" font-size="24" font-style="italic" fill="#f0ad4e">
                                <tspan x="75" y="45">Prestasi</tspan>
                            </text>
                        </svg>
                    </Link>
                </div>

                <!-- Navigasi Menu (Desktop) -->
                <nav class="hidden md:flex items-center space-x-8">
                    <div
                        v-for="item in navigationMenu"
                        :key="item.name"
                        class="relative"
                        @mouseenter="showDropdown(item.name)"
                        @mouseleave="hideDropdown()"
                    >
                        <!-- Tombol Menu Utama -->
                        <Link
                            :href="item.href"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-700 hover:text-blue-800 transition-colors duration-200"
                        >
                            {{ item.name }}
                            <ChevronDown v-if="item.sublinks || item.megaMenu" class="ml-1 h-4 w-4" />
                        </Link>

                        <!-- Dropdown Biasa -->
                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div
                                v-if="activeDropdown === item.name && item.sublinks"
                                class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                                <div class="py-1">
                                    <template v-for="sublink in item.sublinks" :key="sublink.name">
                                        <!-- Submenu dengan sub-sub menu -->
                                        <div v-if="sublink.sublinks" class="relative group">
                                            <button class="w-full text-left flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ sublink.name }}
                                                <ChevronDown class="h-4 w-4 transform -rotate-90" />
                                            </button>
                                            <!-- Level 3 Dropdown -->
                                            <div class="absolute left-full top-0 mt-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                                                <div class="py-1">
                                                    <Link v-for="subsublink in sublink.sublinks" :key="subsublink.name" :href="subsublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        {{ subsublink.name }}
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Submenu biasa -->
                                        <Link v-else :href="sublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ sublink.name }}
                                        </Link>
                                    </template>
                                </div>
                            </div>
                        </transition>

                        <!-- Mega Menu untuk Program Studi -->
                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div
                                v-if="activeDropdown === item.name && item.megaMenu"
                                class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-4xl px-4 sm:px-0"
                            >
                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 grid-cols-2">
                                        <div v-for="column in item.columns" :key="column.title">
                                            <h3 class="text-sm font-medium tracking-wide text-gray-500 uppercase">{{ column.title }}</h3>
                                            <ul role="list" class="mt-4 space-y-4">
                                                <li v-for="link in column.links" :key="link.name" class="text-base">
                                                    <Link :href="link.href" class="text-gray-900 hover:text-blue-800 transition-colors duration-200">
                                                        {{ link.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </nav>

                <!-- Aksi (Bahasa & Pencarian) -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Dropdown Bahasa -->
                    <div class="relative">
                        <select class="w-full pl-4 pr-8 py-2 text-sm border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>🇮🇩 Indonesia</option>
                            <option>🇬🇧 English</option>
                        </select>
                    </div>
                    <!-- Tombol Pencarian -->
                    <button class="p-2 text-gray-600 hover:text-gray-800 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <Search class="h-5 w-5" />
                    </button>
                </div>

                <!-- Tombol Menu Mobile (Hamburger) -->
                <div class="md:hidden">
                    <button class="p-2 rounded-md text-gray-700">
                        <!-- Ganti dengan ikon hamburger -->
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>
/* Menambahkan style khusus jika diperlukan */
/* Contoh: membuat dropdown level 3 muncul di samping */
.group:hover .group-hover\:block {
    display: block;
}
</style>