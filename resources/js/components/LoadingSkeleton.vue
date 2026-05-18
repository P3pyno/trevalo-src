<template>
  <!-- Stat cards -->
  <template v-if="type === 'stat'">
    <div v-for="i in count" :key="i" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
      <div class="w-10 h-10 rounded-xl bg-gray-200 animate-pulse mb-3" />
      <div class="h-7 w-14 bg-gray-200 rounded animate-pulse mb-2" />
      <div class="h-3 w-28 bg-gray-100 rounded animate-pulse" />
    </div>
  </template>

  <!-- List / card rows -->
  <template v-else-if="type === 'list'">
    <div v-for="i in count" :key="i" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
      <div class="flex items-start justify-between gap-4">
        <div class="flex items-start gap-4 flex-1 min-w-0">
          <div class="w-10 h-10 rounded-xl bg-gray-200 animate-pulse flex-shrink-0" />
          <div class="flex-1 space-y-2 min-w-0">
            <div class="h-4 bg-gray-200 rounded animate-pulse w-3/4" />
            <div class="h-3 bg-gray-100 rounded animate-pulse w-1/2" />
            <div class="h-3 bg-gray-100 rounded animate-pulse w-2/3" />
          </div>
        </div>
        <div class="h-6 w-20 bg-gray-200 rounded-full animate-pulse flex-shrink-0" />
      </div>
    </div>
  </template>

  <!-- Message rows -->
  <template v-else-if="type === 'message'">
    <div v-for="i in count" :key="i" class="flex gap-3 px-6 py-3" :class="i % 2 === 0 ? 'justify-end' : 'justify-start'">
      <div v-if="i % 2 !== 0" class="w-7 h-7 rounded-full bg-gray-200 animate-pulse flex-shrink-0" />
      <div class="space-y-1.5" :class="i % 2 === 0 ? 'items-end' : 'items-start'">
        <div class="h-3 w-16 bg-gray-100 rounded animate-pulse" />
        <div class="h-10 rounded-2xl bg-gray-200 animate-pulse"
          :class="[i % 2 === 0 ? 'bg-navy-200 rounded-br-sm' : 'rounded-bl-sm', i % 3 === 0 ? 'w-48' : i % 2 === 0 ? 'w-64' : 'w-40']" />
      </div>
    </div>
  </template>

  <!-- Table rows -->
  <template v-else-if="type === 'table'">
    <div v-for="i in count" :key="i"
      class="flex items-center gap-4 px-6 py-4 border-b border-gray-50 last:border-0">
      <div class="h-4 w-24 bg-gray-200 rounded animate-pulse" />
      <div class="h-4 flex-1 bg-gray-200 rounded animate-pulse" />
      <div class="h-4 w-20 bg-gray-100 rounded animate-pulse" />
      <div class="h-5 w-16 bg-gray-200 rounded-full animate-pulse" />
    </div>
  </template>

  <!-- Default generic rows -->
  <template v-else>
    <div v-for="i in count" :key="i" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-3">
      <div class="h-4 bg-gray-200 rounded w-3/4 animate-pulse" />
      <div class="h-3 bg-gray-100 rounded w-1/2 animate-pulse" />
    </div>
  </template>
</template>

<script setup>
defineProps({
  type:  { type: String, default: 'default' },
  count: { type: Number, default: 3 },
})
</script>
