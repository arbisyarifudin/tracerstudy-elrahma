import { useAuthStore } from '@/store/auth'
import AuthService from '@/services/auth.service'

export default async function guest({ next, router }) {
  const authStore = useAuthStore()
  if (authStore.isAuth === true) {
    await router.push({ name: 'Login Page' })
  } else {
    AuthService.profile().then(async (response) => {
      authStore.setUserProfile(response.data)
      authStore.setIsAuth(true)
      if (authStore.userProfile?.type === 'Administrator') {
        await router.push({ name: 'Dashboard Page' })
      } else {
        await router.push({ name: 'Alumni Dashboard Page' })
      }
    })
  }

  return next()
}
