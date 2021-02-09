<template>
<nav class="fixed w-full z-50 px-4 py-2 bg-white shadow-sm">
    <div class="max-w-4xl mx-auto flex place-items-center text-lg">

    <!-- ヘッダーロゴ -->  
        <div class="flex-grow">
            <router-link to="/" class="font-logo tracking-wider">CubStudio.</router-link>
        </div>

    <!-- 認証ユーザー -->
        <div v-if="isAuthenticated">
            <!--ウィンドウサイズsm未満-->
            <div class="sm:hidden flex h-10 place-items-center space-x-3">
                <router-link to="/post/create"><i class="far fa-plus-square p-1 text-gray-600 text-3xl"></i></router-link>
                <router-link :to="'/user/' + user.id"><img :src="image" class="h-8 w-8 rounded-full border-2 border-gray-600 shadow-inner"></router-link>
            </div>
            <!--ウィンドウサイズsm以上-->
            <div class="hidden sm:flex h-10 place-items-center text-sm space-x-4">
                <router-link to="/post/create"><i class="far fa-plus-square p-1 text-gray-600 text-3xl"></i></router-link>
                <router-link :to="'/user/' + user.id"><img :src="image" class="h-8 w-8 rounded-full border-2 border-gray-600 shadow-inner"></router-link>
            </div>
        </div>

    <!-- ゲスト -->
        <div v-else>
            <!--ウィンドウサイズsm未満-->
            <div class="sm:hidden flex h-10 place-items-center text-sm space-x-3">
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
            },

            image(){
                return this.user.image 
                    ? '/storage/' + this.user.image
                    : '/img/noimage.png'
            }

        },
    }
</script>