<template>
  <teleport to="body">
    <TransitionRoot as="template" :show="open">
      <Dialog as="div" class="relative z-10" @close="open = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
              <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-auto sm:max-w-lg  px-10">
                <div class="absolute top-0 right-0 pr-2 pt-2">
                  <a @click="fnClose" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-0.5 ml-auto inline-flex items-center" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                  </a>
                </div>
                <div class="flex flex-col items-center py-10">
                  <img class="w-24 h-24 mb-3 rounded-full shadow-lg" :src="data.image" alt="Bonnie image"/>
                  <h5 class="mb-1 text-xl font-medium text-gray-900">{{ data.name }}</h5>
                  <span class="text-sm text-gray-500">{{ data.contact }}</span>
                  <span class="text-sm text-gray-500">{{ data.email }}</span>
                  <div class="flex mt-4 space-x-3 md:mt-6">
                    <button @click="fnEvent('edit', data)" class="bg-orange-400 hover:bg-orange-300 text-white font-bold py-2 px-4 border-b-4 border-orange-600 hover:border-orange-400 rounded">
                      <PencilSquareIcon class="h-5 w-5 text-white-500" />
                    </button>
                    <button @click="fnEvent('delete', data)" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                      <TrashIcon class="h-5 w-5 text-white-500" />
                    </button>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </teleport>
</template>

<script setup>
import {ref, defineProps, defineEmits, computed, onMounted} from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/20/solid";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
  show:{
    type: Boolean,
    default: false
  },
  data: Object
});

const emits = defineEmits(['event','close']);

const open = computed(() => props.show);

function fnEvent(event, data){
  emits('event', {
    event: event,
    id:props.data?.id,
    show:false,
    data: data
  });
}

function fnClose(){
  emits('close', false);
}

onMounted(()=>{
  console.log(props.data)
})


</script>