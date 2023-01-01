<template>
  <div class="px-7 text-white md:max-w-3xl w-full mx-auto">
    <div class="text-2xl text-white mb-2">Kontak Kami</div>
    <p class="text-sm">
      Apabila membutuhkan bantuan atau ingin menyampaikan informasi, kritik
      serta saran. Silakan hubungi kami dengan mengisi formulir dibawah:
    </p>
    <div class="my-3 h-[1px] w-full bg-slate-500" />
    <div class="pt-4">
      <form class="" @submit.prevent="onSubmit" @keyup.enter="onSubmit">
        <Select
          label="Kategori"
          placeholder="- Pilih kategori -"
          required
          v-model="state.category"
          :options="categoryOptions"
          :errors="errors.category"
          @change="errors.category = null"
        ></Select>
        <Input
          label="Perihal / Subjek pesan"
          name="subject"
          placeholder="Tuliskan Perihal / Subjek pesan"
          required
          v-model="state.subject"
          :errors="errors.subject"
          @change="errors.subject = null"
        ></Input>
        <Input
          label="Nama Lengkap"
          name="fullname"
          placeholder="Tuliskan Nama Lengkap"
          required
          v-model="state.fullname"
          :errors="errors.fullname"
          @change="errors.fullname = null"
        ></Input>
        <Input
          label="Email Aktif"
          name="email"
          placeholder="Tuliskan Email Aktif"
          required
          v-model="state.email"
          :errors="errors.email"
          @change="errors.email = null"
        ></Input>
        <Textarea
          label="Pesan Anda"
          name="message"
          placeholder="Tuliskan pesan Anda disini..."
          required
          v-model="state.message"
          :errors="errors.message"
          @change="errors.message = null"
        ></Textarea>
        <div class="flex justify-end items-center gap-x-2 py-3">
          <Button
            variant="primary"
            type="submit"
            label="Kirim Pesan"
            icon="paper-plane-right"
            @click="onSubmit"
            :disabled="loading"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import Button from '@/components/UI/Button.vue';
import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Textarea from '@/components/UI/Textarea.vue';

import { ref } from '@vue/reactivity';

const state = ref({
  subject: '',
  fullname: '',
  email: '',
  message: '',
  attachment: null,
});
const errors = ref({
  subject: '',
  fullname: '',
  email: '',
  message: '',
  attachment: '',
});

const categoryOptions = ref([
  {
    label: 'A',
    value: 'a',
  },
]);

const loading = ref(false);

const onSubmit = () => {};
</script>