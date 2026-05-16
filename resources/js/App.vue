<template>
  <div>
    <Navbar v-if="!hideLayout" />
    <main>
      <Transition name="page-fade" mode="out-in">
        <RouterView :key="route.path" />
      </Transition>
    </main>
    <Footer v-if="!hideLayout" />
    <FloatingChat v-if="!hideLayout" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
import FloatingChat from '@/components/FloatingChat.vue'

const route = useRoute()
const hideLayout = computed(() => route.meta.hideLayout === true)
</script>

<style scoped>
.page-fade-enter-active,
.page-fade-leave-active {
  transition: opacity 0.3s ease;
}

.page-fade-enter-from {
  opacity: 0;
}

.page-fade-leave-to {
  opacity: 0;
}
</style>
