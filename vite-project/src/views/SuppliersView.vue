<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
          {{ route.params.id ? model.name : "Add a Supplier" }}
        </h1>
        <button
          v-if="route.params.id"
          type="button"
          @click="deleteSupplier"
          class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-700"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -mt-1 inline-block">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>

        Delete Supplier
        </button>
      </div>
    </template>
    <div v-if="supplierLoading" class="flex justify-center">Loading...</div>
    <form v-else @submit.prevent="saveSupplier" class="animate-fade-in-down">
      <Alert v-if="Object.keys(errors).length" class="flex-col items-stretch text-sm">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col">
            <div v-for="(field, index) of Object.keys(errors)" :key="index">
              <div v-for="(error, ind) of errors[field] || []" :key="ind">
                * {{ error }}
              </div>
            </div>
          </div>
          <span
          @click="errors = ''"
          class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </span>
        </div>

      </Alert>
      <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <!-- Form Inputs -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
              <input type="text" name="title" id="title" v-model="model.name" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
              <input type="text" v-maska data-maska="(##) #####-####"  placeholder="(15) 12345-8910" name="phone" id="phone" v-model="model.phone" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" name="email" id="email" v-model="model.email" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="cep"  class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
              <input type="text" v-maska data-maska="##-### ###" placeholder="18-017 188" name="cep" id="cep" v-model="model.cep" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @blur="searchViaCEP">
            </div>
            <div>
              <label for="complemento" class="block text-sm font-medium text-gray-700 mb-1">Additional Address Info</label>
              <input type="text" name="complemento" id="complemento" v-model="model.complemento" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="bairro" class="block text-sm font-medium text-gray-700 mb-1">Neighborhood</label>
              <input type="text" name="bairro" id="bairro" v-model="model.bairro" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="localidade" class="block text-sm font-medium text-gray-700 mb-1">City</label>
              <input type="text" name="localidade" id="localidade" v-model="model.localidade" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="uf" class="block text-sm font-medium text-gray-700 mb-1">State</label>
              <input type="text" name="uf" id="uf" v-model="model.uf" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
          </div>

          <!-- Save Button -->
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Save
            </button>
          </div>
        </div>
      </div>

    </form>
  </PageComponent>

</template>

<script setup>
  import axios from 'axios';
  import PageComponent from '../components/PageComponent.vue'
  import store from '../store'
  import { ref, watch, computed } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import { vMaska } from 'maska'
  import Alert from '../components/AlertMessage.vue'

  const route = useRoute();
  const router = useRouter();
  const supplierLoading = computed( () => store.state.currentSupplier.loading )

  const errors = ref({});
  let model = ref({
    name: "",
    phone: "",
    email: "",
    cep: "",
    complemento: "",
    bairro: "",
    localidade: "",
    uf: "",
  });

if(route.params.id){
  store.dispatch('getSupplier', route.params.id);
}

watch(
  () => store.state.currentSupplier.data,
  (newVal) => {
    if (newVal) {
      model.value = {
        ...JSON.parse(JSON.stringify(newVal)),
        status: newVal.status !== "draft"
      };
    }
  }
);

function searchViaCEP(){

      const cep = model.value.cep.replace('-', '').replace(' ', '');
      axios.get(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => {
          model.value.complemento = response.data.complemento;
          model.value.bairro = response.data.bairro;
          model.value.localidade = response.data.localidade;
          model.value.uf = response.data.uf;
        })
        .catch(error => {
          console.error('Erro ao buscar CEP:', error);
        });

}


  function saveSupplier(){
    store.dispatch("saveSupplier", model.value).then( ({ data }) => {
      store.commit('notify', {type: 'success', message: "Supplier was succesfully saved!"});
      errors.value = '';
      router.push({
        name: "SuppliersView",
        params: { id: data.data.id },
      });
      } ).catch(err => {

        if( err.response.status === 422){
          errors.value = err.response.data.errors
        }
    })
  }

function deleteSupplier(){
  if( confirm(`Are you sure you want to delete this supplier? Can't be undone! `) ){
    store.dispatch("deleteSupplier", model.value.id)
    .then( () => {
      router.push({ name: "Suppliers" });
    } );
  }
}

</script>
