<template>
  <div
    class="
      banner
      h-full
      min-h-[calc(100vh-220px)]
      flex flex-col flex-1
      items-center
      justify-center
      md:p-8
      p-4
      rounded-lg
    "
  >
    <h2
      class="
        text-5xl
        font-bold
        text-white
        uppercase
        text-center
        leading-tight
        mb-5
      "
    >
      Kirimkan data diri, <br />
      jalin relasi antar alumni.
    </h2>
    <p class="text-white mb-8">
      Lorem ipsum dolor sit amet consectetur adipisicing elit.
    </p>
    <Button label="Daftar Sekarang" size="sm" class="rounded-3xl px-7" />
  </div>
</template>

<script setup>
import Button from '@/components/UI/Button.vue';
</script>

<style lang="scss" scoped>
</style>
