import { defineStore } from 'pinia'

export const useNavigationStore = defineStore('navigation-store', {
  state: () => ({
    activeName: null
  }),
  getters: {
    routeActiveName: (state) => state.activeName
  },
  actions: {
    setRouteActiveName(payload) {
      this.activeName = payload
    }
  }
})
