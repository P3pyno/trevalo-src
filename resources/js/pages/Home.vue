<template>
  <!-- Hero -->
  <section class="relative min-h-screen flex items-center bg-navy-700 overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-32 -right-32 w-[600px] h-[600px] rounded-full bg-navy-600 opacity-40"></div>
      <div class="absolute -bottom-20 -left-20 w-[400px] h-[400px] rounded-full bg-navy-800 opacity-50"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-white/5 rounded-full"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20">
      <div class="max-w-3xl">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-8">
          <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
          <span class="text-white/90 text-sm font-medium">{{ $t('hero.badge') }}</span>
        </div>

        <!-- Heading -->
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white leading-[1.05] tracking-tight">
          Your Gateway to
          <span class="text-gold-400"> Global Sourcing</span>
        </h1>

        <p class="mt-6 text-lg sm:text-xl text-white/70 leading-relaxed max-w-2xl">
          {{ $t('hero.subtitle') }}
        </p>

        <div class="mt-10 flex flex-wrap gap-4">
          <RouterLink to="/contact" class="btn-primary text-base px-8 py-4">
            {{ $t('hero.cta_primary') }}
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </RouterLink>
          <RouterLink to="/services" class="btn-secondary text-base px-8 py-4">
            {{ $t('hero.cta_secondary') }}
          </RouterLink>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/40">
      <span class="text-xs tracking-widest uppercase">Scroll</span>
      <div class="w-px h-8 bg-white/20 animate-pulse"></div>
    </div>
  </section>

  <!-- Stats bar -->
  <section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
        <div v-for="stat in stats" :key="stat.value" class="text-center">
          <div class="text-4xl font-extrabold text-navy-700">{{ stat.value }}</div>
          <div class="text-sm text-gray-500 mt-1 font-medium">{{ $t(stat.key) }}</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services overview -->
  <section class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="section-title">{{ $t('services.title') }}</h2>
        <p class="section-subtitle mx-auto">{{ $t('services.subtitle') }}</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="service in services"
          :key="service.icon"
          class="bg-white rounded-2xl p-7 shadow-sm hover:shadow-md transition-shadow duration-300 group border border-gray-100"
        >
          <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center mb-5 group-hover:bg-navy-700 transition-colors duration-300">
            <component :is="service.icon" class="w-6 h-6 text-navy-700 group-hover:text-gold-400 transition-colors duration-300" />
          </div>
          <h3 class="font-bold text-navy-700 text-lg mb-2">{{ $t(service.titleKey) }}</h3>
          <p class="text-gray-500 text-sm leading-relaxed">{{ $t(service.descKey) }}</p>
        </div>
      </div>

      <div class="text-center mt-12">
        <RouterLink to="/services" class="btn-outline">
          View All Services
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </RouterLink>
      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <!-- Left: decorative visual -->
        <div class="relative hidden lg:block">
          <div class="bg-navy-700 rounded-3xl p-10 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-navy-600 -translate-y-12 translate-x-12"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 rounded-full bg-gold-400/20 translate-y-8 -translate-x-8"></div>
            <div class="relative">
              <div class="text-gold-400 text-sm font-semibold tracking-widest uppercase mb-3">Trivalo Sourcing</div>
              <div class="text-4xl font-extrabold leading-tight mb-6">China-Based.<br>Globally<br>Minded.</div>
              <div class="grid grid-cols-2 gap-4 mt-8">
                <div v-for="stat in highlights" :key="stat.label" class="bg-white/10 rounded-xl p-4">
                  <div class="text-2xl font-bold text-gold-400">{{ stat.value }}</div>
                  <div class="text-white/70 text-xs mt-1">{{ stat.label }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: points -->
        <div>
          <h2 class="section-title">{{ $t('why.title') }}</h2>
          <p class="section-subtitle">{{ $t('why.subtitle') }}</p>

          <div class="mt-10 space-y-6">
            <div v-for="point in whyPoints" :key="point.titleKey" class="flex gap-4">
              <div class="w-10 h-10 rounded-lg bg-gold-50 border border-gold-200 flex items-center justify-center flex-shrink-0 mt-0.5">
                <component :is="point.icon" class="w-5 h-5 text-gold-500" />
              </div>
              <div>
                <h4 class="font-semibold text-navy-700 text-base">{{ $t(point.titleKey) }}</h4>
                <p class="text-gray-500 text-sm mt-1 leading-relaxed">{{ $t(point.descKey) }}</p>
              </div>
            </div>
          </div>

          <div class="mt-10">
            <RouterLink to="/about" class="btn-outline">
              Learn More About Us
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works (brief) -->
  <section class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="section-title">{{ $t('how.title') }}</h2>
        <p class="section-subtitle mx-auto">{{ $t('how.subtitle') }}</p>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
        <!-- Connector line (desktop) -->
        <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%] h-px bg-gold-200 -z-0"></div>

        <div v-for="(step, idx) in steps" :key="idx" class="relative flex flex-col items-center text-center">
          <div class="w-20 h-20 rounded-full bg-white border-2 border-gold-300 flex items-center justify-center mb-5 shadow-sm z-10">
            <span class="text-2xl font-extrabold text-gold-400">{{ idx + 1 }}</span>
          </div>
          <h4 class="font-bold text-navy-700 text-base mb-2">{{ $t(step.titleKey) }}</h4>
          <p class="text-gray-500 text-sm leading-relaxed">{{ $t(step.descKey) }}</p>
        </div>
      </div>

      <div class="text-center mt-12">
        <RouterLink to="/how-it-works" class="btn-outline">
          See the Full Process
        </RouterLink>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <div class="text-gold-500 text-sm font-semibold tracking-widest uppercase mb-3">Client Stories</div>
        <h2 class="section-title">What Our Clients Say</h2>
        <p class="section-subtitle mx-auto">Businesses from around the world trust Trivalo Sourcing to connect them with reliable Chinese manufacturers.</p>
      </div>
    </div>

    <!-- Full-width marquee wrapper — overflow clipped here -->
    <div class="relative overflow-hidden">
      <!-- Gradient edges -->
      <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent pointer-events-none z-10"></div>
      <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-white to-transparent pointer-events-none z-10"></div>

      <!-- Row 1 -->
      <div class="flex gap-6 testimonial-marquee">
        <div v-for="t in [...testimonials, ...testimonials]" :key="t.id + t.name" class="flex-shrink-0 w-80 bg-gray-50 border border-gray-100 rounded-2xl p-6 hover:border-gold-200 hover:shadow-md transition-all duration-300">
          <div class="flex gap-1 mb-4">
            <svg v-for="i in 5" :key="i" class="w-4 h-4 text-gold-400 fill-gold-400" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
          </div>
          <p class="text-gray-600 text-sm leading-relaxed mb-5">"{{ t.quote }}"</p>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-navy-700 flex items-center justify-center text-gold-400 font-bold text-sm flex-shrink-0">{{ t.initials }}</div>
            <div>
              <div class="font-semibold text-navy-700 text-sm">{{ t.name }}</div>
              <div class="text-gray-400 text-xs">{{ t.role }} · {{ t.country }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Row 2 (reverse) -->
      <div class="flex gap-6 testimonial-marquee-reverse mt-6">
        <div v-for="t in [...testimonialsRow2, ...testimonialsRow2]" :key="t.id + t.name" class="flex-shrink-0 w-80 bg-gray-50 border border-gray-100 rounded-2xl p-6 hover:border-gold-200 hover:shadow-md transition-all duration-300">
          <div class="flex gap-1 mb-4">
            <svg v-for="i in 5" :key="i" class="w-4 h-4 text-gold-400 fill-gold-400" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
          </div>
          <p class="text-gray-600 text-sm leading-relaxed mb-5">"{{ t.quote }}"</p>
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-navy-700 flex items-center justify-center text-gold-400 font-bold text-sm flex-shrink-0">{{ t.initials }}</div>
            <div>
              <div class="font-semibold text-navy-700 text-sm">{{ t.name }}</div>
              <div class="text-gray-400 text-xs">{{ t.role }} · {{ t.country }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Banner -->
  <section class="bg-navy-700 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-4xl font-extrabold text-white">{{ $t('cta.title') }}</h2>
      <p class="text-white/70 text-lg mt-4">{{ $t('cta.subtitle') }}</p>
      <div class="mt-10">
        <RouterLink to="/contact" class="btn-primary text-base px-10 py-4">
          {{ $t('cta.button') }}
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<script setup>
import { defineComponent, h } from 'vue'

// Inline icon components (Heroicons-style)
const IconSearch = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z' })]) })
const IconShield = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z' })]) })
const IconClipboard = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4' })]) })
const IconTruck = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z' }), h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8zm0 0l2-5h4l2 5H13z' })]) })
const IconGlobe = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z' })]) })
const IconChat = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z' })]) })
const IconCurrency = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' })]) })
const IconLink = defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1' })]) })

