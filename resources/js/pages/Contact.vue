<template>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-navy-600 opacity-50"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-6">
        <span class="text-gold-400 text-sm font-medium">Let's Talk</span>
      </div>
      <h1 class="text-5xl font-extrabold text-white leading-tight">{{ $t('contact.title') }}</h1>
      <p class="mt-4 text-white/70 text-xl max-w-xl mx-auto">{{ $t('contact.subtitle') }}</p>
    </div>
  </section>

  <!-- Contact section -->
  <section class="bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-3 gap-12">

        <!-- Form -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-navy-700 mb-7">Send Us a Message</h2>

            <!-- Success state -->
            <div v-if="contactStore.success" class="bg-green-50 border border-green-200 rounded-xl p-6 flex items-start gap-4">
              <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div>
                <p class="font-semibold text-green-700">Message sent!</p>
                <p class="text-green-600 text-sm mt-1">{{ $t('contact.form_success') }}</p>
                <button @click="contactStore.reset()" class="mt-3 text-sm text-green-600 underline hover:no-underline">Send another message</button>
              </div>
            </div>

            <!-- Error state -->
            <div v-if="contactStore.error" class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 text-sm text-red-600">
              {{ contactStore.error }}
            </div>

            <!-- Form -->
            <form v-if="!contactStore.success" @submit.prevent="contactStore.submitForm()" class="space-y-5">
              <div class="grid sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('contact.form_name') }} *</label>
                  <input
                    v-model="contactStore.form.name"
                    type="text"
                    required
                    class="w-full rounded-xl border-gray-300 focus:border-navy-500 focus:ring-navy-500 text-sm"
                    :class="{ 'border-red-400': contactStore.fieldErrors.name }"
                    :placeholder="$t('contact.form_name')"
                  >
                  <p v-if="contactStore.fieldErrors.name" class="mt-1 text-xs text-red-500">{{ contactStore.fieldErrors.name[0] }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('contact.form_email') }} *</label>
                  <input
                    v-model="contactStore.form.email"
                    type="email"
                    required
                    class="w-full rounded-xl border-gray-300 focus:border-navy-500 focus:ring-navy-500 text-sm"
                    :class="{ 'border-red-400': contactStore.fieldErrors.email }"
                    :placeholder="$t('contact.form_email')"
                  >
                  <p v-if="contactStore.fieldErrors.email" class="mt-1 text-xs text-red-500">{{ contactStore.fieldErrors.email[0] }}</p>
                </div>
              </div>

              <div class="grid sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('contact.form_company') }}</label>
                  <input
                    v-model="contactStore.form.company"
                    type="text"
                    class="w-full rounded-xl border-gray-300 focus:border-navy-500 focus:ring-navy-500 text-sm"
                    :placeholder="$t('contact.form_company')"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('contact.form_phone') }}</label>
                  <input
                    v-model="contactStore.form.phone"
                    type="tel"
                    class="w-full rounded-xl border-gray-300 focus:border-navy-500 focus:ring-navy-500 text-sm"
                    placeholder="+1 234 567 890"
                  >
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $t('contact.form_message') }} *</label>
                <textarea
                  v-model="contactStore.form.message"
                  rows="6"
                  required
                  class="w-full rounded-xl border-gray-300 focus:border-navy-500 focus:ring-navy-500 text-sm resize-none"
                  :class="{ 'border-red-400': contactStore.fieldErrors.message }"
                  :placeholder="$t('contact.form_placeholder')"
                ></textarea>
                <p v-if="contactStore.fieldErrors.message" class="mt-1 text-xs text-red-500">{{ contactStore.fieldErrors.message[0] }}</p>
              </div>

              <button
                type="submit"
                :disabled="contactStore.loading"
                class="btn-primary w-full justify-center py-4 text-base"
                :class="{ 'opacity-60 cursor-not-allowed': contactStore.loading }"
              >
                <svg v-if="contactStore.loading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                {{ contactStore.loading ? $t('contact.form_sending') : $t('contact.form_send') }}
              </button>
            </form>
          </div>
        </div>

        <!-- Contact channels -->
        <div class="space-y-5">
          <h3 class="text-xl font-bold text-navy-700">Other Ways to Reach Us</h3>

          <!-- Email -->
          <a
            href="mailto:info@trivalo-sourcing.com"
            class="flex items-start gap-4 bg-white rounded-2xl p-6 border border-gray-100 hover:border-gold-300 hover:shadow-md transition-all duration-300 group"
          >
            <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0 group-hover:bg-navy-700 transition-colors">
              <svg class="w-6 h-6 text-navy-700 group-hover:text-gold-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-navy-700 text-sm">{{ $t('contact.channel_email') }}</div>
              <div class="text-gray-500 text-sm mt-0.5">info@trivalo-sourcing.com</div>
              <div class="text-gray-400 text-xs mt-1">Response within 24 hours</div>
            </div>
          </a>

          <!-- WhatsApp -->
          <a
            :href="`https://wa.me/${whatsappNumber}`"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-start gap-4 bg-white rounded-2xl p-6 border border-gray-100 hover:border-green-300 hover:shadow-md transition-all duration-300 group"
          >
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
              <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-navy-700 text-sm">{{ $t('contact.channel_whatsapp') }}</div>
              <div class="text-gray-500 text-sm mt-0.5">+86 XXX XXXX XXXX</div>
              <div class="text-gray-400 text-xs mt-1">Quick responses during business hours</div>
            </div>
          </a>

          <!-- WeChat -->
          <button
            @click="wechatVisible = true"
            class="w-full flex items-start gap-4 bg-white rounded-2xl p-6 border border-gray-100 hover:border-green-300 hover:shadow-md transition-all duration-300 group text-left"
          >
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
              <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.59.59 0 01.213.664l-.39 1.482c-.019.07-.048.14-.048.213 0 .163.13.295.29.295a.326.326 0 00.167-.054l1.903-1.113a.864.864 0 01.717-.099 10.16 10.16 0 002.837.403c.276 0 .543-.027.811-.05-.857-2.578.157-4.972 1.932-6.446 1.703-1.415 3.882-1.98 5.853-1.838-.576-3.583-4.196-6.348-8.596-6.348zM5.785 5.99c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178A1.17 1.17 0 014.623 7.17c0-.651.52-1.18 1.162-1.18zm5.813 0c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178 1.17 1.17 0 01-1.162-1.178c0-.651.52-1.18 1.162-1.18zm5.34 2.867c-1.797-.052-3.746.512-5.28 1.786-1.72 1.428-2.687 3.72-1.78 6.22.942 2.453 3.666 4.229 6.884 4.229.826 0 1.622-.12 2.361-.336a.722.722 0 01.598.082l1.584.927a.272.272 0 00.14.047c.134 0 .24-.112.24-.248 0-.06-.023-.12-.038-.177l-.327-1.233a.49.49 0 01.178-.554C23.024 18.48 24 16.82 24 14.98c0-3.21-2.931-5.837-7.062-6.122zm-3.601 2.673c.568 0 1.03.47 1.03 1.047s-.462 1.047-1.03 1.047c-.568 0-1.03-.47-1.03-1.047s.462-1.047 1.03-1.047zm5.337 0c.568 0 1.03.47 1.03 1.047s-.462 1.047-1.03 1.047c-.568 0-1.03-.47-1.03-1.047s.462-1.047 1.03-1.047z"/>
              </svg>
            </div>
            <div>
              <div class="font-semibold text-navy-700 text-sm">{{ $t('contact.channel_wechat') }}</div>
              <div class="text-gray-500 text-sm mt-0.5">trivalo_sourcing</div>
              <div class="text-gray-400 text-xs mt-1">Scan QR code to connect</div>
            </div>
          </button>

          <!-- Location info -->
          <div class="bg-navy-700 rounded-2xl p-6 text-white">
            <div class="flex items-center gap-2 mb-4">
              <svg class="w-5 h-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <span class="font-semibold text-sm">China Operations</span>
            </div>
            <p class="text-white/70 text-sm leading-relaxed">
              Based in Guangzhou with satellite presence in Yiwu, Shenzhen, and Shanghai — covering China's major manufacturing hubs.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- WeChat Modal -->
  <Transition name="fade">
    <div
      v-if="wechatVisible"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
      @click.self="wechatVisible = false"
    >
      <div class="bg-white rounded-2xl p-8 max-w-xs w-full text-center shadow-2xl">
        <h3 class="text-navy-700 font-bold text-xl mb-2">Add Us on WeChat</h3>
        <p class="text-gray-500 text-sm mb-6">Scan the QR code with your WeChat app to connect.</p>
        <div class="w-48 h-48 mx-auto bg-gray-50 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
          <div class="text-center text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75V16.5zM16.5 6.75h.75v.75h-.75v-.75z"/>
            </svg>
            <span class="text-xs">QR Code Placeholder</span>
          </div>
        </div>
        <p class="text-gray-500 text-sm mt-4">WeChat ID: <span class="font-semibold text-navy-700">trivalo_sourcing</span></p>
        <button @click="wechatVisible = false" class="mt-6 btn-primary w-full justify-center">Close</button>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { useContactStore } from '@/stores/contact'

const contactStore = useContactStore()
const wechatVisible = ref(false)
const whatsappNumber = '8615019253764'
</script>
