<template>
  <Transition name="loader-fade">
    <div v-if="loading" class="fixed top-0 left-0 right-0 z-[9999] pointer-events-none">
      <div class="h-0.5 bg-gray-100">
        <div class="h-full bg-gradient-to-r from-gold-400 to-gold-500 rounded-r-full shadow shadow-gold-300/50 transition-all duration-300 ease-out"
          :style="{ width: progress + '%' }" />
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const loading  = ref(false)
const progress = ref(0)

let timer = null

function start() {
  loading.value  = true
  progress.value = 15
  clearInterval(timer)
  timer = setInterval(() => {
    if (progress.value < 85) progress.value += (85 - progress.value) * 0.12
  }, 120)
}

function finish() {
  clearInterval(timer)
  progress.value = 100
  setTimeout(() => {
    loading.value  = false
    progress.value = 0
  }, 300)
}

const router = useRouter()
router.beforeEach(start)
router.afterEach(finish)
</script>

<style scoped>
.loader-fade-enter-active, .loader-fade-leave-active { transition: opacity 0.2s ease; }
.loader-fade-enter-from, .loader-fade-leave-to       { opacity: 0; }
</style>
