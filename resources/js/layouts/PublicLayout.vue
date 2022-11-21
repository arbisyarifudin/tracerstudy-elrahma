<template>
  <div class="bg-slate-800 min-h-screen md:px-8 md:pt-4 md:pb-2 p-4">
    <div class="max-w-7xl mx-auto">
      <nav class="flex items-center bg-slate-700 py-4 px-8 rounded-lg">
        <div class="flex items-center">
          <img
            src="@/assets/img/avatar.jpg"
            alt="logo"
            class="max-w-full w-10 h-10 rounded-full"
          />
          <h1 class="text-white text-xl uppercase ml-3 leading-4">
            <span class="text-base">Elrahma</span><br /><strong
              >Tracer Study</strong
            >
          </h1>
        </div>
        <div class="ml-auto">
          <ul class="text-white flex items-center space-x-7">
            <li>
              <a
                href="#"
                class="hover:text-slate-300 transition-all duration-300"
                >Beranda</a
              >
            </li>
            <li>
              <a
                href="#"
                class="hover:text-slate-300 transition-all duration-300"
                >Alumni</a
              >
            </li>
            <li>
              <a
                href="#"
                class="hover:text-slate-300 transition-all duration-300"
                >Login</a
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
        <div>Arbi Syarifudin &copy; KP 2022</div>
        <div>
          <ul class="flex items-center space-x-3">
            <li>
              <a
                href="#"
                class="
                  text-slate-300
                  hover:text-slate-50
                  transition-all
                  duration-300
                "
                ><ph-facebook-logo weight="fill" :size="25"></ph-facebook-logo
              ></a>
            </li>
            <li>
              <a
                href="#"
                class="
                  text-slate-300
                  hover:text-slate-50
                  transition-all
                  duration-300
                "
                ><ph-instagram-logo weight="fill" :size="25"></ph-instagram-logo
              ></a>
            </li>
          </ul>
        </div>
      </footer>
    </div>
  </div>
</template>