<template>
  <div
    class="
      flex-1
      bg-white
      rounded-lg
      shadow-md
      md:max-w-lg
      max-w-sm
      min-h-[200px]
      p-5
    "
  >
    <div class="border-b pb-3 mb-5">
      <h2 class="text-2xl font-bold">Login</h2>
    </div>
    <form @submit.prevent="onSubmit">
      <Input
        label="Username / Email:"
        placeholder="Masukkan Username / Email"
        v-model="state.unameOrEmail"
        :errors="errors.unameOrEmail"
        @change="errors.unameOrEmail = null"
        required
      ></Input>
      <Input
        label="Kata Sandi:"
        placeholder="Masukkan Kata Sandi"
        type="password"
        v-model="state.password"
        :errors="errors.password"
        @change="errors.password = null"
        required
      ></Input>
      <div class="flex mt-5">
        <Button
          class="w-full items-center justify-center"
          variant="primary"
          type="submit"
          label="Submit"
          size="md"
          :disabled="loading"
        />
      </div>
    </form>
  </div>
</template>

<script setup>
import Input from '@/components/UI/Input.vue';
import Button from '@/components/UI/Button.vue';
import { ref } from '@vue/reactivity';
import AuthService from '@/services/auth.service';
import { useRouter } from 'vue-router';
import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

const $router = useRouter();

const state = ref({
  unameOrEmail: '',
  password: '',
});
const errors = ref({
  unameOrEmail: null,
  password: null,
});

const loading = ref(false);
const { showAlert } = useAlert();
const { showLoading } = useLoading();

const onSubmit = () => {
  loading.value = true;
  showLoading(true);
  // loading.value = false;
  AuthService.login({
    unameOrEmail: state.value.unameOrEmail,
    password: state.value.password,
  })
    .then(async (res) => {
      showAlert('Login sukses!', { type: 'success' });
      if (res.type === 'Alumni') {
        await $router.push({ name: 'Alumni Dashboard Page' });
      } else {
        await $router.push({ name: 'Admin Dashboard Page' });
      }
      return res;
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      } else {
        errors.value = error.response.data.errors;
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};
</script>