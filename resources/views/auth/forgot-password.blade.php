<x-app-layout>
    <x-slot name="header"></x-slot>
    <x-auth-card>
        <x-slot name="heading">Reset<br>Password</x-slot>
        <form class="w-full" action="{{ route('password.email') }}" method="POST">
            <p class="px-4 mb-6 text-white">パスワード再設定用のメールをお送りします</p>
            <x-error-card></x-error-card>
            @if(session('status'))
            <div class="mb-4 p-4 border border-green-300 bg-green-100 text-xs text-green-600 space-y-4 bg-opacity-80">{{ session('status') }}</div>
            @endif
            @csrf
            <div class="mb-8">
                <x-label for="mail">メールアドレス</x-label>
                <x-input type="email" name="email"></x-input>
            </div>
            <div class="mb-6 text-center sm:text-right">
                <button-component type="submit" color="blue-dark">送信</button-component>
            </div>
            <div class="text-right">
                <a class="text-sm text-white font-bold hover:opacity-70 focus:outline-none" href="{{ route('login') }}">サインインはこちら</a>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>