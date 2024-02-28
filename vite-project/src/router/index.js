import  { createRouter,createWebHistory } from 'vue-router';

import Products from '../views/Products.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Suppliers from '../views/Suppliers.vue'
import SuppliersView from '../views/SuppliersView.vue'
import ProductView from '../views/ProductView.vue'
import AuthLayout from '../components/AuthLayout.vue'
import DefaultLayout from '../components/DefaultLayout.vue'
import store from '../store'


const routes = [
  {
    path: '/',
    redirect: '/product',
    component: DefaultLayout,
    meta: {requiresAuth: true},
    children: [
      { path: '/product', name: 'Products', component: Products },
      { path: '/supplier', name: 'Suppliers', component: Suppliers },
      { path: '/supplier/create', name: 'SupplierCreate', component: SuppliersView },
      { path: '/product/create', name: 'ProductCreate', component: ProductView },
      { path: '/product/:id', name: 'ProductView', component: ProductView },
      { path: '/supplier/:id', name: 'SuppliersView', component: SuppliersView }
    ]
  },
  {
    path: '/auth',
    name: 'Auth',
    redirect: '/login',
    component: AuthLayout,
    meta: {isGuest: true},
    children:[
      {
        path: '/login',
        name: 'Login',
        component: Login
      },
      {
        path: '/register',
        name: 'Register',
        component: Register
      }
    ]
  },


];

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next )=>{
  if( to.meta.requiresAuth && !store.state.user.token){
    next({name: 'Login'})
  }else if(store.state.user.token && (to.meta.isGuest)){
    next({name: 'Products'})
  }else{
    next()
  }
})

export default router;
