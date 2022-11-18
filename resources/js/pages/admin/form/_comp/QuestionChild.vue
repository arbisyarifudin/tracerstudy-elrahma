<template>
  <div class="ml-4 form-question__child">
    <div class="text-xl font-semibold mb-4">Sub Pertanyaan:</div>
    <div
      class="bg-white p-6 border rounded-lg shadow-lg mb-8"
      v-for="(questionChild, questionChildIndex) in question.question_childs"
      :key="questionChildIndex"
    >
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
          <!-- {{ question.code }} -->
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
                  {{ !questionChild.showDefaultValue ? 'Tambahkan' : 'Hapus' }}
                  nilai bawaan</span
                >
              </div>
            </div>
            <Select
              class="w-1/4"
              v-model="questionChild.type"
              :options="questionTypeOptions"
              placeholder="-- Pilih tipe pertanyaan --"
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
          <div v-if="questionChild.type === 'phone number'">
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
          <div v-if="questionChild.type === 'time'">
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
          <ul
            class="text-base text-gray-700 space-y-2"
            v-else-if="
              questionChild.type === 'radio' ||
              questionChild.type === 'multiple choice'
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
                  type="radio"
                  :name="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}`"
                  disabled
                  class="w-5 h-5 pointer-events-none"
                />
                <Input
                  :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${optionIndex}`"
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
            <li
              v-if="
                questionChild.question_options &&
                questionChild.question_options.length
              "
            >
              <label
                :for="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${questionChild.question_options.length}`"
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
            v-else-if="questionChild.type === 'checkbox'"
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
                  type="checkbox"
                  :name="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}`"
                  disabled
                  class="w-5 h-5 pointer-events-none"
                />
                <Input
                  :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${optionIndex}`"
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
                  type="checkbox"
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
          <ol
            class="text-base text-gray-700 space-y-2"
            v-else-if="
              questionChild.type === 'select' ||
              questionChild.type === 'select dropdown'
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
                <span>{{ optionIndex + 1 }}</span>
                <Input
                  :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${optionIndex}`"
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
            <li
              v-if="
                questionChild.question_options &&
                questionChild.question_options.length
              "
            >
              <label
                :for="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-${questionChild.question_options.length}`"
                class="
                  flex
                  items-center
                  flex-1
                  space-x-3
                  cursor-pointer
                  text-gray-500
                "
              >
                <span>{{ questionChild.question_options.length + 1 }}</span>
                &nbsp;
                <span
                  class="
                    text-sm text-gray-500
                    cursor-pointer
                    hover:underline
                    pl-2
                  "
                  >Tambahkan opsi</span
                >
              </label>
            </li>
          </ol>

          <div
            v-else-if="
              questionChild.type === 'rating' ||
              questionChild.type === 'linear scale'
            "
          >
            <div class="flex items-center space-x-3">
              <Select
                class="mb-0"
                size="sm"
                v-model="questionChild.lowRateSelected"
                :options="lowRateOptions"
              />
              <span>sampai</span>
              <Select
                class="mb-0"
                size="sm"
                v-model="questionChild.highRateSelected"
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
                    <span>1</span>
                    <Input
                      :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-1`"
                      variant="secondary"
                      size="sm"
                      underline
                      placeholder="Label (opsional)"
                      class="flex-1"
                    />
                  </label>
                </li>
                <li class="flex items-center justify-between max-w-xs">
                  <label
                    :for="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-2`"
                    class="flex items-center flex-1 space-x-4 cursor-pointer"
                  >
                    <span>2</span>
                    <Input
                      :id="`option-${sectionIndex}-${questionIndex}-${questionChildIndex}-2`"
                      variant="secondary"
                      size="sm"
                      underline
                      placeholder="Label (opsional)"
                      class="flex-1"
                    />
                  </label>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>