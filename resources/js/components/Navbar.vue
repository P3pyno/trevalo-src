<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="isTransparent ? 'bg-transparent py-5' : 'bg-white shadow-md py-3'"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between">
        <AppLogo :text-class="isTransparent ? 'text-white' : 'text-navy-700'" />

        <!-- Desktop nav -->
        <nav class="hidden lg:flex items-center gap-7">
          <RouterLink
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            class="text-sm font-medium transition-colors duration-200"
            :class="isTransparent ? 'text-white/80 hover:text-white' : 'text-gray-600 hover:text-navy-700'"
            active-class="!text-gold-400 font-semibold"
            exact-active-class="!text-gold-400 font-semibold"
          >
            {{ $t(link.key) }}
          </RouterLink>
        </nav>

        <div class="hidden lg:flex items-center gap-3">
          <RouterLink
            to="/auth"
            class="text-sm font-semibold transition-colors duration-200 px-4 py-2 rounded-lg"
            :class="isTransparent
              ? 'text-white/80 hover:text-white hover:bg-white/10'
              : 'text-gray-600 hover:text-navy-700 hover:bg-gray-100'"
          >
            Sign In
          </RouterLink>
          <RouterLink to="/quote" class="btn-primary text-sm">
            {{ $t('nav.get_quote') }}
          </RouterLink>
        </div>

        <!-- Mobile hamburger -->
        <button
          @click="store.toggleMobileMenu()"
          class="lg:hidden p-2 rounded-md transition-colors"
          :class="isTransparent ? 'text-white' : 'text-navy-700'"
          aria-label="Toggle menu"
        >
          <svg v-if="!store.mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg v-else class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <Transition name="slide-down">
      <div v-if="store.mobileMenuOpen" class="lg:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 space-y-1">
          <RouterLink
            v-for="link in navLinks"
            :key="link.path"
            :to="link.path"
            @click="store.closeMobileMenu()"
            class="block px-4 py-3 text-sm font-medium text-gray-600 hover:text-navy-700 hover:bg-navy-50 rounded-lg transition-colors"
            active-class="!text-navy-700 bg-navy-50 font-semibold"
          >
            {{ $t(link.key) }}
          </RouterLink>
          <div class="pt-2 pb-1">
            <RouterLink to="/contact" @click="store.closeMobileMenu()" class="btn-primary w-full text-sm">
              {{ $t('nav.get_quote') }}
            </RouterLink>
          </div>
        </div>
      </div>
    </Transition>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useAppStore } from '@/stores/app'
import AppLogo from './AppLogo.vue'

const store = useAppStore()
const route = useRoute()
const scrollY = ref(0)

const navLinks = [
  { key: 'nav.home',         path: '/' },
  { key: 'nav.about',        path: '/about' },
  { key: 'nav.services',     path: '/services' },
  { key: 'nav.how_it_works', path: '/how-it-works' },
  { key: 'nav.contact',      path: '/contact' },
]

const isTransparent = computed(
  () => route.name === 'home' && scrollY.value < 80 && !store.mobileMenuOpen
)

function onScroll() { scrollY.value = window.scrollY }

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
watch(() => route.path, () => store.closeMobileMenu())
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.25s ease;
}
.slide-down-enter-from,
.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>
