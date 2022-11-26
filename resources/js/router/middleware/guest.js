import { useAuthStore } from '@/store/auth'
import AuthService from '@/services/auth.service'

export default async function guest({ next, router }) {
  const authStore = useAuthStore()
  if (authStore.isAuth === true) {
    if (authStore.userProfile.type === 'Administrator') {
      await router.replace({ name: 'Admin Dashboard Page' })
    } else {
      await router.replace({ name: 'Member Dashboard Page' })
    }
  } else {
    AuthService.profile().then(async (response) => {
      authStore.setUserProfile(response.data)
      authStore.setIsAuth(true)
      if (authStore.userProfile.type === 'Administrator') {
        await router.replace({ name: 'Admin Dashboard Page' })
      } else {
        await router.replace({ name: 'Member Dashboard Page' })
      }
    })
  }

  return next()
}
