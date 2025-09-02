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

const openMenu = ref<string | null>(null);

const navigation = ref([
  { name: 'Dashboard', href: '/admin/dashboard', icon: ChartBarSquareIcon, children: null },
  { 
    name: 'Berita', 
    href: null,
    icon: NewspaperIcon, 
    children: [
      { name: 'Kelola Berita', href: '/admin/posts' }
    ] 
  },
  { 
    name: 'Prestasi', 
    href: null,
    icon: TrophyIcon,
    children: [
      { name: 'Kelola Daftar Prestasi', href: '/admin/achievements' }
    ]
  },
  { name: 'Kelola Akun Admin', href: '/admin/akun', icon: UsersIcon, children: null },
]);

// Fungsi untuk mengecek apakah URL saat ini cocok dengan salah satu anak menu
const isParentUrlActive = (item: any) => {
    if (!item.children) return false;
    return item.children.some((child: any) => page.url.startsWith(child.href));
};

// Fungsi toggle yang benar
const toggleSubMenu = (name: string) => {
  if (openMenu.value === name) {
    openMenu.value = null; // Jika menu sama diklik, tutup submenu
  } else {
    openMenu.value = name; // Jika menu lain diklik, buka submenu
  }
};

// Saat halaman dimuat, buka submenu yang relevan
onMounted(() => {
  const currentParent = navigation.value.find(item => isParentUrlActive(item));
  if (currentParent) {
    openMenu.value = currentParent.name;
  }
});
</script>

<template>
  <div class="flex h-screen bg-gray-50 text-gray-800">
    <!-- PERUBAHAN: Menambahkan 'flex-shrink-0' agar sidebar tidak ikut terdorong/menyusut saat konten lebar -->
    <aside class="flex w-72 flex-col flex-shrink-0 bg-white px-5 pt-6 pb-4 border-r border-gray-200 shadow-lg">
      <div class="px-4 mb-8">
        <img src="/images/logofsti.png" alt="Logo FSTV Prestasi" width="192" height="69" />
      </div>

      <nav class="flex-1 space-y-3">
        <template v-for="item in navigation" :key="item.name">
          <div>
            <!-- Link untuk menu tanpa anak -->
            <Link
              v-if="!item.children"
              :href="item.href"
              :class="[
                'flex items-center w-full p-3 transition-colors duration-200 rounded-lg',
                page.url.startsWith(item.href)
                  ? 'bg-[#4682A9] text-white shadow-md'
                  : 'bg-[#CBDCEB] text-gray-800 hover:bg-[#a6c1da]', 
              ]"
            >
              <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                <component :is="item.icon" :class="['h-5 w-5', page.url.startsWith(item.href) ? 'text-[#4682A9]' : 'text-gray-600']" />
              </span>
              <span class="ml-4 font-semibold">{{ item.name }}</span>
              <ChevronRightIcon class="h-5 w-5 ml-auto" />
            </Link>

            <!-- Tombol untuk menu dengan anak -->
            <button
              v-else
              @click="toggleSubMenu(item.name)"
              :class="[
                'flex items-center w-full p-3 transition-colors duration-200 text-left',
                openMenu === item.name ? 'rounded-t-lg' : 'rounded-lg',
                'bg-[#CBDCEB] text-gray-800 hover:bg-[#a6c1da]',
              ]"
            >
              <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                <component :is="item.icon" :class="['h-5 w-5', isParentUrlActive(item) ? 'text-[#4682A9]' : 'text-gray-600']" />
              </span>
              <span class="ml-4 font-semibold">{{ item.name }}</span>
              <ChevronRightIcon class="h-5 w-5 ml-auto" />
            </button>
            
            <!-- Submenu -->
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

    <!-- PERUBAHAN: Menambahkan 'overflow-x-hidden' agar container ini tidak ikut scroll -->
    <div class="flex flex-1 flex-col overflow-x-hidden">
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
      
      <!-- PERUBAHAN: Mengganti 'overflow-y-auto' menjadi 'overflow-auto' agar bisa scroll horizontal & vertikal -->
      <main class="flex-1 overflow-auto bg-[#CBDCEB] p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

