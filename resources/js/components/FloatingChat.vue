<template>
  <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">

    <!-- Chat panel -->
    <Transition name="chat-pop">
      <div v-if="open" class="mb-4 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col animate-slideInUp" style="max-height: 520px;">

        <!-- Header -->
        <div class="bg-navy-700 px-5 py-4 flex items-center justify-between flex-shrink-0">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gold-400/20 border border-gold-400/40 flex items-center justify-center">
              <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
              </svg>
            </div>
            <div>
              <div class="text-white font-semibold text-sm">Trivalo AI Assistant</div>
              <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                <span class="text-white/50 text-xs">Launching soon</span>
              </div>
            </div>
          </div>
          <button @click="toggleChat()" class="text-white/50 hover:text-white transition-colors p-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <!-- Coming soon banner -->
        <div class="bg-gold-50 border-b border-gold-100 px-5 py-2.5 flex items-center gap-2 flex-shrink-0 animate-slideInDown">
          <svg class="w-3.5 h-3.5 text-gold-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-gold-700 text-xs font-medium">AI quoting is coming soon — contact us directly for now</span>
        </div>

        <!-- Chat messages (mockup) -->
        <div class="flex-1 overflow-y-auto p-5 space-y-4 opacity-50 pointer-events-none select-none">
          <div class="flex gap-2.5">
            <div class="w-7 h-7 rounded-full bg-navy-700 flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-3.5 h-3.5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
              </svg>
            </div>
            <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-[85%]">
              <p class="text-gray-700 text-sm">Hi! I'm Trivalo's sourcing assistant. What product are you looking to source from China?</p>
            </div>
          </div>

          <div class="flex gap-2.5 justify-end">
            <div class="bg-navy-700 rounded-2xl rounded-tr-none px-4 py-3 max-w-[85%]">
              <p class="text-white text-sm">500 units of custom bluetooth earbuds with my logo...</p>
            </div>
          </div>

          <div class="flex gap-2.5">
            <div class="w-7 h-7 rounded-full bg-navy-700 flex items-center justify-center flex-shrink-0 mt-0.5">
              <svg class="w-3.5 h-3.5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
              </svg>
            </div>
            <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-[85%]">
              <p class="text-gray-700 text-sm">Great! What's your target unit price and destination country?</p>
            </div>
          </div>
        </div>

        <!-- Quick actions -->
        <div class="border-t border-gray-100 p-4 space-y-2 flex-shrink-0 bg-gray-50">
          <p class="text-gray-500 text-xs text-center mb-3">Reach us directly instead</p>
          <RouterLink
            to="/contact"
            @click="open = false"
            class="flex items-center gap-2 w-full text-sm font-medium text-navy-700 bg-white border border-gray-200 rounded-xl px-4 py-2.5 hover:border-navy-300 hover:shadow-md hover:shadow-navy-100 transition-all duration-200 active:scale-95"
          >
            <svg class="w-4 h-4 text-navy-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Send us a message
          </RouterLink>
          <a
            href="https://wa.me/8615019253764"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center gap-2 w-full text-sm font-medium text-white bg-[#25D366] rounded-xl px-4 py-2.5 hover:bg-[#1ebe5d] hover:shadow-md hover:shadow-green-300 transition-all duration-200 active:scale-95"
          >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Chat on WhatsApp
          </a>
        </div>
      </div>
    </Transition>

    <!-- Trigger button -->
    <button
      class="w-14 h-14 rounded-full bg-navy-700 shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-200 flex items-center justify-center group active:scale-95"
      :class="open ? 'bg-navy-800' : 'hover:bg-navy-600'"
      aria-label="Get a quote"
      @click="toggleChat()"
    >
      <Transition name="icon-swap" mode="out-in">
        <svg v-if="!open" key="chat" class="w-6 h-6 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <svg v-else key="close" class="w-6 h-6 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </Transition>
    </button>
  </div>
</template>

<script setup>
import { useChat } from '@/composables/useChat'

const { open, toggleChat } = useChat()
</script>

<style scoped>
.chat-pop-enter-active {
  transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.chat-pop-leave-active {
  transition: all 0.18s ease-in;
}
.chat-pop-enter-from,
.chat-pop-leave-to {
  opacity: 0;
  transform: translateY(12px) scale(0.95);
  transform-origin: bottom right;
}

.icon-swap-enter-active,
.icon-swap-leave-active {
  transition: all 0.15s ease;
}
.icon-swap-enter-from,
.icon-swap-leave-to {
  opacity: 0;
  transform: scale(0.7) rotate(15deg);
}

@keyframes slideInUp {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideInDown {
  from {
    opacity: 0;
    transform: translateY(-6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-slideInUp {
  animation: slideInUp 0.3s ease-out;
}

.animate-slideInDown {
  animation: slideInDown 0.3s ease-out 0.05s both;
}
</style>
