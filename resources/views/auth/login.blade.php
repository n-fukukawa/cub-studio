<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-auth-card>
        <x-slot name="heading">SIGNIN</x-slot>
        <form class="w-full text-sm" action="{{ route('login') }}" method="POST">
            <x-error-card></x-error-card>
            @csrf
            <div class="mb-6">
                <x-label for="mail">メールアドレス</x-label>
                <x-input type="email" name="email" value="{{ old('email') }}"></x-input>
            </div>
            <div class="mb-8">
                <x-label for="password">パスワード</x-label>
                <x-input type="password" name="password"></x-input>
            </div>
            <div class="mb-6 flex">
                <input type="checkbox" id="remember_me" name="remember" checked class="self-center mr-2 text-sm text-blue-dark rounded focus:ring-1 focus:ring-blue-dark focus:outline-none">
                <label for="remember_me" class="inline-block self-center text-shadow text-white text-sm">サインイン情報を記憶する</label>
            </div>
            <div class="mb-6 text-center sm:text-right">
                <button-component type="submit" class="text-shadow" color="blue-dark">サインイン</button-component>
            </div>
            <div class="text-right">
                <a class="block mb-2 text-shadow font-bold text-sm text-white hover:opacity-70 focus:outline-none" href="{{ route('password.request') }}">パスワードを忘れましたか？</a>
                <a class="block text-shadow font-bold text-sm text-white hover:opacity-70 focus:outline-none" href="{{ route('register') }}">初めての方はこちら</a>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>