const stats = [
  { value: '500+', key: 'stats.suppliers' },
  { value: '30+',  key: 'stats.countries' },
  { value: '5+',   key: 'stats.experience' },
  { value: '98%',  key: 'stats.satisfaction' },
]

const services = [
  { titleKey: 'services.sourcing_title',      descKey: 'services.sourcing_desc',      icon: IconSearch },
  { titleKey: 'services.verification_title',  descKey: 'services.verification_desc',  icon: IconShield },
  { titleKey: 'services.quality_title',       descKey: 'services.quality_desc',       icon: IconClipboard },
  { titleKey: 'services.shipping_title',      descKey: 'services.shipping_desc',      icon: IconTruck },
]

const highlights = [
  { value: '500+', label: 'Verified Suppliers' },
  { value: '30+',  label: 'Countries' },
  { value: '5+',   label: 'Years in China' },
  { value: '98%',  label: 'Satisfaction' },
]

const whyPoints = [
  { titleKey: 'why.local_title',       descKey: 'why.local_desc',       icon: IconGlobe },
  { titleKey: 'why.multilingual_title', descKey: 'why.multilingual_desc', icon: IconChat },
  { titleKey: 'why.transparent_title', descKey: 'why.transparent_desc', icon: IconCurrency },
  { titleKey: 'why.endtoend_title',    descKey: 'why.endtoend_desc',    icon: IconLink },
]

