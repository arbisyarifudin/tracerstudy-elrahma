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
    <form @submit.prevent="onSubmit">
      <!-- <div class="lg:max-w-6xl md:max-w-xl sm:max-w-lg"> -->
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
            <div class="w-full">
              <Input
                underline
                filled
                placeholder="Judul Section"
                v-model="section.title"
              />
              <Input
                underline
                size="xs"
                placeholder="Deskripsi (optional)"
                v-model="section.description"
              />
            </div>
          </div>
          <div class="ml-4 text-xl font-semibold mb-4">Pertanyaan:</div>
          <div
            class="ml-4 bg-white p-6 border rounded-lg shadow-lg mb-8"
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
                  <div class="w-3/4">
                    <Input
                      underline
                      filled
                      placeholder="Tulis Pertanyaan"
                      v-model="question.text"
                    />
                    <div class="flex justify-end">
                      <span
                        class="
                          flex
                          items-center
                          text-xs text-gray-400
                          cursor-pointer
                          ml-2
                        "
                        @click="question.showHint = !question.showHint"
                      >
                        <ph-plus
                          v-if="!question.showHint"
                          class="text-lime-500"
                        />
                        <ph-x v-else class="text-red-500" />
                        {{ !question.showHint ? 'Tampilkan' : 'Sembunyikan' }}
                        teks bantuan</span
                      >
                      <span
                        class="
                          flex
                          items-center
                          text-xs text-gray-400
                          cursor-pointer
                          ml-2
                        "
                        @click="
                          question.showDefaultValue = !question.showDefaultValue
                        "
                      >
                        <ph-plus
                          v-if="!question.showDefaultValue"
                          class="text-lime-500"
                        />
                        <ph-x v-else class="text-red-500" />
                        {{ !question.showDefaultValue ? 'Tambahkan' : 'Hapus' }}
                        nilai bawaan</span
                      >
                    </div>
                  </div>
                  <Select
                    class="w-1/4"
                    v-model="question.type"
                    :options="questionTypeOptions"
                  />
                </div>
                <div
                  class="mb-4 mt-2"
                  v-if="question.showHint || question.showDefaultValue"
                >
                  <div v-if="question.showHint" class="flex items-center mb-2">
                    <ph-info :size="15" class="-mt-2" />
                    <Input
                      class="pl-2 flex-1"
                      underline
                      size="xs"
                      placeholder="Teks bantuan (opsional)"
                      v-model="question.hint"
                    />
                  </div>
                  <div
                    v-if="question.showDefaultValue"
                    class="flex items-center mb-2"
                  >
                    <div class="w-1/2 flex items-center">
                      <ph-pencil-simple-line :size="15" class="-mt-2" />
                      <Input
                        class="pl-2 flex-1"
                        underline
                        size="xs"
                        placeholder="Nilai bawaan (opsional)"
                        v-model="question.default_value"
                        :disabled="question.is_default_value_editable"
                      />
                    </div>
                    <label
                      :for="`lock-default-value-${sectionIndex}-${questionIndex}`"
                      class="
                        flex
                        items-center
                        text-xs text-gray-500
                        cursor-pointer
                        ml-3
                      "
                    >
                      <input
                        :id="`lock-default-value-${sectionIndex}-${questionIndex}`"
                        type="checkbox"
                        class="mr-2 inline-block"
                        v-model="question.is_default_value_editable"
                      />
                      Kunci nilai bawaan
                    </label>
                  </div>
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
                <div v-if="question.type === 'number'">
                  <input
                    type="number"
                    class="
                      p-2
                      border-b border-dashed border-gray-300
                      text-gray-500 text-sm
                      bg-transparent
                      focus:outline-none
                    "
                    placeholder="Jawaban angka"
                  />
                </div>
                <div v-if="question.type === 'phone number'">
                  <input
                    type="number"
                    class="
                      p-2
                      border-b border-dashed border-gray-300
                      text-gray-500 text-sm
                      bg-transparent
                      focus:outline-none
                      block
                      w-auto
                      min-w-[200px]
                    "
                    placeholder="Jawaban nomor telepon"
                  />
                </div>
                <div v-if="question.type === 'date'">
                  <input
                    type="date"
                    class="
                      p-2
                      border-b border-dashed border-gray-300
                      text-gray-500 text-sm
                      bg-transparent
                      focus:outline-none
                    "
                  />
                </div>
                <div v-if="question.type === 'time'">
                  <input
                    type="time"
                    class="
                      p-2
                      border-b border-dashed border-gray-300
                      text-gray-500 text-sm
                      bg-transparent
                      focus:outline-none
                    "
                  />
                </div>
                <div v-if="question.type === 'year'">
                  <input
                    type="number"
                    :min="2000"
                    :max="maxYear"
                    :minlength="4"
                    :maxlength="4"
                    class="
                      p-2
                      border-b border-dashed border-gray-300
                      text-gray-500 text-sm
                      bg-transparent
                      focus:outline-none
                    "
                    :value="thisYear"
                  />
                </div>
                <div v-if="question.type === 'email'">
                  <input
                    type="email"
                    class="
                      p-2
                      border-b border-dashed border-gray-300
                      text-gray-500 text-sm
                      bg-transparent
                      focus:outline-none
                      w-full
                    "
                    placeholder="Jawaban email"
                    readonly
                  />
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
                    class="flex items-center justify-between"
                  >
                    <label
                      :for="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                      class="flex items-center flex-1 space-x-4 cursor-pointer"
                    >
                      <input
                        type="radio"
                        :name="`option-${sectionIndex}-${questionIndex}`"
                        disabled
                        class="w-5 h-5 pointer-events-none"
                      />
                      <Input
                        :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                        variant="secondary"
                        size="sm"
                        underline-on-hover
                        v-model="option.text"
                        class="flex-1"
                      />
                    </label>
                    <Button
                      icon="x"
                      size="xs"
                      class="
                        bg-transparent
                        text-gray-800
                        hover:bg-gray-50
                        rounded-full
                        py-2
                        text-xs
                        ml-3
                      "
                    />
                  </li>
                  <li>
                    <label
                      :for="`option-${sectionIndex}-${questionIndex}-${question.question_options.length}`"
                      class="
                        flex
                        items-center
                        flex-1
                        space-x-3
                        cursor-pointer
                        text-sm
                      "
                    >
                      <input
                        type="radio"
                        disabled
                        class="w-5 h-5 pointer-events-none"
                      />
                      &nbsp;
                      <span class="text-gray-500 cursor-pointer hover:underline"
                        >Tambahkan opsi</span
                      >
                      <span class="mx-2 inline-block">atau</span>
                      <span class="text-blue-500 cursor-pointer"
                        >tambahkan "Lainnya"</span
                      >
                    </label>
                  </li>
                </ul>
                <ul
                  class="text-base text-gray-700 space-y-2"
                  v-else-if="question.type === 'checkbox'"
                >
                  <li
                    v-for="(option, optionIndex) in question.question_options"
                    :key="optionIndex"
                    class="flex items-center justify-between"
                  >
                    <label
                      :for="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                      class="flex items-center flex-1 space-x-4 cursor-pointer"
                    >
                      <input
                        type="checkbox"
                        :name="`option-${sectionIndex}-${questionIndex}`"
                        disabled
                        class="w-5 h-5 pointer-events-none"
                      />
                      <Input
                        :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                        variant="secondary"
                        size="sm"
                        underline-on-hover
                        v-model="option.text"
                        class="flex-1"
                      />
                    </label>
                    <Button
                      icon="x"
                      size="xs"
                      class="
                        bg-transparent
                        text-gray-800
                        hover:bg-gray-50
                        rounded-full
                        py-2
                        text-xs
                        ml-3
                      "
                    />
                  </li>
                  <li>
                    <label for="">
                      <input
                        type="radio"
                        disabled
                        class="w-5 h-5 pointer-events-none"
                      />
                      &nbsp;
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
import { computed, inject, onMounted, watch } from '@vue/runtime-core';
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
    label: 'Jawaban panjang',
    // value: 'multiple-line text',
    value: 'textarea',
  },
  {
    label: 'Jawaban angka',
    value: 'number',
  },
  {
    label: 'Jawaban email',
    value: 'email',
  },
  {
    label: '───────────────',
    value: null,
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
    label: '───────────────',
    value: null,
  },
  {
    label: 'Skala linier',
    // value: 'linear scale',
    value: 'rating',
  },
  {
    label: '───────────────',
    value: null,
  },
  {
    label: 'Tanggal',
    value: 'date',
  },
  // {
  //   label: 'Waktu',
  //   value: 'time',
  // },
  {
    label: 'Tahun',
    value: 'year',
  },
]);

const thisYear = computed(() => {
  return new Date().getFullYear();
});
const maxYear = computed(() => {
  return thisYear.value + 10;
});

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