<template>
  <div class="rounded-xl border shadow-xl p-6 bg-white">
    <div class="mb-3 border-b pb-3 flex items-center justify-between sticky">
      <h3 class="text-2xl font-semibold">
        Kelola Kuisioner
        <span class="text-sm text-gray-500">/ {{ detailData.name }}</span>
      </h3>
      <div class="flex items-center space-x-3">
        <Button
          label="Kembali"
          icon="arrow-fat-line-left"
          variant="secondary"
          @click="$router.push({ name: 'Form List Page' })"
        />
        <Button
          v-if="state.sections && state.sections.length > 0"
          variant="primary"
          type="submit"
          label="Simpan"
          @click="onSubmit"
          :disabled="loading"
        />
      </div>
    </div>
    <form @submit.prevent="onSubmit">
      <!-- <div class="lg:max-w-6xl md:max-w-xl sm:max-w-lg"> -->
      <div class="max-w-6xl">
        <div
          v-if="state.sections && state.sections.length < 1"
          class="bg-gray-100 p-2 border rounded-lg shadow-sm"
        >
          <div class="flex justify-center items-center space-x-4 px-4 py-6">
            <div>Belum ada Kuisioner.</div>
            <Button
              variant="secondary"
              outline
              label="Tambah Section"
              size="xs"
              icon="plus"
              @click="addSection(sectionIndex)"
            />
          </div>
        </div>

        <section
          v-for="(section, sectionIndex) in state.sections"
          :key="sectionIndex"
          class="form-section"
        >
          <div class="bg-white pt-6 px-6 border rounded-lg mb-5 shadow-lg">
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
                <!-- {{ question.code }} -->
                {{ sectionIndex + 1 }}
              </div>
              <div class="w-full">
                <Input
                  variant="secondary"
                  underline
                  filled
                  placeholder="Judul Section"
                  v-model="section.title"
                  :errors="errors[`sections.${sectionIndex}.title`]"
                  @keyup="errors[`sections.${sectionIndex}.title`] = []"
                />
                <Input
                  variant="secondary"
                  underline
                  size="xs"
                  placeholder="Deskripsi (optional)"
                  v-model="section.description"
                />
              </div>
            </div>
            <div
              class="
                form-section__actions
                flex
                items-center
                justify-end
                border-t
                mt-8
                pt-3
                pb-3
                px-4
              "
            >
              <Button
                variant="light"
                size="lg"
                class="rounded-full"
                icon="plus"
                @click="addSection(sectionIndex)"
              />
              <Button
                variant="light"
                size="lg"
                class="rounded-full"
                icon="trash"
                @click="deleteSection(sectionIndex)"
              />
            </div>
          </div>
          <div class="ml-4 form-question">
            <div
              class="
                text-xl
                font-semibold
                mb-4
                flex
                items-center
                cursor-pointer
              "
              @click="section.showQuestion = !section.showQuestion"
            >
              <Button
                variant="light"
                :icon="
                  section.showQuestion ? 'caret-down-fill' : 'caret-right-fill'
                "
                class="mr-2"
              />
              <span>Pertanyaan:</span>
            </div>
            <div v-show="section.showQuestion">
              <!-- <transition-group tag="span" name="slide-fade" mode="out-in"> -->
              <div
                class="bg-white pt-6 px-6 border rounded-lg shadow-lg mb-8"
                :class="`${question.additionClassNames}`"
                v-for="(question, questionIndex) in section.questions"
                :key="questionIndex"
              >
                <!-- <transition tag="div" name="slide-fade" mode="out-in" appear>
                  <div :key="questionIndex" v-show="true"> -->
                <div class="drag-handle cursor-pointer -mt-5">
                  <ph-dots-six :size="30" class="fill-gray-400 mx-auto" />
                </div>
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
                          variant="secondary"
                          underline
                          filled
                          placeholder="Tulis Pertanyaan"
                          v-model="question.text"
                          :errors="
                            errors[
                              `sections.${sectionIndex}.questions.${questionIndex}.text`
                            ]
                          "
                          @keyup="
                            errors[
                              `sections.${sectionIndex}.questions.${questionIndex}.text`
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
                            @click="question.showHint = !question.showHint"
                          >
                            <ph-plus
                              v-if="!question.showHint"
                              class="text-lime-500"
                            />
                            <ph-x v-else class="text-red-500" />
                            {{
                              !question.showHint ? 'Tampilkan' : 'Sembunyikan'
                            }}
                            teks bantuan</span
                          >
                          <span
                            v-if="
                              allowedDefaultValueTypes.includes(question.type)
                            "
                            class="
                              flex
                              items-center
                              text-xs text-gray-400
                              cursor-pointer
                              ml-2
                            "
                            @click="
                              question.showDefaultValue =
                                !question.showDefaultValue
                            "
                          >
                            <ph-plus
                              v-if="!question.showDefaultValue"
                              class="text-lime-500"
                            />
                            <ph-x v-else class="text-red-500" />
                            {{
                              !question.showDefaultValue ? 'Tambahkan' : 'Hapus'
                            }}
                            nilai bawaan</span
                          >
                        </div>
                      </div>
                      <Select
                        class="w-1/4"
                        v-model="question.type"
                        :options="questionTypeOptions"
                        placeholder="-- Pilih tipe pertanyaan --"
                        @change="onChangeQuestionType(question)"
                        :errors="
                          errors[
                            `sections.${sectionIndex}.questions.${questionIndex}.type`
                          ]
                        "
                        @keyup="
                          errors[
                            `sections.${sectionIndex}.questions.${questionIndex}.type`
                          ] = []
                        "
                      />
                    </div>
                    <div
                      class="mb-4 mt-2"
                      v-if="question.showHint || question.showDefaultValue"
                    >
                      <div
                        v-if="question.showHint"
                        class="flex items-center mb-2"
                      >
                        <ph-info :size="15" class="-mt-2" />
                        <Input
                          variant="secondary"
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
                            variant="secondary"
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
                      v-if="
                        question.type === 'text' ||
                        question.type === 'single-line text'
                      "
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
                      Teks jawaban panjang
                    </div>
                    <ul
                      class="text-base text-gray-700 space-y-2"
                      v-else-if="
                        question.type === 'radio' ||
                        question.type === 'multiple choice'
                      "
                    >
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
                            type="radio"
                            :name="`option-${sectionIndex}-${questionIndex}`"
                            disabled
                            class="w-5 h-5 pointer-events-none"
                          />
                          <div class="flex items-center w-full">
                            <div
                              class="mr-2 text-xs text-gray-400"
                              v-if="!option.is_custom_value"
                            >
                              Label:
                            </div>
                            <Input
                              :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
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
                                  `sections.${sectionIndex}.questions.${questionIndex}.question_options.${optionIndex}.text`
                                ]
                              "
                              @keyup="
                                errors[
                                  `sections.${sectionIndex}.questions.${questionIndex}.question_options.${optionIndex}.text`
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
                                  `sections.${sectionIndex}.questions.${questionIndex}.question_options.${optionIndex}.value`
                                ]
                              "
                              @keyup="
                                errors[
                                  `sections.${sectionIndex}.questions.${questionIndex}.question_options.${optionIndex}.value`
                                ] = []
                              "
                            />
                          </div>
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
                          @click="
                            deleteQuestionOption(
                              question.question_options,
                              optionIndex
                            )
                          "
                        />
                      </li>
                      <li
                        v-if="
                          question.question_options &&
                          question.question_options.length
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
                          <input
                            type="radio"
                            disabled
                            class="w-5 h-5 pointer-events-none"
                          />
                          &nbsp;
                          <span
                            class="text-gray-500 cursor-pointer hover:underline"
                            @click="
                              addQuestionOption(sectionIndex, questionIndex)
                            "
                            >Tambahkan opsi</span
                          >
                          <div
                            v-if="
                              questionCustomValueExists(
                                question.question_options
                              ) === false
                            "
                            @click="
                              addQuestionCustomOption(
                                sectionIndex,
                                questionIndex
                              )
                            "
                          >
                            <span class="mx-2 inline-block">atau</span>
                            <span class="text-blue-500 cursor-pointer"
                              >tambahkan "Lainnya"</span
                            >
                          </div>
                        </label>
                      </li>
                    </ul>
                    <ul
                      class="text-base text-gray-700 space-y-2"
                      v-else-if="question.type === 'checkbox'"
                    >
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
                            type="checkbox"
                            :name="`option-${sectionIndex}-${questionIndex}`"
                            disabled
                            class="w-5 h-5 pointer-events-none"
                          />
                          <div class="flex items-center w-full">
                            <div
                              class="mr-2 text-xs text-gray-400"
                              v-if="!option.is_custom_value"
                            >
                              Label:
                            </div>
                            <Input
                              :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                              variant="secondary"
                              size="sm"
                              underline-on-hover
                              v-model="option.text"
                              :placeholder="
                                option.is_custom_value
                                  ? 'Lainnya...'
                                  : 'Label opsi ' + optionIndex
                              "
                              :disabled="option.is_custom_value"
                              class="flex-1"
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
                            />
                          </div>
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
                          @click="
                            deleteQuestionOption(
                              question.question_options,
                              optionIndex
                            )
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
                            type="checkbox"
                            disabled
                            class="w-5 h-5 pointer-events-none"
                          />
                          &nbsp;
                          <span
                            class="text-gray-500 cursor-pointer hover:underline"
                            @click="
                              addQuestionOption(sectionIndex, questionIndex)
                            "
                            >Tambahkan opsi</span
                          >
                          <div
                            v-if="
                              questionCustomValueExists(
                                question.question_options
                              ) === false
                            "
                            @click="
                              addQuestionCustomOption(
                                sectionIndex,
                                questionIndex
                              )
                            "
                          >
                            <span class="mx-2 inline-block">atau</span>
                            <span class="text-blue-500 cursor-pointer"
                              >tambahkan "Lainnya"</span
                            >
                          </div>
                        </label>
                      </li>
                    </ul>
                    <ol
                      class="text-base text-gray-700 space-y-2"
                      v-else-if="
                        question.type === 'select' ||
                        question.type === 'dropdown'
                      "
                    >
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
                          <span>{{ optionIndex + 1 }}</span>
                          <div class="flex items-center w-full">
                            <div
                              class="mr-2 text-xs text-gray-400"
                              v-if="!option.is_custom_value"
                            >
                              Label:
                            </div>
                            <Input
                              :id="`option-${sectionIndex}-${questionIndex}-${optionIndex}`"
                              variant="secondary"
                              size="sm"
                              underline-on-hover
                              v-model="option.text"
                              :placeholder="'Label opsi ' + optionIndex"
                              class="flex-1"
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
                            />
                          </div>
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
                          @click="
                            deleteQuestionOption(
                              question.question_options,
                              optionIndex
                            )
                          "
                        />
                      </li>
                      <li
                        v-if="
                          question.question_options &&
                          question.question_options.length
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
                            text-gray-500
                          "
                        >
                          <span>{{
                            question.question_options.length + 1
                          }}</span>
                          &nbsp;
                          <span
                            class="
                              text-sm text-gray-500
                              cursor-pointer
                              hover:underline
                              pl-2
                            "
                            @click="
                              addQuestionOption(sectionIndex, questionIndex)
                            "
                            >Tambahkan opsi</span
                          >
                        </label>
                      </li>
                    </ol>

                    <div
                      v-else-if="
                        (question.type === 'rating' ||
                          question.type === 'linear scale') &&
                        question.question_rate
                      "
                    >
                      <div class="flex items-center space-x-3">
                        <Select
                          class="mb-0"
                          size="sm"
                          v-model="question.question_rate.lowest_rate"
                          :options="lowRateOptions"
                        />
                        <span>sampai</span>
                        <Select
                          class="mb-0"
                          size="sm"
                          v-model="question.question_rate.highest_rate"
                          :options="highRateOptions"
                        />
                      </div>
                      <div class="mt-2">
                        <ol class="text-base text-gray-700 space-y-2">
                          <li
                            class="flex items-center justify-between max-w-xs"
                          >
                            <label
                              :for="`option-${sectionIndex}-${questionIndex}-1`"
                              class="
                                flex
                                items-center
                                flex-1
                                space-x-4
                                cursor-pointer
                              "
                            >
                              <span>{{
                                question.question_rate.lowest_rate
                              }}</span>
                              <Input
                                :id="`option-${sectionIndex}-${questionIndex}-1`"
                                variant="secondary"
                                size="sm"
                                underline
                                placeholder="Label (opsional)"
                                class="flex-1"
                                v-model="
                                  question.question_rate.lowest_rate_label
                                "
                              />
                            </label>
                          </li>
                          <li
                            class="flex items-center justify-between max-w-xs"
                          >
                            <label
                              :for="`option-${sectionIndex}-${questionIndex}-2`"
                              class="
                                flex
                                items-center
                                flex-1
                                space-x-4
                                cursor-pointer
                              "
                            >
                              <span>{{
                                question.question_rate.highest_rate
                              }}</span>
                              <Input
                                :id="`option-${sectionIndex}-${questionIndex}-2`"
                                variant="secondary"
                                size="sm"
                                underline
                                placeholder="Label (opsional)"
                                class="flex-1"
                                v-model="
                                  question.question_rate.highest_rate_label
                                "
                              />
                            </label>
                          </li>
                        </ol>
                      </div>
                    </div>

                    <!-- QUESTION CHILDS -->
                    <div
                      v-else-if="question.type === 'multiple question'"
                    ></div>
                  </div>
                </div>
                <div
                  class="
                    form-question__footer
                    flex
                    items-center
                    justify-end
                    border-t
                    mt-8
                    pt-3
                    pb-3
                    px-4
                  "
                >
                  <Button
                    variant="light"
                    size="lg"
                    class="rounded-full"
                    icon="plus"
                    @click="addQuestion(sectionIndex, questionIndex)"
                  />
                  <Button
                    variant="light"
                    size="lg"
                    class="rounded-full"
                    icon="copy-simple"
                    @click="
                      duplicateQuestion(sectionIndex, questionIndex, question)
                    "
                  />
                  <Button
                    variant="light"
                    size="lg"
                    class="rounded-full"
                    icon="trash"
                    @click="deleteQuestion(sectionIndex, questionIndex)"
                  />
                </div>
                <!-- </div> -->
                <!-- </transition> -->
              </div>
              <!-- </transition-group> -->
            </div>
          </div>

          <div class="bg-gray-100 p-2 border rounded-lg shadow-sm mb-[50px]">
            <div class="flex justify-between">
              <Button
                variant="secondary"
                outline
                label="Tambah Section"
                size="sm"
                icon="plus"
                @click="addSection(sectionIndex)"
              />
              <Button
                variant="secondary"
                outline
                label="Tambah Pertanyaan"
                size="sm"
                icon="plus"
                @click="addQuestion(sectionIndex)"
              />
            </div>
          </div>
          <div class="text-center my-3 text-gray-500">***</div>
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
          v-if="state.sections && state.sections.length > 0"
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

const errors = ref({
  sections: [],
});

const getDetail = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/form/' + detailData.value.id + '/detail')
    .then((response) => {
      console.log('res', response.data);
      detailData.value = response.data.data;
      state.value = { ...detailData.value };
      if (detailData.value) {
        state.value.sections = state.value.sections.map((section) => {
          return {
            ...section,
            showQuestion: true,
            questions: section.questions.map((question) => {
              return {
                ...question,
                showDefaultValue: !!question.default_value,
                showHint: !!question.hint,
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
]);

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

const addQuestionOption = (sectionIndex, questionIndex) => {
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

const onSubmit = () => {
  showLoading(true);
  loading.value = true;
  axios
    .put('api/form/' + detailData.value.id + '/detail', state.value)
    .then((response) => {
      console.log('res', response.data);
      showAlert('Kuisioner formulir berhasil diperbarui!', { type: 'success' });
      // $router.push({ name: 'Form List Page' });
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
</style>