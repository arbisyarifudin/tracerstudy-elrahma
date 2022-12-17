<template>
  <div>
    <div class="bg-white border p-3 rounded-lg">
      <h3 class="text-xl font-semibold border-b-2 pb-4">
        Mohon beri kritik, saran &amp; masukkan:
      </h3>
      <div class="mt-4">
        <Textarea
          v-model="state.suggestion"
          :rows="8"
          placeholder="Tulis disini..."
        />
        <div
          class="flex justify-between items-center gap-x-2 py-3 px-4 border-t"
        >
          <Button
            variant="primary"
            type="submit"
            label="Simpan Data"
            @click="onSubmit"
            :disabled="loading"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Button from '@/components/UI/Button.vue';
import Textarea from '@/components/UI/Textarea.vue';

import { inject, onMounted, ref, watch } from '@vue/runtime-core';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

const axios = inject('axios');

const detailData = ref([]);

const { showLoading } = useLoading();
const { showAlert } = useAlert();

const loading = ref(false);

/* DETAIL DATA */
const getFeedback = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/member/feedback')
    .then((response) => {
      state.value.suggestion = response.data?.data?.suggestion;
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      } else {
        showAlert('Data not found!');
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

onMounted(() => {
  getFeedback();
});

/* UPDATE DATA */

const state = ref({
  suggestion: '',
});

const errors = ref({
  suggestion: null,
});

const onSubmit = () => {
  loading.value = true;
  showLoading(true);
  axios
    .put('api/member/feedback', state.value)
    .then((response) => {
      console.log('res', response.data);
      showAlert('Saran & Masukan berhasil diperbarui!', {
        type: 'success',
      });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
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

<style>
</style>