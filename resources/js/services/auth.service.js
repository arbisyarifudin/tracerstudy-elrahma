import api from './api'
import TokenService from './token.service'

class AuthService {
  async login({ email, password }) {
    return await api
      .post('/auth/login', {
        email,
        password
      })
      .then((response) => {
        if (response?.data?.access_token) {
          TokenService.setToken(response.data)
        }

        return response?.data
      })
  }

  logout() {
    TokenService.removeToken()
  }

  register({ uname, email, password }) {
    return api.post('/auth/register', {
      uname,
      email,
      password
    })
  }
}

export default new AuthService()
