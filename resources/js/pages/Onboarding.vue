<template>
  <div class="min-h-screen flex bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 overflow-hidden">

    <!-- Background decoration -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
      <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-gold-400/5 blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-navy-500/30 blur-3xl"></div>
      <div class="absolute inset-0 opacity-[0.03]"
        style="background-image: linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:48px 48px">
      </div>
    </div>

    <!-- Left branding panel (hidden on mobile) -->
    <div class="hidden lg:flex lg:w-[42%] relative flex-col justify-between px-12 py-12">
      <!-- Logo -->
      <RouterLink to="/" class="inline-flex items-center gap-3 group w-fit">
        <svg class="w-10 h-10" viewBox="0 0 40 40" fill="none">
          <circle cx="20" cy="20" r="17" stroke="#C8A45D" stroke-width="2"/>
          <ellipse cx="20" cy="20" rx="8.5" ry="17" stroke="#C8A45D" stroke-width="1.5"/>
          <line x1="3" y1="20" x2="37" y2="20" stroke="#C8A45D" stroke-width="1.5"/>
          <line x1="6" y1="12.5" x2="34" y2="12.5" stroke="#C8A45D" stroke-width="1"/>
          <line x1="6" y1="27.5" x2="34" y2="27.5" stroke="#C8A45D" stroke-width="1"/>
        </svg>
        <div class="leading-none">
          <div class="text-white text-xl font-bold tracking-widest">TRIVALO</div>
          <div class="text-gold-400 text-[10px] font-semibold tracking-[0.25em] mt-0.5">SOURCING</div>
        </div>
      </RouterLink>

      <!-- Center content -->
      <div class="flex-1 flex flex-col justify-center -mt-12">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1.5 mb-8 w-fit">
          <span class="w-1.5 h-1.5 rounded-full bg-gold-400 animate-pulse"></span>
          <span class="text-white/80 text-xs font-medium tracking-wide">You're almost there</span>
        </div>

        <h2 class="text-4xl xl:text-5xl font-extrabold text-white leading-[1.15] mb-6">
          Welcome to<br/>
          <span class="text-gold-400">Trivalo Sourcing.</span>
        </h2>
        <p class="text-white/60 text-base leading-relaxed max-w-sm mb-10">
          Tell us a little about yourself so we can tailor your sourcing experience and connect you with the right suppliers faster.
        </p>

        <!-- Steps preview -->
        <div class="space-y-4">
          <div v-for="(s, i) in steps" :key="i"
            class="flex items-center gap-4 transition-all duration-300"
            :class="step === i + 1 ? 'opacity-100' : step > i + 1 ? 'opacity-50' : 'opacity-30'">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all duration-300"
              :class="step > i + 1 ? 'bg-green-400 text-white' : step === i + 1 ? 'bg-gold-400 text-navy-800' : 'bg-white/10 text-white/50'">
              <svg v-if="step > i + 1" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
              </svg>
              <span v-else>{{ i + 1 }}</span>
            </div>
            <div>
              <div class="text-white text-sm font-semibold">{{ s.title }}</div>
              <div class="text-white/70 text-xs">{{ s.desc }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <p class="text-white/55 text-xs">© 2025 Trivalo Sourcing. All rights reserved.</p>
    </div>

    <!-- Right form panel -->
    <div class="flex-1 flex items-center justify-center px-6 py-10 relative">

      <!-- Mobile logo -->
      <div class="absolute top-6 left-6 lg:hidden flex items-center gap-2">
        <svg class="w-7 h-7" viewBox="0 0 40 40" fill="none">
          <circle cx="20" cy="20" r="17" stroke="#C8A45D" stroke-width="2"/>
          <ellipse cx="20" cy="20" rx="8.5" ry="17" stroke="#C8A45D" stroke-width="1.5"/>
          <line x1="3" y1="20" x2="37" y2="20" stroke="#C8A45D" stroke-width="1.5"/>
        </svg>
        <span class="text-white text-sm font-bold tracking-widest">TRIVALO</span>
      </div>

      <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

          <!-- Progress bar -->
          <div class="h-1 bg-gray-100">
            <div class="h-full bg-gold-400 transition-all duration-500 ease-out rounded-full"
              :style="{ width: `${(step / steps.length) * 100}%` }"></div>
          </div>

          <div class="px-8 pt-8 pb-8">

            <!-- Step indicator -->
            <div class="flex items-center justify-between mb-6">
              <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Step {{ step }} of {{ steps.length }}</span>
              <button v-if="step < steps.length" @click="skip"
                class="text-xs text-gray-500 hover:text-gray-600 transition-colors">
                Skip for now →
              </button>
            </div>

            <!-- ── Step 1: Profile ── -->
            <Transition name="slide-fade" mode="out-in">
              <div v-if="step === 1" key="step1">
                <div class="mb-6">
                  <div class="w-12 h-12 rounded-2xl bg-navy-50 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-navy-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                  </div>
                  <h1 class="text-2xl font-extrabold text-navy-800 mb-1">
                    Welcome, {{ firstName }}!
                  </h1>
                  <p class="text-gray-500 text-sm">Tell us about your business.</p>
                </div>

                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Company / Business Name</label>
                    <input v-model="form.company" type="text"
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                      placeholder="Acme Corp">
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Country</label>
                    <select v-model="form.country"
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition bg-white">
                      <option value="">Select your country…</option>
                      <option v-for="c in countries" :key="c" :value="c">{{ c }}</option>
                    </select>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number <span class="text-gray-500 font-normal">(optional)</span></label>
                    <input v-model="form.phone" type="tel"
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                      placeholder="+1 555 000 0000">
                  </div>
                </div>

                <button @click="nextStep"
                  class="mt-6 w-full py-3.5 bg-navy-700 hover:bg-navy-800 text-white font-semibold text-sm rounded-xl transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2">
                  Continue
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                  </svg>
                </button>
              </div>
            </Transition>

            <!-- ── Step 2: Sourcing interest ── -->
            <Transition name="slide-fade" mode="out-in">
              <div v-if="step === 2" key="step2">
                <div class="mb-6">
                  <div class="w-12 h-12 rounded-2xl bg-gold-50 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                  </div>
                  <h1 class="text-2xl font-extrabold text-navy-800 mb-1">What are you sourcing?</h1>
                  <p class="text-gray-500 text-sm">Help us match you with the right suppliers.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                  <button v-for="cat in categories" :key="cat.value"
                    @click="toggleCategory(cat.value)"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 text-left transition-all duration-150"
                    :class="selectedCategories.includes(cat.value)
                      ? 'border-navy-700 bg-navy-50 text-navy-800'
                      : 'border-gray-200 bg-white text-gray-600 hover:border-gray-300'">
                    <span class="text-lg">{{ cat.icon }}</span>
                    <span class="text-xs font-semibold">{{ cat.label }}</span>
                  </button>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">How did you find us? <span class="text-gray-500 font-normal">(optional)</span></label>
                  <select v-model="form.source"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition bg-white">
                    <option value="">Select an option…</option>
                    <option value="google">Google / Search</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="referral">Referral / Word of mouth</option>
                    <option value="social">Social media</option>
                    <option value="other">Other</option>
                  </select>
                </div>

                <div class="flex gap-3 mt-6">
                  <button @click="step = 1"
                    class="flex-1 py-3.5 border border-gray-200 text-gray-600 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors">
                    Back
                  </button>
                  <button @click="submit" :disabled="submitting"
                    class="flex-1 py-3.5 bg-gold-500 hover:bg-gold-600 text-navy-900 font-bold text-sm rounded-xl transition-all duration-200 active:scale-[0.98] flex items-center justify-center gap-2 disabled:opacity-60">
                    <svg v-if="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    {{ submitting ? 'Setting up…' : 'Start Sourcing' }}
                    <svg v-if="!submitting" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                  </button>
                </div>
              </div>
            </Transition>

          </div>
        </div>

        <!-- Trust badges -->
        <div class="flex items-center justify-center gap-6 mt-6 text-white/70 text-xs">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Secure & private
          </span>
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Verified suppliers
          </span>
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Fast turnaround
          </span>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

const router    = useRouter()
const authStore = useAuthStore()

const step      = ref(1)
const submitting = ref(false)

const steps = [
  { title: 'Your Profile',     desc: 'Company & contact details' },
  { title: 'Sourcing Focus',   desc: 'What you need from China' },
]

const form = ref({
  company: authStore.user?.company || '',
  country: authStore.user?.country || '',
  phone:   authStore.user?.phone   || '',
  source:  '',
})

const selectedCategories = ref([])

const firstName = computed(() => {
  const name = authStore.user?.name || ''
  return name.split(' ')[0] || 'there'
})

const categories = [
  { value: 'electronics',  label: 'Electronics',   icon: '⚡' },
  { value: 'apparel',      label: 'Apparel',        icon: '👕' },
  { value: 'furniture',    label: 'Furniture',      icon: '🪑' },
  { value: 'cosmetics',    label: 'Cosmetics',      icon: '💄' },
  { value: 'machinery',    label: 'Machinery',      icon: '⚙️' },
  { value: 'packaging',    label: 'Packaging',      icon: '📦' },
  { value: 'food',         label: 'Food & Bev',     icon: '🍵' },
  { value: 'other',        label: 'Other',          icon: '🔍' },
]

const countries = [
  'United States', 'United Kingdom', 'Canada', 'Australia', 'Germany', 'France',
  'Spain', 'Italy', 'Netherlands', 'Belgium', 'Sweden', 'Norway', 'Denmark',
  'Switzerland', 'Austria', 'Poland', 'Portugal', 'Greece', 'Czech Republic',
  'Japan', 'South Korea', 'Singapore', 'Malaysia', 'Thailand', 'Vietnam',
  'India', 'UAE', 'Saudi Arabia', 'Turkey', 'Brazil', 'Mexico', 'Argentina',
  'South Africa', 'Nigeria', 'Egypt', 'New Zealand', 'Other',
]

function toggleCategory(val) {
  const idx = selectedCategories.value.indexOf(val)
  if (idx === -1) selectedCategories.value.push(val)
  else selectedCategories.value.splice(idx, 1)
}

function nextStep() {
  step.value = 2
}

function skip() {
  step.value < steps.length ? step.value++ : submit()
}

async function submit() {
  submitting.value = true
  try {
    const payload = {
      company: form.value.company || undefined,
      country: form.value.country || undefined,
      phone:   form.value.phone   || undefined,
    }
    const { data } = await axios.post('/onboarding', payload)
    authStore.setSession(data.user, authStore.token)
    router.push('/dashboard')
  } catch {
    // If onboarding call fails, still go to dashboard
    router.push('/dashboard')
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.25s ease;
}
.slide-fade-enter-from {
  opacity: 0;
  transform: translateX(20px);
}
.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>
