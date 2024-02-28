<template>

  <div class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[470px]">
    <img :src="product.image" class="w-full h-48 object-cover" />
    <h4 class="mt-4 text-lg font-bold">{{ product.name }}</h4>

    <div class="flex justify-between flex-col">
      <div class="text-gray-700">
        <p><strong>Price:</strong> {{ product.unit_price }}</p>
        <p><strong>Category:</strong> {{ product.category }}</p>
        <p><strong>Supplier ID:</strong> {{ product.supplier_id }}</p>
        <p><strong>Stock:</strong> {{ product.stock }}</p>
      </div>
      <div class="flex items-center space-x-4 mt-8">
        <router-link
          class="flex items-center justify-center py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          :to="{ name: 'ProductView', params: { id: product.id } }">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
            <path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
          </svg>
          <span class="ml-2">Edit</span>
        </router-link>
        <button
          class="flex items-center justify-center w-10 h-10 text-red-500 rounded-full border border-transparent hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
          v-if="product.id"
          @click="emit('delete', product)">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
            <path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
          </svg>
        </button>
      </div>
    </div>
  </div>

</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const {product} = defineProps({
  product: Object
})

const emit = defineEmits(['delete'])

</script>
