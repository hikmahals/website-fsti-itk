<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  backgroundImage: {
    type: String,
    required: true,
  }
});

const bannerStyle = computed(() => {
  return {
    backgroundImage: `url('${props.backgroundImage}')`
  };
});
</script>

<template>
  <div
    class="relative h-64 md:h-50 w-full bg-cover bg-center flex items-center justify-center shadow-sm mt-8"
    :style="bannerStyle"
  >
    <div class="absolute inset-0 bg-white opacity-10"></div>

    <div class="relative z-10 text-center px-4">
      <h1
        class="text-white text-6xl md:text-8xl font-kulim-park font-extrabold uppercase tracking-wider"
        style="-webkit-text-stroke: 2px #4682A9; text-stroke: 3px #4682A9;"
      >
        {{ title }}
      </h1>
    </div>
  </div>
</template>