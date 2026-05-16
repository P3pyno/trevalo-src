<template>
  <div class="space-y-6">
    <h2 class="text-2xl font-bold text-navy-700">Analytics Dashboard</h2>
    
    <div v-if="loading" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <LoadingSkeleton :count="4" />
    </div>
    
    <div v-else class="space-y-6">
      <!-- Quote Metrics -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-600">Total Quotes</h3>
            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
          </div>
          <div class="text-3xl font-bold text-navy-700">{{ analytics.quote_metrics.total }}</div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-600">Approved</h3>
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          </div>
          <div class="text-3xl font-bold text-green-600">{{ analytics.quote_metrics.approved }}</div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-600">Conversion Rate</h3>
            <svg class="w-5 h-5 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
          </div>
          <div class="text-3xl font-bold text-gold-500">{{ analytics.quote_metrics.conversion_rate }}%</div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-600">Avg Days to Quote</h3>
            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          </div>
          <div class="text-3xl font-bold text-purple-600">{{ analytics.time_metrics.avg_days_to_quote }}</div>
        </div>
      </div>
      
      <!-- Price Analytics -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <h3 class="text-lg font-bold text-navy-700 mb-4">Price Metrics</h3>
          <div class="space-y-4">
            <div>
              <div class="flex justify-between mb-1">
                <span class="text-sm text-gray-600">Average Price</span>
                <span class="text-sm font-bold text-navy-700">${{ analytics.price_metrics.average.toFixed(2) }}</span>
              </div>
              <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full" style="width: 50%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between mb-1">
                <span class="text-sm text-gray-600">Minimum Price</span>
                <span class="text-sm font-bold text-green-600">${{ analytics.price_metrics.minimum.toFixed(2) }}</span>
              </div>
              <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: 30%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between mb-1">
                <span class="text-sm text-gray-600">Maximum Price</span>
                <span class="text-sm font-bold text-red-600">${{ analytics.price_metrics.maximum.toFixed(2) }}</span>
              </div>
              <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-red-500 h-2 rounded-full" style="width: 100%"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <h3 class="text-lg font-bold text-navy-700 mb-4">Request Status Breakdown</h3>
          <div class="space-y-3">
            <div v-for="(count, status) in analytics.request_statuses" :key="status" class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full" :class="{
                  'bg-yellow-400': status === 'submitted',
                  'bg-blue-400': status === 'confirmed',
                  'bg-purple-400': status === 'in_progress',
                  'bg-green-400': status === 'delivered',
                  'bg-gold-500': status === 'shipped',
                  'bg-red-400': status === 'cancelled',
                }"></div>
                <span class="text-sm text-gray-600 capitalize">{{ status }}</span>
              </div>
              <span class="text-sm font-bold text-navy-700">{{ count }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import LoadingSkeleton from './LoadingSkeleton.vue'

const analytics = ref({
  quote_metrics: { total: 0, approved: 0, conversion_rate: 0, rejected: 0, pending: 0 },
  price_metrics: { average: 0, minimum: 0, maximum: 0 },
  time_metrics: { avg_days_to_quote: 0 },
  request_statuses: {},
  shipment_count: 0,
})
const loading = ref(true)

onMounted(async () => {
  try {
    const { data } = await axios.get('/dashboard/analytics')
    analytics.value = data
  } catch (err) {
    console.error('Failed to load analytics:', err)
  } finally {
    loading.value = false
  }
})
</script>
