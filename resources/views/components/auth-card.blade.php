<div class="glass max-w-3xl w-5/6 mx-auto px-4 py-8 bg-white bg-opacity-90 sm:p-12 sm:rounded sm:shadow-md sm:grid sm:grid-cols-2 gap-8">
    <div class="flex flex-col items-center justify-center">
        <h2 class="font-logo px-2 text-center text-shadow text-3xl text-white font-bold tracking-superwide my-4">{{ $heading }}</h2>
    </div>
    <div class="flex items-center justify-center mt-4 sm:mt-0">
        {{ $slot }}
    </div>
</div>