<template>
  <div
    class="
      modal-overlay
      w-full
      h-full
      fixed
      top-0
      left-0
      z-[60]
      overflow-x-hidden overflow-y-auto
      bg-black/[0.5]
    "
    :class="show ? 'open' : 'hidden'"
    @click="closeModal"
  >
    <div
      class="
        modal-overlay-open:mt-7
        modal-overlay-open:opacity-100
        modal-overlay-open:duration-500
        mt-0
        opacity-0
        ease-out
        transition-all
        sm:max-w-lg sm:w-full
        m-3
        sm:mx-auto
      "
      :class="[vCenteredClass]"
      @click.stop
    >
      <div class="flex flex-col bg-white border shadow-sm rounded-xl">
        <slot name="header">
          <div class="flex justify-between items-center py-3 px-4 border-b">
            <h3 class="font-bold text-gray-800" v-text="title"></h3>
            <Button variant="light" icon="x" @click="closeModal" />
          </div>
        </slot>
        <slot name="content">
          <div class="p-4 overflow-y-auto">
            <p class="text-gray-800 dark:text-gray-400">
              This is a wider card with supporting text below as a natural
              lead-in to additional content.
            </p>
          </div>
        </slot>
        <slot name="footer">
          <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
            <Button
              variant="secondary"
              outline
              label="Close"
              class="mr-1"
              @click="closeModal"
            />
            <Button
              type="submit"
              label="Submit"
              @click="confirmModal"
              :disabled="loading"
            />
          </div>
        </slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import Button from '@/components/UI/Button.vue';
import { computed } from '@vue/runtime-core';

const $props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  vCentered: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: 'Title',
  },
});

const vCenteredClass = computed(() => {
  return $props.vCentered && 'flex items-center min-h-[calc(100%-3.5rem)]';
});

const $emit = defineEmits(['close', 'confirm']);

const closeModal = () => {
  $emit('close');
};
const confirmModal = () => {
  $emit('confirm');
};
</script>

<style lang="scss">
.modal-overlay-open {
  transition: all 0.5s ease-in;
}
.open {
  // display: block;
  .modal-overlay-open {
    &\:mt {
      &-7 {
        margin-top: 1.75rem;
      }
    }
    &\:opacity {
      &-100 {
        opacity: 1;
      }
    }
    &\:duration {
      &-500 {
        transition-duration: 500ms;
      }
    }
  }
}
</style>