<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold text-navy-700">Quote Workflow</h2>
    
    <div v-if="loading" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div v-for="i in 3" :key="i">
        <LoadingSkeleton :count="3" />
      </div>
    </div>
    
    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Pending Column -->
      <div class="bg-gray-50 rounded-2xl p-4 min-h-96">
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-bold text-gray-700 flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
            Pending ({{ pendingQuotes.length }})
          </h3>
        </div>
        <div class="space-y-3">
          <div v-for="quote in pendingQuotes" :key="quote.id"
            class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-move group">
            <div class="text-sm font-semibold text-navy-700">{{ quote.supplier_name }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ quote.notes?.substring(0, 50) }}...</div>
            <div class="flex items-center justify-between mt-3">
              <div class="text-sm font-bold text-gold-500">${{ parseFloat(quote.total_price).toFixed(2) }}</div>
              <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button @click="approveQuote(quote.id)"
                  class="p-1.5 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors"
                  title="Approve">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </button>
                <button @click="rejectQuote(quote.id)"
                  class="p-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                  title="Reject">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
            </div>
          </div>
          <div v-if="pendingQuotes.length === 0" class="text-center py-8 text-gray-400">
            <p class="text-sm">No pending quotes</p>
          </div>
        </div>
      </div>
      
      <!-- Approved Column -->
      <div class="bg-green-50 rounded-2xl p-4 min-h-96">
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-bold text-gray-700 flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            Approved ({{ approvedQuotes.length }})
          </h3>
        </div>
        <div class="space-y-3">
          <div v-for="quote in approvedQuotes" :key="quote.id"
            class="bg-white rounded-xl p-4 shadow-sm border border-green-200 hover:shadow-md transition-shadow">
            <div class="text-sm font-semibold text-navy-700">{{ quote.supplier_name }}</div>
            <div class="text-xs text-gray-500 mt-1">Lead time: {{ quote.lead_time }} days</div>
            <div class="text-sm font-bold text-green-600 mt-3">${{ parseFloat(quote.total_price).toFixed(2) }}</div>
          </div>
          <div v-if="approvedQuotes.length === 0" class="text-center py-8 text-gray-400">
            <p class="text-sm">No approved quotes</p>
          </div>
        </div>
      </div>
      
      <!-- Rejected Column -->
      <div class="bg-red-50 rounded-2xl p-4 min-h-96">
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-bold text-gray-700 flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            Rejected ({{ rejectedQuotes.length }})
          </h3>
        </div>
        <div class="space-y-3">
          <div v-for="quote in rejectedQuotes" :key="quote.id"
            class="bg-white rounded-xl p-4 shadow-sm border border-red-200 hover:shadow-md transition-shadow opacity-60">
            <div class="text-sm font-semibold text-gray-600">{{ quote.supplier_name }}</div>
            <div class="text-xs text-gray-400 mt-1">Rejected</div>
            <div class="text-sm font-bold text-red-600 mt-3">${{ parseFloat(quote.total_price).toFixed(2) }}</div>
          </div>
          <div v-if="rejectedQuotes.length === 0" class="text-center py-8 text-gray-400">
            <p class="text-sm">No rejected quotes</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import LoadingSkeleton from './LoadingSkeleton.vue'

const quotes = ref([])
const loading = ref(true)

const pendingQuotes = computed(() => quotes.value.filter(q => q.status === 'pending'))
const approvedQuotes = computed(() => quotes.value.filter(q => q.status === 'approved'))
const rejectedQuotes = computed(() => quotes.value.filter(q => q.status === 'rejected'))

async function approveQuote(quoteId) {
  try {
    await axios.patch(`/quotes/${quoteId}/approve`)
    const quote = quotes.value.find(q => q.id === quoteId)
    if (quote) quote.status = 'approved'
  } catch (err) {
    console.error('Failed to approve quote:', err)
  }
}

async function rejectQuote(quoteId) {
  try {
    await axios.patch(`/quotes/${quoteId}/reject`)
    const quote = quotes.value.find(q => q.id === quoteId)
    if (quote) quote.status = 'rejected'
  } catch (err) {
    console.error('Failed to reject quote:', err)
  }
}

onMounted(async () => {
  try {
    const { data } = await axios.get('/quotes', { params: { per_page: 100 } })
    quotes.value = data.data || data
  } catch (err) {
    console.error('Failed to load quotes:', err)
  } finally {
    loading.value = false
  }
})
</script>
