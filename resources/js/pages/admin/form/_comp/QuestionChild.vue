<template>
  <div class="ml-4 form-question form-question--child">
    <div
      class="text-xl font-semibold mb-4 flex items-center cursor-pointer"
      @click="question.showQuestionChild = !question.showQuestionChild"
    >
      <Button
        variant="light"
        :icon="
          question.showQuestionChild ? 'caret-down-fill' : 'caret-right-fill'
        "
        class="mr-2"
      />
      <span>Sub Pertanyaan:</span>
    </div>
    <div v-show="question.showQuestionChild">
      <!-- <transition-group tag="span" name="slide-fade" mode="out-in"> -->
      <div
        class="bg-white pt-6 px-6 border rounded-lg shadow-lg mb-8"
        :class="`${questionChild.additionClassNames}`"
        v-for="(questionChild, questionChildIndex) in question.question_childs"
        :key="questionChildIndex"
      >
        <!-- <transition tag="div" name="slide-fade" mode="out-in" appear>
                  <div :key="questionIndex" v-show="true"> -->
        <div class="drag-handle cursor-pointer -mt-5">
          <ph-dots-six :size="30" class="fill-gray-400 mx-auto" />
        </div>
        <div class="flex items-start w-full">
          <div
            class="
              bg-gray-400
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
            <!-- {{ questionChild.code }} -->
            {{
              sectionIndex +
              1 +
              '-' +
              (questionIndex + 1) +
              '-' +
              (questionChildIndex + 1)
            }}
          </div>
          <div class="flex-1">
            <div class="flex space-x-5">
              <div class="w-3/4">
                <Input
                  variant="secondary"
                  underline
                  filled
                  placeholder="Tulis Pertanyaan"
                  v-model="questionChild.text"
                  :errors="
                    errors[
                      `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.text`
                    ]
                  "
                  @keyup="
                    errors[
                      `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.text`
                    ] = []
                  "
                />
                <div class="flex justify-end mb-3">
                  <span
                    class="
                      flex
                      items-center
                      text-xs text-gray-400
                      cursor-pointer
                      ml-2
                    "
                    @click="questionChild.showHint = !questionChild.showHint"
                  >
                    <ph-plus
                      v-if="!questionChild.showHint"
                      class="text-lime-500"
                    />
                    <ph-x v-else class="text-red-500" />
                    {{ !questionChild.showHint ? 'Tampilkan' : 'Sembunyikan' }}
                    teks bantuan</span
                  >
                  <span
                    v-if="allowedDefaultValueTypes.includes(questionChild.type)"
                    class="
                      flex
                      items-center
                      text-xs text-gray-400
                      cursor-pointer
                      ml-2
                    "
                    @click="
                      questionChild.showDefaultValue =
                        !questionChild.showDefaultValue
                    "
                  >
                    <ph-plus
                      v-if="!questionChild.showDefaultValue"
                      class="text-lime-500"
                    />
                    <ph-x v-else class="text-red-500" />
                    {{
                      !questionChild.showDefaultValue ? 'Tambahkan' : 'Hapus'
                    }}
                    nilai bawaan</span
                  >
                </div>
              </div>
              <Select
                class="w-1/4"
                v-model="questionChild.type"
                :options="questionChildTypeOptions"
                placeholder="-- Pilih tipe pertanyaan --"
                @change="onChangeQuestionType(questionChild)"
                :errors="
                  errors[
                    `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.type`
                  ]
                "
                @keyup="
                  errors[
                    `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.type`
                  ] = []
                "
              />
            </div>
            <div
              class="mb-4 mt-2"
              v-if="questionChild.showHint || questionChild.showDefaultValue"
            >
              <div v-if="questionChild.showHint" class="flex items-center mb-2">
                <ph-info :size="15" class="-mt-2" />
                <Input
                  variant="secondary"
                  class="pl-2 flex-1"
                  underline
                  size="xs"
                  placeholder="Teks bantuan (opsional)"
                  v-model="questionChild.hint"
                />
              </div>
              <div
                v-if="questionChild.showDefaultValue"
                class="flex items-center mb-2"
              >
                <div class="w-1/2 flex items-center">
                  <ph-pencil-simple-line :size="15" class="-mt-2" />
                  <Input
                    variant="secondary"
                    class="pl-2 flex-1"
                    underline
                    size="xs"
                    placeholder="Nilai bawaan (opsional)"
                    v-model="questionChild.default_value"
                    :disabled="questionChild.is_default_value_editable"
                  />
                </div>
                <label
                  :for="`lock-default-value-${sectionIndex}-${questionIndex}-${questionChildIndex}`"
                  class="
                    flex
                    items-center
                    text-xs text-gray-500
                    cursor-pointer
                    ml-3
                  "
                >
                  <input
                    :id="`lock-default-value-${sectionIndex}-${questionIndex}-${questionChildIndex}`"
                    type="checkbox"
                    class="mr-2 inline-block"
                    v-model="questionChild.is_default_value_editable"
                  />
                  Kunci nilai bawaan
                </label>
              </div>
            </div>
            <div
              v-if="
                questionChild.type === 'text' ||
                questionChild.type === 'single-line text'
              "
              class="
                p-2
                border-b border-dashed border-gray-300
                text-gray-500 text-sm
              "
            >
              Teks jawaban singkat
            </div>
            <div
              v-else-if="
                questionChild.type === 'textarea' ||
                questionChild.type === 'multi-line text'
              "
              class="
                p-2
                border-b border-dashed border-gray-300
                text-gray-500 text-sm
                h-16
              "
            >
              Teks jawaban panjang
            </div>
            <div v-if="questionChild.type === 'number'">
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
            <div v-if="questionChild.type === 'date'">
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

            <div v-if="questionChild.type === 'year'">
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
            <div v-if="questionChild.type === 'email'">
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
            <ul
              class="text-base text-gray-700 space-y-2"
              v-else-if="
                questionChild.type === 'radio' ||
                questionChild.type === 'multiple choice' ||
                questionChild.type === 'checkbox' ||
                questionChild.type === 'select' ||
                questionChild.type === 'dropdown'
              "
            >
              <li
                v-for="(option, optionIndex) in questionChild.question_options"
                :key="optionIndex"
                class="flex items-center justify-between"
              >
                <label
                  :for="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${optionIndex}`"
                  class="flex items-center flex-1 space-x-4 cursor-pointer"
                >
                  <input
                    v-if="
                      questionChild.type === 'radio' ||
                      questionChild.type === 'multiple choice' ||
                      questionChild.type === 'checkbox'
                    "
                    :type="
                      ['radio', 'multiple choice'].includes(questionChild.type)
                        ? 'radio'
                        : 'checkbox'
                    "
                    :name="`option-${sectionIndex}-${questionIndex}`"
                    disabled
                    class="w-5 h-5 pointer-events-none"
                  />
                  <span v-else>{{ optionIndex + 1 }}</span>
                  <div class="flex items-center w-full">
                    <div
                      class="mr-2 text-xs text-gray-400"
                      v-if="!option.is_custom_value"
                    >
                      Label:
                    </div>
                    <Input
                      :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${optionIndex}`"
                      variant="secondary"
                      size="sm"
                      underline-on-hover
                      v-model="option.text"
                      :placeholder="
                        option.is_custom_value
                          ? 'Lainnya...'
                          : 'Label opsi ' + optionIndex
                      "
                      class="flex-1"
                      :errors="
                        errors[
                          `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.question_options.${optionIndex}.text`
                        ]
                      "
                      @keyup="
                        errors[
                          `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.question_options.${optionIndex}.text`
                        ] = []
                      "
                    />
                    <div
                      class="mx-2 text-xs text-gray-400"
                      v-if="!option.is_custom_value"
                    >
                      Nilai:
                    </div>
                    <Input
                      v-if="!option.is_custom_value"
                      variant="secondary"
                      size="sm"
                      underline-on-hover
                      v-model="option.value"
                      :placeholder="'Nilai opsi ' + optionIndex"
                      class="flex-1"
                      :errors="
                        errors[
                          `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.question_options.${optionIndex}.value`
                        ]
                      "
                      @keyup="
                        errors[
                          `sections.${sectionIndex}.questions.${questionIndex}.question_childs.${questionChildIndex}.question_options.${optionIndex}.value`
                        ] = []
                      "
                    />
                  </div>
                </label>
                <Button
                  icon="x"
                  variant="light"
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
                  @click="
                    deleteQuestionOption(
                      questionChild.question_options,
                      optionIndex
                    )
                  "
                />
              </li>
              <li
                v-if="
                  questionChild.question_options &&
                  questionChild.question_options.length &&
                  (questionChild.type === 'radio' ||
                    questionChild.type === 'multiple choice' ||
                    questionChild.type === 'checkbox')
                "
              >
                <label
                  :for="`option-${sectionIndex}-${questionIndex}-${questionChild.question_options.length}`"
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
                    :type="
                      ['radio', 'multiple choice'].includes(questionChild.type)
                        ? 'radio'
                        : 'checkbox'
                    "
                    disabled
                    class="w-5 h-5 pointer-events-none"
                  />
                  &nbsp;
                  <span
                    class="text-gray-500 cursor-pointer hover:underline"
                    @click="addQuestionOption(questionChildIndex)"
                    >Tambahkan opsi</span
                  >
                  <div
                    v-if="
                      questionCustomValueExists(
                        questionChild.question_options
                      ) === false
                    "
                    @click="addQuestionCustomOption(questionChildIndex)"
                  >
                    <span class="mx-2 inline-block">atau</span>
                    <span class="text-blue-500 cursor-pointer"
                      >tambahkan "Lainnya"</span
                    >
                  </div>
                </label>
              </li>
            </ul>

            <div
              v-else-if="
                (questionChild.type === 'rating' ||
                  questionChild.type === 'linear scale') &&
                questionChild.question_rate
              "
            >
              <div class="flex items-center space-x-3">
                <Select
                  class="mb-0"
                  size="sm"
                  v-model="questionChild.question_rate.lowest_rate"
                  :options="lowRateOptions"
                />
                <span>sampai</span>
                <Select
                  class="mb-0"
                  size="sm"
                  v-model="questionChild.question_rate.highest_rate"
                  :options="highRateOptions"
                />
              </div>
              <div class="mt-2">
                <ol class="text-base text-gray-700 space-y-2">
                  <li class="flex items-center justify-between max-w-xs">
                    <label
                      :for="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-1`"
                      class="flex items-center flex-1 space-x-4 cursor-pointer"
                    >
                      <span>{{ questionChild.question_rate.lowest_rate }}</span>
                      <Input
                        :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-1`"
                        variant="secondary"
                        size="sm"
                        underline
                        placeholder="Label (opsional)"
                        class="flex-1"
                        v-model="questionChild.question_rate.lowest_rate_label"
                      />
                    </label>
                  </li>
                  <li class="flex items-center justify-between max-w-xs">
                    <label
                      :for="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-2`"
                      class="flex items-center flex-1 space-x-4 cursor-pointer"
                    >
                      <span>{{
                        questionChild.question_rate.highest_rate
                      }}</span>
                      <Input
                        :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-2`"
                        variant="secondary"
                        size="sm"
                        underline
                        placeholder="Label (opsional)"
                        class="flex-1"
                        v-model="questionChild.question_rate.highest_rate_label"
                      />
                    </label>
                  </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div
          class="
            form-question__footer
            flex
            items-center
            justify-between
            border-t
            mt-8
            pt-3
            pb-3
            px-4
          "
        >
          <div class="">
            <Input
              v-model="questionChild.code"
              placeholder="Kode pertanyaan"
              size="sm"
              style="width: 150px"
            />
          </div>
          <div class="flex">
            <Button
              variant="light"
              size="lg"
              class="rounded-full"
              icon="plus"
              @click="addQuestion(questionChildIndex)"
            />
            <Button
              variant="light"
              size="lg"
              class="rounded-full"
              icon="copy-simple"
              @click="duplicateQuestion(questionChildIndex, questionChild)"
            />
            <Button
              variant="light"
              size="lg"
              class="rounded-full"
              icon="trash"
              @click="deleteQuestion(questionChildIndex)"
            />
          </div>
        </div>
        <!-- </div> -->
        <!-- </transition> -->
      </div>
      <!-- </transition-group> -->
    </div>
  </div>
</template>

<script setup>
import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';
import Button from '@/components/UI/Button.vue';
import { ref } from '@vue/reactivity';
import { computed, watch } from '@vue/runtime-core';

const $props = defineProps({
  sectionIndex: {
    type: [String, Number],
  },
  questionIndex: {
    type: [String, Number],
  },
  question: {
    type: Object,
  },
  errors: {
    type: Object,
    default: () => {
      return {};
    },
  },
});

const $emit = defineEmits(['resetErrors']);

// watch(
//   () => $props.errors,
//   (val) => {
//     console.log('errors', val);
//   }
// );

/* FORM */

const questionTypeOptions = ref([
  {
    label: 'Jawaban singkat',
    value: 'single-line text',
    // value: 'text',
  },
  {
    label: 'Jawaban panjang',
    value: 'multi-line text',
    // value: 'textarea',
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
    // value: 'radio',
    value: 'multiple choice',
  },
  {
    label: 'Kotak Centang',
    value: 'checkbox',
  },
  {
    label: 'Drop-down',
    // value: 'select',
    value: 'dropdown',
  },
  {
    label: '───────────────',
    value: null,
  },
  {
    label: 'Skala linier',
    value: 'linear scale',
    // value: 'rating',
  },
  {
    label: 'Pertanyaan ganda',
    value: 'multiple question',
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
  {
    label: '───────────────',
    value: null,
  },
  {
    label: 'Pilihan Provinsi',
    value: 'select province',
  },
  {
    label: 'Pilihan Kab/Kota',
    value: 'select regency',
  },
]);

const questionChildTypeOptions = ref(
  questionTypeOptions.value.filter((v) => v.value !== 'multiple question')
);

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
  $emit('resetErrors');
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

// FORM QUESTION

const deleteQuestion = (questionChildIndex) => {
  resetErrors();
  $props.question.question_childs.splice(questionChildIndex, 1);
};

const addQuestion = (questionChildIndex) => {
  resetErrors();

  let newlyAddedIndex;
  if (
    typeof questionChildIndex === 'undefined' ||
    questionChildIndex === null
  ) {
    newlyAddedIndex = $props.question.question_childs.push(
      copyObject(questionTemplate.value)
    );
  } else {
    $props.question.question_childs.splice(
      questionChildIndex + 1,
      0,
      copyObject(questionTemplate.value)
    );
    newlyAddedIndex = questionChildIndex + 1;
  }
};

const duplicateQuestion = (questionChildIndex, questionChild) => {
  resetErrors();

  let newlyAddedIndex;
  if (
    typeof questionChildIndex === 'undefined' ||
    questionChildIndex === null
  ) {
    newlyAddedIndex = $props.question.question_childs.push({
      ...questionChild,
    });
  } else {
    $props.question.question_childs.splice(questionChildIndex + 1, 0, {
      ...questionChild,
    });
    newlyAddedIndex = questionChildIndex + 1;
  }
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

const addQuestionOption = (questionChildIndex) => {
  resetErrors();

  const options =
    $props.question.question_childs[questionChildIndex].question_options;

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
const addQuestionCustomOption = (questionChildIndex) => {
  resetErrors();

  const options =
    $props.question.question_childs[questionChildIndex].question_options;
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
  }
};
</script>