<template>
  <PageComponent>

    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
          {{ route.params.id ? model.name : "Add a Product" }}
        </h1>
        <button
          v-if="route.params.id"
          type="button"
          @click="deleteProduct"
          class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-700"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -mt-1 inline-block">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>

        Delete Product
        </button>
      </div>
    </template>
    <div v-if="productLoading" class="flex justify-center">Loading...</div>
    <form v-else @submit.prevent="saveProduct" class="animate-fade-in-down">
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
          <!-- Image -->
          <div class="flex flex-row" >

            <div class="mb-6 ">
              <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
              <div class="flex items-center">
                <div class="w-64 h-48 bg-gray-100 flex-shrink-0 flex items-center justify-center rounded-md overflow-hidden">
                  <img v-if="model.image" :src="model.image" :alt="model.name" class="w-full h-full object-cover" />
                  <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-20 h-20 text-gray-300">
                    <path d="M2 7V21C2 21.5304 2.21071 22.0391 2.58579 22.4142C2.96086 22.7893 3.46957 23 4 23H20C20.5304 23 21.0391 22.7893 21.4142 22.4142C21.7893 22.0391 22 21.5304 22 21V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17 2H7C5.67392 2 4.40215 2.52678 3.46447 3.46447C2.52678 4.40215 2 5.67392 2 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 13V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 17H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                </div>

                <label for="file-input" class="sr-only">Choose file</label>
                <input @change="onImageChoose" type="file" name="file-input" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600
                  file:bg-gray-50 file:border-0 my-3
                  dark:file:bg-gray-700 dark:file:text-gray-400">
            </div>

            <div class="ml-10 w-full">
              <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="title" id="title" v-model="model.name" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>
              <div class="mt-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" v-model="model.description" autocomplete="off" class="block h-44 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mb-4"></textarea>
              </div>
            </div>

          </div>

          <!-- Form Inputs -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <Select  :product="model"/>
            <div>
              <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
              <input type="text" name="unit_price" id="unit_price" v-model="model.unit_price" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
              <label for="category"  class="block text-sm font-medium text-gray-700 mb-1">Category</label>
              <input type="text" name="category" id="category" v-model="model.category" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
            </div>
            <div>
              <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
              <input type="text" name="stock" id="stock" v-model="model.stock" autocomplete="off" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
  import PageComponent from '../components/PageComponent.vue'
  import store from '../store'
  import { ref, watch, computed } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import Select from '../components/Select.vue';
  import Alert from '../components/AlertMessage.vue';

  const route = useRoute();
  const router = useRouter();
  const productLoading = computed( () => store.state.currentProduct.loading )
  const supplierId = computed( () => store.state.supplierId.data )

  const errors = ref({});
  let model = ref({
    name: "",
    description: "",
    unit_price: "",
    category: "",
    supplier_id: "",
    stock: "",
    image: null
  });

if(route.params.id){
  store.dispatch('getProduct', route.params.id);
}

watch(
  () => store.state.currentProduct.data,
  (newVal) => {
    if (newVal) {
      model.value = {
        ...JSON.parse(JSON.stringify(newVal)),
        status: newVal.status !== "draft"
      };
    }
  }
);


  function onImageChoose(ev){
    const file = ev.target.files[0];
    const allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

    const extension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(extension)) {
        alert('Please, select an image file with extension JPG, JPEG, GIF ou PNG.');
        return;
    }

    const reader = new FileReader();
    reader.onload = () => {
      model.value.image = reader.result;

      model.value.image_url = reader.result;
    }
    reader.readAsDataURL(file);
  }


  function saveProduct(){
    model.value.supplier_id = supplierId.value.id;
    store.dispatch("saveProduct", model.value).then( ({ data }) => {
      store.commit('notify', {type: 'success', message: "Product was succesfully saved!"});
      errors.value = '';
      router.push({
        name: "ProductView",
        params: { id: data.data.id },
      });
      }).catch( err => {
        if( err.response.status === 422){
          errors.value = err.response.data.errors
        }
      })
  }

function deleteProduct(){
  if( confirm(`Are you sure you want to delete this product? Can't be undone! `) ){
    store.dispatch("deleteProduct", model.value.id)
    .then( () => {
      router.push({ name: "Products" });
    } );
  }
}

</script>
