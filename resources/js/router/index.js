import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/pages/Home.vue'),
    meta: { title: 'Trivalo Sourcing — Global Sourcing from China' },
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('@/pages/About.vue'),
    meta: { title: 'About Us — Trivalo Sourcing' },
  },
  {
    path: '/services',
    name: 'services',
    component: () => import('@/pages/Services.vue'),
    meta: { title: 'Our Services — Trivalo Sourcing' },
  },
  {
    path: '/how-it-works',
    name: 'how-it-works',
    component: () => import('@/pages/HowItWorks.vue'),
    meta: { title: 'How It Works — Trivalo Sourcing' },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('@/pages/Contact.vue'),
    meta: { title: 'Contact Us — Trivalo Sourcing' },
  },
  {
    path: '/auth',
    name: 'auth',
    component: () => import('@/pages/Auth.vue'),
    meta: { title: 'Sign In — Trivalo Sourcing', hideLayout: true, guestOnly: true },
  },
  {
    path: '/verify-email/:id/:hash',
    name: 'verify-email',
    component: () => import('@/pages/VerifyEmail.vue'),
    meta: { title: 'Verify Email — Trivalo Sourcing', hideLayout: true },
  },
  {
    path: '/quote',
    name: 'quote',
    component: () => import('@/pages/Quote.vue'),
    meta: { title: 'Get a Quote — Trivalo Sourcing' },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/pages/Dashboard.vue'),
    meta: { title: 'Dashboard — Trivalo Sourcing', hideLayout: true, requiresAuth: true },
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import('@/pages/Profile.vue'),
    meta: { title: 'My Profile — Trivalo Sourcing', requiresAuth: true },
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import('@/pages/AdminDashboard.vue'),
    meta: { title: 'Admin — Trivalo Sourcing', hideLayout: true, requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/privacy',
    name: 'privacy',
    component: () => import('@/pages/Privacy.vue'),
    meta: { title: 'Privacy Policy — Trivalo Sourcing' },
  },
  {
    path: '/terms',
    name: 'terms',
    component: () => import('@/pages/Terms.vue'),
    meta: { title: 'Terms of Service — Trivalo Sourcing' },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0 }
  },
})

router.beforeEach((to) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return { name: 'auth', query: { redirect: to.fullPath } }
  }

  if (to.meta.requiresAdmin && !auth.user?.is_admin) {
    return { name: 'dashboard' }
  }

  if (to.meta.guestOnly && auth.isAuthenticated) {
    return { name: 'dashboard' }
  }
})

router.afterEach((to) => {
  document.title = to.meta.title || 'Trivalo Sourcing'
})

export default router
