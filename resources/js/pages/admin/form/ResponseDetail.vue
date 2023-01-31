<template>
  <div class="rounded-xl border shadow-xl p-6 bg-white relative">
    <div class="mb-3 border-b pb-3 flex items-center justify-between sticky">
      <div class="block">
        <h3 class="text-xl font-semibold">Detail Response Kuisioner</h3>
        <div class="text-sm text-gray-500 mb-2">
          Dikirim melalui: {{ detailData.name }}
        </div>
        <hr />
        <div class="text-xl mt-2">
          Oleh: {{ detailData?.response?.alumni?.fullname }} /
          <span class="text-gray-500 text-lg"
            >NIM: {{ detailData?.response?.alumni?.nim }}</span
          >
        </div>
      </div>
      <div class="flex items-center space-x-3">
        <Button
          label="Kembali"
          icon="arrow-fat-line-left"
          variant="secondary"
          @click="$router.push({ name: 'Form Response List Page' })"
        />
      </div>
    </div>
    <form class="pb-5">
      <!-- <div class="lg:max-w-6xl md:max-w-xl sm:max-w-lg"> -->
      <div class="max-w-6xl">
        <div
          v-if="state.sections && state.sections.length < 1"
          class="bg-gray-100 p-2 border rounded-lg shadow-sm"
        >
          <div class="flex justify-center items-center space-x-4 px-4 py-6">
            <div>Belum ada Kuisioner.</div>
          </div>
        </div>

        <section
          v-for="(section, sectionIndex) in state.sections"
          :key="sectionIndex"
          class="form-section"
        >
          <div class="bg-white py-6 px-6 border rounded-lg mb-5 shadow-lg">
            <div class="flex items-start">
              <div
                class="
                  bg-red-500
                  text-white
                  px-2
                  rounded-lg
                  flex
                  text-lg
                  font-semibold
                  min-w-8
                  text-center
                  mr-3
                  mt-2
                "
              >
                {{ sectionIndex + 1 }}
              </div>
              <div class="w-full">
                <div class="text-2xl">{{ section.title }}</div>
                <div class="text-base text-gray-500" v-if="section.description">
                  {{ section.description }}
                </div>
              </div>
            </div>
            <div class="ml-4 form-question mt-6">
              <div class="text-base mb-4 items-center cursor-pointer">
                <span>Pertanyaan & Jawaban:</span>
              </div>
              <div
                class="bg-white py-6 px-6 rounded-lg mb-0"
                :class="`${question.additionClassNames}`"
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
                      mt-1
                    "
                  >
                    {{ sectionIndex + 1 + '-' + (questionIndex + 1) }}
                  </div>
                  <div class="flex-1 pl-2">
                    <div class="mb-3">
                      <div class="text-lg">{{ question.text }}</div>
                      <div
                        class="text-xs text-gray-400 tracking-wide mt-1"
                        v-if="question.hint"
                      >
                        {{ question.hint }}
                      </div>
                    </div>
                    <div
                      v-if="
                        question.type === 'text' ||
                        question.type === 'single-line text'
                      "
                    >
                      <Input
                        variant="secondary"
                        underline
                        filled
                        placeholder="Tulis Jawaban"
                        v-model="question.response"
                        readonly
                        :errors="errors[`questions.${question.key}.response`]"
                        @keyup="
                          errors[`questions.${question.key}.response`] = []
                        "
                      />
                    </div>
                    <div
                      v-else-if="
                        question.type === 'textarea' ||
                        question.type === 'multi-line text'
                      "
                      class="
                        p-2
                        border-b border-dashed border-gray-300
                        text-gray-500 text-sm
                        h-16
                      "
                    >
                      <Textarea
                        variant="secondary"
                        underline
                        filled
                        placeholder="Tulis Jawaban"
                        v-model="question.response"
                        readonly
                        :errors="errors[`questions.${question.key}.response`]"
                        @keyup="
                          errors[`questions.${question.key}.response`] = []
                        "
                      />
                    </div>
                    <div v-if="question.type === 'number'">
                      <Input
                        type="number"
                        variant="secondary"
                        underline
                        filled
                        placeholder="Tulis Jawaban"
                        v-model="question.response"
                        readonly
                        :errors="errors[`questions.${question.key}.response`]"
                        @keyup="
                          errors[`questions.${question.key}.response`] = []
                        "
                      />
                    </div>
                    <div v-if="question.type === 'date'">
                      <Input
                        type="date"
                        variant="secondary"
                        underline
                        filled
                        v-model="question.response"
                        readonly
                        :errors="errors[`questions.${question.key}.response`]"
                        @keyup="
                          errors[`questions.${question.key}.response`] = []
                        "
                      />
                    </div>
                    <div v-if="question.type === 'year'">
                      <Input
                        type="number"
                        :min="2000"
                        :max="maxYear"
                        :minlength="4"
                        :maxlength="4"
                        variant="secondary"
                        underline
                        filled
                        placeholder="Tulis Jawaban"
                        v-model="question.response"
                        readonly
                        :errors="errors[`questions.${question.key}.response`]"
                        @keyup="
                          errors[`questions.${question.key}.response`] = []
                        "
                      />
                    </div>
                    <div v-if="question.type === 'email'">
                      <Input
                        type="email"
                        variant="secondary"
                        underline
                        filled
                        placeholder="Tulis Jawaban"
                        v-model="question.response"
                        readonly
                        :errors="errors[`questions.${question.key}.response`]"
                        @keyup="
                          errors[`questions.${question.key}.response`] = []
                        "
                      />
                    </div>
                    <div
                      class=""
                      v-else-if="
                        question.type === 'radio' ||
                        question.type === 'multiple choice' ||
                        question.type === 'checkbox'
                      "
                    >
                      <ul class="text-base text-gray-700 space-y-4">
                        <li
                          v-for="(
                            option, optionIndex
                          ) in question.question_options"
                          :key="optionIndex"
                          class="flex items-center justify-between"
                        >
                          <label
                            :for="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                            class="
                              flex
                              items-center
                              flex-1
                              space-x-4
                              cursor-pointer
                            "
                          >
                            <input
                              v-if="
                                (question.type === 'radio' ||
                                  question.type === 'multiple choice' ||
                                  question.type === 'checkbox') &&
                                !option.is_custom_value
                              "
                              :type="
                                ['radio', 'multiple choice'].includes(
                                  question.type
                                )
                                  ? 'radio'
                                  : 'checkbox'
                              "
                              :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                              :name="
                                ['radio', 'multiple choice'].includes(
                                  question.type
                                )
                                  ? `option-${sectionIndex}-${questionIndex}`
                                  : `option-${sectionIndex}-${questionIndex}[]`
                              "
                              class="w-5 h-5"
                              :value="option.value"
                              v-model="question.response"
                              readonly
                              disabled
                              @change="updateResponseOption(question)"
                            />
                            <span v-else-if="!option.is_custom_value">{{
                              optionIndex + 1
                            }}</span>
                            <div class="flex items-center w-full">
                              <div
                                v-text="option.text"
                                :class="!option.is_custom_value ? 'flex-1' : ''"
                              ></div>
                              <Input
                                v-if="option.is_custom_value"
                                class="flex-1 ml-4"
                                type="text"
                                variant="secondary"
                                underline
                                filled
                                size="sm"
                                placeholder="Tulis Jawaban Lainnya"
                                readonly
                                :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                                :name="`option-${sectionIndex}-${questionIndex}`"
                                v-model="question.responseOptionCustom"
                                @keyup="updateResponseOptionCustom(question)"
                              />
                            </div>
                          </label>
                        </li>
                        <li
                          class="hidden"
                          v-if="
                            question.question_options &&
                            question.question_options.length &&
                            (question.type === 'radio' ||
                              question.type === 'multiple choice' ||
                              question.type === 'checkbox')
                          "
                        >
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
                            <div>Lainnya:</div>
                            <Input
                              type="text"
                              variant="secondary"
                              underline
                              filled
                              size="sm"
                              placeholder="Tulis Jawaban Lainnya"
                              readonly
                              :id="`option-${sectionIndex}-${questionIndex}-${question.question_options.length}`"
                              :name="`option-${sectionIndex}-${questionIndex}`"
                              v-model="question.responseOptionCustom"
                              @keyup="updateResponseOptionCustom(question)"
                            />
                          </label>
                        </li>
                      </ul>
                      <div
                        class="text-sm text-red-500"
                        v-for="(error, i) in errors[
                          `questions.${question.key}.response`
                        ]"
                        :key="i"
                      >
                        <span v-html="error"></span>
                      </div>
                    </div>
                    <Select
                      v-else-if="
                        question.type === 'select' ||
                        question.type === 'dropdown'
                      "
                      :options="question.question_options"
                      mapOptions
                      optionLabel="text"
                      optionValue="value"
                      placeholder="-- Pilih --"
                      v-model="question.response"
                      readonly
                      disabled
                      :errors="errors[`questions.${question.key}.response`]"
                    />
                    <div
                      v-else-if="
                        (question.type === 'rating' ||
                          question.type === 'linear scale') &&
                        question.question_rate
                      "
                    >
                      <div class="mt-2">
                        <ol
                          class="
                            text-base text-gray-700
                            space-x-5
                            flex
                            items-center
                            justify-center
                          "
                        >
                          <li
                            class="flex items-center justify-between max-w-xs"
                            v-for="rate in question.question_rate.highest_rate"
                            :key="rate"
                          >
                            <label
                              :for="`option-${sectionIndex}-${questionIndex}-${rate}`"
                              class="flex flex-col items-center cursor-pointer"
                            >
                              <input
                                :id="`option-${sectionIndex}-${questionIndex}-${rate}`"
                                :name="`option-${sectionIndex}-${questionIndex}`"
                                type="radio"
                                :value="rate"
                                v-model="question.response"
                                readonly
                                disabled
                                class="w-10 h-10 mb-3 cursor-pointer"
                              />
                              <span>{{ rate }}</span>
                            </label>
                          </li>
                        </ol>
                        <div
                          class="flex items-center justify-center mt-3"
                          v-if="
                            question.question_rate.lowest_rate_label &&
                            question.question_rate.highest_rate_label
                          "
                        >
                          <b>{{ question.question_rate.lowest_rate_label }}</b>
                          <div class="mx-8">ke</div>
                          <b>{{ question.question_rate.highest_rate_label }}</b>
                        </div>
                        <div
                          class="text-sm text-red-500"
                          v-for="(error, i) in errors[
                            `questions.${question.key}.response`
                          ]"
                          :key="i"
                        >
                          <span v-html="error"></span>
                        </div>
                      </div>
                    </div>
                    <div v-else-if="question.type === 'select province'">
                      <div class="mt-2">- work in progress -</div>
                    </div>
                    <div v-else-if="question.type === 'select regency'">
                      <div class="mt-2">- work in progress -</div>
                    </div>

                    <!-- QUESTION CHILDS -->
                    <div v-else-if="question.type === 'multiple question'">
                      <QuestionChild
                        :section-index="sectionIndex"
                        :question-index="questionIndex"
                        :question="question"
                        :errors="errors"
                        @resetErrors="resetErrors"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="text-center my-3 text-gray-500">***</div>
        </section>
      </div>
    </form>
  </div>
