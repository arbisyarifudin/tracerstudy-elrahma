import { defineStore } from 'pinia'

export const useMenuStore = defineStore('menu-store', {
  state: () => ({
    isShowLoginDialogState: false
  }),
  getters: {
    isLoginDialogShow: (state) => state.isShowLoginDialogState
  },
  actions: {
    setShowLoginDialog(payload) {
      this.isShowLoginDialogState = payload
    }
  }
})
