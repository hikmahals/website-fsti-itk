<script setup lang="ts">
// Import komponen Navbar dan Footer
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue'; 
</script>

<template>
  <div class="bg-white font-sans antialiased overflow-x-hidden">
    <!-- Navbar akan selalu tampil di bagian atas -->
    <Navbar />

    <!-- 'slot' adalah tempat di mana konten halaman (seperti Home.vue) akan dimasukkan -->
    <main>
      <slot />
    </main>

    <!-- Footer akan selalu tampil di bagian bawah -->
    <!-- <Footer /> -->
     <Footer />
  </div>
</template>