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
            :active-class="isTransparent ? '!text-gold-400 font-semibold' : '!text-gold-700 font-semibold'"
            :exact-active-class="isTransparent ? '!text-gold-400 font-semibold' : '!text-gold-700 font-semibold'"
          >
            {{ $t(link.key) }}
          </RouterLink>
        </nav>

        <div class="hidden lg:flex items-center gap-3">
          <!-- Guest -->
          <RouterLink
            v-if="!authStore.isAuthenticated"
            to="/auth"
            class="text-sm font-semibold transition-colors duration-200 px-4 py-2 rounded-lg"
            :class="isTransparent
              ? 'text-white/80 hover:text-white hover:bg-white/10'
              : 'text-gray-600 hover:text-navy-700 hover:bg-gray-100'"
          >
            Sign In
          </RouterLink>

          <!-- Authenticated: avatar + dropdown -->
          <div v-else class="relative" ref="profileRef">
            <button
              @click="profileOpen = !profileOpen"
              class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl transition-colors duration-200"
              :class="isTransparent ? 'hover:bg-white/10' : 'hover:bg-gray-100'"
            >
              <!-- Avatar initials -->
              <div class="w-8 h-8 rounded-full bg-gold-400 flex items-center justify-center text-navy-700 font-bold text-sm flex-shrink-0">
                {{ userInitials }}
              </div>
              <span class="text-sm font-semibold max-w-[120px] truncate"
                :class="isTransparent ? 'text-white' : 'text-navy-700'">
                {{ authStore.user?.name?.split(' ')[0] }}
              </span>
              <svg class="w-4 h-4 transition-transform duration-200"
                :class="[profileOpen ? 'rotate-180' : '', isTransparent ? 'text-white/70' : 'text-gray-500']"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>

            <!-- Dropdown -->
            <Transition name="dropdown">
              <div v-if="profileOpen" class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                <!-- User info -->
                <div class="px-4 py-3 border-b border-gray-100">
                  <div class="text-sm font-semibold text-navy-700 truncate">{{ authStore.user?.name }}</div>
                  <div class="text-xs text-gray-500 truncate mt-0.5">{{ authStore.user?.email }}</div>
                </div>


                <RouterLink to="/profile" @click="profileOpen = false"
                  class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:text-navy-700 hover:bg-gray-50 transition-colors">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  Profile
                </RouterLink>

                <RouterLink v-if="!authStore.user?.is_admin" to="/dashboard" @click="profileOpen = false"
                  class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:text-navy-700 hover:bg-gray-50 transition-colors">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                  </svg>
                  Dashboard
                </RouterLink>

                <RouterLink v-if="authStore.user?.is_admin" to="/admin" @click="profileOpen = false"
                  class="flex items-center gap-3 px-4 py-2.5 text-sm text-gold-700 hover:text-gold-700 hover:bg-gold-50 transition-colors">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                  </svg>
                  Admin Panel
                </RouterLink>

                <div class="border-t border-gray-100 mt-2 pt-2">
                  <button @click="handleLogout"
                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                  </button>
                </div>
              </div>
            </Transition>
          </div>

          <button @click="openChat()" class="btn-primary text-sm">
            {{ $t('nav.get_quote') }}
          </button>
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
          <template v-if="authStore.isAuthenticated">
            <RouterLink v-if="!authStore.user?.is_admin" to="/dashboard" @click="store.closeMobileMenu()"
              class="block px-4 py-3 text-sm font-medium text-gray-600 hover:text-navy-700 hover:bg-navy-50 rounded-lg transition-colors">
              Dashboard
            </RouterLink>
            <RouterLink to="/profile" @click="store.closeMobileMenu()"
              class="block px-4 py-3 text-sm font-medium text-gray-600 hover:text-navy-700 hover:bg-navy-50 rounded-lg transition-colors">
              Profile
            </RouterLink>
            <RouterLink v-if="authStore.user?.is_admin" to="/admin" @click="store.closeMobileMenu()"
              class="block px-4 py-3 text-sm font-medium text-gold-700 hover:text-gold-700 hover:bg-gold-50 rounded-lg transition-colors">
              Admin Panel
            </RouterLink>
            <button @click="handleLogout(); store.closeMobileMenu()"
              class="block w-full text-left px-4 py-3 text-sm font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors">
              Logout
            </button>
          </template>
          <template v-else>
            <RouterLink to="/auth" @click="store.closeMobileMenu()"
              class="block px-4 py-3 text-sm font-medium text-gray-600 hover:text-navy-700 hover:bg-navy-50 rounded-lg transition-colors">
              Sign In
            </RouterLink>
          </template>
          <div class="pt-2 pb-1">
            <button @click="openChat(); store.closeMobileMenu()" class="btn-primary w-full text-sm">
              {{ $t('nav.get_quote') }}
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAppStore } from '@/stores/app'
import { useAuthStore } from '@/stores/auth'
import { useChat } from '@/composables/useChat'
import AppLogo from './AppLogo.vue'

const { openChat } = useChat()

const store     = useAppStore()
const authStore = useAuthStore()
const route     = useRoute()
const router    = useRouter()
const scrollY   = ref(0)

const profileOpen = ref(false)
const profileRef  = ref(null)

const userInitials = computed(() => {
  const name = authStore.user?.name || ''
  return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase()
})

async function handleLogout() {
  profileOpen.value = false
  await authStore.logout()
  router.push('/')
}

function onClickOutside(e) {
  if (profileRef.value && !profileRef.value.contains(e.target)) {
    profileOpen.value = false
  }
}

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

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true })
  document.addEventListener('mousedown', onClickOutside)
})
onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
  document.removeEventListener('mousedown', onClickOutside)
})
watch(() => route.path, () => { store.closeMobileMenu(); profileOpen.value = false })
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

.dropdown-enter-active {
  transition: all 0.18s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.dropdown-leave-active {
  transition: all 0.12s ease-in;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-6px) scale(0.97);
}
</style>
