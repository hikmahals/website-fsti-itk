<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';

// Baris ini wajib agar halaman ini tetap menggunakan layout admin
defineOptions({ layout: AdminLayout });
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold text-black">Dashboard</h1>
    <p class="mt-1 text-black">Selamat datang di dashboard admin.</p>
  </div>
</template>
