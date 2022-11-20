<template>
  <div class="flex justify-center">
    <div class="form-check form-switch">
      <input
        class="
          form-check-input
          appearance-none
          w-9
          -ml-10
          rounded-full
          float-left
          h-5
          align-top
          bg-white bg-no-repeat bg-contain bg-gray-300
          focus:outline-none
          cursor-pointer
          shadow-sm
        "
        :class="[styles]"
        type="checkbox"
        role="switch"
        :id="id"
        v-model="modelValue"
        @change="updateValue"
        :true-value="trueValue"
        :false-value="falseValue"
        :disabled="disabled"
      />
      <label
        class="form-check-label inline-block text-gray-800"
        v-if="label"
        :for="id"
        >{{ label }}</label
      >
    </div>
  </div>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { computed } from '@vue/runtime-core';

const $props = defineProps({
  id: {
    type: [String, Number],
    default: () => {
      return Math.round(Math.random() * Math.random());
    },
  },
  label: {
    type: String,
    default: null,
  },
  variant: {
    type: String,
    default: 'primary',
  },
  size: {
    type: String,
    default: 'md',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  modelValue: {
    type: [String, Number, Boolean],
  },
  trueValue: {
    type: [String, Number, Boolean],
    default: true,
  },
  falseValue: {
    type: [String, Number, Boolean],
    default: false,
  },
});

const $emit = defineEmits(['update:modelValue']);

const variants = ref({
  primary: 'checked:bg-blue-800 checked:border-blue-800',
  secondary: '',
  danger: '',
  light: '',
});

const sizes = ref({
  xs: '',
  sm: '',
  md: '',
  lg: '',
});

const styles = computed(() => {
  const styleVariant = variants.value[$props.variant];
  const styleSize = sizes.value[$props.size];
  return `${styleVariant} ${styleSize}`;
});

const updateValue = (event) => {
  $emit('update:modelValue', $props.modelValue);
};
</script>