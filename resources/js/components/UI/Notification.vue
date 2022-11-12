<template>
  <notificationGroup group="foo">
    <div
      class="
        fixed
        inset-0
        flex
        px-4
        py-6
        pointer-events-none
        p-6
        items-start
        justify-end
      "
    >
      <div class="max-w-sm w-full">
        <notification v-slot="{ notifications }">
          <div v-for="notification in notifications" :key="notification.id">
            <div
              v-if="notification.type === 'info'"
              class="
                flex
                max-w-sm
                w-full
                mx-auto
                bg-white
                shadow-md
                rounded-lg
                overflow-hidden
                mt-4
              "
            >
              <div class="flex justify-center items-center w-12 bg-blue-500">
                <svg
                  class="h-6 w-6 fill-current text-white"
                  viewBox="0 0 40 40"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"
                  />
                </svg>
              </div>

              <div class="-mx-3 py-2 px-4">
                <div class="mx-3">
                  <span class="text-blue-500 font-semibold">{{
                    notification.title
                  }}</span>
                  <p class="text-gray-600 text-sm">T{{ notification.text }}</p>
                </div>
              </div>
            </div>
            <div
              class="
                flex
                max-w-sm
                w-full
                mx-auto
                bg-white
                shadow-md
                rounded-lg
                overflow-hidden
                mt-4
              "
              v-if="notification.type === 'warning'"
            >
              <div class="flex justify-center items-center w-12 bg-yellow-500">
                <svg
                  class="h-6 w-6 fill-current text-white"
                  viewBox="0 0 40 40"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"
                  />
                </svg>
              </div>

              <div class="-mx-3 py-2 px-4">
                <div class="mx-3">
                  <span class="text-yellow-500 font-semibold">{{
                    notification.title
                  }}</span>
                  <p class="text-gray-600 text-sm">{{ notification.text }}</p>
                </div>
              </div>
            </div>
          </div>
        </notification>
      </div>
    </div>
  </notificationGroup>
</template>