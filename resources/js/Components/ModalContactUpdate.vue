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
              <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-128 sm:max-w-lg">
                <div class="absolute top-0 right-0 pr-2 pt-2 z-50">
                  <a @click="fnClose" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-0.5 ml-auto inline-flex items-center" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                  </a>
                </div>
                <div class="flex flex-col items-center py-10">

                  <div class="isolate bg-white px-6 py-0 sm:py-5 lg:px-8">
                    <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
                      <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
                    </div>
                    <div class="mx-auto max-w-2xl text-center">
                      <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Editar Contato</h2>
                      <p class="mt-2 text-lg leading-8 text-gray-600">Preencha os campos obrigatórios.</p>
                    </div>
                    <form @submit.prevent="update" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-10">
                      <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                        <div class="sm:col-span-2">
                          <label for="company" class="block text-sm font-semibold leading-6 text-gray-900">Nome</label>
                          <div class="mt-2.5">
                            <input type="text" v-model="computedData.name" name="name" id="name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            <div class="text-sm text-red-600 mt-2" v-if="errors.name">{{ errors.name[0] }}</div>
                          </div>
                        </div>
                        <div class="sm:col-span-2">
                          <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Contato</label>
                          <div class="mt-2.5">
                            <input type="tel" v-model="computedData.contact" name="phone" id="phone" autocomplete="phone" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            <div class="text-sm text-red-600 mt-2" v-if="errors.contact">{{ errors.contact[0] }}</div>
                          </div>
                        </div>
                        <div class="sm:col-span-2">
                          <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">E-mail</label>
                          <div class="mt-2.5">
                            <input type="email" v-model="computedData.email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            <div class="text-sm text-red-600 mt-2" v-if="errors.email">{{ errors.email[0] }}</div>
                          </div>
                        </div>
                      </div>
                      <div class="mt-10">
                        <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm
                        hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
                      </div>
                    </form>
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
import {computed, onMounted, defineEmits, defineProps, ref, reactive, onBeforeMount} from 'vue'
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot
} from '@headlessui/vue'

const props = defineProps({
  show:{
    type: Boolean,
    default: false
  },
  data:{
    type:Object,
    default: null
  },
});


const open = computed(() => props.show);

const emit = defineEmits(['close', 'event']);
function fnClose(){
  errors.value = {};
  emit('close', false);
}
const errors = ref({});

const data = ref({
  name: null,
  contact: null,
  email: null,
})

const computedData = computed({
  get: () => {
  data.value = props.data;
  return data.value;
  },
  set: (value)=> {
    data.value = value;
  }
} );


function update() {
  let data = {
    id:props.data?.id,
    name: computedData.value.name,
    contact: computedData.value.contact,
    email: computedData.value.email,
  }
  axios.put(route('contact.update', props.data?.id), data).then(
      response => {
        if(response.data.status){
          errors.value = {};
          emit("event", response.data);
        }
      }
  ).catch(error => {
    console.log(error);
    errors.value = error.response.data.errors;
  });
}

</script>