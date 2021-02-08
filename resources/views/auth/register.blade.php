<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-auth-card>
        <x-slot name="heading">SIGNUP</x-slot>
        <form class="w-full text-sm tracking-wider" action="{{ route('register') }}" method="POST">
            <x-error-card></x-error-card>
            @csrf
            <div class="mb-6">
                <x-label for="name">ユーザー名<span class="text-xs"> (半角英数字)</span></x-label>
                <x-input type="text" name="name" value="{{ old('name') }}"></x-input>
            </div>
            <div class="mb-6">
                <x-label for="mail">メールアドレス</x-label>
                <x-input type="email" name="email" value="{{ old('email') }}"></x-input>
            </div>
            <div class="mb-6">
                <x-label for="password">パスワード</x-label>
                <x-input type="password" name="password"></x-input>
            </div>
            <div class="mb-8">
                <x-label for="password_confirmation">パスワード（確認）</x-label>
                <x-input type="password" name="password_confirmation"></x-input>
            </div>
            <div class="mb-6 text-center sm:text-right">
                <button-component type="submit" color="blue-dark">登録</button-component>
            </div>
            <div class="text-right">
                <a class="text-sm font-bold text-white hover:opacity-70 focus:outline-none" href="{{ route('login') }}">サインインはこちら</a>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>