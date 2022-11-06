import { ref } from 'vue'

const isLoading = ref(false)
export default function useLoading() {
  const showLoading = (state = true) => {
    isLoading.value = state
  }
  return { isLoading, showLoading }
}
