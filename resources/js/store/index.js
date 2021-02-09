import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import image from './image'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
      loading: false,
  },
  mutations: {
      setLoading(state, loading){
          state.loading = loading
      },
  },
  modules: {
      auth,
      error,
      image,
  }
})

export default store

