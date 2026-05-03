import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const user  = ref(JSON.parse(localStorage.getItem('auth_user') || 'null'))
  const token = ref(localStorage.getItem('auth_token') || null)

  const isAuthenticated = computed(() => !!token.value)

  function setSession(userData, tokenValue) {
    user.value  = userData
    token.value = tokenValue
    localStorage.setItem('auth_user',  JSON.stringify(userData))
    localStorage.setItem('auth_token', tokenValue)
    axios.defaults.headers.common['Authorization'] = `Bearer ${tokenValue}`
  }

  function clearSession() {
    user.value  = null
    token.value = null
    localStorage.removeItem('auth_user')
    localStorage.removeItem('auth_token')
    delete axios.defaults.headers.common['Authorization']
  }

  async function register(payload) {
    const { data } = await axios.post('/auth/register', payload)
    setSession(data.user, data.token)
    return data.user
  }

  async function login(payload) {
    const { data } = await axios.post('/auth/login', payload)
    setSession(data.user, data.token)
    return data.user
  }

  async function logout() {
    await axios.post('/auth/logout').catch(() => {})
    clearSession()
  }

  async function fetchProfile() {
    const { data } = await axios.get('/user')
    user.value = data
    localStorage.setItem('auth_user', JSON.stringify(data))
    return data
  }

  async function updateProfile(payload) {
    const { data } = await axios.put('/user/profile', payload)
    user.value = data.user
    localStorage.setItem('auth_user', JSON.stringify(data.user))
    return data
  }

  async function changePassword(payload) {
    const { data } = await axios.put('/user/password', payload)
    return data
  }

  async function deleteAccount(payload) {
    await axios.delete('/user', { data: payload })
    clearSession()
  }

  // Restore token header on page load
  if (token.value) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
  }

  return {
    user, token, isAuthenticated,
    register, login, logout,
    fetchProfile, updateProfile, changePassword, deleteAccount,
  }
})
