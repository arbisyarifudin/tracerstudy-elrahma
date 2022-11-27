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
      <Button
        label="Daftar Sekarang"
        size="lg"
        class="rounded-3xl !px-8"
        @click="isOpenDialogRegister = true"
      />
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
  <Modal
    title="Pendaftaran Alumni"
    size="lg"
    :show="isOpenDialogRegister"
    :loading="loading"
    @close="onCloseDialogRegister"
  >
    <template #content>
      <div class="p-4">
        <!-- <div class="mb-3 bg-green-200 rounded-lg p-4 text-sm">
          Lorem ipsum dolor sit amet.
        </div> -->
        <form @submit.prevent="onSubmit" @keyup.enter="onSubmit">
          <Input
            label="NIM"
            name="nim"
            placeholder="Tuliskan NIM"
            required
            v-model="state.nim"
            :errors="errors.nim"
            @change="errors.nim = null"
          ></Input>
          <Input
            label="Nama Lengkap"
            name="fullname"
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
                name="place_of_birth"
                placeholder="Tulis tempat lahir"
                required
                v-model="state.place_of_birth"
                :errors="errors.place_of_birth"
                @change="errors.place_of_birth = null"
              ></Input>
            </div>
            <div class="w-full md:w-2/3">
              <Input
                label="Tanggal Lahir"
                placeholder="Pilih tanggal lahir"
                required
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
                required
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
                required
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
                name="phone_number"
                placeholder="Tulis nomor HP"
                type="number"
                required
                v-model="state.phone_number"
                :errors="errors.phone_number"
                @change="errors.phone_number = null"
              ></Input>
            </div>
            <div class="w-full md:w-1/2">
              <Input
                label="Nomor WhatsApp"
                name="wa_number"
                placeholder="Tulis nomor WhatsApp"
                type="number"
                required
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
                name="graduate_year"
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
                name="gpa"
                placeholder="Tulis IPK"
                type="number"
                required
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
                :src="previewImage ?? previewImageDefault"
                alt="photo"
                class="max-w-full w-[200px] h-[200px] object-contain"
              />
            </div>
            <div class="w-full mb-3">
              <Input
                label="Foto"
                type="file"
                accept=".jpg,.png"
                required
                :errors="errors.photo"
                @change="handleUploadFile"
              ></Input>
            </div>
          </div>

          <hr class="my-4" />

          <h3 class="mb-3 text-2xl font-semibold">Kredensial</h3>

          <div class="flex flex-row md:space-x-4 flex-wrap md:flex-nowrap">
            <div class="w-full md:w-1/2">
              <Input
                label="Email Aktif"
                name="email"
                placeholder="Tulis email aktif"
                type="email"
                required
                v-model="state.email"
                :errors="errors.email"
                @change="errors.email = null"
              ></Input>
            </div>
            <div class="w-full md:w-1/2">
              <Input
                label="Kata sandi"
                name="password"
                placeholder="Tulis kata sandi"
                type="password"
                required
                v-model="state.password"
                :errors="errors.password"
                @change="errors.password = null"
              ></Input>
            </div>
          </div>
        </form>
      </div>
    </template>
    <template #footer>
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
        <Button
          variant="secondary"
          label="Batal"
          @click="isOpenDialogRegister = false"
        />
        <Button
          variant="primary"
          type="submit"
          label="Kirim Pendaftaran"
          @click="onSubmit"
          :disabled="loading"
        />
      </div>
    </template>
  </Modal>
</template>

<script setup>
import Button from '@/components/UI/Button.vue';
import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Modal from '@/components/UI/Modal.vue';
import { ref } from '@vue/reactivity';
import { inject, onMounted, watch } from '@vue/runtime-core';
import { useRouter } from 'vue-router';

const axios = inject('axios');
const $router = useRouter();

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

const { showLoading } = useLoading();
const { showAlert } = useAlert();

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
  email: null,
  password: null,
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

const isOpenDialogRegister = ref(false);
const loading = ref(false);

watch(
  () => state.value.province_id,
  (val) => {
    getRegency(val);
  }
);

const getProvince = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/province', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      // console.log('res', response.data);
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
  if (!province_id) return;
  regencyOptions.value = [];
  showLoading(true);
  loading.value = true;
  axios
    .get('api/regency', {
      params: {
        size: 500,
        page: 1,
        province_id,
      },
    })
    .then((response) => {
      // console.log('res', response.data);
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
    .get('api/public/batch', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      // console.log('res', response.data);
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
    .get('api/public/major', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      // console.log('res', response.data);
      majorOptions.value = response.data.data.map((v) => {
        return {
          label: v.level + ' ' + v.name,
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

onMounted(() => {
  getMajor();
  getBatch();
  getProvince();
});

const onSubmit = () => {
  showLoading(true);
  loading.value = true;
  axios
    .post('api/public/alumni', state.value)
    .then((response) => {
      console.log('res', response.data);
      showAlert('Alumni berhasil ditambahkan!', { type: 'success' });
      $router.push({ name: 'Alumni List Page' });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      } else {
        errors.value = error.response.data.errors;
        // for (const key in errors.value) {
        showAlert('Permintaan tidak valid! Mohon cek kembali.');
        //   if (Object.hasOwnProperty.call(errors.value, key)) {
        //     const msg = errors.value[key];
        //     showAlert(msg[0]);
        //   }
        // }
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const onCloseDialogRegister = () => {
  isOpenDialogRegister.value = false;
  state.value = {};
  errors.value = {};
};

/* HANDLE UPLOADED FILE */
let previewImage = ref(null);
const previewImageDefault = ref('/images/avatar.jpg');
const handleUploadFile = (e) => {
  errors.value.photo = null;
  const image = e.target.files[0];
  if (image) {
    const reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };
  } else {
    previewImage.value = null;
  }
};
</script>

<style lang="scss" scoped>
</style>
