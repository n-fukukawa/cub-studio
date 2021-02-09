<template>
<div>
    <div class="mt-4">
        <div class="w-full mx-auto px-4 py-8 bg-white shadow rounded sm:grid sm:grid-cols-2 sm:max-w-3xl sm:py-16 sm:px-8">
            <div class="flex items-center justify-center font-logo text-3xl font-bold text-gray-700 tracking-superwide mt-4 mb-8 sm:my-0">
                <slot name="heading" />
            </div>
            <div class="flex items-center justify-center">
                <slot />
            </div>
        </div>
    </div>
</div>
</template>