<template>
  <div class="rounded-xl border shadow-xl p-6 bg-white">
    <div class="mb-3 border-b pb-3 flex items-center justify-between">
      <h3 class="text-2xl font-semibold">
        Edit Alumni
        <span class="text-sm text-gray-500">/ NIM: {{ detailData.nim }}</span>
      </h3>
      <Button
        label="Kembali"
        icon="arrow-fat-line-left"
        size="xs"
        variant="secondary"
        @click="$router.push({ name: 'Alumni List Page' })"
      />
    </div>
    <form @submit.prevent="onSubmit" @keyup.enter="onSubmit">
      <Input
        label="NIM"
        placeholder="Tuliskan NIM"
        required
        v-model="state.nim"
        :errors="errors.nim"
        @change="errors.nim = null"
      ></Input>
      <Input
        label="Nama Lengkap"
        placeholder="Tuliskan nama lengkap"
        required
        v-model="state.fullname"
        :errors="errors.fullname"
        @change="errors.fullname = null"
      ></Input>
      <Select
        label="Jenis Kelamin"
        placeholder="- Pilih jenis kelamin -"
        required
        v-model="state.gender"
        :options="genderOptions"
        :errors="errors.gender"
        @change="errors.gender = null"
      ></Select>
      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="w-full md:w-1/3">
          <Input
            label="Tempat Lahir"
            placeholder="Tulis tempat lahir"
            v-model="state.place_of_birth"
            :errors="errors.place_of_birth"
            @change="errors.place_of_birth = null"
          ></Input>
        </div>
        <div class="w-full md:w-2/3">
          <Input
            label="Tanggal Lahir"
            placeholder="Pilih tanggal lahir"
            type="date"
            v-model="state.date_of_birth"
            :errors="errors.date_of_birth"
            @change="errors.date_of_birth = null"
          ></Input>
        </div>
      </div>
      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="w-full md:w-1/2">
          <Select
            label="Provinsi"
            placeholder="- Pilih provinsi -"
            v-model="state.province_id"
            :options="provinceOptions"
            :errors="errors.province_id"
            @change="
              errors.province_id = null;
              state.regency_id = null;
            "
          ></Select>
        </div>
        <div class="w-full md:w-1/2">
          <Select
            label="Kota / Kabupaten"
            placeholder="- Pilih kota / kabupaten -"
            v-model="state.regency_id"
            :options="regencyOptions"
            :errors="errors.regency_id"
            :disabled="!state.province_id"
            @change="errors.regency_id = null"
          ></Select>
        </div>
      </div>
      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="w-full md:w-1/2">
          <Input
            label="Nomor HP"
            placeholder="Tulis nomor HP"
            type="number"
            v-model="state.phone_number"
            :errors="errors.phone_number"
            @change="errors.phone_number = null"
          ></Input>
        </div>
        <div class="w-full md:w-1/2">
          <Input
            label="Nomor WhatsApp"
            placeholder="Tulis nomor WhatsApp"
            type="number"
            v-model="state.wa_number"
            :errors="errors.wa_number"
            @change="errors.wa_number = null"
          ></Input>
        </div>
      </div>
      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="w-full md:w-1/2">
          <Select
            label="Tahun Masuk"
            placeholder="- Pilih tahun angkatan -"
            required
            v-model="state.batch_id"
            :options="batchOptions"
            :errors="errors.batch_id"
            @change="errors.batch_id = null"
          ></Select>
        </div>
        <div class="w-full md:w-1/2">
          <Input
            label="Tahun Lulus"
            placeholder="Tulis tahun lulus"
            type="number"
            required
            v-model="state.graduate_year"
            :errors="errors.graduate_year"
            @change="errors.graduate_year = null"
          ></Input>
        </div>
      </div>
      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="w-full md:w-1/2">
          <Select
            label="Program Studi"
            placeholder="- Pilih program studi -"
            required
            v-model="state.major_id"
            :options="majorOptions"
            :errors="errors.major_id"
            @change="errors.major_id = null"
          ></Select>
        </div>
        <div class="w-full md:w-1/2">
          <Input
            label="IPK"
            placeholder="Tulis IPK"
            type="number"
            v-model="state.gpa"
            :min="0.0"
            :max="4.0"
            :step="0.1"
            :errors="errors.gpa"
            @change="errors.gpa = null"
          ></Input>
        </div>
      </div>
      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="flex-none mb-3">
          <img
            src="/images/avatar.jpg"
            alt="photo"
            class="max-w-full w-[200px] h-[200px]"
          />
        </div>
        <div class="w-full mb-3">
          <Input
            label="Foto"
            type="file"
            :errors="errors.photo"
            @change="errors.photo = null"
          ></Input>
        </div>
      </div>

      <hr class="my-4" />

      <h3 class="mb-3 text-2xl font-semibold">Kredensial</h3>

      <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
        <div class="w-full md:w-1/2">
          <Input
            label="Email"
            placeholder="Tulis Email"
            type="email"
            hint="Jika diisi maka email tersebut akan dikirimi email
            pemberitahuan."
            v-model="state.email"
            :errors="errors.email"
            @change="errors.email = null"
          ></Input>
        </div>
        <div class="w-full md:w-1/2">
          <Input
            label="Password"
            placeholder="Tulis Password"
            hint="Kosongkan jika tidak diubah."
            type="password"
            v-model="state.password"
            :errors="errors.password"
            @change="errors.password = null"
          ></Input>
        </div>
      </div>

      <div class="mt-5 flex items-center md:flex-nowrap flex-wrap md:space-x-4">
        <Button
          class="w-full justify-center mb-3"
          variant="primary"
          outline
          type="reset"
          label="Reset Data"
        />
        <Button
          class="w-full justify-center mb-3"
          variant="primary"
          type="submit"
          label="Simpan"
          @click="onSubmit"
          :disabled="loading"
        />
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { inject, onMounted, watch } from '@vue/runtime-core';
const axios = inject('axios');

