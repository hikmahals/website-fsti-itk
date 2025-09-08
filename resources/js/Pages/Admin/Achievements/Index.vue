<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, router, usePage, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import type { PaginatedAchievements, Achievement, Filters } from '@/types';
import { 
    PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon,
    MagnifyingGlassIcon, FunnelIcon, ArrowUpOnSquareIcon, ArrowDownOnSquareIcon, ChevronDownIcon 
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
  achievements: PaginatedAchievements;
  filters: Filters;
}>();

// --- Logika Filter & Pencarian ---
const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

watch([search, category], debounce(() => {
    router.get(route('admin.achievements.index'), {
        search: search.value,
        category: category.value,
    }, { preserveState: true, replace: true });
}, 300));

// --- Logika Modal & Notifikasi ---
const isModalOpen = ref(false);
const itemToDelete = ref<Achievement | null>(null);
const openDeleteModal = (item: Achievement) => { itemToDelete.value = item; isModalOpen.value = true; };
const closeDeleteModal = () => { isModalOpen.value = false; itemToDelete.value = null; };
const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.achievements.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);
watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 3000);
    }
}, { immediate: true });

// --- Logika Impor & Ekspor ---
const isExportOpen = ref(false);
const importForm = useForm({
    file: null as File | null,
});

const triggerImportFile = () => {
    const fileInput = document.getElementById('import-file-input') as HTMLInputElement;
    fileInput.click();
};

const handleFileImport = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        importForm.file = target.files[0];
        importForm.post(route('admin.achievements.import'));
    }
};
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-black">Kelola Daftar Prestasi</h1>
        <p class="mt-1 text-black">Manajemen daftar prestasi mahasiswa untuk website Fakultas Sains dan Teknologi <br> Institut Teknologi Kalimantan</p>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0">
        <div class="relative">
            <button @click="isExportOpen = !isExportOpen" class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-black border border-gray-300 shadow-sm hover:bg-gray-50">
                <ArrowUpOnSquareIcon class="h-5 w-5" />
                Ekspor
                <ChevronDownIcon class="h-4 w-4" />
            </button>
            <div v-if="isExportOpen" @click="isExportOpen = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                <div class="py-1">
                    <a :href="route('admin.achievements.export', { format: 'xlsx' })" class="block px-4 py-2 text-sm text-black hover:bg-gray-100">Excel (.xlsx)</a>
                    <a :href="route('admin.achievements.export', { format: 'csv' })" class="block px-4 py-2 text-sm text-black hover:bg-gray-100">CSV (.csv)</a>
                    <a :href="route('admin.achievements.export', { format: 'pdf' })" class="block px-4 py-2 text-sm text-black hover:bg-gray-100">PDF (.pdf)</a>
                </div>
            </div>
        </div>
        <form @submit.prevent>
            <input type="file" id="import-file-input" @change="handleFileImport" class="hidden" accept=".xlsx, .csv" />
            <button @click="triggerImportFile" type="button" class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-black border border-gray-300 shadow-sm hover:bg-gray-50">
                <ArrowDownOnSquareIcon class="h-5 w-5" />
                Impor
            </button>
        </form>
        <Link :href="route('admin.achievements.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">
          <PlusIcon class="h-5 w-5" />
          Tambah Prestasi
        </Link>
      </div>
    </div>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="relative flex-grow">
            <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
            <input 
                v-model="search"
                type="text" 
                placeholder="Cari daftar prestasi" 
                class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
            />
        </div>
        <div class="relative flex-shrink-0">
            <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
            <select v-model="category" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <option value="">Semua Kategori</option>
                <option value="Akademik">Akademik</option>
                <option value="Non-Akademik">Non-Akademik</option>
            </select>
        </div>
    </div>

    <div class="bg-white shadow-sm p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-black mb-4">Daftar Prestasi</h3>
      <div class="border rounded-lg overflow-x-auto">
        <table class="w-full min-w-full">
          <thead class="bg-[#CBDCEB]">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">Nama Mahasiswa</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">Capaian Prestasi</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-40">Kategori</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-40">Tingkat</th>
              <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-black w-24">Tahun</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-32">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-if="achievements.data.length > 0" v-for="item in achievements.data" :key="item.id" class="hover:bg-gray-50">
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ item.student_name }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ item.achievement_name }}</td>
              <td class="whitespace-nowrap px-6 py-4">
                <span class="rounded-full px-3 py-1 text-xs font-medium" :class="item.category === 'Akademik' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">{{ item.category }}</span>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ item.level }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black text-center">{{ item.year }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                  <Link :href="route('admin.achievements.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                    <PencilSquareIcon class="h-4 w-4" />
                    Edit
                  </Link>
                  <span class="text-gray-300">|</span>
                  <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                    <TrashIcon class="h-4 w-4" />
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
            <tr v-else>
              <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data prestasi.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex items-center justify-between mt-4">
        <p v-if="achievements.total > 0" class="text-sm text-black">
          Menampilkan <span class="font-medium">{{ achievements.from }}</span> sampai <span class="font-medium">{{ achievements.to }}</span> dari <span class="font-medium">{{ achievements.total }}</span> hasil
        </p>
        <div class="flex items-center gap-1">
          <Link v-for="(link, index) in achievements.links" :key="index" :href="link.url ?? '#'" v-html="link.label"
            :class="['px-3 py-1 text-sm rounded border border-gray-300', link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB]  text-gray-800 hover:bg-gray-100', !link.url ? 'text-gray-400 cursor-not-allowed' : '']"
          />
        </div>
      </div>
    </div>
    
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity" @click.self="closeDeleteModal">
      <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl transition-transform transform scale-95" :class="{'scale-100': isModalOpen}">
        <div class="flex flex-col items-center text-center">
          <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
            <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
          </div>
          <h2 class="text-2xl font-bold text-gray-800">Hapus Prestasi</h2>
          <p class="mt-2 text-gray-600">
            Apakah Anda yakin ingin menghapus prestasi oleh <br>
            <span class="font-semibold">"{{ itemToDelete?.student_name }}"</span>? Aksi ini tidak dapat dibatalkan.
          </p>
        </div>
        <div class="mt-8 flex justify-center gap-4">
          <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">
            Batal
          </button>
          <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">
            Ya, Hapus
          </button>
        </div>
      </div>
    </div>
    
    <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="showNotification" class="fixed top-5 right-5 z-50">
            <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
                <CheckCircleIcon class="h-8 w-8" />
                <p class="font-semibold">{{ notificationMessage }}</p>
            </div>
        </div>
    </transition>

  </div>
</template>

