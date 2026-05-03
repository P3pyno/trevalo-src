<template>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-navy-600 opacity-50"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-6">
        <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
        <span class="text-gold-400 text-sm font-medium">AI-Powered Quoting</span>
      </div>
      <h1 class="text-5xl font-extrabold text-white leading-tight">Get a Quote</h1>
      <p class="mt-4 text-white/70 text-xl max-w-xl mx-auto">Describe your product and our AI assistant will guide you through the sourcing process.</p>
    </div>
  </section>

  <!-- Chat placeholder -->
  <section class="bg-gray-50 py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Coming soon badge -->
      <div class="flex justify-center mb-8">
        <div class="inline-flex items-center gap-2 bg-gold-50 border border-gold-200 text-gold-600 text-sm font-semibold px-5 py-2 rounded-full">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          AI Chat — Coming Soon
        </div>
      </div>

      <!-- Chat window mockup -->
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Chat header -->
        <div class="bg-navy-700 px-6 py-4 flex items-center gap-3">
          <div class="w-9 h-9 rounded-full bg-gold-400/20 border border-gold-400/40 flex items-center justify-center">
            <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
          </div>
          <div>
            <div class="text-white font-semibold text-sm">Trivalo AI Assistant</div>
            <div class="flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
              <span class="text-white/50 text-xs">Offline — launching soon</span>
            </div>
          </div>
        </div>

        <!-- Chat messages preview -->
        <div class="p-6 space-y-4 opacity-50 select-none pointer-events-none">
          <div class="flex gap-3">
            <div class="w-8 h-8 rounded-full bg-navy-700 flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
              </svg>
            </div>
            <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-xs">
              <p class="text-gray-700 text-sm">Hi! I'm Trivalo's sourcing assistant. What product are you looking to source from China?</p>
            </div>
          </div>

          <div class="flex gap-3 justify-end">
            <div class="bg-navy-700 rounded-2xl rounded-tr-none px-4 py-3 max-w-xs">
              <p class="text-white text-sm">I'm looking for 500 units of custom bluetooth earbuds with my logo...</p>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="w-8 h-8 rounded-full bg-navy-700 flex items-center justify-center flex-shrink-0">
              <svg class="w-4 h-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
              </svg>
            </div>
            <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-xs">
              <p class="text-gray-700 text-sm">Great! I have a few questions to refine your requirements. What's your target unit price and destination country?</p>
            </div>
          </div>
        </div>

        <!-- Input bar (disabled) -->
        <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-3 bg-gray-50 opacity-50 pointer-events-none">
          <input
            type="text"
            placeholder="Type your message..."
            disabled
            class="flex-1 rounded-xl border-gray-200 bg-white text-sm text-gray-400 cursor-not-allowed"
          >
          <button disabled class="btn-primary text-sm opacity-60 cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- In the meantime -->
      <div class="mt-10 text-center">
        <p class="text-gray-500 text-sm mb-6">In the meantime, reach us directly — we respond within 24 hours.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <RouterLink to="/contact" class="btn-primary text-sm px-8 py-3">
            Send Us a Message
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </RouterLink>
          <a
            href="https://wa.me/8615019253764"
            target="_blank"
            rel="noopener noreferrer"
            class="btn-outline text-sm px-8 py-3"
          >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp Us
          </a>
        </div>
      </div>
    </div>
  </section>
</template>
