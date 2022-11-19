import { useAuthStore } from '@/store/auth'
import AuthService from '@/services/auth.service'

export default async function auth({ next, router }) {
  const authStore = useAuthStore()
  if (authStore.isAuth === false) {
    AuthService.profile()
      .then((response) => {
        authStore.setUserProfile(response.data)
        authStore.setIsAuth(true)
      })
      .catch(async (err) => {
        return await router.push({ name: 'Login Page' })
      })
  }

  return next()
}
