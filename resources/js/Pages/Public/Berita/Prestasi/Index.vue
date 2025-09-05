<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue'; 
import Banner from '@/Components/Banner.vue';

const pageTitle = 'Prestasi';
const bannerImage = '/images/background-banner.png';
</script>

<template>
  <PublicLayout :title="pageTitle">
    
    <Banner :title="pageTitle" :background-image="bannerImage" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-lg">
          <p>Ini adalah konten halaman Profil...</p>
        </div>
      </div>
    </div>
    
  </PublicLayout>
</template>