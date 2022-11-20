<template>
  <main
    id="main"
    class="
      main
      w-full
      relative
      bg-slate-100
      min-h-screen
      transition-all
      duration-500
      ease-out
    "
  >
    <header
      class="
        main-header
        h-14
        flex
        items-center
        px-2
        py-8
        bg-slate-800
        text-white
        bg-gradient-to-r
        from-slate-800
        to-slate-900
        justify-between
      "
    >
      <ph-list :size="28" @click="closeSidebar" class="cursor-pointer" />
      <!-- <span class="text-lg ml-2">{{ $route.meta.title }}</span> -->
      <div class="flex justify-end flex-1">
        <div class="">
          <div class="dropdown relative">
            <button
              class="w-auto flex items-center"
              type="button"
              id="dropdownButtonProfile"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <div
                class="
                  mr-3
                  hidden
                  md:flex
                  flex-col
                  justify-start
                  items-start
                  whitespace-nowrap
                "
              >
                <span class="text-xs text-gray-400">Selamat datang,</span>
                <span>{{ authStore?.userProfile?.name }}</span>
              </div>
              <img
                src="@/assets/img/avatar.jpg"
                class="w-full h-10 max-w-full rounded-full"
              />
            </button>
            <ul
              class="
                dropdown-menu
                min-w-[130px]
                absolute
                bg-white
                text-base
                z-50
                float-left
                py-2
                list-none
                text-left
                rounded-lg
                shadow-lg
                !mt-3
                hidden
                m-0
                bg-clip-padding
                border-none
              "
              aria-labelledby="dropdownButtonProfile"
            >
              <li>
                <a
                  class="
                    dropdown-item
                    flex
                    items-center
                    text-sm
                    py-2
                    px-4
                    font-normal
                    w-full
                    whitespace-nowrap
                    bg-transparent
                    text-gray-700
                    hover:bg-gray-100
                  "
                  href="#"
                  >Akun Saya</a
                >
              </li>
              <hr
                class="
                  h-0
                  my-2
                  border border-solid border-t-0 border-gray-700
                  opacity-25
                "
              />
              <li>
                <a
                  class="
                    dropdown-item
                    flex
                    items-center
                    text-sm
                    py-2
                    px-4
                    font-normal
                    w-full
                    whitespace-nowrap
                    bg-transparent
                    text-gray-700
                    hover:bg-gray-100
                  "
                  href="#"
                  @click.prevent="showLogoutDialog = true"
                  ><ph-sign-out class="mr-2" /> Keluar</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>
    <div class="bg-slate-800 pt-0">
      <div
        class="
          bg-gradient-to-r
          from-blue-900
          to-slate-800
          p-4
          shadow
          text-2xl text-white
        "
        :class="[closed ? 'rounded-none' : 'rounded-tl-3xl']"
      >
        <h3 class="font-bold pl-2">{{ $route.meta.title }}</h3>
      </div>
    </div>
    <div class="main-content px-4 py-5">
      <!-- <ul class="breadcrumb flex items-center space-x-2 text-md">
        <li>Dashboard</li>
        <li v-if="$route.meta.title">&#62;</li>
        <li v-if="$route.meta.title">{{ $route.meta.title }}</li>
      </ul> -->
      <slot />
    </div>
  </main>
  <Modal
    title="Logout Session"
    :show="showLogoutDialog"
    @close="showLogoutDialog = false"
  >
    <template #content>
      <div class="p-4">Apakah anda yakin ingin keluar?</div>
    </template>
    <template #footer>
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
        <Button
          variant="secondary"
          type="button"
          label="Batal"
          @click="showLogoutDialog = false"
        />
        <Button
          variant="danger"
          type="submit"
          label="Ya, Keluar"
          :disabled="loading"
          @click="onConfirmLogout"
        />
      </div>
    </template>
  </Modal>
</template>

<script setup>
import Modal from '@/components/UI/Modal.vue';
import Button from '@/components/UI/Button.vue';

import { ref } from '@vue/reactivity';
import { useRoute, useRouter } from 'vue-router';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

import AuthService from '@/services/auth.service';
import { useAuthStore } from '@/store/auth';
const $route = useRoute();
const $router = useRouter();

const authStore = useAuthStore();

defineProps({
  closed: {
    type: Boolean,
    default: true,
  },
});

const $emit = defineEmits(['closeSidebar']);
const closeSidebar = () => {
  $emit('closeSidebar');
};

const showLogoutDialog = ref(false);
const { showLoading } = useLoading();
const { showAlert } = useAlert();
const loading = ref(false);

const onConfirmLogout = async () => {
  showLoading(true);
  await AuthService.logout();
  showAlert('Logout sukses!', { type: 'success' });
  await $router.push({ name: 'Login Page' });
  showLoading(false);
};
</script>