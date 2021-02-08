<template>
<auth-layout>
    <template #heading>LOGIN</template>
    <form @submit.prevent="login" class="w-full space-y-6">
        <div>
            <my-label for="mail">メールアドレス</my-label>
            <my-input type="email" name="email" v-model="loginForm.email"></my-input>
        </div>
        <div>
            <my-label for="password">パスワード</my-label>
            <my-input type="password" name="password" v-model="loginForm.password"></my-input>
        </div>
        <div class="mb-6 flex">
            <input type="checkbox" id="remember_me" name="remember" v-model="loginForm.remember" checked class="self-center mr-2 text-sm text-blue-dark rounded focus:ring-1 focus:ring-blue-dark focus:outline-none">
            <my-label for="remember_me">ログイン情報を記憶する</my-label>
        </div>
        <my-button type="submit" color="blue-dark">ログイン</my-button>
        <div class="text-right">
            <!-- <router-link :to="{ name: 'for', params: { userId: 123 }}" class="block mb-2 text-shadow font-bold text-sm text-white hover:opacity-70 focus:outline-none" href="{{ route('password.request') }}">パスワードを忘れましたか？</a> -->
        </div>
    </form>
</auth-layout>
</template>
<script>
import AuthLayout from '../layouts/AuthLayout'
import MyLabel from '../components/MyLabel'
import MyInput from '../components/MyInput'
import MyButton from '../components/MyButton'

export default {
    components: {
        AuthLayout,
        MyLabel,
        MyInput,
        MyButton,
    },
    data() {
        return {
            loginForm: {
                email: '',
                password: '',
                remember: true,
            },
        }
    },
    methods: {
        login() {
            this.$store.dispatch('auth/login', this.loginForm)
        },
    },
}
</script>