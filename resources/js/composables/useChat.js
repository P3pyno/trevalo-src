import { ref } from 'vue'

const open = ref(false)

export function useChat() {
  return {
    open,
    openChat: () => { open.value = true },
    closeChat: () => { open.value = false },
    toggleChat: () => { open.value = !open.value },
  }
}
