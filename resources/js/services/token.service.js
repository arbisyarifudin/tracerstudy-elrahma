class TokenService {
  getLocalRefreshToken() {
    const token = JSON.parse(localStorage.getItem('token'))
    return token?.refreshToken
  }

  getLocalAccessToken() {
    const token = JSON.parse(localStorage.getItem('token'))
    return token?.accessToken
  }

  updateLocalAccessToken(token) {
    let tokenData = JSON.parse(localStorage.getItem('token'))
    tokenData.accessToken = token
    localStorage.setItem('token', JSON.stringify(tokenData))
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
