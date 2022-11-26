import { useAuthStore } from '@/store/auth'
import AuthService from '@/services/auth.service'

export default async function auth({ from, to, next, router }) {
  const authStore = useAuthStore()
  if (authStore.isAuth === false) {
    const result = await AuthService.profile()
      .then((response) => {
        return response.data
      })
      .catch((err) => {
        return err
      })
    if (result && result.id) {
      await authStore.setUserProfile(result)
      await authStore.setIsAuth(true)
    } else {
      return next({ name: 'Login Page' })
    }
  }
  if (
    authStore.isAuth === true &&
    to.meta?.role &&
    to.meta.role !== authStore.userProfile?.type
  ) {
    if (authStore.userProfile.type === 'Administrator') {
      await router.replace({ name: 'Admin Dashboard Page' })
    } else {
      await router.replace({ name: 'Member Dashboard Page' })
    }
  }

  return next()
}
