<template>
  <footer class="bg-navy-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        <!-- Brand -->
        <div class="lg:col-span-2">
          <AppLogo text-class="text-white" />
          <p class="mt-4 text-gray-400 text-sm leading-relaxed max-w-sm">
            {{ $t('footer.tagline') }}
          </p>
          <div class="flex flex-wrap gap-4 mt-6">
            <a
              href="mailto:info@trivalo-sourcing.com"
              class="flex items-center gap-2 text-sm text-gray-400 hover:text-gold-400 transition-colors"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              info@trivalo-sourcing.com
            </a>
            <a
              :href="`https://wa.me/${whatsappNumber}`"
              target="_blank"
              rel="noopener noreferrer"
              class="flex items-center gap-2 text-sm text-gray-400 hover:text-gold-400 transition-colors"
            >
              <!-- WhatsApp -->
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              WhatsApp
            </a>
            <button
              @click="wechatVisible = true"
              class="flex items-center gap-2 text-sm text-gray-400 hover:text-gold-400 transition-colors"
            >
              <!-- WeChat -->
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.59.59 0 01.213.664l-.39 1.482c-.019.07-.048.14-.048.213 0 .163.13.295.29.295a.326.326 0 00.167-.054l1.903-1.113a.864.864 0 01.717-.099 10.16 10.16 0 002.837.403c.276 0 .543-.027.811-.05-.857-2.578.157-4.972 1.932-6.446 1.703-1.415 3.882-1.98 5.853-1.838-.576-3.583-4.196-6.348-8.596-6.348zM5.785 5.99c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178A1.17 1.17 0 014.623 7.17c0-.651.52-1.18 1.162-1.18zm5.813 0c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178 1.17 1.17 0 01-1.162-1.178c0-.651.52-1.18 1.162-1.18zm5.34 2.867c-1.797-.052-3.746.512-5.28 1.786-1.72 1.428-2.687 3.72-1.78 6.22.942 2.453 3.666 4.229 6.884 4.229.826 0 1.622-.12 2.361-.336a.722.722 0 01.598.082l1.584.927a.272.272 0 00.14.047c.134 0 .24-.112.24-.248 0-.06-.023-.12-.038-.177l-.327-1.233a.49.49 0 01.178-.554C23.024 18.48 24 16.82 24 14.98c0-3.21-2.931-5.837-7.062-6.122zm-3.601 2.673c.568 0 1.03.47 1.03 1.047s-.462 1.047-1.03 1.047c-.568 0-1.03-.47-1.03-1.047s.462-1.047 1.03-1.047zm5.337 0c.568 0 1.03.47 1.03 1.047s-.462 1.047-1.03 1.047c-.568 0-1.03-.47-1.03-1.047s.462-1.047 1.03-1.047z"/>
              </svg>
              WeChat
            </button>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-gold-400 font-semibold text-xs tracking-[0.15em] uppercase mb-5">Quick Links</h4>
          <ul class="space-y-3">
            <li v-for="link in navLinks" :key="link.path">
              <RouterLink :to="link.path" class="text-gray-400 hover:text-white text-sm transition-colors">
                {{ $t(link.key) }}
              </RouterLink>
            </li>
          </ul>
        </div>

        <!-- Services -->
        <div>
          <h4 class="text-gold-400 font-semibold text-xs tracking-[0.15em] uppercase mb-5">Services</h4>
          <ul class="space-y-3 text-sm text-gray-400">
            <li>Product Sourcing</li>
            <li>Supplier Verification</li>
            <li>Quality Control</li>
            <li>Shipping & Logistics</li>
            <li>Private Label / OEM</li>
          </ul>
        </div>
      </div>

      <div class="border-t border-white/10 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center gap-3">
        <p class="text-gray-500 text-sm">{{ $t('footer.copyright') }}</p>
        <p class="text-gray-500 text-xs">Based in China · Serving the World</p>
      </div>
    </div>

    <!-- WeChat modal -->
    <Transition name="fade">
      <div
        v-if="wechatVisible"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
        @click.self="wechatVisible = false"
      >
        <div class="bg-white rounded-2xl p-8 max-w-xs w-full text-center shadow-2xl">
          <h3 class="text-navy-700 font-bold text-lg mb-2">Add Us on WeChat</h3>
          <p class="text-gray-500 text-sm mb-6">Scan the QR code with WeChat to connect with us.</p>
          <!-- QR code placeholder -->
          <div class="w-48 h-48 mx-auto bg-gray-100 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
            <div class="text-center text-gray-400">
              <svg class="w-10 h-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75V16.5zM16.5 6.75h.75v.75h-.75v-.75z"/>
              </svg>
              <span class="text-xs">QR Code Here</span>
            </div>
          </div>
          <p class="text-gray-400 text-xs mt-4">WeChat ID: <span class="font-medium text-gray-600">trivalo_sourcing</span></p>
          <button @click="wechatVisible = false" class="mt-6 btn-primary w-full justify-center text-sm">
            Close
          </button>
        </div>
      </div>
    </Transition>
  </footer>
</template>

<script setup>
import { ref } from 'vue'
import AppLogo from './AppLogo.vue'

const wechatVisible = ref(false)
const whatsappNumber = '8612345678900'  // placeholder — replace with real number

const navLinks = [
  { key: 'nav.home',         path: '/' },
  { key: 'nav.about',        path: '/about' },
  { key: 'nav.services',     path: '/services' },
  { key: 'nav.how_it_works', path: '/how-it-works' },
  { key: 'nav.contact',      path: '/contact' },
]
</script>
