<template>
  <div
    class="
      banner
      h-full
      min-h-[calc(100vh-230px)]
      flex flex-col flex-1
      items-center
      justify-center
      md:p-8
      p-4
      rounded-lg
      md:relative
    "
  >
    <div class="flex flex-col items-center md:static md:-mt-10 absolute top-40">
      <h2
        class="
          text-2xl
          md:text-5xl
          font-bold
          text-white
          uppercase
          text-center
          leading-tight
          mb-5
        "
      >
        Selamat datang <br />di Tracer Study ELRAHMA
      </h2>
      <p
        class="text-white text-center mb-8 text-sm md:text-base tracking-wider"
      >
        Kirimkan data diri, jalin relasi dan dapatkan info seputar alumni.
      </p>
      <Button label="Daftar Sekarang" size="lg" class="rounded-3xl !px-8" />
    </div>

    <div
      class="
        flex flex-wrap
        w-full
        h-10
        md:absolute md:bottom-2 md:-translate-y-5 md:px-6
        px-3
      "
    >
      <div class="md:w-1/3 md:px-3 w-full mb-4 md:mb-0">
        <div class="bg-slate-400 rounded-lg p-4 flex items-center">
          <ph-magnifying-glass class="mr-4" :size="25" />
          <div>
            <div class="text-lg mb-1">Cari Alumni</div>
            <p class="text-xs">Cari alumni dan jalin relasi</p>
          </div>
        </div>
      </div>
      <div class="md:w-1/3 md:px-3 w-full mb-4 md:mb-0">
        <div class="bg-slate-400 rounded-lg p-4 flex items-center">
          <ph-newspaper class="mr-4" :size="25" />
          <div>
            <div class="text-lg mb-1 flex items-center">Lihat Informasi</div>
            <p class="text-xs">
              Lihat pengumuman, lowongan kerja dan informasi lainnya
            </p>
          </div>
        </div>
      </div>
      <div class="md:w-1/3 md:px-3 w-full mb-4 md:mb-0">
        <div class="bg-slate-400 rounded-lg p-4 flex items-center">
          <ph-envelope-simple class="mr-4" :size="25" />
          <div>
            <div class="text-lg mb-1">Hubungi Kampus</div>
            <p class="text-xs">Hubungi kampus, tanyakan/bagikan sesuatu</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Button from '@/components/UI/Button.vue';
</script>

<style lang="scss" scoped>
</style>
