<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';

// Baris ini wajib agar layout tetap ada
defineOptions({ layout: AdminLayout });

// Menerima props 'achievements' yang dikirim dari PrestasiController
defineProps<{
  achievements: {
    data: Array<{
      id: number;
      student_name: string;
      achievement_name: string;
      category: string;
      level: string;
      year: number;
    }>
  }
}>();
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold text-black">Kelola Daftar Prestasi</h1>
    <p class="mt-1 text-black">Konten untuk halaman daftar prestasi akan dibuat di sini nanti.</p>
    
    <!-- Bagian ini hanya untuk tes, menampilkan data jika ada -->
    <div v-if="achievements.data.length > 0" class="mt-8 bg-white p-4 rounded-lg">
      <h2 class="font-bold">Data dari Database:</h2>
      <ul>
        <li v-for="item in achievements.data" :key="item.id">
          {{ item.student_name }} - {{ item.achievement_name }}
        </li>
      </ul>
    </div>
    <div v-else class="mt-8 bg-yellow-100 p-4 rounded-lg text-yellow-800">
      Belum ada data prestasi di database.
    </div>

  </div>
</template>