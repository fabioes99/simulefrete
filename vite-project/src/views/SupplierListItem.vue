<template>
  <div class="rounded-lg mb-5  overflow-hidden shadow-md bg-white hover:bg-gray-50 w-full">
    <div class="flex flex-row justify-between" >
      <div class="flex flex-col px-6 py-4 w-full ">
        <h4 class="font-bold text-lg mb-2">{{ supplier.name }}</h4>
        <div class="flex flex-wrap -mx-2 mb-4">
          <div class="w-full md:w-1/2 px-2 mb-2 md:mb-0">
            <p class="text-sm"><strong>Phone:</strong> <span v-html="supplier.phone"></span></p>
          </div>
          <div class="w-full md:w-1/2 px-2">
            <p class="text-sm"><strong>Email:</strong> <span v-html="supplier.email"></span></p>
          </div>
        </div>
        <div class="flex flex-wrap -mx-2">
          <div class="w-full md:w-1/2 px-2 mb-2 md:mb-0">
            <p class="text-sm"><strong>CEP:</strong> <span v-html="supplier.cep"></span></p>
          </div>
          <div class="w-full md:w-1/2 px-2">
            <p class="text-sm"><strong>Complement:</strong> <span v-html="supplier.complemento"></span></p>
          </div>
        </div>
        <div class="flex flex-wrap -mx-2">
          <div class="w-full md:w-1/2 px-2 mb-2 md:mb-0">
            <p class="text-sm"><strong>Neighborhood:</strong> <span v-html="supplier.bairro"></span></p>
          </div>
          <div class="w-full md:w-1/2 px-2">
            <p class="text-sm"><strong>City:</strong> <span v-html="supplier.localidade"></span></p>
          </div>
        </div>
      </div>

      <div class="flex flex-col justify-between items-center mt-4">
        <router-link
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          :to="{ name: 'SuppliersView', params: { id: supplier.id } }"
        >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
          </svg>
          Edit
        </router-link>

        <button
          class="inline-flex items-center m-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-red-500 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
          v-if="supplier.id"
          @click="emit('delete', supplier)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
          </svg>
          Delete
        </button>
      </div>
    </div>


  </div>

</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const {supplier} = defineProps({
  supplier: Object
})

const emit = defineEmits(['delete'])

</script>
