<x-app-layout>
<x-slot name="header"></x-slot>
    <x-auth-card>
        <x-slot name="heading">Email Verification</x-slot>
        <div>
            <x-error-card></x-error-card>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 border border-green-300 bg-green-100 text-sm text-green-600 bg-opacity-80 space-y-4">
                    メールアドレス認証用のメールを送信しました。
                </div>
            @else
            <p class="px-4 mb-6 text-center text-white">まだ本登録がされていません。始めるには、メールアドレスの認証が必要です。</p>
            @endif
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button-component color="blue-dark">メールアドレスを認証する</button-component>
            </form>

            <form id="onLogout" action="/logout" method="POST" class="mt-4 text-right">
                @csrf
                <button form="onLogout" type="submit" class="text-shadow font-bold text-sm text-white hover:opacity-70 focus:outline-none">サインアウト</button>
            </form>
        </div>
</x-auth-card>
</x-app-layout>