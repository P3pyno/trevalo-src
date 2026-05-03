<template>
  <div class="min-h-screen flex">

    <!-- ── Left panel ─────────────────────────────────────────── -->
    <div class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative bg-navy-700 flex-col overflow-hidden">

      <!-- Background layers -->
      <div class="absolute inset-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-navy-600 opacity-60"></div>
        <div class="absolute -bottom-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-navy-800 opacity-70"></div>
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-[0.04]"
          style="background-image: linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:40px 40px">
        </div>
      </div>

      <!-- Content -->
      <div class="relative flex flex-col h-full px-10 py-10">

        <!-- Logo -->
        <RouterLink to="/" class="inline-flex items-center gap-3 group w-fit">
          <svg class="w-9 h-9" viewBox="0 0 40 40" fill="none">
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

        <!-- Hero text -->
        <div class="mt-auto mb-auto pt-16">
          <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1.5 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-gold-400 animate-pulse"></span>
            <span class="text-white/80 text-xs font-medium tracking-wide">China-Based · Globally Trusted</span>
          </div>
          <h2 class="text-4xl xl:text-5xl font-extrabold text-white leading-[1.1]">
            Source Smarter.<br/>
            <span class="text-gold-400">Ship Faster.</span>
          </h2>
          <p class="mt-5 text-white/60 text-base leading-relaxed max-w-sm">
            Join hundreds of businesses using Trivalo Sourcing to connect with verified Chinese manufacturers.
          </p>

          <!-- Large decorative globe -->
          <div class="relative mt-12 flex items-center justify-center">
            <div class="relative w-64 h-64">
              <!-- Outer ring -->
              <div class="absolute inset-0 rounded-full border border-white/10 animate-[spin_30s_linear_infinite]"></div>
              <!-- Mid ring -->
              <div class="absolute inset-6 rounded-full border border-white/8"></div>
              <!-- Globe SVG -->
              <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-48 h-48 text-white/10" viewBox="0 0 200 200" fill="none">
                  <circle cx="100" cy="100" r="90" stroke="currentColor" stroke-width="1.5"/>
                  <ellipse cx="100" cy="100" rx="42" ry="90" stroke="currentColor" stroke-width="1"/>
                  <line x1="10" y1="100" x2="190" y2="100" stroke="currentColor" stroke-width="1"/>
                  <line x1="22" y1="62" x2="178" y2="62" stroke="currentColor" stroke-width="0.8"/>
                  <line x1="22" y1="138" x2="178" y2="138" stroke="currentColor" stroke-width="0.8"/>
                  <line x1="40" y1="30" x2="160" y2="30" stroke="currentColor" stroke-width="0.6"/>
                  <line x1="40" y1="170" x2="160" y2="170" stroke="currentColor" stroke-width="0.6"/>
                </svg>
              </div>
              <!-- Floating stat cards -->
              <div class="absolute -top-4 -right-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-2.5 text-center">
                <div class="text-gold-400 font-extrabold text-xl leading-none">500+</div>
                <div class="text-white/60 text-[10px] mt-0.5">Suppliers</div>
              </div>
              <div class="absolute -bottom-4 -left-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-2.5 text-center">
                <div class="text-gold-400 font-extrabold text-xl leading-none">30+</div>
                <div class="text-white/60 text-[10px] mt-0.5">Countries</div>
              </div>
              <div class="absolute top-1/2 -right-14 -translate-y-1/2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-2.5 text-center">
                <div class="text-gold-400 font-extrabold text-xl leading-none">98%</div>
                <div class="text-white/60 text-[10px] mt-0.5">Satisfaction</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Testimonial -->
        <div class="mt-auto bg-white/8 border border-white/12 rounded-2xl p-5">
          <p class="text-white/75 text-sm leading-relaxed italic">
            "Trivalo made sourcing from China effortless. We found a great supplier in days, not months."
          </p>
          <div class="flex items-center gap-3 mt-4">
            <div class="w-8 h-8 rounded-full bg-gold-400 flex items-center justify-center text-navy-700 font-bold text-sm">M</div>
            <div>
              <div class="text-white text-sm font-semibold">Marc Dupont</div>
              <div class="text-white/50 text-xs">CEO, Maison d'Export · France</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Right panel ─────────────────────────────────────────── -->
    <div class="flex-1 flex flex-col min-h-screen bg-white">

      <!-- Mobile logo -->
      <div class="lg:hidden flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <RouterLink to="/" class="inline-flex items-center gap-2.5">
          <svg class="w-8 h-8" viewBox="0 0 40 40" fill="none">
            <circle cx="20" cy="20" r="17" stroke="#C8A45D" stroke-width="2"/>
            <ellipse cx="20" cy="20" rx="8.5" ry="17" stroke="#C8A45D" stroke-width="1.5"/>
            <line x1="3" y1="20" x2="37" y2="20" stroke="#C8A45D" stroke-width="1.5"/>
          </svg>
          <div class="leading-none">
            <div class="text-navy-700 text-lg font-bold tracking-widest">TRIVALO</div>
            <div class="text-gold-400 text-[9px] font-semibold tracking-[0.25em]">SOURCING</div>
          </div>
        </RouterLink>
        <RouterLink to="/" class="text-sm text-gray-500 hover:text-navy-700 transition-colors">
          ← Back to site
        </RouterLink>
      </div>

      <!-- Form area -->
      <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">

          <!-- Back link (desktop) -->
          <RouterLink to="/" class="hidden lg:inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-navy-700 transition-colors mb-8 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to site
          </RouterLink>

          <!-- Tab switcher -->
          <div class="flex bg-gray-100 rounded-xl p-1 mb-8">
            <button
              @click="mode = 'signin'"
              class="flex-1 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200"
              :class="mode === 'signin'
                ? 'bg-white text-navy-700 shadow-sm'
                : 'text-gray-500 hover:text-gray-700'"
            >
              Sign In
            </button>
            <button
              @click="mode = 'signup'"
              class="flex-1 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200"
              :class="mode === 'signup'
                ? 'bg-white text-navy-700 shadow-sm'
                : 'text-gray-500 hover:text-gray-700'"
            >
              Create Account
            </button>
          </div>

          <!-- Heading -->
          <Transition name="slide-tab" mode="out-in">
            <div :key="mode">
              <h1 class="text-2xl font-extrabold text-navy-700">
                {{ mode === 'signin' ? 'Welcome back' : 'Create your account' }}
              </h1>
              <p class="text-gray-500 text-sm mt-1.5">
                {{ mode === 'signin'
                  ? 'Sign in to manage your sourcing projects.'
                  : 'Start sourcing from China in minutes.' }}
              </p>
            </div>
          </Transition>

          <!-- ── Sign In form ── -->
          <Transition name="slide-tab" mode="out-in">
            <form v-if="mode === 'signin'" key="signin" @submit.prevent="handleSignIn" class="mt-8 space-y-5">

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </span>
                  <input
                    v-model="signin.email"
                    type="email"
                    required
                    placeholder="you@company.com"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                  >
                </div>
              </div>

              <div>
                <div class="flex justify-between items-center mb-1.5">
                  <label class="text-sm font-medium text-gray-700">Password</label>
                  <a href="#" class="text-xs text-gold-500 hover:text-gold-600 font-medium transition-colors">Forgot password?</a>
                </div>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                  </span>
                  <input
                    v-model="signin.password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    placeholder="••••••••"
                    class="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                  >
                  <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                    <svg v-if="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                  </button>
                </div>
              </div>

              <div class="flex items-center gap-2.5">
                <input id="remember" v-model="signin.remember" type="checkbox"
                  class="w-4 h-4 rounded border-gray-300 text-navy-700 focus:ring-navy-500 cursor-pointer">
                <label for="remember" class="text-sm text-gray-600 cursor-pointer">Keep me signed in</label>
              </div>

              <!-- Error -->
              <div v-if="signinError" class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ signinError }}
              </div>

              <button
                type="submit"
                :disabled="signinLoading"
                class="w-full btn-primary justify-center py-3.5 text-sm"
                :class="{ 'opacity-60 cursor-not-allowed': signinLoading }"
              >
                <svg v-if="signinLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                {{ signinLoading ? 'Signing in…' : 'Sign In' }}
              </button>

              <p class="text-center text-sm text-gray-500">
                Don't have an account?
                <button type="button" @click="mode = 'signup'" class="text-navy-700 font-semibold hover:text-gold-500 transition-colors">
                  Create one
                </button>
              </p>
            </form>

            <!-- ── Sign Up form ── -->
            <form v-else key="signup" @submit.prevent="handleSignUp" class="mt-8 space-y-5">

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">First name</label>
                  <input
                    v-model="signup.firstName"
                    type="text"
                    required
                    placeholder="Jean"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">Last name</label>
                  <input
                    v-model="signup.lastName"
                    type="text"
                    required
                    placeholder="Dupont"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                  >
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Work email</label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </span>
                  <input
                    v-model="signup.email"
                    type="email"
                    required
                    placeholder="you@company.com"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                    :class="{ 'border-red-400 focus:ring-red-400': signupErrors.email }"
                  >
                </div>
                <p v-if="signupErrors.email" class="mt-1 text-xs text-red-500">{{ signupErrors.email }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company <span class="text-gray-400 font-normal">(optional)</span></label>
                <input
                  v-model="signup.company"
                  type="text"
                  placeholder="Your company name"
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                  </span>
                  <input
                    v-model="signup.password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    placeholder="Min 8 characters"
                    class="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-navy-500 focus:border-transparent transition"
                    :class="{ 'border-red-400 focus:ring-red-400': signupErrors.password }"
                  >
                  <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                    <svg v-if="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                  </button>
                </div>
                <!-- Password strength -->
                <div v-if="signup.password" class="mt-2 flex gap-1">
                  <div v-for="i in 4" :key="i"
                    class="h-1 flex-1 rounded-full transition-colors duration-300"
                    :class="passwordStrength >= i ? strengthColor : 'bg-gray-200'">
                  </div>
                </div>
                <p v-if="signup.password" class="mt-1 text-xs" :class="strengthTextColor">
                  {{ strengthLabel }}
                </p>
                <p v-if="signupErrors.password" class="mt-1 text-xs text-red-500">{{ signupErrors.password }}</p>
              </div>

              <div class="flex items-start gap-2.5">
                <input id="terms" v-model="signup.terms" type="checkbox" required
                  class="w-4 h-4 mt-0.5 rounded border-gray-300 text-navy-700 focus:ring-navy-500 cursor-pointer">
                <label for="terms" class="text-sm text-gray-600 cursor-pointer leading-relaxed">
                  I agree to the
                  <RouterLink to="/terms" class="text-navy-700 font-medium hover:text-gold-500 transition-colors">Terms of Service</RouterLink>
                  and
                  <RouterLink to="/privacy" class="text-navy-700 font-medium hover:text-gold-500 transition-colors">Privacy Policy</RouterLink>
                </label>
              </div>

              <!-- Error -->
              <div v-if="signupError" class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ signupError }}
              </div>

              <button
                type="submit"
                :disabled="signupLoading"
                class="w-full btn-primary justify-center py-3.5 text-sm"
                :class="{ 'opacity-60 cursor-not-allowed': signupLoading }"
              >
                <svg v-if="signupLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                {{ signupLoading ? 'Creating account…' : 'Create Account' }}
              </button>

              <p class="text-center text-sm text-gray-500">
                Already have an account?
                <button type="button" @click="mode = 'signin'" class="text-navy-700 font-semibold hover:text-gold-500 transition-colors">
                  Sign in
                </button>
              </p>
            </form>
          </Transition>

        </div>
      </div>

      <!-- Footer -->
      <div class="px-6 py-5 border-t border-gray-100 flex flex-wrap gap-4 justify-center">
        <span class="text-xs text-gray-400">© 2025 Trivalo Sourcing</span>
        <RouterLink to="/privacy" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Privacy</RouterLink>
        <RouterLink to="/terms" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Terms</RouterLink>
        <a href="mailto:info@trivalo-sourcing.com" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Support</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router    = useRouter()
