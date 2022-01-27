import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

Vue.use(VueRouter)


import Welcome from '../pages/Welcome';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Home from '../pages/Home';
const routes = [
    {
        name: 'welcome',
        path: '/',
        component: Welcome,
        meta:{
            middleware:"guest",
            title:`Welcome`
        }
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta:{
            middleware:"guest",
            title:`Register`
        }
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta:{
            middleware:"guest",
            title:`Login`
        }
    },
    {
        name: 'home',
        path: '/home',
        component: Home,
        meta:{
            middleware:"auth",
            title:`Home`
        }
    },
];

const router  = new VueRouter({
    mode: 'history',
    routes: routes
})

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - GuestBook`
    if(to.meta.middleware == "guest"){
        if(store.state.auth.authenticated){
            next({name:"home"})
        }
        next()
    }else{
        if(store.state.auth.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router