</template>

<script setup>
import Input from '@/components/UI/Input.vue';
import Textarea from '@/components/UI/Textarea.vue';
import Select from '@/components/UI/Select.vue';
import Button from '@/components/UI/Button.vue';

import QuestionChild from './_comp/QuestionChildReadonly.vue';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';
import { useRoute, useRouter } from 'vue-router';

import { ref } from '@vue/reactivity';
import { computed, inject, onMounted, watch } from '@vue/runtime-core';

const axios = inject('axios');

const $route = useRoute();
const $router = useRouter();

const { showLoading } = useLoading();
const { showAlert } = useAlert();

const loading = ref(false);

const detailData = ref({
  id: null,
});

const state = ref({});

const errors = ref({
  sections: [],
});

const getDetail = () => {
  if (!$route.params.responseId) {
    $router.push({ name: 'Form Response List Page' });
    return;
  }

  showLoading(true);
  loading.value = true;
  axios
    .get('api/admin/form-response/' + $route.params.responseId)
    .then((response) => {
      console.log('res', response.data);
      detailData.value = response.data.data;
      state.value = { ...detailData.value };
      if (detailData.value) {
        let questionKey = -1;
        state.value.sections = state.value.sections.map((section) => {
          return {
            ...section,
            questions: section.questions.map((question) => {
              if (!question.response) {
                question.response = ['checkbox'].includes(question.type)
                  ? []
                  : '';
              }
              if (
                question.question_options.length > 0 &&
                !question.question_options.find(
                  (v) => v.value === question.response
                )
              ) {
                question.responseOptionCustom = question.response;
              }
              questionKey++;
              return {
                ...question,
                key: questionKey,
              };
            }),
          };
        });
        console.log(state.value);
      }
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      } else {
        showAlert('Data not found!');
      }
      return $router.push({ name: 'Form Response List Page' });
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

onMounted(() => {
  getDetail();
});

/* FORM */

const allowedDefaultValueTypes = [
  'text',
  'single-line text',
  'number',
  'date',
  'year',
  'email',
  'textarea',
  'multi-line text',
];

const lowRateOptions = ref([
  {
    label: '0',
    value: 0,
  },
  {
    label: '1',
    value: 1,
  },
]);

const highRateOptions = ref([
  {
    label: '2',
    value: 2,
  },
  {
    label: '3',
    value: 3,
  },
  {
    label: '4',
    value: 4,
  },
  {
    label: '5',
    value: 5,
  },
  {
    label: '6',
    value: 6,
  },
  {
    label: '7',
    value: 7,
  },
  {
    label: '8',
    value: 8,
  },
  {
    label: '9',
    value: 9,
  },
  {
    label: '10',
    value: 10,
  },
]);

const thisYear = computed(() => {
  return new Date().getFullYear();
});
const maxYear = computed(() => {
  return thisYear.value + 10;
});

/* FORM ACTION */

const copyObject = (obj) => {
  return JSON.parse(JSON.stringify(obj));
};

const scrollTo = (toX = 0, toY = 0) => {
  window.scrollTo(toX, toY);
};

const resetErrors = () => {
  errors.value = {
    sections: [],
  };
};

// FORM SECTION

const questionTemplate = ref({
  code: null,
  text: '',
  hint: null,
  // order: 0,
  type: 'single-line text',
  // is_required: 0,
  default_value: null,
  is_default_value_editable: null,
  // is_displayed_from_start: 1,
  // parent_id: null,
  default_next_question_id: null,
  is_exportable: 1,
  export_code: '',
  export_order: null,
  question_options: [],
  question_childs: [],
  // additionClassNames: '!border-2 border-blue-500 !shadow-blue-500',
  additionClassNames: '',
});

const sectionTemplate = ref({
  title: 'Judul Section',
  description: '',
  // order: 0,
  showQuestion: true,
  questions: [copyObject(questionTemplate.value)],
});

const addSection = (sectionIndex) => {
  resetErrors();

  if (typeof sectionIndex === 'undefined' || sectionIndex === null) {
    state.value.sections.push({
      ...copyObject(sectionTemplate.value),
      title: 'Judul Section 1',
    });
  } else {
    state.value.sections.splice(sectionIndex + 1, 0, {
      ...copyObject(sectionTemplate.value),
      title: 'Judul Section ' + (sectionIndex + 1),
    });
  }
};
const deleteSection = (sectionIndex) => {
  state.value.sections.splice(sectionIndex, 1);
};

// FORM QUESTION

const deleteQuestion = (sectionIndex, questionIndex) => {
  resetErrors();

  state.value.sections[sectionIndex].questions.splice(questionIndex, 1);
};

const addQuestion = (sectionIndex, questionIndex) => {
  resetErrors();

  let newlyAddedIndex;
  if (typeof questionIndex === 'undefined' || questionIndex === null) {
    newlyAddedIndex = state.value.sections[sectionIndex].questions.push(
      copyObject(questionTemplate.value)
    );
  } else {
    state.value.sections[sectionIndex].questions.splice(
      questionIndex + 1,
      0,
      copyObject(questionTemplate.value)
    );
    newlyAddedIndex = questionIndex + 1;
  }
  // removeQuestionAdditionalClass(sectionIndex, newlyAddedIndex);
  state.value.sections[sectionIndex].showQuestion = true;
  // scrollTo(0, window.scrollY + 250);
};

// const removeQuestionAdditionalClass = (sectionIndex, questionIndex) => {
//   setTimeout(() => {
//     state.value.sections[sectionIndex].questions[
//       questionIndex
//     ].additionClassNames = '';
//   }, 2000);
// };

const duplicateQuestion = (sectionIndex, questionIndex, question) => {
  resetErrors();

  let newlyAddedIndex;
  if (typeof questionIndex === 'undefined' || questionIndex === null) {
    newlyAddedIndex = state.value.sections[sectionIndex].questions.push({
      ...question,
    });
  } else {
    state.value.sections[sectionIndex].questions.splice(questionIndex + 1, 0, {
      ...question,
    });
    newlyAddedIndex = questionIndex + 1;
  }
  // removeQuestionAdditionalClass(sectionIndex, newlyAddedIndex);
};

/* FORM QUESTION - OPTIONS */
const questionOptionTemplate = ref({
  text: 'Opsi',
  hint: null,
  value: '1',
  is_custom_value: 0,
  // order: 0,
  code: null,
  export_code: null,
});

const addQuestionOption = (
  sectionIndex,
  questionIndex,
  questionChildIndex = null
) => {
  resetErrors();

  const options =
    state.value.sections[sectionIndex].questions[questionIndex]
      .question_options;

  const customValueExistIndex = options.findIndex((v) => v.is_custom_value);
  if (customValueExistIndex > -1) {
    options.splice(customValueExistIndex, 0, {
      ...copyObject(questionOptionTemplate.value),
      text: 'Opsi ' + options.length,
      value: options.length,
    });
  } else {
    options.push({
      ...copyObject(questionOptionTemplate.value),
      text: 'Opsi ' + (options.length + 1),
      value: options.length + 1,
    });
  }
};

const questionCustomValueExists = (options) => {
  const found = options.findIndex((v) => v.is_custom_value);
  return found > -1;
};
const addQuestionCustomOption = (sectionIndex, questionIndex) => {
  resetErrors();

  const options =
    state.value.sections[sectionIndex].questions[questionIndex]
      .question_options;
  if (questionCustomValueExists(options) === false) {
    options.push({
      ...copyObject(questionOptionTemplate.value),
      text: 'Lainnya, tuliskan:',
      value: '-',
      is_custom_value: 1,
    });
  }
};

const deleteQuestionOption = (options, optionIndex) => {
  resetErrors();
  options.splice(optionIndex, 1);
};

const inputWithOptionTypes = [
  'radio',
  'multiple choice',
  'select',
  'dropdown',
  'checkbox',
];
const onChangeQuestionType = (question) => {
  question.question_childs = [];
  question.question_rate = {};
  question.question_options = [];
  question.showQuestionChild = false;

  if (allowedDefaultValueTypes.includes(question.type)) {
    question.question_options = [];
  } else if (inputWithOptionTypes.includes(question.type)) {
    question.question_options = [
      {
        ...copyObject(questionOptionTemplate.value),
        text: 'Opsi 1',
        value: 1,
      },
    ];
  } else if (['rating', 'linear scale'].includes(question.type)) {
    question.question_options = [];
    question.question_rate = {
      lowest_rate: 1,
      lowest_rate_label: '',
      highest_rate: 5,
      highest_rate_label: '',
    };
  } else if (['multiple question'].includes(question.type)) {
    // question.question_options = [];
    // question.question_rate = {};
    // question.question_childs = [];
    question.showQuestionChild = true;
    question.question_childs.push(copyObject(questionTemplate.value));
  }
};

/* UPDATE QUESTION RESPONSE FROM OPTION */
const updateResponseOption = (question) => {
  question.responseOptionCustom = '';
};
const updateResponseOptionCustom = (question) => {
  if (
    question.responseOptionCustom &&
    question.responseOptionCustom.length > 0
  ) {
    if (['checkbox'].includes(question.type)) {
      question.response = [];
    } else {
      question.response = '';
    }
  }
};
</script>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

.fixedContainer {
  position: fixed;
  left: 50%;
  bottom: 0;
  transform: translate(-50%, 0%);
}
</style>