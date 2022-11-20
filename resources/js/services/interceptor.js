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
      if (originalConfig.url !== '/api/auth/login' && err.response) {
        // Access Token was expired
        if (err.response.status === 401) {
          router.push({ name: 'Login Page' })
          //     // if (!originalConfig._retry) {
          //     //   originalConfig._retry = true
          //     //   try {
          //     //     const response = await axiosInstance.post(
          //     //       '/api/auth/refresh-token',
          //     //       {
          //     //         headers: {
          //     //           Authorization:
          //     //             'Bearer ' + TokenService.getLocalRefreshToken()
          //     //         }
          //     //       }
          //     //     )
          //     //     const { refresh_token: refreshToken } = response.data
          //     //     authStore.setRefreshToken(refreshToken)
          //     //     TokenService.updateLocalAccessToken(refreshToken)
          //     //     return axiosInstance(originalConfig)
          //     //   } catch (_error) {
          //     //     return Promise.reject(_error)
          //     //   }
          //     // }
        }
      }

      return Promise.reject(err)
    }
  )
}

export default setup
