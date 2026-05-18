<template>
  <div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-navy-700">Quote Comparison</h3>
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
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">MOQ</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Lead Time</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Quote File</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="quote in sortedQuotes" :key="quote.id" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <div class="font-medium text-navy-700">{{ quote.supplier_name }}</div>
                <div class="text-xs text-gray-500">{{ quote.sourcing_request?.title }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="font-medium text-navy-700">{{ quote.moq?.toLocaleString() }} units</div>
              </td>
              <td class="px-6 py-4">{{ quote.lead_time }}</td>
              <td class="px-6 py-4">
                <a v-if="quote.quote_file_path" :href="`/storage/${quote.quote_file_path}`" target="_blank"
                  class="inline-flex items-center gap-1.5 text-sm font-medium text-navy-600 hover:text-navy-800">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                  </svg>
                  Download
                </a>
                <span v-else class="text-xs text-gray-500">—</span>
              </td>
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
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import LoadingSkeleton from './LoadingSkeleton.vue'

const quotes = ref([])
const loading = ref(true)

const sortedQuotes = computed(() => {
  return [...quotes.value].sort((a, b) => (a.moq || 0) - (b.moq || 0))
})

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
