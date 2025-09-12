<script setup lang="ts">
import { computed } from 'vue';
import { Globe, Flag, Building, Calendar, Award } from 'lucide-vue-next';

interface Achievement {
  id: number;
  student_name: string;
  competition_name: string;
  organizer: string;
  level: string;
  year: number;
  photo_url?: string; // Foto bersifat opsional
}

const props = defineProps<{
  achievement: Achievement;
}>();

// Logika untuk menentukan ikon dan warna badge berdasarkan tingkat prestasi
const levelInfo = computed(() => {
    switch (props.achievement.level.toLowerCase()) {
        case 'internasional':
            return { icon: Globe, color: 'bg-yellow-500 text-white', label: 'Internasional' };
        case 'nasional':
            return { icon: Flag, color: 'bg-red-600 text-white', label: 'Nasional' };
        default:
            return { icon: Building, color: 'bg-blue-500 text-white', label: props.achievement.level };
    }
});
</script>

<template>
    <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group">
        <!-- Bagian Gambar -->
        <div class="aspect-video bg-gray-200">
            <img 
                :src="achievement.photo_url" 
                :alt="'Foto ' + achievement.student_name" 
                class="w-full h-full object-cover"
                loading="lazy"
                onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/FFFFFF?text=Image+Not+Found';"
            >
        </div>

        <!-- Bagian Konten -->
        <div class="p-6 flex flex-col h-full">
            <h3 class="text-xl font-bold text-[#133E87] mb-2 leading-tight">
                {{ achievement.student_name }}
            </h3>
            <p class="text-gray-700 font-semibold flex-grow">
                <Award class="inline-block w-4 h-4 mr-2 text-yellow-500" />
                {{ achievement.competition_name }}
            </p>
            <p class="text-sm text-gray-500 mt-1 mb-4">
                Oleh: {{ achievement.organizer }}
            </p>

            <!-- Bagian Metadata (Tingkat & Tahun) -->
            <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center text-sm">
                <span 
                    :class="levelInfo.color" 
                    class="inline-flex items-center font-bold px-3 py-1 rounded-full text-xs"
                >
                    <component :is="levelInfo.icon" class="w-4 h-4 mr-2" />
                    {{ levelInfo.label }}
                </span>
                <span class="text-gray-600 font-medium flex items-center">
                    <Calendar class="w-4 h-4 mr-2 text-gray-400" />
                    {{ achievement.year }}
                </span>
            </div>
        </div>
    </div>
</template>
