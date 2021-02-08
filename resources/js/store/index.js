import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import image from './image'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
      loading: false,
      keyForRender: 0,
  },
  mutations: {
      setLoading(state, loading){
          state.loading = loading
      },
      forceRender(state){
          state.KeyForRender++
      }
  },
  modules: {
      auth,
      error,
      image,
  }
})

export default store

