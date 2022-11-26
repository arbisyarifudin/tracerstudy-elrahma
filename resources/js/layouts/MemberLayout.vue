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
                :to="{ name: 'Member Dashboard Page' }"
                class="
                  flex
                  items-center
                  hover:text-slate-300
                  transition-all
                  duration-300
                "
                >Dashboard</router-link
              >
            </li>
            <li>
              <router-link
                :to="{ name: 'Member Alumni List Page' }"
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
                :to="{ name: 'Member Information List Page' }"
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
                :to="{ path: 'contact' }"
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
            <li>
              <router-link
                :to="{ name: 'Login Page' }"
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
                "
                ><ph-sign-in class="mr-1" /> Login</router-link
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
</template>

<script setup>
import { ref } from '@vue/reactivity';

const show = ref(false);

const toggleMenu = () => {
  show.value = !show.value;
};
</script>