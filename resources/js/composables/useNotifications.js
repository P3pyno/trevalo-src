import { ref } from 'vue'

const notifications = ref([])
let nextId = 1

export function useNotifications() {
  function push(type, title, body = '') {
    const id = nextId++
    notifications.value.unshift({ id, type, title, body, at: new Date() })
    // Auto-dismiss after 6 s
    setTimeout(() => dismiss(id), 6000)
  }

  function dismiss(id) {
    notifications.value = notifications.value.filter(n => n.id !== id)
  }

  return { notifications, push, dismiss }
}
