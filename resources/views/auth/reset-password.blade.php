<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-auth-card>
        <x-slot name="heading">New Password</x-slot>
        <form class="w-full text-sm" action="{{ route('password.update') }}" method="POST">
            <p class="px-4 mb-6 text-white">新しいパスワードを設定します</p>
            <x-error-card></x-error-card>
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-8">
                <x-label for="password">新しいパスワード</x-label>
                <x-input type="password" name="password"></x-input>
            </div>
            <div class="mb-8">
                <x-label for="password_confirmation">新しいパスワード（確認）</x-label>
                <x-input type="password" name="password_confirmation"></x-input>
            </div>
            <div class="mb-6 text-center sm:text-right">
                <button-component type="submit" class="text-shadow" color="blue-dark">送信</button-component>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>