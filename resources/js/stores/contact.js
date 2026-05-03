import { defineStore } from 'pinia'
import { ref, reactive } from 'vue'
import axios from 'axios'

export const useContactStore = defineStore('contact', () => {
  const loading = ref(false)
  const success = ref(false)
  const error = ref(null)
  const fieldErrors = ref({})

  const form = reactive({
    name: '',
    email: '',
    company: '',
    phone: '',
    message: '',
  })

  async function submitForm() {
    loading.value = true
    success.value = false
    error.value = null
    fieldErrors.value = {}

    try {
      await axios.post('/contact', { ...form })
      success.value = true
      Object.assign(form, { name: '', email: '', company: '', phone: '', message: '' })
    } catch (err) {
      if (err.response?.status === 422) {
        fieldErrors.value = err.response.data.errors || {}
      } else {
        error.value = err.response?.data?.message || 'Something went wrong. Please try again.'
      }
    } finally {
      loading.value = false
    }
  }

  function reset() {
    success.value = false
    error.value = null
    fieldErrors.value = {}
  }

  return { form, loading, success, error, fieldErrors, submitForm, reset }
})
