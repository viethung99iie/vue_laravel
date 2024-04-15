    import { createRouter, createWebHistory } from 'vue-router'
    import Login from '@/views/backend/Login.vue'
    import Dashboard from '@/views/backend/Dashboard.vue'
    import authMiddleware from '@/middleware/auth'
    import loginMiddleware from '@/middleware/login'
    import UserCatalogueIndex from '@/views/backend/user/catalogue/View.vue'
    import UserCatalogueStore from '@/views/backend/user/catalogue/Store.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {path: '/admin',name: 'login',component: Login,meta: {middleware: [loginMiddleware]}},
    {path: '/dashboard',name: 'dashboard.index',component: Dashboard,meta: {middleware: [authMiddleware]}},
    {path: '/user/catalogue/index',name: 'user.catalogue.index',component: UserCatalogueIndex,meta: {middleware: [authMiddleware]}},
    {path: '/user/catalogue/store',name: 'user.catalogue.store',component: UserCatalogueStore,meta: {middleware: [authMiddleware]}},
    // {path: '/user/store',name: 'user.store',component: UserStore},
    // {path: '/user/delete',name: 'user.delete',component: UserDelete},
  ]
})

router.beforeEach((to, from, next) => {
	if(to.meta.middleware){
		const middleware = to.meta.middleware
		middleware.forEach( m => m(to, from, next) )
	}else{
		next()
	}
})

export default router