import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Button from '@/components/UI/Button.vue';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';
import { useRoute, useRouter } from 'vue-router';

const { showLoading } = useLoading();
const { showAlert } = useAlert();

const loading = ref(false);

const detailData = ref({
  id: null,
});

const state = ref({
  nim: '',
  fullname: '',
  gender: null,
  place_of_birth: '',
  date_of_birth: '',
  address: '',
  province_id: '',
  regency_id: '',
  phone_number: '',
  wa_number: '',
  batch_id: '',
  graduate_year: '',
  major_id: '',
  major_interest_id: null,
  gpa: 0.0,
  photo: null,
  suggestion: '',
  email: '',
  password: '',
  // is_active: false,
  // socials: [],
});

const errors = ref({
  nim: null,
  fullname: null,
  gender: null,
  place_of_birth: null,
  date_of_birth: null,
  address: null,
  province_id: null,
  regency_id: null,
  phone_number: null,
  wa_number: null,
  batch_id: null,
  graduate_year: null,
  major_id: null,
  major_interest_id: null,
  gpa: null,
  photo: null,
  suggestion: null,
  email: null,
  password: null,
  is_active: false,
});

const genderOptions = ref([
  {
    label: 'Laki-laki',
    value: 'L',
  },
  {
    label: 'Perempuan',
    value: 'P',
  },
]);

const provinceOptions = ref([]);
const regencyOptions = ref([]);
const batchOptions = ref([]);
const majorOptions = ref([]);

watch(
  () => state.value.province_id,
  (val) => {
    console.log(val);
    if (val) {
      getRegency(val);
    }
  }
);

const getDetail = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/admin/alumni/' + detailData.value.id)
    .then((response) => {
      console.log('res', response.data);
      detailData.value = response.data.data;
      state.value = { ...detailData.value };
      getMajor();
      getBatch();
      getProvince();
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      } else {
        showAlert('Data not found!');
      }
      return $router.replace({ name: 'Alumni List Page' });
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const getProvince = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/admin/province', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      console.log('res', response.data);
      provinceOptions.value = response.data.data.map((v) => {
        return {
          label: v.name,
          value: v.id,
        };
      });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const getRegency = (province_id) => {
  regencyOptions.value = [];
  showLoading(true);
  loading.value = true;
  axios
    .get('api/admin/regency', {
      params: {
        size: 500,
        page: 1,
        province_id,
      },
    })
    .then((response) => {
      console.log('res', response.data);
      regencyOptions.value = response.data.data.map((v) => {
        return {
          label: v.name,
          value: v.id,
        };
      });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const getBatch = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/admin/batch', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      console.log('res', response.data);
      batchOptions.value = response.data.data.map((v) => {
        return {
          label: v.year,
          value: v.id,
        };
      });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const getMajor = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/admin/major', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      console.log('res', response.data);
      majorOptions.value = response.data.data.map((v) => {
        return {
          label: v.name,
          value: v.id,
        };
      });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const $route = useRoute();
const $router = useRouter();
onMounted(() => {
  if (!$route.params.id) {
    showAlert('Page not found!');
    return $router.replace({ name: 'Alumni List Page' });
  }
  detailData.value.id = $route.params.id;
  getDetail();
});

const onSubmit = () => {
  showLoading(true);
  loading.value = true;
  axios
    .put('api/admin/alumni/' + detailData.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showAlert('Alumni berhasil diperbarui!', { type: 'success' });
      $router.push({ name: 'Alumni List Page' });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      } else {
        errors.value = error.response.data.errors;
        showAlert('Permintaan tidak valid! Mohon cek kembali.');
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};
</script>