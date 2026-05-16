<template>
  <div class="space-y-4">
    <div v-for="i in count" :key="i" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 animate-pulse">
      <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
      <div class="h-3 bg-gray-100 rounded w-1/2"></div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  count: {
    type: Number,
    default: 5,
  },
})
</script>
