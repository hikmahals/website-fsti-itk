<script setup lang="ts">
import { GraduationCap, Award, Calendar, Trophy, Medal } from 'lucide-vue-next';

interface Achievement {
  id: number;
  student_name: string;
  study_program: string;
  achievement_name: string;
  organizer: string;
  level: string;
  category: string;
  year: number;
  photo_url: string;
}

const props = defineProps<{
  achievement: Achievement;
}>();
</script>

<template>
  <div 
    class="bg-[#CBDCEB] rounded-lg overflow-hidden transition-transform duration-300 ease-in-out 
           hover:scale-105 hover:shadow-lg flex flex-col"
  >
    <div class="aspect-video">
      <img 
        :src="achievement.photo_url" 
        :alt="'Foto ' + achievement.student_name" 
        class="w-full h-full object-cover"
        loading="lazy"
        onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/FFFFFF?text=Image+Not+Found';"
      >
    </div>

    <div class="p-5 flex flex-col flex-grow justify-between">
      <div>
        <div class="flex items-center flex-wrap gap-2 mb-3">
          <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#133E87] bg-white px-2 py-0.5 rounded-full border border-[#133E87]">
            <Trophy class="h-3 w-3" /> {{ achievement.category }}
          </span>
          <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#133E87] bg-white px-2 py-0.5 rounded-full border border-[#133E87]">
            <Medal class="h-3 w-3" /> {{ achievement.level }}
          </span>
          <span class="inline-flex items-center gap-1 text-xs font-semibold text-[#133E87] bg-white px-2 py-0.5 rounded-full border border-[#133E87]">
            <Calendar class="h-3 w-3" />
            {{ achievement.year }}
          </span>
        </div>

        <h3 class="text-xl font-bold text-black leading-snug">{{ achievement.student_name }}</h3>
        <p class="flex items-center gap-2 text-sm text-black mt-1">
          <GraduationCap class="h-4 w-4" />
          {{ achievement.study_program }}
        </p>
      </div>

      <div class="mt-4 pt-4 border-t border-gray-400/50 flex flex-col">
        <p class="flex items-start gap-2 text-base font-bold text-black min-h-[3rem]">
          <Award class="h-5 w-5 flex-shrink-0 mt-0.5" />
          <span class="flex-1">{{ achievement.achievement_name }}</span>
        </p>
        <p class="text-sm text-black mt-2">
          Oleh: {{ achievement.organizer }}
        </p>
      </div>
    </div>
  </div>
</template>