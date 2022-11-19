import { useAuthStore } from '@/store/auth'
import axios from 'axios'

export default async function auth({ next }) {
  const authStore = useAuthStore()
  if (authStore.isAuth === false) {
    await axios
      .get('api/user/profile')
      .then((response) => {
        authStore.setUserProfile(response.data)
        authStore.setIsAuth(true)
      })
      .catch(async () => {
        return next({ name: 'Login Page' })
      })
  }

  return next()
}
