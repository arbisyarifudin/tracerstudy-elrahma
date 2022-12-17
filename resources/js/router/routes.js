import auth from './middleware/auth'
import guest from './middleware/guest'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/PublicLayout.vue'),
    children: [
      {
        path: '',
        name: 'Home Page',
        meta: {
          title: 'Beranda'
          // middlewares: [guest]
        },
        component: () => import('@/pages/Home.vue')
      },
      {
        path: 'alumni',
        name: 'Public Alumni Page',
        meta: {
          title: 'Alumni'
        },
        component: () => import('@/pages/Alumni.vue')
      },
      {
        path: 'information',
        name: 'Public Information Page',
        meta: {
          title: 'Alumni'
        },
        component: () => import('@/pages/Information.vue')
      },
      {
        path: 'contact',
        name: 'Public Contact Page',
        meta: {
          title: 'Contact'
        },
        component: () => import('@/pages/Contact.vue')
      }
    ]
  },
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
    component: () => import('@/layouts/AdminLayout.vue'),
    children: [
      {
        path: '',
        redirect: '/admin/dashboard'
      },
      {
        path: 'dashboard',
        name: 'Admin Dashboard Page',
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
    path: '/member',
    meta: {
      role: 'Alumni',
      middlewares: [auth]
    },
    component: () => import('@/layouts/MemberLayout.vue'),
    children: [
      {
        path: '',
        redirect: '/member/dashboard'
      },
      {
        path: 'dashboard',
        name: 'Member Dashboard Page',
        meta: {
          title: 'Dashboard'
        },
        component: () => import('@/pages/member/Dashboard.vue')
      },
      {
        path: 'biodata',
        name: 'Member Biodata Page',
        meta: {
          title: 'Profil Alumni'
        },
        component: () => import('@/pages/member/biodata/Index.vue')
      },
      {
        path: 'biodata/education',
        name: 'Member Biodata Education Page',
        meta: {
          title: 'Riwayat Pendidikan'
        },
        component: () => import('@/pages/member/biodata/Education.vue')
      },
      {
        path: 'biodata/job',
        name: 'Member Biodata Job Page',
        meta: {
          title: 'Riwayat Pekerjaan'
        },
        component: () => import('@/pages/member/biodata/Job.vue')
      },
      {
        path: 'biodata/feedback',
        name: 'Member Biodata Feedback Page',
        meta: {
          title: 'Saran & Masukan'
        },
        component: () => import('@/pages/member/biodata/Feedback.vue')
      }
    ]
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    meta: {
      title: 'Page Not Found'
    },
    path: '/:catchAll(.*)*',
    component: () => import('@/pages/error/404.vue')
  }
]

export default routes
