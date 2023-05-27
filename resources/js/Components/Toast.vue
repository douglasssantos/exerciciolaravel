<script setup>
import {computed, defineProps, onMounted, defineEmits} from "vue";

const emit = defineEmits(['close']);

const props = defineProps({
    show: true
})

const open = computed(() => props.show)

onMounted(() =>{
    setTimeout(()=> emit('close') , 2000);
})

</script>

<template>
  <Transition>
    <div v-if="open" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-100 fixed" style="top:10px;right: 10px;" role="alert">
      <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8">
        <slot name="icon"></slot>
      </div>
      <div class="ml-3 text-sm font-normal">
        <slot name="body"></slot>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>