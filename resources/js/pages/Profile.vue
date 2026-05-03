<template>
  <div class="min-h-screen bg-gray-50 pt-24 pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Page header -->
      <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-navy-700">My Profile</h1>
        <p class="text-gray-500 text-sm mt-1">Manage your personal information and account security.</p>
      </div>

      <div class="grid lg:grid-cols-3 gap-8">

        <!-- ── Left: profile card ── -->
        <div class="lg:col-span-1 space-y-5">

          <!-- Avatar card -->
          <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
            <div class="relative inline-block mb-4">
              <div class="w-24 h-24 rounded-full bg-navy-700 flex items-center justify-center mx-auto text-gold-400 font-extrabold text-3xl shadow-lg">
                {{ initials }}
              </div>
              <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-green-400 rounded-full border-2 border-white"></div>
            </div>
            <h2 class="text-xl font-bold text-navy-700">{{ authStore.user?.name }}</h2>
            <p class="text-gray-400 text-sm mt-1">{{ authStore.user?.email }}</p>
            <div v-if="authStore.user?.company" class="mt-2 inline-flex items-center gap-1.5 bg-navy-50 text-navy-600 text-xs font-medium px-3 py-1 rounded-full">
              <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
              {{ authStore.user.company }}
            </div>
            <div class="mt-6 pt-5 border-t border-gray-100 space-y-3 text-left">
              <div v-if="authStore.user?.phone" class="flex items-center gap-2.5 text-sm text-gray-500">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ authStore.user.phone }}
              </div>
              <div v-if="authStore.user?.country" class="flex items-center gap-2.5 text-sm text-gray-500">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ authStore.user.country }}
              </div>
              <div class="flex items-center gap-2.5 text-sm text-gray-500">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Member since {{ memberSince }}
              </div>
            </div>
          </div>

          <!-- Quick nav -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <button
              v-for="tab in tabs" :key="tab.id"
              @click="activeTab = tab.id"
              class="flex items-center gap-3 w-full px-5 py-3.5 text-sm font-medium transition-colors text-left border-b border-gray-50 last:border-0"
              :class="activeTab === tab.id
                ? 'bg-navy-50 text-navy-700 border-l-2 border-l-navy-700'
                : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700'"
            >
              <component :is="tab.icon" class="w-4 h-4 flex-shrink-0" />
              {{ tab.label }}
            </button>
          </div>
        </div>

        <!-- ── Right: content panels ── -->
        <div class="lg:col-span-2 space-y-6">

          <!-- Personal Information -->
          <div v-show="activeTab === 'info'" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-lg font-bold text-navy-700 mb-1">Personal Information</h3>
            <p class="text-gray-400 text-sm mb-7">Update your name, company and contact details.</p>

            <form @submit.prevent="saveProfile" class="space-y-5">
              <div class="grid sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">First name</label>
                  <input v-model="profileForm.firstName" type="text" required
                    class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Last name</label>
                  <input v-model="profileForm.lastName" type="text" required
                    class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm">
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                <input :value="authStore.user?.email" type="email" disabled
                  class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-400 text-sm cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">Email cannot be changed for security reasons.</p>
              </div>

              <div class="grid sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Company <span class="text-gray-400 font-normal">(optional)</span></label>
                  <input v-model="profileForm.company" type="text"
                    class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm"
                    placeholder="Your company name">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone / WhatsApp <span class="text-gray-400 font-normal">(optional)</span></label>
                  <input v-model="profileForm.phone" type="tel"
                    class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm"
                    placeholder="+1 234 567 890">
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Country <span class="text-gray-400 font-normal">(optional)</span></label>
                <select v-model="profileForm.country"
                  class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm">
                  <option value="">Select your country</option>
                  <option v-for="c in countries" :key="c" :value="c">{{ c }}</option>
                </select>
              </div>

              <!-- Feedback -->
              <div v-if="profileSuccess" class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Profile updated successfully.
              </div>
              <div v-if="profileError" class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">{{ profileError }}</div>

              <div class="flex justify-end pt-2">
                <button type="submit" :disabled="profileLoading" class="btn-primary text-sm px-8"
                  :class="{ 'opacity-60 cursor-not-allowed': profileLoading }">
                  <svg v-if="profileLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                  </svg>
                  {{ profileLoading ? 'Saving…' : 'Save Changes' }}
                </button>
              </div>
            </form>
          </div>

          <!-- Security -->
          <div v-show="activeTab === 'security'" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-lg font-bold text-navy-700 mb-1">Change Password</h3>
            <p class="text-gray-400 text-sm mb-7">Use a strong password with at least 8 characters.</p>

            <form @submit.prevent="savePassword" class="space-y-5">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Current password</label>
                <input v-model="pwForm.current" type="password" required
                  class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm"
                  placeholder="••••••••">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">New password</label>
                <input v-model="pwForm.password" type="password" required
                  class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm"
                  placeholder="Min 8 characters">
                <!-- Strength bar -->
                <div v-if="pwForm.password" class="mt-2 flex gap-1">
                  <div v-for="i in 4" :key="i" class="h-1 flex-1 rounded-full transition-colors duration-300"
                    :class="pwStrength >= i ? pwStrengthColor : 'bg-gray-200'"></div>
                </div>
                <p v-if="pwForm.password" class="text-xs mt-1" :class="pwStrengthTextColor">{{ pwStrengthLabel }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm new password</label>
                <input v-model="pwForm.confirmation" type="password" required
                  class="w-full rounded-xl border-gray-200 focus:border-navy-500 focus:ring-navy-500 text-sm"
                  :class="{ 'border-red-400': pwForm.confirmation && pwForm.password !== pwForm.confirmation }"
                  placeholder="••••••••">
                <p v-if="pwForm.confirmation && pwForm.password !== pwForm.confirmation"
                  class="text-xs text-red-500 mt-1">Passwords do not match.</p>
              </div>

              <div v-if="pwSuccess" class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Password changed successfully.
              </div>
              <div v-if="pwError" class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">{{ pwError }}</div>

              <div class="flex justify-end pt-2">
                <button type="submit"
                  :disabled="pwLoading || (pwForm.confirmation && pwForm.password !== pwForm.confirmation)"
                  class="btn-primary text-sm px-8"
                  :class="{ 'opacity-60 cursor-not-allowed': pwLoading }">
                  <svg v-if="pwLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                  </svg>
                  {{ pwLoading ? 'Updating…' : 'Update Password' }}
                </button>
              </div>
            </form>
          </div>

          <!-- Danger Zone -->
          <div v-show="activeTab === 'danger'" class="bg-white rounded-2xl shadow-sm border border-red-100 p-8">
            <h3 class="text-lg font-bold text-red-600 mb-1">Danger Zone</h3>
            <p class="text-gray-400 text-sm mb-7">Permanent actions that cannot be undone.</p>

            <div class="border border-red-100 rounded-xl p-6">
              <div class="flex items-start justify-between gap-6">
                <div>
                  <h4 class="font-semibold text-gray-800">Delete Account</h4>
                  <p class="text-gray-400 text-sm mt-1">Permanently delete your account and all associated data. This action cannot be reversed.</p>
                </div>
                <button @click="deleteConfirm = true"
                  class="flex-shrink-0 px-5 py-2 text-sm font-semibold text-red-600 border border-red-200 rounded-xl hover:bg-red-50 transition-colors">
                  Delete Account
                </button>
              </div>
            </div>

            <!-- Delete confirmation modal -->
            <Transition name="fade">
              <div v-if="deleteConfirm"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
                @click.self="deleteConfirm = false">
                <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
                  <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                  </div>
                  <h3 class="text-xl font-bold text-center text-gray-900">Delete your account?</h3>
                  <p class="text-gray-500 text-sm text-center mt-2 mb-6">This will permanently delete your account and all data. Enter your password to confirm.</p>
                  <input v-model="deletePassword" type="password"
                    class="w-full rounded-xl border-gray-200 focus:border-red-400 focus:ring-red-400 text-sm mb-4"
                    placeholder="Enter your password">
                  <div v-if="deleteError" class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3 mb-4">{{ deleteError }}</div>
                  <div class="flex gap-3">
                    <button @click="deleteConfirm = false"
                      class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                      Cancel
                    </button>
                    <button @click="handleDeleteAccount" :disabled="deleteLoading"
                      class="flex-1 py-2.5 text-sm font-semibold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors"
                      :class="{ 'opacity-60 cursor-not-allowed': deleteLoading }">
                      {{ deleteLoading ? 'Deleting…' : 'Yes, Delete' }}
                    </button>
                  </div>
                </div>
              </div>
            </Transition>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, defineComponent, h } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
