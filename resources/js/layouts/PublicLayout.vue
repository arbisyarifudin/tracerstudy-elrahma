<template>
  <div
    class="bg-slate-800 min-h-screen md:px-8 md:pt-4 md:pb-2 p-4"
    @click.stop="show = false"
  >
    <div class="max-w-7xl mx-auto border border-slate-500 rounded-lg">
      <nav class="flex items-center bg-slate-700 py-4 px-8 rounded-lg relative">
        <router-link class="flex items-center" :to="{ path: '/' }">
          <img
            src="/logo.webp"
            alt="logo"
            class="max-w-full w-10 h-10 rounded-full"
          />
          <h1 class="text-white text-xl uppercase ml-3 leading-4">
            <span class="text-base">Elrahma</span><br /><strong
              >Tracer Study</strong
            >
          </h1>
        </router-link>
        <div class="ml-auto">
          <button
            class="md:hidden text-white p-2 rounde-lg"
            @click.stop="toggleMenu"
          >
            <ph-list :size="20"></ph-list>
          </button>
          <ul
            class="
              text-left
              absolute
              bg-slate-50
              right-7
              rounded
              py-3
              pl-3
              pr-5
              text-sm text-slate-600
              space-y-1
              md:space-y-0
              md:bg-transparent
              md:text-white
              md:items-center
              md:flex
              md:static
              md:space-x-7
            "
            :class="[show ? '' : 'hidden']"
          >
            <li>
              <router-link
                :to="{ name: 'Public Alumni Page' }"
                class="
                  flex
                  items-center
                  hover:text-slate-300
                  transition-all
                  duration-300
                "
                >Alumni</router-link
              >
            </li>
            <li>
              <router-link
                :to="{ name: 'Public Information Page' }"
                class="
                  flex
                  items-center
                  hover:text-slate-300
                  transition-all
                  duration-300
                "
                >Informasi</router-link
              >
            </li>
            <li>
              <router-link
                :to="{ name: 'Public Contact Page' }"
                class="
                  flex
                  items-center
                  hover:text-slate-300
                  transition-all
                  duration-300
                "
                ><!-- <ph-phone class="mr-1" /> -->
                Kontak</router-link
              >
            </li>
            <li class="md:hidden"><hr class="bg-slate-800 my-2" /></li>
            <li v-if="!authStore.isAuth">
              <a
                class="
                  flex
                  items-center
                  hover:text-slate-300
                  md:hover:text-slate-800 md:hover:bg-slate-300
                  transition-all
                  duration-300
                  md:bg-slate-100
                  md:text-slate-800
                  md:py-2
                  md:px-4
                  md:opacity-7
                  md:rounded-lg
                  cursor-pointer
                "
                @click.prevent="openDialogLogin"
                ><ph-sign-in class="mr-1" /> Masuk</a
              >
            </li>
            <li v-else-if="authStore.isAuth">
              <router-link
                :to="{ name: 'Member Dashboard Page' }"
                class="
                  flex
                  items-center
                  hover:text-slate-300
                  md:hover:text-slate-800 md:hover:bg-slate-300
                  transition-all
                  duration-300
                  md:bg-slate-100
                  md:text-slate-800
                  md:py-2
                  md:px-4
                  md:opacity-7
                  md:rounded-lg
                  cursor-pointer
                "
                ><ph-gauge class="mr-1" /> Dashboard</router-link
              >
            </li>
          </ul>
        </div>
      </nav>
      <main class="py-8 min-h-[calc(100vh-160px)]">
        <router-view></router-view>
      </main>
      <footer
        class="
          flex
          items-center
          justify-between
          bg-slate-700
          min-h-[30px]
          py-2
          px-8
          rounded-lg
          text-white
        "
      >
        <div class="text-xs text-slate-400">Arbi Syarifudin &copy; KP 2022</div>
        <div>
          <ul class="flex items-center space-x-3">
            <li>
              <router-link
                to="#"
                class="
                  text-slate-300
                  hover:text-slate-50
                  transition-all
                  duration-300
                "
                ><ph-facebook-logo weight="fill" :size="25"
              /></router-link>
            </li>
            <li>
              <router-link
                to="#"
                class="
                  text-slate-300
                  hover:text-slate-50
                  transition-all
                  duration-300
                "
                ><ph-instagram-logo weight="fill" :size="25"
              /></router-link>
            </li>
          </ul>
        </div>
      </footer>
    </div>
  </div>
  <Modal
    title="Login Alumni"
    size="md"
    :show="isOpenDialogLogin"
    :loading="loading"
    @close="onCloseDialogLogin"
  >
    <template #content>
      <div class="p-4">
        <form @submit.prevent="onSubmitLogin" @keyup.enter="onSubmitLogin">
          <Input
            label="NIM / Email"
            name="unameOrEmail"
            placeholder="Masukan NIM atau Email"
            required
            autocomplete="off"
            v-model="stateLogin.unameOrEmail"
            :errors="errorsLogin.unameOrEmail"
            @change="errorsLogin.unameOrEmail = null"
          ></Input>
          <Input
            label="Kata Sandi"
            name="password"
            type="password"
            placeholder="Masukkan kata sandi"
            required
            autocomplete="new-password"
            v-model="stateLogin.password"
            :errors="errorsLogin.password"
            @change="errorsLogin.password = null"
          ></Input>
        </form>
      </div>
    </template>
    <template #footer>
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
        <Button
          variant="primary"
          type="submit"
          class="block w-full justify-center !py-4"
          label="Login"
          @click="onSubmitLogin"
          :disabled="loading"
        />
      </div>
    </template>
  </Modal>
