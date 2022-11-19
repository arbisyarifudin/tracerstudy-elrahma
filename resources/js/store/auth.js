import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth-store', {
  state: () => ({
    userProfileState: null,
    isAuthState: false
  }),
  getters: {
    userProfile: (state) => state.userProfileState,
    isAuth: (state) => state.isAuthState
  },
  actions: {
    setIsAuth(payload) {
      this.isAuthState = payload
    },
    setUserProfile(payload) {
      this.userProfileState = payload
    }
  }
})
