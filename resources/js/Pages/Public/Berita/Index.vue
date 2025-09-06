<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import SidebarLatest from '@/Components/SidebarLatest.vue';
import { Link } from '@inertiajs/vue3';
import { Search, ListFilter, ChevronDown } from 'lucide-vue-next';
import type { PaginatedPosts, Post, Filters } from '@/types';
import { debounce } from 'lodash';

const props = defineProps<{
  posts: PaginatedPosts;
  recentPosts: Post[];
  categories: string[];
  filters: Filters;
}>();

const bannerImage = '/images/background-banner.png';

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

// --- LOGIKA UNTUK CUSTOM DROPDOWN ---
const isOpen = ref(false);
const dropdownRef = ref<HTMLDivElement | null>(null);

function selectCategory(selected: string) {
  category.value = selected;
  isOpen.value = false;
}

const handleClickOutside = (event: MouseEvent) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
});
onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});
// --- END LOGIKA ---

watch([search, category], debounce(() => {
    router.get(route('berita.index'), {
        search: search.value,
        category: category.value,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

</script>

<template>
  <PublicLayout title="Berita">
    
    <Banner title="Berita" :background-image="bannerImage" />

    <div class="py-12 md:py-16 bg-white">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col md:flex-row gap-4">
          <div class="relative flex-grow">
            <input 
              type="text" 
              placeholder="Cari berita" 
              class="w-full pl-12 pr-4 py-4 border-none rounded-lg focus:ring-2 focus:ring-blue-500 bg-[#CBD5E1] text-black font-bold placeholder-black"
              v-model="search"
            >
            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-black" />
          </div>

          <div class="relative md:w-auto" ref="dropdownRef">
            <button 
              @click="isOpen = !isOpen"
              class="w-full md:w-64 pl-12 pr-10 py-4 border-none rounded-lg bg-[#CBD5E1] text-black font-bold flex items-center justify-between text-left"
            >
              <span>{{ category || 'Semua Kategori' }}</span>
              <ChevronDown class="w-6 h-6 text-black transition-transform" :class="{'rotate-180': isOpen}" />
            </button>
            <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-black pointer-events-none" />
            
            <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
            >
              <div v-if="isOpen" class="absolute z-10 mt-2 w-full bg-white rounded-md shadow-lg border border-gray-200">
                <div class="py-1">
                  <a @click="selectCategory('')" class="block px-4 py-2 text-black font-medium hover:bg-gray-100 cursor-pointer">Semua Kategori</a>
                  <a v-for="cat in categories" :key="cat" @click="selectCategory(cat)" class="block px-4 py-2 text-black font-medium hover:bg-gray-100 cursor-pointer">
                    {{ cat }}
                  </a>
                </div>
              </div>
            </transition>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <div class="lg:col-span-2 space-y-8">
            <ArticleCard v-for="post in posts.data" :key="post.id" :post="post" />
          </div>
          <div class="lg:col-span-1">
            <div class="sticky top-24">
              <SidebarLatest :recent-posts="recentPosts" />
            </div>
          </div>
        </div>

        <div v-if="posts.links.length > 3" class="mt-12 flex justify-center items-center space-x-1">
            <template v-for="(link, index) in posts.links" :key="index">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    v-html="link.label"
                    class="px-4 py-2 text-sm font-semibold rounded-lg"
                    :class="{
                        'bg-[#133E87] text-white': link.active,
                        'text-black hover:bg-gray-200': !link.active,
                    }"
                />
                <span
                    v-else
                    v-html="link.label"
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-black cursor-not-allowed"
                />
            </template>
        </div>

        <div v-if="posts.total > 0" class="mt-4 text-center text-sm text-black">
            Menampilkan 
            <span class="font-bold">{{ posts.from }}</span> 
            sampai 
            <span class="font-bold">{{ posts.to }}</span> 
            dari 
            <span class="font-bold">{{ posts.total }}</span> 
            berita
        </div>

      </div>
    </div>
  </PublicLayout>
</template>