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
    <form @submit.prevent="">
      <Input
        label="NIM / Username / Email:"
        placeholder="Masukkan NIM / Username / Email"
        v-model="state.username"
        :errors="errors.username"
        @change="errors.username = null"
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

const state = ref({
  username: '',
  password: '',
});
const errors = ref({
  username: null,
  password: null,
});

const loading = ref(false);
</script>