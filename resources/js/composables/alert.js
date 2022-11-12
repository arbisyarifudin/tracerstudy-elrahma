import { ref } from 'vue'
import { useToast } from 'vue-toastification'

export default function useAlert() {
  const toast = useToast()
  const showAlert = (message = 'Alert', opts = {}) => {
    console.log('message', message)
    toast(message, {
      ...opts,
      type: opts.type ?? 'error'
    })
  }
  return { showAlert }
}
