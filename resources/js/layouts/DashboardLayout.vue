<template>
  <div class="flex flex-1">
    <Sidebar :closed="closed" />
    <Main :closed="closed" @closeSidebar="onCloseSidebar">
      <router-view></router-view>
    </Main>
  </div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue';
import Main from '@/components/Main.vue';
import { ref } from '@vue/reactivity';

const closed = ref(false);
const onCloseSidebar = () => {
  closed.value = !closed.value;
};
</script>

<style scoped>
.sidebar.closed ~ .main {
  left: 78px;
  width: calc(100% - 78px);
}
@media (max-width: 400px) {
  .sidebar.closed ~ .main {
    width: 100%;
    left: 0;
  }
}
</style>