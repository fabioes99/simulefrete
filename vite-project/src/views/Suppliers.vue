
<template>
<PageComponent >
  <template v-slot:header>
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Suppliers
      </h1>
      <router-link :to="{ name: 'SupplierCreate'}" class="flex justify-between items-center py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-700 ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Add new supplier
      </router-link>
    </div>
  </template>
  <div v-if="suppliers.loading" class="flex justify-center">Loading...</div>
  <div v-else-if="suppliers.data && suppliers.data.length > 0" >
    <div class="">
      <SupplierListItem
        v-for="supplier in suppliers.data"
        :key="supplier.id"
        :supplier="supplier"
        @delete="deleteSupplier(supplier)"
        :style="{animationDelay: `${ind * 0.1}s`}"
        class="opacity-0 animate-fade-in-down"
      />
    </div>
  </div>
  <div v-else >
    No suppliers found.
  </div>

</PageComponent>
</template>

<script setup>
  import PageComponent from '../components/PageComponent.vue';
  import SupplierListItem from '../views/SupplierListItem.vue';
  import store from '../store'
  import { computed } from 'vue'

  import { useRouter } from 'vue-router'

  const router = useRouter();

  const suppliers = computed( () => store.state.suppliers )

  store.dispatch('getSuppliers')

  function deleteSupplier(supplier){
  if( confirm(`Are you sure you want to delete this supplier? Can't be undone! `) ){
    store.dispatch("deleteSupplier", supplier.id)
    .then( () => {
      store.dispatch('getSuppliers')
    } );
  }
}


</script>
