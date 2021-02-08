<template>
<nav class="fixed w-full z-50 px-4 py-2 bg-white shadow-sm">
    <div class="max-w-4xl mx-auto flex place-items-center text-lg">

    <!-- ヘッダーロゴ -->  
        <div class="flex-grow">
            <a href="/" class="font-logo tracking-wider">CubStudio.</a>
        </div>

    <!-- 認証ユーザー -->
        <div v-if="isAuthenticated">
            <!--ウィンドウサイズsm未満-->
            <div class="sm:hidden flex h-10 place-items-center space-x-2">
                <router-link to="/post/create"><i class="fas fa-edit p-1 text-blue-dark text-2xl"></i></router-link>
                <router-link :to="'/user/' + user.id"><img :src="'/storage/' + user.image" class="h-8 w-8 rounded-full border border-gray-500 shadow-inner"></router-link>
            </div>
            <!--ウィンドウサイズsm以上-->
            <div class="hidden sm:flex h-10 place-items-center text-sm space-x-4">
                <router-link to="/post/create"><i class="fas fa-edit p-1 text-blue-dark text-2xl"></i></router-link>
                <router-link :to="'/user/' + user.id"><img :src="'/storage/' + user.image" class="h-8 w-8 rounded-full border border-gray-500 shadow-inner"></router-link>
            </div>
        </div>

    <!-- ゲスト -->
        <div v-else>
            <!--ウィンドウサイズsm未満-->
            <div class="sm:hidden flex h-10 place-items-center text-sm space-x-2">
                <router-link to="/login">ログイン</router-link>
                <router-link to="/register">新規登録</router-link>
            </div>
            <!--ウィンドウサイズsm以上-->
            <div class="hidden sm:flex h-10 place-items-center text-sm space-x-4">
                <router-link to="/login">ログイン</router-link>
                <router-link to="/register">新規登録</router-link>
            </div>
        </div>
    </div>
</nav>
</template>

<script>
    export default {
        computed: {
            user(){
                return this.$store.state.auth.user
            },

            isAuthenticated(){
                return this.$store.getters['auth/isAuthenticated']
            }
        },
    }
</script>