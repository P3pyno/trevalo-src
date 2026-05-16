<template>
  <div class="space-y-6">
    <!-- Price Comparison Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-navy-700">Price Comparison</h3>
        <p class="text-sm text-gray-500 mt-1">Compare quotes from different suppliers</p>
      </div>
      
      <div v-if="loading" class="p-6">
        <LoadingSkeleton :count="3" />
      </div>
      
      <div v-else-if="quotes.length === 0" class="p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h8m-8-6h8m-8 12h8M5 8a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
        <p class="text-gray-500">No quotes to compare</p>
      </div>
      
      <div v-else class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Supplier</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Unit Price</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Total Price</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Lead Time</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="quote in sortedQuotes" :key="quote.id" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <div class="font-medium text-navy-700">{{ quote.supplier_name }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="font-medium text-navy-700">${{ parseFloat(quote.unit_price).toFixed(2) }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-lg font-bold text-gold-500">${{ parseFloat(quote.total_price).toFixed(2) }}</div>
                <div v-if="lowestPrice && quote.total_price === lowestPrice" class="text-xs text-green-600 font-semibold mt-1">Best Price ✓</div>
              </td>
              <td class="px-6 py-4">{{ quote.lead_time }} days</td>
              <td class="px-6 py-4">
                <span :class="`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                  quote.status === 'approved' ? 'bg-green-100 text-green-800' :
                  quote.status === 'rejected' ? 'bg-red-100 text-red-800' :
                  'bg-yellow-100 text-yellow-800'
                }`">
                  {{ quote.status }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Price Chart -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <h3 class="text-lg font-bold text-navy-700 mb-4">Price Distribution</h3>
      <div class="space-y-3">
        <div v-for="quote in sortedQuotes" :key="quote.id" class="flex items-center gap-4">
          <div class="w-32 text-sm font-medium text-gray-600 truncate">{{ quote.supplier_name }}</div>
          <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden">
            <div class="bg-gold-400 h-full" :style="{ width: getBarWidth(quote.total_price) + '%' }"></div>
          </div>
          <div class="text-sm font-bold text-navy-700 w-24 text-right">${{ parseFloat(quote.total_price).toFixed(2) }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'
import LoadingSkeleton from './LoadingSkeleton.vue'

const authStore = useAuthStore()
const quotes = ref([])
const loading = ref(true)

const sortedQuotes = computed(() => {
  return [...quotes.value].sort((a, b) => parseFloat(a.total_price) - parseFloat(b.total_price))
})

const lowestPrice = computed(() => {
  return quotes.value.length > 0 ? Math.min(...quotes.value.map(q => parseFloat(q.total_price))) : 0
})

const maxPrice = computed(() => {
  return quotes.value.length > 0 ? Math.max(...quotes.value.map(q => parseFloat(q.total_price))) : 1
})

function getBarWidth(price) {
  return ((parseFloat(price) - (Math.min(...quotes.value.map(q => parseFloat(q.total_price))) || 0)) / (maxPrice.value - (Math.min(...quotes.value.map(q => parseFloat(q.total_price))) || 0))) * 100
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
