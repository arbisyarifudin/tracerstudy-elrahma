<template>
  <div class="flex flex-1">
    <Sidebar :closed="closed" :menus="menus" />
    <Main :closed="closed" @closeSidebar="onCloseSidebar">
      <router-view></router-view>
    </Main>
  </div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue';
import Main from '@/components/Main.vue';
import { ref } from '@vue/reactivity';
import { onMounted } from 'vue';

const closed = ref(false);
const onCloseSidebar = () => {
  closed.value = !closed.value;
};

const menus = ref([
  {
    title: 'Dashboard',
    icon: 'circles-four',
    path: {
      name: 'Admin Dashboard Page',
    },
    activeName: 'Dashboard',
    expand: false,
  },
  {
    title: 'Data Master',
    icon: 'database',
    activeName: 'Master',
    expand: true,
    childs: [
      {
        title: 'Angkatan',
        path: {
          name: 'Batch List Page',
        },
        activeName: 'Master',
      },
      {
        title: 'Program Studi',
        path: {
          name: 'Major List Page',
        },
        activeName: 'Master',
      },
      // {
      //   title: 'Peminatan',
      //   path: {
      //     name: 'Major Interest List Page',
      //   },
      //   activeName: 'Master',
      // },
      // {
      //   title: 'Alumni',
      //   path: {
      //     name: 'Alumni List Page',
      //   },
      //   activeName: 'Master',
      // },
    ],
  },
  {
    title: 'Alumni',
    icon: 'users-four',
    path: {
      name: 'Alumni List Page',
    },
    activeName: 'Alumni',
    expand: false,
  },
  {
    title: 'Formulir',
    icon: 'table',
    path: {
      name: 'Form List Page',
    },
    activeName: 'Formulir',
    expand: false,
  },
  // {
  //   title: 'Pengguna',
  //   icon: 'users',
  //   path: {
  //     name: 'User List Page',
  //   },
  //   activeName: 'User',
  //   expand: false,
  // },
]);

const collapseChild = () => {
  if (window.innerWidth < 768) {
    for (let i = 0; i < menus.value.length; i++) {
      menus.value[i].expand = false;
    }
  }
};

onMounted(() => {
  // listen window resize
  window.addEventListener('resize', collapseChild);
  collapseChild();
});
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