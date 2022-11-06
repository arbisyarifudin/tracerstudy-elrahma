import { ref } from 'vue'

export default function useAlert() {
  const showAlert = (variant = 'danger', message = 'Alert', opts = {}) => {
    console.log(message)
  }
  return { showAlert }
}