const router    = useRouter()

// Redirect if not authenticated
if (!authStore.isAuthenticated) router.push('/auth')

const activeTab = ref('info')

// Icons
const IconUser    = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' })]) })
const IconLock    = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z' })]) })
const IconWarning = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' })]) })

const tabs = [
  { id: 'info',     label: 'Personal Information', icon: IconUser },
  { id: 'security', label: 'Security',              icon: IconLock },
  { id: 'danger',   label: 'Danger Zone',           icon: IconWarning },
]

// ── Computed ──────────────────────────────────────
const initials = computed(() => {
  const name = authStore.user?.name || ''
  return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase()
})

const memberSince = computed(() => {
  const d = authStore.user?.created_at
  if (!d) return '—'
  return new Date(d).toLocaleDateString('en-US', { year: 'numeric', month: 'long' })
})

// ── Profile form ──────────────────────────────────
const nameParts = computed(() => {
  const parts = (authStore.user?.name || '').split(' ')
  return { first: parts[0] || '', last: parts.slice(1).join(' ') || '' }
})

const profileForm = reactive({
  firstName: '',
  lastName:  '',
  company:   '',
  phone:     '',
  country:   '',
})

onMounted(async () => {
  await authStore.fetchProfile()
  profileForm.firstName = nameParts.value.first
  profileForm.lastName  = nameParts.value.last
  profileForm.company   = authStore.user?.company || ''
  profileForm.phone     = authStore.user?.phone   || ''
  profileForm.country   = authStore.user?.country || ''
})

