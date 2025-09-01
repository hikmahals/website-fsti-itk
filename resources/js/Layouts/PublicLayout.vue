<script setup lang="ts">
// Import komponen Navbar dan Footer
import Navbar from '@/Components/Navbar.vue';
// Footer akan kita buat selanjutnya, untuk sekarang bisa berupa placeholder
// import Footer from '@/components/Footer.vue'; 
</script>

<template>
  <div class="bg-gray-100 font-sans antialiased">
    <!-- Navbar akan selalu tampil di bagian atas -->
    <Navbar />

    <!-- 'slot' adalah tempat di mana konten halaman (seperti Home.vue) akan dimasukkan -->
    <main>
      <slot />
    </main>

    <!-- Footer akan selalu tampil di bagian bawah -->
    <!-- <Footer /> -->
    <footer class="bg-gray-800 text-white py-8 text-center">
        <p>(Placeholder untuk Footer)</p>
    </footer>
  </div>
</template>