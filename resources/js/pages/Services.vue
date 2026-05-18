<template>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-navy-600 opacity-50"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-6">
        <span class="text-gold-400 text-sm font-medium">What We Do</span>
      </div>
      <h1 class="text-5xl font-extrabold text-white leading-tight">{{ $t('services.title') }}</h1>
      <p class="mt-4 text-white/70 text-xl max-w-2xl mx-auto">{{ $t('services.subtitle') }}</p>
    </div>
  </section>

  <!-- Main Services -->
  <section class="bg-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="space-y-16">
        <div
          v-for="(service, idx) in services"
          :key="service.titleKey"
          class="grid lg:grid-cols-2 gap-12 items-center"
          :class="{ 'lg:flex-row-reverse': idx % 2 !== 0 }"
        >
          <div :class="idx % 2 !== 0 ? 'lg:order-2' : ''">
            <div class="inline-flex items-center gap-2 bg-gold-50 border border-gold-200 rounded-full px-3 py-1 mb-5">
              <span class="text-gold-700 text-xs font-semibold tracking-widest uppercase">Service 0{{ idx + 1 }}</span>
            </div>
            <h2 class="text-3xl font-bold text-navy-700 mb-4">{{ $t(service.titleKey) }}</h2>
            <p class="text-gray-500 leading-relaxed mb-6">{{ $t(service.descKey) }}</p>
            <ul class="space-y-3">
              <li v-for="point in service.points" :key="point" class="flex items-center gap-3 text-gray-600 text-sm">
                <svg class="w-5 h-5 text-gold-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ point }}
              </li>
            </ul>
          </div>
          <div :class="idx % 2 !== 0 ? 'lg:order-1' : ''" class="relative">
            <div class="bg-gray-50 rounded-3xl p-12 flex items-center justify-center min-h-[300px]">
              <div class="text-center">
                <div class="w-24 h-24 rounded-2xl bg-navy-700 flex items-center justify-center mx-auto mb-4">
                  <component :is="service.icon" class="w-12 h-12 text-gold-400" />
                </div>
                <div class="text-navy-700 font-bold text-xl">{{ $t(service.titleKey) }}</div>
              </div>
              <!-- Decorative blob -->
              <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-gold-100 rounded-2xl -z-10"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Additional Services -->
  <section class="bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
        <h2 class="section-title">Additional Services</h2>
        <p class="section-subtitle mx-auto">Beyond our core offerings, we provide a range of supporting services.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="add in additionalServices" :key="add.title" class="bg-white rounded-2xl p-7 border border-gray-100 hover:border-gold-200 hover:shadow-md transition-all duration-300">
          <div class="w-10 h-10 rounded-lg bg-navy-50 flex items-center justify-center mb-4">
            <component :is="add.icon" class="w-5 h-5 text-navy-700" />
          </div>
          <h4 class="font-bold text-navy-700 mb-2">{{ add.title }}</h4>
          <p class="text-gray-500 text-sm leading-relaxed">{{ add.desc }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Industries -->
  <section class="bg-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
        <h2 class="section-title">Industries We Serve</h2>
        <p class="section-subtitle mx-auto">We have experience across a broad range of product categories and industries.</p>
      </div>
      <div class="flex flex-wrap justify-center gap-3">
        <span
          v-for="industry in industries"
          :key="industry"
          class="px-5 py-2.5 bg-navy-50 text-navy-700 rounded-full text-sm font-medium border border-navy-100 hover:bg-navy-700 hover:text-white transition-colors duration-200 cursor-default"
        >
          {{ industry }}
        </span>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-navy-700 py-12">
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

const mkIcon = (d) => defineComponent({ render: () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '2' }, [h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d })]) })

const IconSearch  = mkIcon('M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z')
const IconShield  = mkIcon('M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z')
const IconClip    = mkIcon('M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4')
const IconTruck   = mkIcon('M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8zm0 0l2-5h4l2 5H13z')
const IconTag     = mkIcon('M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z')
const IconFactory = mkIcon('M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4')
const IconDoc     = mkIcon('M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z')

const services = [
  {
    titleKey: 'services.sourcing_title',
    descKey: 'services.sourcing_desc',
    icon: IconSearch,
    points: [
      'Product specification analysis',
      'Market research across manufacturing regions',
      'Supplier shortlisting and comparison reports',
      'Sample coordination and evaluation',
      'Price negotiation on your behalf',
    ],
  },
  {
    titleKey: 'services.verification_title',
    descKey: 'services.verification_desc',
    icon: IconShield,
    points: [
      'Business license and registration verification',
      'On-site factory audit and assessment',
      'Export capability and certifications check',
      'Financial stability review',
      'Reference checks with existing clients',
    ],
  },
  {
    titleKey: 'services.quality_title',
    descKey: 'services.quality_desc',
    icon: IconClip,
    points: [
      'Pre-production inspection of materials',
      'During-production (DUPRO) inspection',
      'Pre-shipment final inspection (PSI)',
      'Detailed photo and video reports',
      'Third-party lab testing coordination',
    ],
  },
  {
    titleKey: 'services.shipping_title',
    descKey: 'services.shipping_desc',
    icon: IconTruck,
    points: [
      'Sea freight (FCL & LCL)',
      'Air freight and express courier',
      'Export customs clearance in China',
      'Import customs documentation support',
      'Real-time shipment tracking',
    ],
  },
]

const additionalServices = [
  { title: 'Private Label & OEM', desc: 'Custom branding, packaging design, and private label manufacturing for your products.', icon: IconTag },
  { title: 'Factory Visits', desc: 'Organized and accompanied factory visits so you can meet your suppliers in person.', icon: IconFactory },
  { title: 'Trade Documentation', desc: 'All export documents, certificates of origin, and compliance paperwork handled for you.', icon: IconDoc },
]

const industries = [
  'Consumer Electronics', 'Apparel & Textiles', 'Furniture & Home Decor', 'Industrial Equipment',
  'Health & Beauty', 'Toys & Games', 'Sports & Outdoors', 'Automotive Parts',
  'Food Packaging', 'Construction Materials', 'Agriculture', 'Medical Devices',
]
</script>
