<template>
  <RouterLink to="/" class="inline-flex items-center gap-3 group">
    <!-- Globe icon -->
    <svg class="w-9 h-9 flex-shrink-0" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="20" cy="20" r="17" stroke="#C8A45D" stroke-width="2"/>
      <ellipse cx="20" cy="20" rx="8.5" ry="17" stroke="#C8A45D" stroke-width="1.5"/>
      <line x1="3" y1="20" x2="37" y2="20" stroke="#C8A45D" stroke-width="1.5"/>
      <line x1="6" y1="12.5" x2="34" y2="12.5" stroke="#C8A45D" stroke-width="1"/>
      <line x1="6" y1="27.5" x2="34" y2="27.5" stroke="#C8A45D" stroke-width="1"/>
    </svg>
    <div class="leading-none">
      <div :class="textClass" class="text-xl font-bold tracking-widest">TRIVALO</div>
      <div class="text-gold-400 text-[10px] font-semibold tracking-[0.25em] mt-0.5">SOURCING</div>
    </div>
  </RouterLink>
</template>

<script setup>
defineProps({
  textClass: {
    type: String,
    default: 'text-navy-700',
  },
})
</script>
