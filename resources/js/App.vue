<template>
  <div>
    <Navbar v-if="!hideLayout" />
    <main>
      <RouterView />
    </main>
    <Footer v-if="!hideLayout" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'

const route = useRoute()
const hideLayout = computed(() => route.meta.hideLayout === true)
</script>
