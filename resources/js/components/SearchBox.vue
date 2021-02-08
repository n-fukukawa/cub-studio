<template>
<div class="relative place-items-center">
<input :value="value" @input="$emit('input', $event.target.value)" 
    :placeholder="placeholder"
    autocomplete ="off"
    class="w-full mr-2 p-2 pl-4 rounded-full border border-gray-300 tracking-wider text-base placeholder-gray-600 placeholder-opacity-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-30 focus:placeholder-transparent"
/>
<i @click="$emit('submit')" class="absolute right-2 bottom-1/2 transform translate-y-2/4 p-2 rounded-full  bg-white text-gray-600 fas fa-search cursor-pointer"></i>
</div>
</template>
<script>
export default {
    props: {
        value: {
            type: String,
        },
        placeholder: {
            type: String,
        }
    },
}
</script>