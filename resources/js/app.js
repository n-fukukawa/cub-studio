import './bootstrap.js'

import Vue from 'vue'
import router from './router'
import store from './store'

import VueLazyload from 'vue-lazyload'
import AppLayout from './AppLayout'

Vue.use(VueLazyload, {
    preLoad:'1.3', // 事前ロードする高さの割合指定
    error: '/img/no_post_image.jpg', //エラー時に表示する画像指定する
    loading: '/img/loadingl.gif', // ロード中に表示する画像指定する
    attempt: '3',// ロード失敗した時のリトライの上限指定
    // throttleWait: '0'
  })
const createApp = async () => {
    await store.dispatch('auth/getAuth')

    const app = new Vue({
        el: '#app',
        router,
        store,
        components: { AppLayout },
        template: '<app-layout />'
    });
}

createApp()

