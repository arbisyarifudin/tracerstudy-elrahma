import api from './api'
import TokenService from './token.service'
import { useAuthStore } from '@/store/auth'
class AuthService {
  async login({ unameOrEmail, password }) {
    return await api
      .post('/api/auth/login', {
        unameOrEmail,
        password
      })
      .then((response) => {
        if (response?.data?.data?.access_token) {
          TokenService.setToken(response.data.data)
          // const authStore = useAuthStore()
          // authStore.setUserProfile(response.data.data)
          // authStore.setIsAuth(true)
        }

        return response?.data
      })
  }

  async profile() {
    return await api.get('/api/user/profile').then((response) => {
      return response?.data
    })
  }

  async logout() {
    console.log('logouting...')
    return await api.post('/api/auth/logout').then((response) => {
      TokenService.removeToken()
      const authStore = useAuthStore()
      authStore.setUserProfile(null)
      authStore.setIsAuth(false)
      return response?.data
    })
  }

  register({ uname, email, password }) {
    return api.post('/api/auth/register', {
      uname,
      email,
      password
    })
  }
}

export default new AuthService()
