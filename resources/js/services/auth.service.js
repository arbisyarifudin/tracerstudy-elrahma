import api from './api'
import TokenService from './token.service'

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
    return await api.post('/api/auth/logout').then((response) => {
      TokenService.removeToken()
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
