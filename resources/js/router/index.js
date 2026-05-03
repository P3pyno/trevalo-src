import { createRouter, createWebHistory } from 'vue-router'

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
    meta: { title: 'Sign In — Trivalo Sourcing', hideLayout: true },
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

router.afterEach((to) => {
  document.title = to.meta.title || 'Trivalo Sourcing'
})

export default router
