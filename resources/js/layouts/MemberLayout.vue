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
      name: 'Member Dashboard Page',
    },
    activeName: 'Dashboard',
    expand: false,
  },
  {
    title: 'Biodata',
    icon: 'user',
    activeName: 'Biodata',
    expand: true,
    childs: [
      {
        title: 'Profil Alumni',
        path: {
          name: 'Member Biodata Page',
        },
        activeName: 'Biodata',
      },
      {
        title: 'Riwayat Pendidikan',
        path: {
          name: 'Member Biodata Education Page',
        },
        activeName: 'Biodata',
      },
      {
        title: 'Riwayat Pekerjaan',
        path: {
          name: 'Member Biodata Job Page',
        },
        activeName: 'Biodata',
      },
      {
        title: 'Saran & Masukan',
        path: {
          name: 'Member Biodata Feedback Page',
        },
        activeName: 'Biodata',
      },
    ],
  },
  {
    title: 'Tracer Study',
    icon: 'pencil',
    path: {
      name: 'Member Form Page',
    },
    activeName: 'Form',
    expand: false,
  },
  {
    title: 'Informasi',
    icon: 'newspaper',
    path: {
      // name: 'Member Information Page',
      name: 'Public Information Page',
    },
    activeName: 'Informasi',
    expand: false,
  },
  {
    title: 'Alumni',
    icon: 'users',
    path: {
      // name: 'Member Alumni Page',
      name: 'Public Alumni Page',
    },
    activeName: 'Alumni',
    expand: false,
  },
  {
    title: 'Kontak',
    icon: 'chat',
    path: {
      // name: 'Member Contact Page',
      name: 'Public Contact Page',
    },
    activeName: 'Kontak',
    expand: false,
  },
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