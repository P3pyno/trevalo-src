<template>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-navy-600 opacity-50"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-6">
        <span class="text-gold-400 text-sm font-medium">Our Process</span>
      </div>
      <h1 class="text-5xl font-extrabold text-white leading-tight">{{ $t('how.title') }}</h1>
      <p class="mt-4 text-white/70 text-xl max-w-2xl mx-auto">{{ $t('how.subtitle') }}</p>
    </div>
  </section>

  <!-- Process Steps (detailed) -->
  <section class="bg-white py-14">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="relative">
        <!-- Vertical timeline line -->
        <div class="hidden md:block absolute left-[60px] top-8 bottom-8 w-0.5 bg-gradient-to-b from-gold-300 via-gold-400 to-gold-200"></div>

        <div class="space-y-16">
          <div v-for="(step, idx) in detailedSteps" :key="idx" class="flex gap-8 items-start">
            <!-- Step number -->
            <div class="flex-shrink-0 relative">
              <div class="w-[120px] h-[120px] rounded-2xl bg-navy-700 flex flex-col items-center justify-center shadow-lg">
                <span class="text-gold-400 text-xs font-bold tracking-widest uppercase">Step</span>
                <span class="text-white text-4xl font-extrabold">{{ String(idx + 1).padStart(2, '0') }}</span>
              </div>
            </div>
            <!-- Content -->
            <div class="flex-1 pt-4">
              <h3 class="text-2xl font-bold text-navy-700 mb-3">{{ $t(step.titleKey) }}</h3>
              <p class="text-gray-500 leading-relaxed mb-5">{{ step.body }}</p>
              <ul class="grid sm:grid-cols-2 gap-2">
                <li v-for="point in step.bullets" :key="point" class="flex items-center gap-2 text-sm text-gray-600">
                  <svg class="w-4 h-4 text-gold-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                  </svg>
                  {{ point }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Timeline summary -->
  <section class="bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
        <h2 class="section-title">Typical Timeline</h2>
        <p class="section-subtitle mx-auto">Timeframes vary by product complexity and order size, but here's what to expect.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div v-for="t in timeline" :key="t.step" class="bg-white rounded-2xl p-7 border border-gray-100 text-center">
          <div class="text-gold-700 font-bold text-xs tracking-widest uppercase mb-2">{{ t.step }}</div>
          <div class="text-navy-700 font-extrabold text-3xl mb-1">{{ t.duration }}</div>
          <div class="text-gray-500 text-sm">{{ t.label }}</div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="bg-white py-14">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle mx-auto">Answers to the most common questions about our process.</p>
      </div>
      <div class="space-y-4">
        <div
          v-for="(faq, idx) in faqs"
          :key="idx"
          class="border border-gray-200 rounded-xl overflow-hidden"
        >
          <button
            @click="toggleFaq(idx)"
            class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors"
          >
            <span class="font-semibold text-navy-700 pr-4">{{ faq.q }}</span>
            <svg
              class="w-5 h-5 text-gold-700 flex-shrink-0 transition-transform duration-200"
              :class="{ 'rotate-180': openFaq === idx }"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <Transition name="faq">
            <div v-if="openFaq === idx" class="px-6 pb-5 text-gray-500 text-sm leading-relaxed border-t border-gray-100 pt-4">
              {{ faq.a }}
            </div>
          </Transition>
        </div>
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
import { ref } from 'vue'

const openFaq = ref(null)
function toggleFaq(idx) {
  openFaq.value = openFaq.value === idx ? null : idx
}

const detailedSteps = [
  {
    titleKey: 'how.step1_title',
    body: 'The process starts with a conversation. Share your product requirements — specifications, target price, quantities, certifications needed, and your delivery timeline. The more detail you provide, the better we can serve you.',
    bullets: ['Product specifications', 'Target unit price & MOQ', 'Required certifications', 'Delivery timeline'],
  },
  {
    titleKey: 'how.step2_title',
    body: 'Our team researches the Chinese market to identify manufacturers who match your requirements. We conduct factory visits, verify credentials, and present you with a curated shortlist with comparison data.',
    bullets: ['Market & competitor research', 'Factory visits & audits', 'Credential verification', 'Comparison report delivery'],
  },
  {
    titleKey: 'how.step3_title',
    body: 'Before full production begins, we order and evaluate samples on your behalf. Our inspectors visit the factory during production and perform a final pre-shipment inspection with photo and video evidence.',
    bullets: ['Sample ordering & evaluation', 'During-production inspection', 'Pre-shipment final inspection', 'Detailed photo/video reports'],
  },
  {
    titleKey: 'how.step4_title',
    body: 'Once goods pass inspection, we arrange freight forwarding, handle all export documentation, and track your shipment in real-time until delivery. We support sea, air, and express courier options.',
    bullets: ['Sea, air & express options', 'Export documentation', 'Customs clearance support', 'Real-time tracking'],
  },
]

const timeline = [
  { step: 'Step 1', duration: '1–3d', label: 'Requirements & briefing' },
  { step: 'Step 2', duration: '5–10d', label: 'Sourcing & supplier audit' },
  { step: 'Step 3', duration: '7–30d', label: 'Production & inspection' },
  { step: 'Step 4', duration: '7–35d', label: 'Shipping & delivery' },
]

const faqs = [
  {
    q: 'What is your minimum order quantity?',
    a: "It depends on the product and supplier. Many factories have MOQs as low as 100–500 units. We'll find suppliers that fit your scale, whether you're a startup or an established enterprise.",
  },
  {
    q: 'Do you charge a commission from suppliers?',
    a: 'Never. We are paid exclusively by our clients, not suppliers. This ensures our recommendations are always in your best interest.',
  },
  {
    q: 'Can I visit the factory myself?',
    a: 'Absolutely. We can organize accompanied factory visits and help you navigate logistics, translation, and negotiations on the ground.',
  },
  {
    q: 'What happens if the goods fail the inspection?',
    a: 'We negotiate with the supplier for rework or replacement before shipment. We never approve shipment of goods that fail to meet your specs.',
  },
  {
    q: 'Do you handle customs in the destination country?',
    a: 'We handle export customs in China. For import customs in your country, we provide all the necessary documentation and can connect you with a local customs broker.',
  },
  {
    q: 'How do you handle payment to suppliers?',
    a: 'You pay suppliers directly. We handle negotiations and communications, but your money goes straight to the factory — full transparency throughout.',
  },
]
</script>

<style scoped>
.faq-enter-active,
.faq-leave-active {
  transition: all 0.2s ease;
}
.faq-enter-from,
.faq-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}
</style>