const steps = [
  { titleKey: 'how.step1_title', descKey: 'how.step1_desc' },
  { titleKey: 'how.step2_title', descKey: 'how.step2_desc' },
  { titleKey: 'how.step3_title', descKey: 'how.step3_desc' },
  { titleKey: 'how.step4_title', descKey: 'how.step4_desc' },
]

const testimonials = [
  {
    id: 1, name: 'Marcus Levi', initials: 'ML', role: 'E-commerce Founder', country: 'Germany',
    quote: 'Trivalo found us three verified suppliers in under a week. The factory audit report gave us complete confidence before placing our first order. We\'ve since scaled to monthly containers.'
  },
  {
    id: 2, name: 'Sophie Martin', initials: 'SM', role: 'Purchasing Manager', country: 'France',
    quote: 'The quality inspection service is exceptional. They caught packaging defects before shipment that would have been a disaster. I now rely on them for every single order.'
  },
  {
    id: 3, name: 'Ahmed Al-Rashid', initials: 'AR', role: 'Import Director', country: 'UAE',
    quote: 'Sea freight from Guangzhou to Dubai was seamless. All customs paperwork was handled perfectly and the goods arrived on time. Trivalo takes real ownership of the process.'
  },
]

const testimonialsRow2 = [
  {
    id: 4, name: 'James Thornton', initials: 'JT', role: 'Brand Owner', country: 'United Kingdom',
    quote: 'We launched our private label line entirely through Trivalo. From packaging design coordination to final delivery, they managed every detail. Our margins are 30% better than before.'
  },
  {
    id: 5, name: 'Maria Santos', initials: 'MS', role: 'Retail Buyer', country: 'Brazil',
    quote: 'As a first-time importer, I was nervous about dealing with Chinese factories directly. Trivalo acted as a true partner — transparent, responsive, and honest about timelines.'
  },
  {
    id: 6, name: 'David Park', initials: 'DP', role: 'Operations Manager', country: 'United States',
    quote: 'The supplier verification process is thorough. We had a bad experience with another agent before Trivalo. Now we have long-term partnerships with two factories they introduced us to.'
  },
]
</script>

<style scoped>
@keyframes marquee {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}
@keyframes marquee-reverse {
  from { transform: translateX(-50%); }
  to { transform: translateX(0); }
}
.testimonial-marquee {
  animation: marquee 40s linear infinite;
  width: max-content;
}
.testimonial-marquee:hover {
  animation-play-state: paused;
}
.testimonial-marquee-reverse {
  animation: marquee-reverse 40s linear infinite;
  width: max-content;
}
.testimonial-marquee-reverse:hover {
  animation-play-state: paused;
}
</style>
