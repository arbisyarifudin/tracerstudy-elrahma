import auth from './middleware/auth'
import guest from './middleware/guest'

const routes = [
  {
    path: '/',
    meta: {
      role: null
    },
    component: () => import('@/layouts/PublicLayout.vue'),
    children: [
      {
        path: '',
        name: 'Home Page',
        meta: {
          title: 'Beranda'
        },
        component: () => import('@/pages/Home.vue')
      }
    ]
  },
  // {
  //   path: '/about',
  //   name: 'about',
  //   component: About
  // },
  {
    path: '/auth',
    meta: {
      role: null
    },
    component: () => import('@/layouts/AuthLayout.vue'),
    children: [
      {
        path: 'login',
        name: 'Login Page',
        meta: {
          title: 'Login',
          middlewares: [guest]
        },
        component: () => import('@/pages/auth/Login.vue')
      }
    ]
  },
  {
    path: '/admin',
    meta: {
      role: 'Administrator',
      middlewares: [auth]
    },
    component: () => import('@/layouts/DashboardLayout.vue'),
    children: [
      {
        path: '',
        name: 'Dashboard Page',
        meta: {
          title: 'Dashboard'
        },
        component: () => import('@/pages/admin/Dashboard.vue')
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
        component: () => import('@/pages/admin/major-interest/List.vue')
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
        path: 'form/:id/questionnaire',
        name: 'Form Questionnaire Edit Page',
        meta: {
          title: 'Formulir - Kelola Kuisioner'
        },
        component: () => import('@/pages/admin/form/EditQuestion.vue')
      },
      {
        path: 'user',
        name: 'User List Page',
        meta: {
          title: 'Pengguna'
        },
        component: () => import('@/pages/admin/Dashboard.vue')
      }
    ]
  },
  {
    path: '/alumni',
    meta: {
      role: 'Alumni',
      middlewares: [auth]
    },
    component: () => import('@/layouts/AlumniDashboardLayout.vue'),
    children: [
      {
        path: '',
        name: 'Alumni Dashboard Page',
        meta: {
          title: 'Dashboard'
        },
        component: () => import('@/pages/alumni/Dashboard.vue')
      }
    ]
  }
]

export default routes
