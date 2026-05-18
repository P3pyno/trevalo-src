<template>
  <Teleport to="body">
    <div class="fixed top-4 right-4 z-[9998] space-y-2 w-80 pointer-events-none">
      <TransitionGroup name="toast">
        <div v-for="n in notifications" :key="n.id"
          class="pointer-events-auto bg-white rounded-2xl shadow-xl border border-gray-100 p-4 flex items-start gap-3">
          <!-- Icon -->
          <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
            :class="{
              'bg-blue-50':   n.type === 'message',
              'bg-gold-50':   n.type === 'quote',
              'bg-green-50':  n.type === 'status',
              'bg-navy-50':   n.type === 'request',
              'bg-gray-50':   !['message','quote','status','request'].includes(n.type),
            }">
            <!-- Message icon -->
            <svg v-if="n.type === 'message'" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <!-- Quote icon -->
            <svg v-else-if="n.type === 'quote'" class="w-4 h-4 text-gold-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <!-- Status icon -->
            <svg v-else-if="n.type === 'status'" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <!-- Request icon -->
            <svg v-else class="w-4 h-4 text-navy-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </div>
          <!-- Text -->
          <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold text-navy-700 leading-tight">{{ n.title }}</div>
            <div v-if="n.body" class="text-xs text-gray-500 mt-0.5 truncate">{{ n.body }}</div>
          </div>
          <!-- Dismiss -->
          <button @click="dismiss(n.id)" class="flex-shrink-0 text-gray-300 hover:text-gray-500 transition-colors mt-0.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<script setup>
import { useNotifications } from '@/composables/useNotifications'
const { notifications, dismiss } = useNotifications()
</script>

<style scoped>
.toast-enter-active { transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
.toast-leave-active { transition: all 0.2s ease; }
.toast-enter-from   { opacity: 0; transform: translateX(100%); }
.toast-leave-to     { opacity: 0; transform: translateX(100%); }
.toast-move         { transition: transform 0.3s ease; }
</style>
