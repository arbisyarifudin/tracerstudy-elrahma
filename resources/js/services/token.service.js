class TokenService {
  getLocalRefreshToken() {
    const token = JSON.parse(localStorage.getItem('token'))
    return token?.refresh_token
  }

  getLocalAccessToken() {
    const token = JSON.parse(localStorage.getItem('token'))
    return token?.access_token
  }

  updateLocalAccessToken(token) {
    let tokenData = JSON.parse(localStorage.getItem('token'))
    if (tokenData) {
      tokenData.access_token = token
      localStorage.setItem('token', JSON.stringify(tokenData))
    }
  }

  getToken() {
    return JSON.parse(localStorage.getItem('token'))
  }

  setToken(token) {
    console.log(JSON.stringify(token))
    localStorage.setItem('token', JSON.stringify(token))
  }

  removeToken() {
    localStorage.removeItem('token')
  }
}

export default new TokenService()
