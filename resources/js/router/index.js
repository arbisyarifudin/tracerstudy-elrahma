import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/pages/Home.vue'
import About from '@/pages/About.vue'
import Dashboard from '@/pages/admin/Dashboard.vue'

const routes = [
  {
    path: '/',
    name: 'home'
    // component: () => import('@/layouts/DashboardLayout.vue')
  },
  {
    path: '/about',
    name: 'about',
    component: About
  },
  {
    path: '/admin',
    component: () => import('@/layouts/DashboardLayout.vue'),
    children: [
      {
        path: '',
        name: 'Dashboard Page',
        meta: {
          title: 'Dashboard'
        },
        component: Dashboard
      },
      {
        path: 'batch',
        name: 'Batch List Page',
        meta: {
          title: 'Angkatan'
        },
        component: () => import('@/pages/admin/batch/List.vue')
      },
      {
        path: 'major',
        name: 'Major List Page',
        meta: {
          title: 'Program Studi'
        },
        component: Dashboard
      },
      {
        path: 'major-interest',
        name: 'Major Interest List Page',
        meta: {
          title: 'Peminatan'
        },
        component: Dashboard
      },
      {
        path: 'alumni',
        name: 'Alumni List Page',
        meta: {
          title: 'Alumni'
        },
        component: Dashboard
      },
      {
        path: 'user',
        name: 'User List Page',
        meta: {
          title: 'Pengguna'
        },
        component: Dashboard
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
