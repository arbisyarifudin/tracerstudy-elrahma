<template>
  <div class="rounded-xl border shadow-xl p-6 bg-white">
    <div class="mb-3 border-b pb-3 flex items-center justify-between">
      <h3 class="text-2xl font-semibold">Tambah Alumni</h3>
      <Button
        label="Kembali"
        icon="arrow-fat-line-left"
        size="xs"
        variant="secondary"
        @click="$router.push({ name: 'Alumni List Page' })"
      />
    </div>
    <form @submit.prevent="">
      <Input
        label="NIM"
        placeholder="Tuliskan NIM"
        v-model="state.nim"
        :errors="errors.nim"
        @change="errors.nim = null"
      ></Input>
      <Input
        label="Nama Lengkap"
        placeholder="Tuliskan nama lengkap"
        v-model="state.fullname"
        :errors="errors.fullname"
        @change="errors.fullname = null"
      ></Input>
      <Select
        label="Jenis Kelamin"
        v-model="state.gender"
        :options="genderOptions"
        :errors="errors.gender"
        @change="errors.gender = null"
      ></Select>
    </form>
  </div>
</template>

<script setup>
import { ref } from '@vue/reactivity';

import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Button from '@/components/UI/Button.vue';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

const { showLoading } = useLoading();
const { showAlert } = useAlert();

const state = ref({
  nim: '',
  fullname: '',
  gender: '',
  date_of_birth: '',
  address: '',
  province_id: '',
  regency_id: '',
  entered_year: '',
  graduated_year: '',
  major_id: '',
  major_interest_id: null,
  gpa: '',
  photo: null,
  suggestion: '',
  email: '',
  password: '',
  is_active: false,
  socials: [],
});

const errors = ref({
  nim: null,
  fullname: null,
  level: null,
});

const genderOptions = ref([
  {
    label: 'Laki-laki',
    value: 'Laki-laki',
  },
  {
    label: 'Perempuan',
    value: 'Perempuan',
  },
]);

const submitBatch = () => {
  showLoading(true);
  loading.value = true;
  axios
    .post('api/major', state.value)
    .then((response) => {
      console.log('res', response.data);
    })
    .catch((error) => {
      console.log('err', error.response.data);
      if (error.response.status !== 422) {
        showAlert(error.response.message);
      } else {
        errors.value = error.response.data.errors;
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};
</script>