const profileLoading = ref(false)
const profileSuccess = ref(false)
const profileError   = ref(null)

async function saveProfile() {
  profileLoading.value = true
  profileSuccess.value = false
  profileError.value   = null
  try {
    await authStore.updateProfile({
      first_name: profileForm.firstName,
      last_name:  profileForm.lastName,
      company:    profileForm.company || null,
      phone:      profileForm.phone   || null,
      country:    profileForm.country || null,
    })
    profileSuccess.value = true
    setTimeout(() => { profileSuccess.value = false }, 4000)
  } catch (err) {
    profileError.value = err?.response?.data?.message || 'Failed to update profile.'
  } finally {
    profileLoading.value = false
  }
}

// ── Password form ─────────────────────────────────
const pwForm = reactive({ current: '', password: '', confirmation: '' })
const pwLoading = ref(false)
const pwSuccess = ref(false)
const pwError   = ref(null)

const pwStrength = computed(() => {
  const p = pwForm.password
  if (!p) return 0
  let s = 0
  if (p.length >= 8)          s++
  if (/[A-Z]/.test(p))        s++
  if (/[0-9]/.test(p))        s++
  if (/[^A-Za-z0-9]/.test(p)) s++
  return s
})
const pwStrengthColor     = computed(() => ['', 'bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'][pwStrength.value])
const pwStrengthTextColor = computed(() => ['', 'text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-600'][pwStrength.value])
const pwStrengthLabel     = computed(() => ['', 'Weak', 'Fair', 'Good', 'Strong'][pwStrength.value])

async function savePassword() {
  if (pwForm.password !== pwForm.confirmation) return
  pwLoading.value = true
  pwSuccess.value = false
  pwError.value   = null
  try {
    await authStore.changePassword({
      current_password:      pwForm.current,
      password:              pwForm.password,
      password_confirmation: pwForm.confirmation,
    })
    pwSuccess.value = true
    Object.assign(pwForm, { current: '', password: '', confirmation: '' })
    setTimeout(() => { pwSuccess.value = false }, 4000)
  } catch (err) {
    pwError.value = err?.response?.data?.message || 'Failed to change password.'
  } finally {
    pwLoading.value = false
  }
}

// ── Delete account ────────────────────────────────
const deleteConfirm  = ref(false)
const deletePassword = ref('')
const deleteLoading  = ref(false)
const deleteError    = ref(null)

async function handleDeleteAccount() {
  deleteLoading.value = true
  deleteError.value   = null
  try {
    await authStore.deleteAccount({ password: deletePassword.value })
    router.push('/')
  } catch (err) {
    deleteError.value = err?.response?.data?.message || 'Failed to delete account.'
  } finally {
    deleteLoading.value = false
  }
}

// ── Countries list ────────────────────────────────
const countries = [
  'Algeria', 'Australia', 'Austria', 'Belgium', 'Brazil', 'Canada', 'China', 'Denmark',
  'Egypt', 'Finland', 'France', 'Germany', 'Ghana', 'Greece', 'India', 'Indonesia',
  'Ireland', 'Italy', 'Japan', 'Jordan', 'Kenya', 'Kuwait', 'Lebanon', 'Malaysia',
  'Mexico', 'Morocco', 'Netherlands', 'New Zealand', 'Nigeria', 'Norway', 'Oman',
  'Pakistan', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Saudi Arabia',
  'Senegal', 'Singapore', 'South Africa', 'South Korea', 'Spain', 'Sweden', 'Switzerland',
  'Thailand', 'Tunisia', 'Turkey', 'Ukraine', 'United Arab Emirates', 'United Kingdom',
  'United States', 'Vietnam',
]
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
