<template>
<div>
    <header>
        <navigation-header />
    </header>
    <main class="max-w-3xl mx-auto pt-16 px-2 text-gray-700 tracking-wider sm:px-8">
        <transition mode="out-in" appear>
            <router-view />
        </transition>
    <loading v-if="loading"/>
    </main>
    <error-modal v-if="errorModal" @close="close"/>
</div>
</template>

<script>
import { INTERNAL_SERVER_ERROR, TOKEN_MISMATCH, UNPROCESSABLE_ENTITY, NOT_FOUND, UNAUTHORIZED, FORBIDDEN } from './utility'
import NavigationHeader from './components/NavigationHeader'
import ErrorModal from './components/ErrorModal'
import Loading from './components/Loading'

export default {
    components: {
        NavigationHeader,
        ErrorModal,
        Loading,
    },

    data() {
        return {
            errorModal: false,
        }
    },

    computed: {
        errorCode() {
            return this.$store.state.error.errorCode
        },

        errorMessages() {
            return this.$store.state.error.errorMessages
        },

        loading() {
            return this.$store.state.loading
        }
    },

    methods: {
        close() {
            this.errorModal = false
            this.$store.commit('error/setErrorMessages', null)
        },
    },

    watch: {
        errorCode() {
            switch(this.errorCode){
                //422　バリデーションエラーの場合、モーダルを表示
                case UNPROCESSABLE_ENTITY:
                    this.errorModal = true
                    this.$store.commit('error/setErrorCode', null)
                    break

                //500エラーの場合、サーバーエラー画面に移動
                case INTERNAL_SERVER_ERROR:
                    this.$router.push('/server-error')
                    this.$store.commit('error/setErrorCode', null)
                    break

                //401 要認証エラーの場合、モーダルを表示
                case UNAUTHORIZED:
                    this.errorModal = true
                    this.$store.commit('error/setErrorCode', null)
                    this.$store.commit('error/setErrorMessages', {'message': ['ログインが必要です']})
                    break

                //401 要認証エラーの場合、モーダルを表示
                case FORBIDDEN:
                    this.errorModal = true
                    this.$store.commit('error/setErrorCode', null)
                    this.$store.commit('error/setErrorMessages', {'message': ['不正なアクションです']})
                    this.$router.push('/')
                    break

                //404 エラーの場合、NotFound画面に移動
                case NOT_FOUND:
                    this.$router.push('/not-found')
                    this.$store.commit('error/setErrorCode', null)
                    break

                //419 トークンミスマッチエラーの場合、
                // case TOKEN_MISMATCH:
                //     this.$store.commit('error/setErrorMessages', {'error': ['ページを更新して再試行してください。']})
                //     this.errorModal = true
                //     this.$store.commit('error/setErrorCode', null)
                //     break
            }
        },

    }
}
</script>

<style scoped>
    .v-enter-active {
        transition: opacity 0.8s;
    }
    .v-leave-active {
        transition: opacity 0.3s;
    }
    .v-enter, .v-leave-to {
        opacity: 0.0;
    }

</style>