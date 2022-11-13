<template>
  <aside
    id="sidebar"
    class="sidebar bg-slate-800"
    :class="[closed ? 'sidebar-hide' : '']"
  >
    <div
      class="sidebar-logo bg-slate-800 flex items-center justify-center mb-3"
    >
      <span class="text-white text-lg font-bold">LOGO</span>
    </div>
    <ul class="menu flex flex-col items-start justify-center w-full">
      <li
        v-for="(menu, i) in menus"
        :key="i"
        class="
          menu-item
          flex
          items-center
          justify-center
          md:justify-start
          cursor-pointer
          h-14
          md:h-auto
          w-full
          hover:bg-slate-800
          text-slate-300
          hover:text-white
          transition
          duraton-300
          group
        "
      >
        <router-link
          v-if="!menu.childs || (menu.childs && menu.childs < 1)"
          :to="menu.path"
          class="
            flex flex-col
            w-full
            md:flex-row
            items-center
            justify-start
            md:px-4 md:py-4
          "
          :class="[routeActiveName === menu.activeName ? 'active' : '']"
        >
          <!-- <ph-circles-four :size="25" class="md:mr-3" /> -->
          <component
            :is="`ph-${menu.icon}`"
            :size="25"
            class="md:mr-3"
          ></component>
          <span
            class="font-semibold hidden md:inline-block text-xl"
            v-text="menu.title"
          ></span
        ></router-link>
        <div
          v-else
          class="
            flex flex-col
            w-full
            items-center
            md:items-start
            justify-start
            md:px-4 md:py-4
            relative
          "
          :class="[routeActiveName === menu.activeName ? 'active' : '']"
          v-click-outside="collapseChild"
        >
          <div
            class="menu-item__parent flex md:w-full"
            @click="menu.expand = !menu.expand"
          >
            <component
              :is="`ph-${menu.icon}`"
              :size="25"
              class="md:mr-3"
            ></component>
            <div class="hidden md:flex flex-1">
              <span
                class="flex-1 font-semibold text-xl"
                v-text="menu.title"
              ></span>
              <ph-caret-down
                :size="25"
                class="menu-item__caret"
                :class="menu.expand ? 'open' : ''"
              />
            </div>
          </div>
          <transition name="slide-fade" :duration="100">
            <ul
              class="
                menu-item__child
                md:pl-6
                mt-2
                leading-8
                md:w-full
                transition-all
                md:static
                absolute
                top-0
                right-0
                md:bg-transparent
                bg-slate-900
                z-20
                p-2
                rounded-r-lg
                min-w-[140px]
                translate-x-[140px]
                md:translate-x-0
              "
              v-show="menu.expand"
            >
              <li
                v-for="(submenu, i2) in menu.childs"
                :key="i2"
                class="
                  menu-item__child-item
                  text-slate-400
                  hover:text-white hover:font-semibold
                  transition-all
                  duration-200
                "
              >
                <router-link
                  :to="submenu.path"
                  class="
                    flex flex-col
                    w-full
                    md:flex-row md:items-center
                    justify-start
                  "
                >
                  <component
                    :is="`ph-${submenu.icon}`"
                    :size="25"
                    class="md:mr-3"
                  ></component>
                  <span
                    class="font-normal md:inline-block"
                    v-text="submenu.title"
                  ></span
                ></router-link>
              </li>
            </ul>
          </transition>
        </div>
      </li>
    </ul>
  </aside>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { useNavigationStore } from '@/store/navigation';
import { computed, onMounted, watch } from '@vue/runtime-core';
import { useRoute } from 'vue-router';

const $props = defineProps({
  closed: {
    type: Boolean,
    default: true,
  },
  menus: {
    type: Array,
    default: () => {
      return [];
    },
  },
});

// const menus = ref([]);

const collapseChild = () => {
  // console.log('window.innerWidth', window.innerWidth);
  if (window.innerWidth < 768) {
    for (let i = 0; i < $props.menus.value.length; i++) {
      $props.menus.value[i].expand = false;
    }
  }
};

const $route = useRoute();
const navigationStore = useNavigationStore();
const routeActiveName = computed(() => {
  return navigationStore.routeActiveName;
});
const checkRouteActiveName = () => {
  switch ($route.name) {
    case 'Dashboard Page':
      navigationStore.setRouteActiveName('Dashboard');
      break;
    case 'Batch List Page':
    case 'Major List Page':
    case 'Major Interest List Page':
      navigationStore.setRouteActiveName('Master');
      break;
    case 'Alumni List Page':
    case 'Alumni Add Page':
    case 'Alumni Edit Page':
      navigationStore.setRouteActiveName('Alumni');
      break;
    case 'User List Page':
      navigationStore.setRouteActiveName('User');
      break;
    case 'Form List Page':
      navigationStore.setRouteActiveName('Form');
      break;
    default:
      navigationStore.setRouteActiveName(null);
      break;
  }

  const findActiveMenu = $props.menus.find(
    (v) => v.activeName === routeActiveName.value
  );
  if (findActiveMenu) {
    findActiveMenu.expand = true;
  }
};

watch(
  () => $route.name,
  (val) => {
    console.log('route name:', val);
    checkRouteActiveName();
  }
);

onMounted(() => {
  checkRouteActiveName();
});
</script>

<style lang="scss" scoped>
#sidebar {
  width: calc(50px + 32px);
  transition: all 0.3s ease-out;
  &.sidebar-hide {
    width: 0;
  }
  .sidebar {
    &-logo {
      width: 100%;
      // height: calc(50px + 32px);
      height: calc(30px + 32px);
    }
  }

  .menu {
    &-item {
      > .router-link-exact-active,
      // > .router-link-active,
      > .active {
        color: #fff;
        svg {
          color: rgba(37, 99, 235, 1);
        }
      }
      &__caret {
        transition: all 0.3s ease-out;
        &.open {
          transform: rotate(-180deg);
        }
      }
      &__child {
        transition: all 0.3s ease-out;
        .router-link-exact-active {
          color: #fff;
        }
      }
    }
  }
}

@media screen and (min-width: 768px) {
  #sidebar {
    width: calc((50px * 5) + 32px);
  }
}
</style>