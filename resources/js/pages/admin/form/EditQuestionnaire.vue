<template>
  <div class="rounded-xl border shadow-xl p-6 bg-white">
    <div class="mb-3 border-b pb-3 flex items-center justify-between">
      <h3 class="text-2xl font-semibold">
        Kelola Kuisioner
        <span class="text-sm text-gray-500">/ {{ detailData.name }}</span>
      </h3>
      <Button
        label="Kembali"
        icon="arrow-fat-line-left"
        size="xs"
        variant="secondary"
        @click="$router.push({ name: 'Form List Page' })"
      />
    </div>
    <form @submit.prevent="onSubmit" @keyup.enter="onSubmit">
      <div class="max-w-6xl">
        <section
          v-for="(section, sectionIndex) in state.sections"
          :key="sectionIndex"
        >
          <div
            class="
              bg-white
              p-6
              border
              rounded-lg
              mb-5
              shadow-lg
              flex
              items-start
            "
          >
            <div
              class="
                bg-red-500
                text-white
                px-2
                rounded-lg
                inline
                text-lg
                font-semibold
                min-w-8
                text-center
                mr-3
                mt-2
              "
            >
              <!-- {{ question.code }} -->
              {{ sectionIndex + 1 }}
            </div>
            <div class="">
              <div class="text-2xl font-semibold">{{ section.title }}</div>
              <div
                class="text-lg font-normal mt-2 mb-3"
                v-if="section.description"
              >
                {{ section.description }}
              </div>
            </div>
          </div>
          <div class="text-xl font-semibold mb-4">Pertanyaan:</div>
          <div
            class="bg-white p-6 border rounded-lg shadow-lg mb-8"
            v-for="(question, questionIndex) in section.questions"
            :key="questionIndex"
          >
            <div class="flex items-start w-full">
              <div
                class="
                  bg-lime-500
                  text-white
                  px-2
                  rounded-lg
                  inline
                  text-sm
                  font-semibold
                  min-w-8
                  text-center
                  mr-3
                  mt-2
                "
              >
                <!-- {{ question.code }} -->
                {{ sectionIndex + 1 + '-' + (questionIndex + 1) }}
              </div>
              <div class="flex-1">
                <div class="flex space-x-5">
                  <Input
                    class="w-3/4"
                    underline
                    filled
                    placeholder="Tulis Pertanyaan"
                    v-model="question.text"
                  />
                  <Select
                    class="w-1/4"
                    v-model="question.type"
                    :options="questionTypeOptions"
                  />
                </div>
                <div
                  v-if="question.type === 'text'"
                  class="
                    p-2
                    border-b border-dashed border-gray-300
                    text-gray-500 text-sm
                  "
                >
                  Teks jawaban singkat
                </div>
                <div
                  v-if="question.type === 'number'"
                  class="
                    p-2
                    border-b border-dashed border-gray-300
                    text-gray-500 text-sm
                  "
                >
                  Jawaban nomor
                </div>
                <div
                  v-else-if="question.type === 'textarea'"
                  class="
                    p-2
                    border-b border-dashed border-gray-300
                    text-gray-500 text-sm
                    h-16
                  "
                >
                  Teks jawaban panjang
                </div>
                <ul
                  class="text-base text-gray-700 space-y-2"
                  v-else-if="question.type === 'radio'"
                >
                  <li
                    v-for="(option, optionIndex) in question.question_options"
                    :key="optionIndex"
                  >
                    <label
                      :for="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                    >
                      <input
                        type="radio"
                        :name="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                      />
                      &nbsp; {{ option.text }}</label
                    >
                  </li>
                  <li>
                    <label for="">
                      <input type="radio" disabled /> &nbsp;
                      <span class="text-gray-500 cursor-pointer hover:underline"
                        >Tambahkan opsi</span
                      >
                      atau
                      <span class="text-blue-500 cursor-pointer"
                        >tambahkan "Lainnya"</span
                      >
                    </label>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div class="bg-gray-100 p-2 border rounded-lg shadow-sm mb-[50px]">
            <div class="flex justify-end">
              <Button
                variant="secondary"
                outline
                label="Tambah Section"
                size="sm"
                icon="plus"
              />
            </div>
          </div>
        </section>
      </div>

      <div class="mt-5 flex items-center md:flex-nowrap flex-wrap md:space-x-4">
        <!-- <Button
          class="w-full justify-center mb-3"
          variant="primary"
          outline
          type="reset"
          label="Reset Data"
        /> -->
        <Button
          class="justify-center mb-3"
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

const state = ref({});

const errors = ref({});

const questionTypeOptions = ref([
  {
    label: 'Jawaban singkat',
    // value: 'single-line text',
    value: 'text',
  },
  {
    label: 'Jawaban nomor',
    value: 'number',
  },
  {
    label: 'Jawaban Panjang',
    // value: 'multiple-line text',
    value: 'textarea',
  },
  {
    label: 'Pilihan Ganda',
    value: 'radio',
  },
  {
    label: 'Kotak Centang',
    value: 'checkbox',
  },
  {
    label: 'Drop-down',
    // value: 'dropdown',
    value: 'select',
  },
  {
    label: 'Skala linier',
    // value: 'linear scale',
    value: 'rating',
  },
  {
    label: 'Tanggal',
    value: 'date',
  },
  {
    label: 'Waktu',
    value: 'time',
  },
  {
    label: 'Tahun',
    value: 'year',
  },
]);

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
    .get('api/form/' + detailData.value.id + '/detail')
    .then((response) => {
      console.log('res', response.data);
      detailData.value = response.data.data;
      state.value = { ...detailData.value };
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      } else {
        showAlert('Data not found!');
      }
      return $router.replace({ name: 'Form List Page' });
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
    return $router.replace({ name: 'Form List Page' });
  }
  detailData.value.id = $route.params.id;
  getDetail();
});

const onSubmit = () => {
  showLoading(true);
  loading.value = true;
  axios
    .put('api/alumni/' + detailData.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showAlert('Formulir berhasil diperbarui!', { type: 'success' });
      $router.push({ name: 'Form List Page' });
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