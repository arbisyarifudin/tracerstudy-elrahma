<template>
  <aside
    class="
      sidebar
      bg-gray-900
      fixed
      h-full
      z-50
      w-[78px]
      md:w-1/6
      top-0
      left-0
      transition-all
      ease-out-out
      text-white
    "
    :class="[closed ? 'closed md:w-[78px]' : '']"
  >
    <button @click="closed = !closed">Toggle</button>
    <div class="logo-details h-10 w-full flex items-center">
      <i
        class="
          bx
          bxl-c-plus-plus
          min-w-[78px]
          h-10
          text-xl text-center
          !leading-10
        "
      ></i>
      <span
        class="logo_name text-xl font-semibold transition ease-out duration-300"
        :class="[
          closed ? 'opacity-0 delay-0 pointer-events-none' : 'delay-100',
        ]"
        >KPTracerStudy</span
      >
    </div>
    <ul
      class="nav-links h-full pt-7 px-0 pb-36"
      :class="[closed ? 'overflow-visible' : 'overflow-auto']"
    >
      <li
        class="relative transition-all duration-300 ease-out hover:bg-slate-800"
      >
        <a href="#" class="flex items-center">
          <i
            class="
              bx bx-grid-alt
              h-10
              min-w-[78px]
              text-center
              !leading-10
              text-xl
              cursor-pointer
              transition-all
              duration-300
              ease-out
            "
          ></i>
          <span
            class="
              link_name
              text-lg
              font-normal
              transition-all
              duration-300
              ease-out
            "
            :class="[closed ? 'opacity-0 pointer-events-none' : '']"
            >Dashboard</span
          >
        </a>
        <ul
          class="sub-menu blank bg-slate-800 absolute left-[100%]"
          :class="[
            closed
              ? '-top-3 mt-0 py-3 px-5 opacity-0 block pointer-events-none transition duration-[0s] rounded-r-md'
              : 'opacity-100 pointer-events-auto pt-2 pr-2 pb-4 pl-20',
          ]"
        >
          <li>
            <a
              class="link_name"
              :class="[closed ? 'text-lg opacity-100 block' : 'hidden']"
              href="#"
              >Category</a
            >
          </li>
        </ul>
      </li>
      <li
        class="relative transition-all duration-300 ease-out hover:bg-slate-800"
      >
        <div
          class="iocn-link items-center justify-between"
          :class="[closed ? 'block' : 'flex']"
        >
          <a href="#" class="flex items-center">
            <i
              class="
                bx bx-collection
                h-10
                min-w-[78px]
                text-center
                !leading-10
                text-xl
                cursor-pointer
                transition-all
                duration-300
                ease-out
              "
            ></i>
            <span
              class="
                link_name
                text-lg
                font-normal
                transition-all
                duration-300
                ease-out
              "
              :class="[closed ? 'opacity-0 pointer-events-none' : '']"
              >Category</span
            >
          </a>
          <i
            class="
              bx
              bxs-chevron-down
              arrow
              h-10
              min-w-[78px]
              text-center
              !leading-10
              text-xl
              cursor-pointer
              transition-all
              duration-300
              ease-out
            "
            :class="[closed ? '!hidden' : 'inline']"
          ></i>
        </div>
        <ul
          class="sub-menu bg-slate-800 absolute left-[100%]"
          :class="[
            closed
              ? '-top-3 mt-0 py-3 px-5 opacity-0 block pointer-events-none transition duration-[0s] rounded-r-md'
              : 'pt-2 pr-2 pb-4 pl-20',
          ]"
        >
          <li>
            <a
              class="
                link_name
                text-lg
                py-2
                whitespace-nowrap
                opacity-100
                hover:opacity-100
                transition-all
                duration-300
                ease-out
              "
              :class="[closed ? 'text-lg opacity-100 block' : 'hidden']"
              href="#"
              >Category</a
            >
          </li>
          <li>
            <a
              href="#"
              class="
                block
                text-base
                py-2
                whitespace-nowrap
                opacity-60
                hover:opacity-100
                transition-all
                duration-300
                ease-out
              "
              >HTML & CSS</a
            >
          </li>
          <li>
            <a
              href="#"
              class="
                block
                text-base
                py-2
                whitespace-nowrap
                opacity-60
                hover:opacity-100
                transition-all
                duration-300
                ease-out
              "
              >JavaScript</a
            >
          </li>
          <li>
            <a
              href="#"
              class="
                block
                text-base
                py-2
                whitespace-nowrap
                opacity-60
                hover:opacity-100
                transition-all
                duration-300
                ease-out
              "
              >PHP & MySQL</a
            >
          </li>
        </ul>
      </li>
    </ul>
  </aside>
</template>

<script setup>
defineProps({
  closed: {
    type: Boolean,
    default: true,
  },
});
</script>

<style lang="scss" scoped>
.sidebar {
  /* width: 260px; */
  /* transition: all 0.5s ease-out; */
  @media (max-width: 400px) {
    &.closed {
      left: -78px;
    }
  }
  .nav-links {
    @media (max-width: 400px) {
      overflow: visible;
      li .link_name {
        display: block !important;
      }
      .sub-menu {
        padding-left: 20px;
        top: 0;
        left: 100%;
      }
    }
  }
  &.closed {
    width: 78px;
    .nav-links {
      li:hover {
        .sub-menu {
          top: 0;
          opacity: 1 !important;
          pointer-events: auto;
          transition: all 0.4s ease-out;
        }
      }
    }
  }
}
</style>