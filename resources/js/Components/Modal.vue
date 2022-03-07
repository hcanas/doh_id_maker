<script setup>
  defineProps(['show']);
</script>

<template>
  <div :class="{ '-translate-y-full': !show }" class="w-full h-full absolute inset-0 flex justify-center items-center transition transform duration-100">
    <div class="w-full h-full absolute inset-0 bg-gray-900 opacity-75"></div>
    <div class="relative w-1/3 h-5/6 bg-white p-8 rounded overflow-y-auto">
      <slot />
    </div>
  </div>
</template>