import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

import PostList from './views/PostList'
import PostSearch from './views/PostSearch'

import Login from './views/Login'
import Register from './views/Register'

import PostCreate from './views/PostCreate'
import PostShow from './views/PostShow'
import PostEdit from './views/PostEdit'

import UserPage from './views/UserPage'
import UserEdit from './views/UserEdit'

import ServerError from './views/ServerError'
import NotFound from './views/NotFound'


Vue.use(VueRouter)

const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                component: PostList
            },

            {
                path: '/post/search/:keyword?',
                component: PostSearch,
                props: true,
            },

            {
                path: '/login',
                component: Login,
                beforeEnter(to, from, next){
                    if(store.getters['auth/isAuthenticated']){
                        next('/')
                    } else {
                        next()
                    }
                }
            },

            {
                path: '/register',
                component: Register,
                beforeEnter(to, from, next){
                    if(store.getters['auth/isAuthenticated']){
                        next('/')
                    } else {
                        next()
                    }
                }
            },

            {
                path: '/post/create',
                component: PostCreate,
                beforeEnter(to, from, next){
                    if(store.getters['auth/isAuthenticated']){
                        next()
                    } else {
                        next('/login')
                    }
                }
            },

            {
                path: '/post/:id',
                component: PostShow,
                props: true,
            },

            {
                path: '/post/:id/edit',
                component: PostEdit,
                props: true,
                beforeEnter(to, from, next){
                    if(store.getters['auth/isAuthenticated']){
                        next()
                    } else {
                        next('/login')
                    }
                }
            },

            {
                path: '/user/:id',
                component: UserPage,
                props: true,
            },

            {
                path: '/user/:id/edit',
                component: UserEdit,
                props: true,
                beforeEnter(to, from, next){
                    if(store.getters['auth/isAuthenticated']){
                        next()
                    } else {
                        next('/login')
                    }
                }
            },

            {
                path: '/server-error',
                component: ServerError,
            },

            {
                path: '/not-found',
                component: NotFound,
            },

        ],
    });

export default router
