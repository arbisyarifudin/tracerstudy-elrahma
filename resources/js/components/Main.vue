<template>
  <main
    class="
      main
      w-5/6
      relative
      bg-slate-100
      h-screen
      transition-all
      duration-500
      ease-out
    "
  >
    <header class="main-header h-14 flex items-center">
      <i
        class="bx bx-menu text-3xl mx-4 cursor-pointer"
        @click="closeSidebar"
      ></i>
      <span class="text-2xl">Page Title</span>
    </header>
  </main>
</template>

<script setup>
import { ref } from '@vue/reactivity';
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
  left: 16.6666%;
  @media (max-width: 400px) {
    left: 78px;
    width: calc(100% - 78px);
    // z-index: 50;
  }
}
</style>