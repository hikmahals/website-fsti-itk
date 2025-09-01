<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { 
  MagnifyingGlassIcon, 
  FunnelIcon,
  ChevronDownIcon,
  EyeIcon,
  PencilSquareIcon,
  TrashIcon,
  PlusIcon,
} from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

interface Berita {
  id: number;
  judul: string;
  kategori: string;
  tanggal: string;
  status: 'Published' | 'Draft';
  views: number;
}

const daftarBerita = ref<Berita[]>([
  { id: 1, judul: 'Workshop AI dan Machine Learning untuk Mahasiswa', kategori: 'Kegiatan', tanggal: '24/08/2025', status: 'Published', views: 100 },
]);
</script>

<template>
  <div>
    <div class="flex items-start justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-black">Kelola Berita</h1>
        <p class="mt-1 text-black">Manajemen konten berita untuk website Fakultas Sains dan Teknologi Institut Teknologi Kalimantan</p>
      </div>
      <button class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0">
        <PlusIcon class="h-5 w-5" />
        Tambah Berita
      </button>
    </div>

    <!-- Panel Aksi (Search & Filter) -->
    <div class="flex items-center justify-between gap-4 mb-6">
      <div class="relative flex-grow">
        <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
        <!-- Diubah: Ditambahkan bg-white dan shadow-sm, border di-override -->
        <input 
          type="text" 
          placeholder="Cari Berita" 
          class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
        />
      </div>
      
      <!-- Diubah: Ditambahkan bg-white dan shadow-sm, padding disesuaikan -->
      <button class="flex items-center gap-3 rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 flex-shrink-0 shadow-sm">
        <FunnelIcon class="h-5 w-5 text-gray-500"/>
        <span class="text-black">Semua Status</span>
        <ChevronDownIcon class="h-5 w-5 text-gray-500"/>
      </button>
    </div>

    <!-- Tabel -->
    <div class="bg-white shadow-sm p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-black mb-4">Daftar Berita</h3>
      
      <div class="border rounded-lg overflow-x-auto">
        <table class="w-full min-w-full">
          <thead class="bg-[#CBDCEB]">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Judul</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Kategori</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tanggal</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Views</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="berita in daftarBerita" :key="berita.id" class="hover:bg-gray-50">
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ berita.judul }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm">
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">{{ berita.kategori }}</span>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ berita.tanggal }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm">
                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">{{ berita.status }}</span>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                <span class="flex items-center gap-2"><EyeIcon class="h-4 w-4" /> {{ berita.views }}</span>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                  <a href="#" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                    <PencilSquareIcon class="h-4 w-4" />
                    Edit
                  </a>
                  <span class="text-gray-300">|</span>
                  <a href="#" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                    <TrashIcon class="h-4 w-4" />
                    Hapus
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex items-center justify-between mt-4">
        <p class="text-sm text-black">
          Showing <span class="font-semibold">1-10</span> of <span class="font-semibold">30</span>
        </p>
        <div class="flex items-center gap-2">
           <button class="rounded border border-gray-300 bg-[#CBDCEB] px-3 py-1 text-sm font-medium text-gray-800 hover:bg-opacity-80">Previous</button>
           <button class="rounded border border-gray-300 bg-[#CBDCEB] px-3 py-1 text-sm font-medium text-gray-800 hover:bg-opacity-80">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>