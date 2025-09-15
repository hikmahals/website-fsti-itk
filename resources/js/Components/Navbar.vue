<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronDown, Search } from 'lucide-vue-next';

// --- Data untuk Menu Navigasi ---
const navigationMenu = [
    { name: 'Beranda', href: route('home') },
    {
        name: 'Profil',
        href: '#',
        sublinks: [
            // --- PERUBAHAN DI SINI ---
            { name: 'Visi Misi', href: route('visi-misi') },
            {
                name: 'Struktur Organisasi',
                href: '#',
                sublinks: [
                    { name: 'Bagan Organisasi', href: route('bagan-organisasi') },
                    { name: 'Pimpinan Fakultas', href: route('profil.pimpinan-fakultas') },
                    { name: 'Pimpinan Jurusan', href: route('profil.pimpinan-jurusan') },
                    { name: 'Pimpinan Prodi', href: route('profil.pimpinan-prodi') },
                    { name: 'Pimpinan Laboratorium', href: route('profil.pimpinan-laboratorium') },
                ],
            },
            {
                name: 'Civitas Akademika',
                href: '#',
                sublinks: [
                    { name: 'Dosen', href: route('profil.dosen') },
                    { name: 'Tenaga Kependidikan', href: route('profil.tenaga-kependidikan') },
                ],
            },
        ],
    },
    {
        name: 'Program Studi',
        href: '#',
        megaMenu: true,
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
                    { name: 'Program Studi Matematika', href: route('prodi.matematika') },
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
            { name: 'Prestasi Mahasiswa', href: route('prestasi.index') },
            { name: 'Portal Layanan Mahasiswa', href: '#' },
        ],
    },
    { name: 'Berita', href: route('berita.index') },
    { name: 'Kontak', href: '#' },
];

// State untuk mengontrol visibilitas dropdown
const activeDropdown = ref<string | null>(null);

function showDropdown(menuName: string) {
    activeDropdown.value = menuName;
}

function hideDropdown() {
    activeDropdown.value = null;
}
</script>

<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <Link href="/" class="flex items-center space-x-2">
                        <img class="h-10 w-auto" src="/images/logofsti.png" alt="Logo FSTI">
                    </Link>
                </div>

                <nav class="hidden md:flex items-center space-x-8">
                    <div
                        v-for="item in navigationMenu"
                        :key="item.name"
                        class="relative"
                        @mouseenter="showDropdown(item.name)"
                        @mouseleave="hideDropdown()"
                    >
                        <Link
                            :href="item.href"
                            class="inline-flex items-center px-1 pt-1 text-sm font-bold text-gray-700 hover:text-[#133E87] transition-colors duration-200"
                        >
                            {{ item.name }}
                            <ChevronDown v-if="item.sublinks || item.megaMenu" class="ml-1 h-4 w-4" />
                        </Link>

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
                                        <div v-if="sublink.sublinks" class="relative group">
                                            <button class="w-full text-left flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#133E87]">
                                                {{ sublink.name }}
                                                <ChevronDown class="h-4 w-4 transform -rotate-90" />
                                            </button>
                                            <div class="absolute left-full top-0 mt-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                                                <div class="py-1">
                                                    <Link v-for="subsublink in sublink.sublinks" :key="subsublink.name" :href="subsublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        {{ subsublink.name }}
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                        <Link v-else :href="sublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ sublink.name }}
                                        </Link>
                                    </template>
                                </div>
                            </div>
                        </transition>

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

                <div class="hidden md:flex items-center space-x-4">
                    <div class="relative">
                        <select class="w-full pl-4 pr-8 py-2 text-sm border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>🇮🇩 Indonesia</option>
                            <option>🇬🇧 English</option>
                        </select>
                    </div>
                    <button class="p-2 text-gray-600 hover:text-gray-800 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <Search class="h-5 w-5" />
                    </button>
                </div>

                <div class="md:hidden">
                    <button class="p-2 rounded-md text-gray-700">
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