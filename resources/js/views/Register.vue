<template>
<auth-layout>
    <template #heading>SIGNUP</template>
    <form @submit.prevent="register" class="w-full space-y-6">
        <div>
            <my-label for="mail">メールアドレス</my-label>
            <my-input type="email" name="email" v-model="registerForm.email"></my-input>
        </div>
        <div>
            <my-label for="mail">ユーザー名</my-label>
            <my-input type="text" name="email" v-model="registerForm.name" placeholder="半角英数字15文字以内" class="focus:placeholder-transparent"></my-input>
        </div>
        <div>
            <my-label for="password">パスワード</my-label>
            <my-input type="password" name="password" v-model="registerForm.password"></my-input>
        </div>
        <div>
            <my-label for="password_confirmation">パスワード（確認）</my-label>
            <my-input type="password" name="password_confirmation" v-model="registerForm.password_confirmation"></my-input>
        </div>
        <div class="mb-6 flex">
            <input type="checkbox" id="remember_me" name="remember" v-model="registerForm.remember" checked class="self-center mr-2 text-sm text-blue-dark rounded focus:ring-1 focus:ring-blue-dark focus:outline-none">
            <my-label for="remember_me">ログイン情報を記憶する</my-label>
        </div>
        <my-button type="submit" class="text-shadow" color="blue-dark">登録</my-button>
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
            registerForm: {
                email: '',
                name: '',
                password: '',
                password_confirmation: '',
                remember: true,
            },
        }
    },

    methods: {
        async register() {
            await this.$store.dispatch('auth/register', this.registerForm)
        }
    }
    
}
</script>