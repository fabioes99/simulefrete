import {createStore} from "vuex";
import axiosClient from "../axios";


const store = createStore({
  state: {
    user: {
    data: {},
    token: sessionStorage.getItem('TOKEN')
    },
    currentSupplier: {
      loading: false,
      data: {}
    },
    currentProduct: {
      loading: false,
      data: {}
    },
    suppliers: {
      loading: false,
      data: []
    },
    products:{
      loading: false,
      data: []
    },
    supplierId:{
      data: []
    },
    notification: {
      show: false,
      type: null,
      message: null
    }
  },
  getters: {},
  actions: {
    register({commit}, user){
      return axiosClient.post('/register', user)
      .then(({data}) => {
        commit('setUser', data)
        return data
      })

    },
    login({commit}, user){
      return axiosClient.post('/login', user)
      .then(({data}) => {
        console.log(data);
        commit('setUser', data)
        return data
      })
    },
    logout({commit}){
      return axiosClient.post('/logout')
      .then(response => {
        commit('logout')
        return response
      })
    },
    getSupplier({commit}, id){
      commit("setCurrentSupplierLoading", true);
      return axiosClient.get(`/supplier/${id}`)
      .then(response => {
        commit("setCurrentSupplier", response.data);
        commit("setCurrentSupplierLoading", false);
        return response
      })
      .catch( (err) => {
        commit("setCurrentSupplierLoading", false);
        throw err;
      } )
    },
    getProduct({commit}, id){
      commit("setCurrentProductLoading", true);
      return axiosClient.get(`/product/${id}`)
      .then(response => {
        commit("setCurrentProduct", response.data);
        commit("setCurrentProductLoading", false);
        return response
      })
      .catch( (err) => {
        commit("setCurrentProductLoading", false);
        throw err;
      } )
    },
    saveSupplier( {commit}, supplier ){
      delete supplier.image_url;
      let response;

      if(supplier.id){
        response = axiosClient.put(`/supplier/${supplier.id}`, supplier)
        .then( (res) => {
          commit("setCurrentSupplier", res.data)
          return res
        } )
      } else {
        response = axiosClient.post('/supplier', supplier)
        .then( res => {
            commit('setCurrentSupplier', res.data)
            return res
        } )
      }

      return response;
    },
    saveProduct( {commit}, product ){
      let response;
      console.log(product);
      if(product.id){
        response = axiosClient.put(`/product/${product.id}`, product)
        .then( (res) => {
          commit("setCurrentProduct", res.data)
          return res
        } )
      } else {
        response = axiosClient.post('/product', product)
        .then( res => {
            commit('setCurrentProduct', res.data)
            return res
        } )
      }

      return response;
    },
    deleteSupplier({}, id){
      return axiosClient.delete(`/supplier/${id}`);
    },
    deleteProduct({}, id){
      return axiosClient.delete(`/product/${id}`);
    },
    getSuppliers({commit}, { url = null } = {}){
      url = url || "/supplier";
      commit('setSuppliersLoading', true);
      return axiosClient.get(url)
      .then( (res) => {
        commit('setSuppliersLoading', false);
        commit('setSuppliers', res.data);
        return res
      })
    },
    getProducts({commit}, { url = null } = {}){
      url = url || "/product";
      commit('setProductsLoading', true);
      return axiosClient.get(url)
      .then( (res) => {
        commit('setProductsLoading', false);
        commit('setProducts', res.data);
        return res
      })
    }
  },
  mutations: {
    setCurrentSupplierLoading:( state, loading ) => {
      state.currentSupplier.loading = loading;
    },
    setCurrentProductLoading:( state, loading ) => {
      state.currentProduct.loading = loading;
    },
    setSuppliersLoading: (state, loading) => {
      state.suppliers.loading = loading;
    },
    setProductsLoading: (state, loading) => {
      state.products.loading = loading;
    },
    setCurrentSupplier:( state , suppliers ) => {
      state.currentSupplier.data = suppliers.data;
    },
    setCurrentProduct:( state , product ) => {
      state.currentProduct.data = product.data;
    },
    setSuppliers: (state, suppliers) => {
      state.suppliers.data = suppliers.data;
    },
    setSupplierId: (state, id) => {
      state.supplierId.data = id;
    },
    setProducts: (state, products) => {
      state.products.data = products.data;
    },
    logout: (state) => {
      state.user.data = {};
      state.user.token = null;
      sessionStorage.removeItem('TOKEN');
    },
    setUser: (state, userData) => {
      state.user.token = userData.token;
      state.user.data = userData.user;
      sessionStorage.setItem('TOKEN', userData.token);
    },
    notify: ( state, {message, type}) => {
      state.notification.show = true;
      state.notification.message = message;
      state.notification.type = type;
      setTimeout(() => {
        state.notification.show = false;
      }, 3000);
    }
  },
  modules: {},
});


export default store;