const route     = useRoute()
const authStore = useAuthStore()

const mode = ref('signin')
const showPassword = ref(false)

// Sign In
const signin = reactive({ email: '', password: '', remember: false })
const signinLoading = ref(false)
const signinError = ref(null)

async function handleSignIn() {
  signinLoading.value = true
  signinError.value = null
  try {
    await authStore.login({ email: signin.email, password: signin.password })
    router.push(route.query.redirect || '/dashboard')
  } catch (err) {
    signinError.value = err?.response?.data?.message || 'Invalid email or password.'
  } finally {
    signinLoading.value = false
  }
}

// Sign Up
const signup = reactive({ firstName: '', lastName: '', email: '', company: '', password: '', terms: false })
const signupLoading = ref(false)
const signupError = ref(null)
const signupErrors = reactive({ email: '', password: '' })

async function handleSignUp() {
  signupLoading.value = true
  signupError.value = null
  Object.assign(signupErrors, { email: '', password: '' })

  try {
    await authStore.register({
      first_name: signup.firstName,
      last_name:  signup.lastName,
      email:      signup.email,
      company:    signup.company || undefined,
      password:   signup.password,
    })
    router.push(route.query.redirect || '/dashboard')
  } catch (err) {
    const errors = err?.response?.data?.errors
    if (errors?.email)    signupErrors.email    = errors.email[0]
    if (errors?.password) signupErrors.password = errors.password[0]
    if (!errors) signupError.value = err?.response?.data?.message || 'Registration failed.'
  } finally {
    signupLoading.value = false
  }
}

// Password strength
const passwordStrength = computed(() => {
  const p = signup.password
  if (!p) return 0
  let score = 0
  if (p.length >= 8) score++
  if (/[A-Z]/.test(p)) score++
  if (/[0-9]/.test(p)) score++
  if (/[^A-Za-z0-9]/.test(p)) score++
  return score
})

const strengthColor = computed(() => {
  return ['', 'bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'][passwordStrength.value]
})
const strengthTextColor = computed(() => {
  return ['', 'text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-600'][passwordStrength.value]
})
const strengthLabel = computed(() => {
  return ['', 'Weak', 'Fair', 'Good', 'Strong'][passwordStrength.value]
})
</script>

<style scoped>
.slide-tab-enter-active,
.slide-tab-leave-active {
  transition: all 0.18s ease;
}
.slide-tab-enter-from {
  opacity: 0;
  transform: translateY(6px);
}
.slide-tab-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}
</style>
