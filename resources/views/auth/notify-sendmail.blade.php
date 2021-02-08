<x-app-layout>
<x-slot name="header"></x-slot>
    <x-auth-card>
        <x-slot name="heading">Thanks for Registration</x-slot>
        <div class="px-4">            
            <p class="mb-4 text-white">
                仮登録が完了しました。メールをご確認いただき、本登録を完了してください。
            </p>
            <a href="{{ route('verification.notice') }}" class="flex justify-end text-white underline">メールが届かない場合</a>
        </div>
</x-auth-card>
</x-app-layout>