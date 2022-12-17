import axiosInstance from './api'
import TokenService from './token.service'

const setup = (authStore, router) => {
  axiosInstance.interceptors.request.use(
    (config) => {
      const token = TokenService.getLocalAccessToken()
      if (token) {
        config.headers['Authorization'] = 'Bearer ' + token // for PHP back-end
        // config.headers['x-access-token'] = token // for Node.js Express back-end
      }
      return config
    },
    (error) => {
      return Promise.reject(error)
    }
  )

  axiosInstance.interceptors.response.use(
    (res) => {
      return res
    },
    async (err) => {
      const originalConfig = err.config
      if (err.response) {
        // Access Token was expired
        if (err.response.status === 401) {
          authStore.setIsAuth(false)
        }
      }

      return Promise.reject(err)
    }
  )
}

export default setup
