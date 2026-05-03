<template>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-navy-600 opacity-50"></div>
      <div class="absolute -bottom-10 -left-10 w-64 h-64 rounded-full bg-navy-800 opacity-40"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-6">
        <span class="text-gold-400 text-sm font-medium">Who We Are</span>
      </div>
      <h1 class="text-5xl font-extrabold text-white leading-tight">{{ $t('about.title') }}</h1>
      <p class="mt-4 text-white/70 text-xl max-w-2xl mx-auto">{{ $t('about.subtitle') }}</p>
    </div>
  </section>

  <!-- Story -->
  <section class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <div>
          <div class="text-gold-500 text-sm font-semibold tracking-widest uppercase mb-3">Our Story</div>
          <h2 class="section-title">{{ $t('about.story_title') }}</h2>
          <div class="mt-6 space-y-4 text-gray-600 leading-relaxed">
            <p v-for="(para, i) in storyParagraphs" :key="i">{{ para }}</p>
          </div>
        </div>
        <div class="bg-gray-50 rounded-3xl p-10 space-y-6">
          <div class="flex gap-4 items-start">
            <div class="w-10 h-10 rounded-lg bg-navy-700 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-navy-700">China-Based Operations</h4>
              <p class="text-gray-500 text-sm mt-1">Physical presence across major manufacturing hubs in China.</p>
            </div>
          </div>
          <div class="flex gap-4 items-start">
            <div class="w-10 h-10 rounded-lg bg-navy-700 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-navy-700">International Ownership</h4>
              <p class="text-gray-500 text-sm mt-1">Founded and managed by experienced foreign entrepreneurs.</p>
            </div>
          </div>
          <div class="flex gap-4 items-start">
            <div class="w-10 h-10 rounded-lg bg-navy-700 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <div>
              <h4 class="font-bold text-navy-700">Multilingual Team</h4>
              <p class="text-gray-500 text-sm mt-1">English, Chinese, French, and Arabic — no barriers.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission & Vision -->
  <section class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-navy-700 rounded-2xl p-10 text-white relative overflow-hidden">
          <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-navy-600 -translate-y-8 translate-x-8"></div>
          <div class="relative">
            <div class="text-gold-400 text-xs font-bold tracking-widest uppercase mb-3">Mission</div>
            <h3 class="text-2xl font-bold mb-4">{{ $t('about.mission_title') }}</h3>
            <p class="text-white/70 leading-relaxed">{{ $t('about.mission_body') }}</p>
          </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-10 relative overflow-hidden">
          <div class="absolute bottom-0 right-0 w-32 h-32 rounded-full bg-gold-50 translate-y-8 translate-x-8"></div>
          <div class="relative">
            <div class="text-gold-500 text-xs font-bold tracking-widest uppercase mb-3">Vision</div>
            <h3 class="text-2xl font-bold text-navy-700 mb-4">{{ $t('about.vision_title') }}</h3>
            <p class="text-gray-500 leading-relaxed">{{ $t('about.vision_body') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Values -->
  <section class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <div class="text-gold-500 text-sm font-semibold tracking-widest uppercase mb-3">What We Stand For</div>
        <h2 class="section-title">{{ $t('about.values_title') }}</h2>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div v-for="value in values" :key="value.titleKey" class="text-center p-8 rounded-2xl border border-gray-100 hover:border-gold-200 hover:shadow-md transition-all duration-300">
          <div class="w-14 h-14 rounded-full bg-gold-50 border-2 border-gold-200 flex items-center justify-center mx-auto mb-5">
            <component :is="value.icon" class="w-7 h-7 text-gold-500" />
          </div>
          <h4 class="font-bold text-navy-700 text-lg mb-2">{{ $t(value.titleKey) }}</h4>
          <p class="text-gray-500 text-sm leading-relaxed">{{ $t(value.descKey) }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Team -->
  <section class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <div class="text-gold-500 text-sm font-semibold tracking-widest uppercase mb-3">The People Behind It</div>
        <h2 class="section-title">Meet Our Team</h2>
        <p class="section-subtitle mx-auto">International entrepreneurs who chose to build from China — bridging cultures, languages, and supply chains.</p>
      </div>

      <div class="flex justify-center">
        <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100 max-w-sm w-full text-center hover:shadow-md transition-shadow duration-300">
          <!-- Avatar -->
          <div class="relative inline-block mb-6">
            <div class="w-32 h-32 rounded-full overflow-hidden mx-auto border-4 border-gold-200 shadow-lg">
              <img
                src="https://api.dicebear.com/8.x/lorelei/svg?seed=RedaDahmouch&backgroundColor=0D1B4B&scale=90"
                alt="Reda Dahmouch"
                class="w-full h-full object-cover bg-navy-700"
              >
            </div>
            <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-gold-400 rounded-full flex items-center justify-center shadow">
              <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
          </div>

          <h3 class="text-xl font-bold text-navy-700">Reda Dahmouch</h3>
          <div class="text-gold-500 font-semibold text-sm mt-1">Founder & CEO</div>
          <div class="text-gray-400 text-xs mt-1">MSc International Trade & Business</div>

          <p class="text-gray-500 text-sm leading-relaxed mt-5">
            With a master's degree in international trade and years of hands-on experience navigating China's manufacturing landscape, Reda founded Trivalo Sourcing to give global businesses the reliable, transparent partner he wished he'd had.
          </p>

          <div class="flex justify-center gap-3 mt-6">
            <span class="inline-flex items-center gap-1.5 bg-navy-50 text-navy-700 text-xs font-medium px-3 py-1.5 rounded-full">
              <span>🇫🇷</span> French
            </span>
            <span class="inline-flex items-center gap-1.5 bg-navy-50 text-navy-700 text-xs font-medium px-3 py-1.5 rounded-full">
              <span>🇬🇧</span> English
            </span>
            <span class="inline-flex items-center gap-1.5 bg-navy-50 text-navy-700 text-xs font-medium px-3 py-1.5 rounded-full">
              <span>🇨🇳</span> Mandarin
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-navy-700 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-4xl font-extrabold text-white">{{ $t('cta.title') }}</h2>
      <p class="text-white/70 text-lg mt-4">{{ $t('cta.subtitle') }}</p>
      <div class="mt-10">
        <RouterLink to="/contact" class="btn-primary text-base px-10 py-4">
          {{ $t('cta.button') }}
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<script setup>
import { defineComponent, h } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const storyParagraphs = t('about.story_body').split('\n\n')

const IconEye = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z' }), h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' })]) })
const IconCheck = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z' })]) })
const IconStar = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z' })]) })
const IconHeart = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z' })]) })

const values = [
  { titleKey: 'about.val1_title', descKey: 'about.val1_desc', icon: IconEye },
  { titleKey: 'about.val2_title', descKey: 'about.val2_desc', icon: IconCheck },
  { titleKey: 'about.val3_title', descKey: 'about.val3_desc', icon: IconStar },
  { titleKey: 'about.val4_title', descKey: 'about.val4_desc', icon: IconHeart },
]
</script>
