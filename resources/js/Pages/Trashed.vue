

<template>
  <div class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
      <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
    </div>
<!--    <modal></modal>-->

    <div class="mx-auto max-w-2xl text-center">
      <div class="absolute right-0 top-0">
        <div  class="p-3 flex gap-3 items-center flex-row">
          <template v-if="props.isLogged">
            <a :href="route('contact.index')" class="bg-gray-100 hover:bg-gray-200 text-black font-bold py-2 px-4 border-b-4 border-gray-200 hover:border-gray-300 rounded  flex flex-row items-center gap-2">
              <ArrowUturnLeftIcon class="h-6 w-6 text-white-500" /> Voltar
            </a>

            <a :href="route('logout')" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded flex flex-row items-center gap-2">
              <ArrowLeftOnRectangleIcon class="h-6 w-6 text-white-500" /> Sair
            </a>
          </template>
          <template v-else>
            <a :href="route('login')" class="bg-blue-400 hover:bg-blue-300 text-white font-bold py-2 px-4 border-b-4 border-blue-600 hover:border-blue-400 rounded flex flex-row items-center gap-2">
              <ArrowRightOnRectangleIcon class="h-6 w-6 text-white-500" /> Entrar
            </a>

            <a :href="route('register')" class="bg-white-400 hover:bg-gray-100 text-black font-bold py-2 px-4 border-b-4 border-gray-50 hover:border-gray-200 rounded  flex flex-row items-center gap-2">
              <UserPlusIcon class="h-6 w-6 text-white-500" /> Registrar-me
            </a>
          </template>

        </div>
      </div>


      <toast v-if="state.toast.show" :show="state.toast.show" @close="fnToast">
        <template v-slot:body>{{state.toast.text}}</template>
      </toast>
      <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Lista Contatos</h2>
      <p class="mt-2 text-lg leading-8 text-gray-600">abaixo contem a sua lista de contatos.</p>

      <form class="flex items-center my-10">

        <select  v-model="state.search.type"
                 class="py-2.5 px-7 text-sm text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200">
          <option value="name" selected>Nome</option>
          <option value="contact">Contato</option>
          <option value="email">E-mail</option>
        </select>

        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
          <input v-model="state.search.value"
                 @input="fnSearch"
                 type="text" id="simple-search"
                 class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full  pr-10 p-2.5" placeholder="Buscar Contato" required>
          <div class="absolute inset-y-0 right-0 flex items-center pl-3 pointer-events-none p-2.5">
            <MagnifyingGlassIcon class="h-5 w-5 text-white-500" />
          </div>
        </div>
      </form>

    </div>
      <ul role="list" class="divide-y divide-gray-100">
        <template v-if="computedData.length > 0">
          <li v-for="person in computedData" :key="person.email" class="flex justify-between gap-x-6 py-5">
            <div class="flex gap-x-4">
              <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="person.image" alt="" />
              <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold leading-6 text-gray-900">{{ person.name }} - {{ person.contact}}</p>
                <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ person.email }}</p>
              </div>
            </div>
            <template v-if="props.isLogged">
              <div class="hidden sm:flex sm:flex-col sm:items-end">
                <div class="mt-1 flex items-center gap-x-1.5">
                  <button @click="fnRestore(person.id)" class="bg-blue-400 hover:bg-blue-300 text-white font-bold py-2 px-4 border-b-4 border-blue-600 hover:border-blue-400 rounded">
                    <ArrowUturnLeftIcon class="h-6 w-6 text-white-500" />
                  </button>
                </div>
              </div>
            </template>
          </li>
        </template>
        <template v-else>
          <li class="flex flex-col text-center border-t border-b py-5">Nenhum contato deletado até o momento!</li>
        </template>
      </ul>
  </div>
</template>
<script setup>
import {ArrowUturnLeftIcon, UserPlusIcon, ArrowRightOnRectangleIcon, ArrowLeftOnRectangleIcon, MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import Toast from "@/Components/Toast.vue";
import {computed, onBeforeMount, reactive} from "vue";
const props = defineProps(['contacts', 'user', 'isLogged']);

const state = reactive({
  data:null,
  search: {
    value:null,
    type:"name"
  },
  modalUpdateOrCreate:{
    show:false,
    data:{}
  },
  modalDetail:{
    show:false,
    data:null
  },
  toast:{
    show:false,
    icon: null,
    text:null,
  }
});

const computedData = computed({
  get : function () {
    return state.data;
  },
  set : function (newValue) {
    return state.data = newValue;
  }
});

function fnToast() {
  console.log("close toast")
  state.toast.show = false;
}

function fnRestore(id) {
  axios.put(route("contact.trashed.restore", id)).then(
      response => {
        if(response.data.status) {
          state.toast.text = response.data.message;
          state.toast.show = true;
          computedData.value = response.data.data;
        }
      }
  )
}
function fnSearch() {
  axios.post(route('contact.trashed.search'), {
    search:state.search.value,
    type:state.search.type
  }).then(response => state.data = response.data)
}

onBeforeMount(() => {
  computedData.value = props.contacts;
})



</script>
<style scoped>

</style>