<template>
  <div>
    <PageLoader />
    <Navbar v-if="!hideLayout" />
    <main>
      <Transition name="page-fade">
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
import PageLoader from '@/components/PageLoader.vue'

const route = useRoute()
const hideLayout = computed(() => route.meta.hideLayout === true)
</script>

<style scoped>
.page-fade-enter-active,
.page-fade-leave-active {
  transition: opacity 0.15s ease;
}

.page-fade-enter-from,
.page-fade-leave-to {
  opacity: 0;
}
</style>
