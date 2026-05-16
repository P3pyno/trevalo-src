<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-navy-50 to-navy-100 px-4">
    <div class="w-full max-w-md">
      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gold-50 mb-4">
            <svg v-if="!loading && verified" class="w-8 h-8 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <svg v-else-if="!loading && error" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <svg v-else class="w-8 h-8 text-navy-400 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
          </div>
          <h1 class="text-2xl font-bold text-navy-700">
            {{ loading ? 'Verifying Email...' : verified ? 'Email Verified!' : 'Verification Failed' }}
          </h1>
        </div>

        <!-- Content -->
        <div class="text-center mb-8">
          <p v-if="loading" class="text-gray-600">
            Please wait while we verify your email address...
          </p>
          <p v-else-if="verified" class="text-gray-600 mb-4">
            {{ message || 'Your email has been successfully verified! You can now log in to your account.' }}
          </p>
          <p v-else class="text-gray-600 mb-4">
            {{ message || 'The verification link is invalid or has expired.' }}
          </p>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
          <RouterLink v-if="verified" to="/auth?tab=signin" class="w-full btn-primary py-3.5 text-sm text-center">
            Go to Sign In
          </RouterLink>
          <template v-else>
            <RouterLink to="/auth?tab=signup" class="w-full btn-primary py-3.5 text-sm text-center">
              Back to Registration
            </RouterLink>
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">or</span>
              </div>
            </div>
            <button @click="showResendForm = !showResendForm" class="w-full btn-secondary py-3.5 text-sm">
              {{ showResendForm ? 'Cancel' : 'Resend Verification Email' }}
            </button>
          </template>
        </div>

        <!-- Resend Email Form -->
        <Transition name="slide">
          <form v-if="showResendForm && !verified" @submit.prevent="handleResend" class="mt-8 pt-8 border-t border-gray-200">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
            <input
              v-model="resendEmail"
              type="email"
              required
              placeholder="you@company.com"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
            >
            <div v-if="resendError" class="mt-3 bg-red-50 border border-red-200 rounded-lg px-4 py-2 text-xs text-red-600">
              {{ resendError }}
            </div>
            <div v-if="resendSuccess" class="mt-3 bg-green-50 border border-green-200 rounded-lg px-4 py-2 text-xs text-green-600">
              {{ resendSuccess }}
            </div>
            <button
              type="submit"
              :disabled="resendLoading"
              class="w-full mt-4 btn-primary py-3 text-sm"
              :class="{ 'opacity-60 cursor-not-allowed': resendLoading }"
            >
              {{ resendLoading ? 'Sending...' : 'Send Verification Email' }}
            </button>
          </form>
        </Transition>

        <!-- Help text -->
        <div class="mt-8 pt-8 border-t border-gray-200 text-center">
          <p class="text-xs text-gray-500 mb-3">Need help?</p>
          <a href="mailto:support@trivalo-sourcing.com" class="text-sm text-gold-600 hover:text-gold-700 font-medium transition-colors">
            Contact support
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

const loading = ref(true)
const verified = ref(false)
const error = ref(false)
const message = ref('')

const showResendForm = ref(false)
const resendEmail = ref('')
const resendLoading = ref(false)
const resendError = ref('')
const resendSuccess = ref('')

onMounted(async () => {
  try {
    const { id, hash } = route.params
    if (!id || !hash) {
      throw new Error('Invalid verification link')
    }

    const { data } = await axios.get(`/api/auth/verify-email/${id}/${hash}`)
    message.value = data.message
    verified.value = true
  } catch (err) {
    error.value = true
    message.value = err?.response?.data?.message || err.message || 'Verification failed'
  } finally {
    loading.value = false
  }
})

async function handleResend() {
  resendLoading.value = true
  resendError.value = ''
  resendSuccess.value = ''

  try {
    const { data } = await axios.post('/api/auth/resend-verification-email', {
      email: resendEmail.value,
    })
    resendSuccess.value = data.message
    resendEmail.value = ''
  } catch (err) {
    resendError.value = err?.response?.data?.message || 'Failed to send verification email'
  } finally {
    resendLoading.value = false
  }
}
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}
.slide-enter-from {
  opacity: 0;
  max-height: 0;
}
.slide-leave-to {
  opacity: 0;
  max-height: 0;
}
</style>
