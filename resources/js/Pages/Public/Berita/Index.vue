<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import SidebarLatest from '@/Components/SidebarLatest.vue';
import { Link } from '@inertiajs/vue3';
import { Search, ListFilter } from 'lucide-vue-next';

// Terima semua data dinamis dari Controller
const props = defineProps<{
  posts: {
    data: any[];
    links: Array<{
      url: string | null;
      label: string;
      active: boolean;
    }>;
  };
  latestPosts: any[];
  categories: any[];
}>();

const bannerImage = '/images/background-banner.png';
</script>

<template>
  <PublicLayout title="Berita">
    
    <Banner title="Berita" :background-image="bannerImage" />

    <div class="py-12 md:py-16 bg-gray-50">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 flex flex-col md:flex-row gap-4">
          <div class="relative flex-grow">
            <input type="text" placeholder="Cari berita" class="w-full pl-10 pr-4 py-3 border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
          </div>
          <div class="relative md:w-auto">
            <select class="w-full md:w-64 pl-10 pr-4 py-3 border-gray-200 rounded-lg appearance-none focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
              <option value="">Semua Kategori</option>
              <option v-for="category in props.categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
            <ListFilter class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          
          <div class="lg:col-span-2 space-y-8">
            <ArticleCard v-for="post in props.posts.data" :key="post.id" :post="post" />
          </div>
          
          <div class="lg:col-span-1">
            <div class="sticky top-24">
              <SidebarLatest :latestPosts="props.latestPosts" />
            </div>
          </div>

        </div>

        <div v-if="props.posts.links && props.posts.links.length > 3" class="mt-12 flex justify-center items-center space-x-1">
            <Link
                v-for="(link, index) in props.posts.links"
                :key="index"
                :href="link.url ?? undefined"
                v-html="link.label"
                class="px-4 py-2 text-sm font-semibold rounded-lg"
                :class="{
                    'bg-[#133E87] text-white': link.active,
                    'text-gray-700 hover:bg-gray-200': !link.active,
                    'text-gray-400 cursor-not-allowed': !link.url
                }"
            />
        </div>

      </div>
    </div>
  </PublicLayout>
</template>