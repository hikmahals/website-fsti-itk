<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import {
  ChartBarSquareIcon,
  NewspaperIcon,
  TrophyIcon,
  UsersIcon,
  ArrowLeftOnRectangleIcon,
  ChevronRightIcon,
} from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';

const page = usePage();
const isProfileOpen = ref(false);

// State untuk melacak menu mana yang sedang dibuka
const openMenu = ref<string | null>(null);

// Menggunakan URL yang konsisten dengan file web.php Anda
const navigation = ref([
  { name: 'Dashboard', href: '/admin/dashboard', icon: ChartBarSquareIcon, children: null },
  { 
    name: 'Berita', 
    href: '/admin/posts', // Sesuai dengan web.php
    icon: NewspaperIcon, 
    children: [
      { name: 'Kelola Berita', href: '/admin/posts' }
    ] 
  },
  { 
    name: 'Prestasi', 
    href: '/admin/achievements', // Sesuai dengan web.php
    icon: TrophyIcon,
    children: [
      { name: 'Kelola Daftar Prestasi', href: '/admin/achievements' }
    ]
  },
  { name: 'Kelola Akun Admin', href: '/admin/akun', icon: UsersIcon, children: null },
]);

const isUrl = (...urls: string[]) => {
  return urls.some(url => page.url.startsWith(url));
};

// --- FUNGSI DIPERBAIKI DENGAN LOGIKA NAVIGASI ---
const toggleSubMenu = (name: string) => {
  if (openMenu.value === name) {
    // Jika menu yang sama diklik (untuk menutup):
    openMenu.value = null; // 1. Tutup submenu
    router.visit('/admin/dashboard'); // 2. Kembali ke halaman Dashboard
  } else {
    // Jika menu baru diklik:
    openMenu.value = name; // 1. Buka submenu yang baru
  }
};

// Saat halaman pertama kali dimuat, buka submenu yang sesuai dengan URL
onMounted(() => {
  const currentItem = navigation.value.find(item => isUrl(item.href));
  if (currentItem && currentItem.children) {
    openMenu.value = currentItem.name;
  }
});
</script>

<template>
  <div class="flex h-screen bg-gray-50 text-gray-800">
    <aside class="flex w-72 flex-col bg-white px-5 pt-6 pb-4 border-r border-gray-200 shadow-lg">
      <div class="px-4 mb-8">
        <img src="/images/logofsti.png" alt="Logo FSTV Prestasi" width="192" height="69" />
      </div>

      <nav class="flex-1 space-y-3">
        <template v-for="item in navigation" :key="item.name">
          <!-- Wrapper untuk menyatukan menu dan submenu -->
          <div>
            <component 
              :is="item.children ? 'button' : Link"
              :href="item.href"
              @click="item.children ? toggleSubMenu(item.name) : null"
              :class="[
                'flex items-center w-full p-3 transition-colors duration-200 text-left',
                openMenu === item.name ? 'rounded-t-lg' : 'rounded-lg',
                (isUrl(item.href) && !item.children)
                  ? 'bg-[#4682A9] text-white shadow-md'
                  : 'bg-[#CBDCEB] text-gray-800 hover:bg-[#a6c1da]', 
              ]"
            >
              <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                <component :is="item.icon" :class="['h-5 w-5', isUrl(item.href) ? 'text-[#4682A9]' : 'text-gray-600']" />
              </span>
              <span class="ml-4 font-semibold">{{ item.name }}</span>
              <ChevronRightIcon class="h-5 w-5 ml-auto" />
            </component>
            
            <div v-if="item.children && openMenu === item.name">
              <Link v-for="child in item.children" :key="child.name" :href="child.href"
                :class="[
                    'block w-full text-center py-2 font-semibold transition-colors duration-200 rounded-b-lg',
                     page.url.startsWith(child.href) 
                      ? 'bg-[#4682A9] text-white' 
                      : 'bg-[#CBDCEB] text-black hover:bg-[#a6c1da]'
                ]"
              >
                {{ child.name }}
              </Link>
            </div>
          </div>
        </template>
      </nav>
      
      <div class="mt-auto">
        <Link 
            href="/logout" 
            method="post" 
            as="button" 
            class="flex w-full items-center justify-between rounded-lg p-3 bg-[#CBDCEB] text-black hover:bg-[#a6c1da] transition-colors duration-200"
        >
          <span class="font-semibold">Logout</span>
          <span class="flex h-7 w-7 items-center justify-center rounded-md bg-black">
            <ArrowLeftOnRectangleIcon class="h-5 w-5 text-white" />
          </span>
        </Link>
      </div>
    </aside>

    <div class="flex flex-1 flex-col">
      <header class="flex items-center justify-end border-b border-gray-200 bg-white px-6 py-3 shadow-md">
        <div class="relative">
          <button @click="isProfileOpen = !isProfileOpen" class="flex items-center gap-4 p-1 rounded-lg">
            <div class="text-right">
              <p class="font-bold">Hikmah</p>
              <p class="text-sm text-gray-500">Super Admin</p>
            </div>
            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center border-2 border-black">
               <UsersIcon class="h-8 w-8 text-gray-400" />
            </div>
          </button>
          
          <div v-if="isProfileOpen" @click="isProfileOpen = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
              <Link href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</Link>
              <Link href="/reset-password" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Reset Password</Link>
            </div>
          </div>
        </div>
      </header>
      
      <main class="flex-1 overflow-y-auto bg-[#CBDCEB] p-8">
        <slot />
      </main>
    </div>
  </div>
</template>