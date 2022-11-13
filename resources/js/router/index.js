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
        component: () => import('@/pages/admin/major/List.vue')
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
        component: () => import('@/pages/admin/alumni/List.vue')
      },
      {
        path: 'alumni/add',
        name: 'Alumni Add Page',
        meta: {
          title: 'Tambah Alumni'
        },
        component: () => import('@/pages/admin/alumni/Add.vue')
      },
      {
        path: 'alumni/:id/edit',
        name: 'Alumni Edit Page',
        meta: {
          title: 'Edit Alumni'
        },
        component: () => import('@/pages/admin/alumni/Edit.vue')
      },
      {
        path: 'form',
        name: 'Form List Page',
        meta: {
          title: 'Formulir'
        },
        component: () => import('@/pages/admin/form/List.vue')
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
