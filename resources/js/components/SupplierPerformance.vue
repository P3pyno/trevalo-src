<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold text-navy-700">Supplier Performance</h2>
    
    <div v-if="loading" class="bg-white rounded-2xl shadow-sm border border-gray-100">
      <LoadingSkeleton :count="5" />
    </div>
    
    <div v-else class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div v-if="suppliers.length === 0" class="p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.936a3 3 0 01-2.868-4.06m18.864 0a9 9 0 005.964-9.217 9.003 9.003 0 00-8.716-8.288" />
        </svg>
        <p class="text-gray-500">No supplier data available</p>
      </div>
      
      <table v-else class="w-full">
        <thead>
          <tr class="bg-gray-50 border-b border-gray-100">
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Supplier</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Total Quotes</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Approval Rate</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Avg Price</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600">Rating</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr v-for="supplier in suppliers" :key="supplier.supplier_name" class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4">
              <div class="font-semibold text-navy-700">{{ supplier.supplier_name }}</div>
              <div class="text-xs text-gray-500 mt-1">{{ formatDate(supplier.first_quote_date) }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="font-bold text-navy-700">{{ supplier.quote_count }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-16 h-2 bg-gray-100 rounded-full overflow-hidden">
                  <div class="h-full bg-green-500" :style="{ width: supplier.approval_rate + '%' }"></div>
                </div>
                <div class="font-semibold text-green-600 text-sm">{{ supplier.approval_rate }}%</div>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="font-bold text-gold-500">${{ supplier.avg_price.toFixed(2) }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-1">
                <div v-for="i in 5" :key="i" class="text-lg" :class="i <= Math.round(supplier.approval_rate / 20) ? 'text-gold-400' : 'text-gray-300'">
                  ★
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import LoadingSkeleton from './LoadingSkeleton.vue'

const suppliers = ref([])
const loading = ref(true)

function formatDate(date) {
  if (!date) return '-'
  return new Date(date).toLocaleDateString()
}

onMounted(async () => {
  try {
    const { data } = await axios.get('/dashboard/supplier-performance')
    suppliers.value = data
  } catch (err) {
    console.error('Failed to load supplier performance:', err)
  } finally {
    loading.value = false
  }
})
</script>
