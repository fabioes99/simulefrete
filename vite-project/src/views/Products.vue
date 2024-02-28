
<template>
  <PageComponent >
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
          Products
        </h1>
        <router-link :to="{ name: 'ProductCreate'}" class="flex justify-between items-center py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-700 ">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Add new Product
        </router-link>
      </div>
    </template>
    <div v-if="products.loading" class="flex justify-center">Loading...</div>
    <div v-else-if="products.data && products.data.length > 0" >
      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
        <ProductListItem
          v-for="product in products.data"
          :key="product.id"
          :product="product"
          @delete="deleteProduct(product)"
          :style="{animationDelay: `${ind * 0.1}s`}"
          class="opacity-0 animate-fade-in-down"
        />
      </div>
    </div>
    <div v-else >
      No products found.
    </div>

  </PageComponent>
  </template>

  <script setup>
    import PageComponent from '../components/PageComponent.vue';
    import ProductListItem from '../views/ProductListItem.vue';
    import store from '../store'
    import { computed } from 'vue'

    import { useRouter } from 'vue-router'

    const router = useRouter();

    const products = computed( () => store.state.products )

    store.dispatch('getProducts')

    function deleteProduct(product){
    if( confirm(`Are you sure you want to delete this survey? Can't be undone! `) ){
      store.dispatch("deleteProduct", product.id)
      .then( () => {
        store.dispatch('getProducts')
      } );
    }
  }


  </script>
