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
      "
    >
      <ph-list
        :size="28"
        @click="closeSidebar"
        class="cursor-pointer md:hidden"
      />
      <!-- <span class="text-lg ml-2">{{ $route.meta.title }}</span> -->
    </header>
    <!-- <div class="p-3 bg-slate-700 text-white mt-2">{{ $route.meta.title }}</div> -->
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
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { useRoute } from 'vue-router';

const $route = useRoute();

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
</script>

<style lang="scss" scoped>
.main {
}
</style>