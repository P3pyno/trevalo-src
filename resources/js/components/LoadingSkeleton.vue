<template>
  <div class="space-y-4">
    <div v-for="i in count" :key="i" class="list-item bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
      <div class="h-4 bg-gradient-to-r from-gray-200 to-gray-100 rounded w-3/4 mb-3 animate-pulse"></div>
      <div class="h-3 bg-gradient-to-r from-gray-100 to-gray-50 rounded w-1/2 animate-pulse"></div>
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

<style scoped>
@keyframes shimmer {
  0% {
    background-position: -1000px 0;
  }
  100% {
    background-position: 1000px 0;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
