import axios from "axios"
import router from "../router"
// import { OK, CREATED, UNPROCESSABLE_ENTITY, INTERNAL_SERVER_ERROR} from "../utility"

const state = {
    user: null,
}

const getters = {
    isAuthenticated: state => {
        return !! state.user
    },
    username: state => { 
        return state.user ? state.user.name : ''
    },
}

const mutations = {
    setUser(state, user){
        state.user = user
    },
}

const actions = {
    //認証中のユーザー
    async getAuth(context, data){
        await axios.get('/api/auth')
        .then(response => {
            let user
            if(response.data === ''){
                user = null
            } else {
                user = response.data
            }
            context.commit('setUser', user)
        })
    },

    //新規登録
    async register(context, data){
        await axios.post('/api/register', data)
            .then(response => {
                context.commit('setUser', response.data)
                router.push('/')
            })
            .catch(error => {
                context.commit('error/setErrorCode', error.response.status, { root: true })
                context.commit('error/setErrorMessages', error.response.data.errors, { root: true })
            })
    },

    //ログイン
    async login(context, data){
        await axios.post('/api/login', data)
            .then(response => {
                context.commit('setUser', response.data)
                router.push('/')
            })
            .catch(error => {
                context.commit('error/setErrorCode', error.response.status, { root: true })
                context.commit('error/setErrorMessages', error.response.data.errors, { root: true })
            })
    },

    //ログアウト
    async logout(context, data){
        await axios.post('/api/logout')
            .then(response => {
                context.commit('setUser', null)
                router.push('/', () => {})
            })
            .catch(error => {
                context.commit('error/setErrorMessages', error.response.data.errors, { root: true })
            })
    }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}