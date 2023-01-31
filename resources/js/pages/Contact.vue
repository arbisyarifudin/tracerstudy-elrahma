<template>
  <div class="px-7 text-white md:max-w-3xl w-full mx-auto">
    <div class="text-2xl text-white mb-2">Kontak Kami</div>
    <p class="text-sm">
      Apabila membutuhkan bantuan atau ingin menyampaikan informasi, kritik
      serta saran. Silakan hubungi kami dengan mengisi formulir dibawah:
    </p>
    <div class="my-3 h-[1px] w-full bg-slate-500" />
    <div class="pt-4">
      <form class="" @submit.prevent="onSubmit">
        <Select
          label="Kategori"
          placeholder="- Pilih kategori -"
          required
          v-model="state.category"
          :options="categoryOptions"
          :errors="errors.category"
          @change="errors.category = null"
        ></Select>
        <Input
          label="Perihal / Subjek pesan"
          name="subject"
          placeholder="Tuliskan Perihal / Subjek pesan"
          required
          v-model="state.subject"
          :errors="errors.subject"
          @change="errors.subject = null"
        ></Input>
        <Input
          label="Nama Lengkap"
          name="fullname"
          placeholder="Tuliskan Nama Lengkap"
          required
          v-model="state.fullname"
          :errors="errors.fullname"
          @change="errors.fullname = null"
        ></Input>
        <Input
          label="NIM Mahasiswa"
          name="nim"
          placeholder="Tuliskan NIM Anda"
          required
          v-model="state.nim"
          :errors="errors.nim"
          @change="errors.nim = null"
        ></Input>
        <Input
          label="Email Aktif"
          name="email"
          placeholder="Tuliskan Email Aktif"
          required
          v-model="state.email"
          :errors="errors.email"
          @change="errors.email = null"
        ></Input>
        <Textarea
          label="Pesan Anda"
          name="message"
          placeholder="Tuliskan pesan Anda disini..."
          required
          v-model="state.message"
          :errors="errors.message"
          @change="errors.message = null"
          @keyup.enter.stop="() => {}"
        ></Textarea>
        <div class="flex justify-end items-center gap-x-2 py-3">
          <Button
            variant="primary"
            type="submit"
            label="Kirim Pesan"
            icon="paper-plane-right"
            @click="onSubmit"
            :disabled="loading"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { VueReCaptcha, useReCaptcha } from 'vue-recaptcha-v3';

import Button from '@/components/UI/Button.vue';
import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Textarea from '@/components/UI/Textarea.vue';

import { ref } from '@vue/reactivity';
import { computed, inject, onMounted, watch } from '@vue/runtime-core';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

import { useAuthStore } from '@/store/auth';

const axios = inject('axios');

const { showLoading } = useLoading();
const { showAlert } = useAlert();

const authStore = useAuthStore();

const state = ref({
  subject: '',
  fullname: '',
  nim: '',
  email: '',
  message: '',
  attachment: null,
  recaptchaToken: '',
});
const errors = ref({
  subject: '',
  fullname: '',
  nim: '',
  email: '',
  message: '',
  attachment: '',
});

const categoryOptions = ref([
  {
    label: 'Bantuan',
    value: 'Bantuan',
  },
  {
    label: 'Informasi',
    value: 'Informasi',
  },
  {
    label: 'Kritik & Saran / Masukkan',
    value: 'Kritik & Saran / Masukkan',
  },
  {
    label: 'Lainnya',
    value: 'Lainnya',
  },
]);

const loading = ref(false);

const onSubmit = async () => {
  showLoading(true);
  loading.value = true;
  await initiateRecaptcha();

  axios
    .post('api/public/contact', state.value)
    .then((response) => {
      console.log('res', response.data);
      showAlert('Pesan berhasil dikirim!', { type: 'success' });
      state.value = {
        subject: '',
        fullname: '',
        email: '',
        message: '',
        attachment: null,
        recaptchaToken: '',
      };
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      } else {
        errors.value = error.response.data.errors;
        // for (const key in errors.value) {
        showAlert('Permintaan tidak valid! Mohon cek kembali.');
        //   if (Object.hasOwnProperty.call(errors.value, key)) {
        //     const msg = errors.value[key];
        //     showAlert(msg[0]);
        //   }
        // }
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

// User profile
watch(
  () => authStore.isAuth,
  (val) => {
    if (val === true) {
      state.value.fullname = authStore.userProfile.name;
      state.value.nim = authStore.userProfile.uname;
      state.value.email = authStore.userProfile.email;
    }
  }
);

/* GOOGLE RECAPTCHA v3 */
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const initiateRecaptcha = async () => {
  // (optional) Wait until recaptcha has been loaded.
  await recaptchaLoaded();
  // Execute reCAPTCHA with action "login".
  const token = await executeRecaptcha();
  // console.log(token);

  // Do stuff with the received token.
  state.value.recaptchaToken = token;
};
</script>