</template>

<script setup>
import { VueReCaptcha, useReCaptcha } from 'vue-recaptcha-v3';

import { ref } from '@vue/reactivity';
import { computed, onMounted, watch } from '@vue/runtime-core';
import { useRouter } from 'vue-router';

import Button from '@/components/UI/Button.vue';
import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Modal from '@/components/UI/Modal.vue';

import AuthService from '@/services/auth.service';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

import { useMenuStore } from '@/store/menu';
import { useAuthStore } from '@/store/auth';

const show = ref(false);
const loading = ref(false);
const $router = useRouter();

const { showLoading } = useLoading();
const { showAlert } = useAlert();

const authStore = useAuthStore();
const menuStore = useMenuStore();

const toggleMenu = () => {
  show.value = !show.value;
};

/* LOGIN */
const stateLogin = ref({
  unameOrEmail: '',
  password: '',
  recaptchaToken: '',
});
const errorsLogin = ref({
  unameOrEmail: '',
  password: '',
});
const isOpenDialogLogin = ref(false);

const openDialogLogin = () => {
  isOpenDialogLogin.value = true;
};

const onCloseDialogLogin = () => {
  isOpenDialogLogin.value = false;
  stateLogin.value = {};
  errorsLogin.value = {};

  menuStore.setShowLoginDialog(false);
};

const onSubmitLogin = async () => {
  showLoading(true);
  loading.value = true;
  await initiateRecaptcha();
  AuthService.login({
    unameOrEmail: stateLogin.value.unameOrEmail,
    password: stateLogin.value.password,
    recaptchaToken: stateLogin.value.recaptchaToken,
  })
    .then(async (res) => {
      if (res.type === 'Alumni') {
        await $router.push({ name: 'Member Dashboard Page' });
      } else {
        await $router.push({ name: 'Admin Dashboard Page' });
      }
      showAlert('Berhasil login!', { type: 'success' });
      return res;
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
        errorsLogin.value.password = [error.response.data.message];
      } else {
        errorsLogin.value = error.response.data.errors;
        showAlert('Permintaan tidak valid! Mohon cek kembali.');
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

onMounted(() => {
  AuthService.profile().then(async (response) => {
    await authStore.setUserProfile(response.data);
    await authStore.setIsAuth(true);
  });
});

watch(
  () => menuStore.isLoginDialogShow,
  (value) => {
    isOpenDialogLogin.value = value;
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
  stateLogin.value.recaptchaToken = token;
};
</script>