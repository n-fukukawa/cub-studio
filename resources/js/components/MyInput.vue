<template>
<input :value="value" @input="$emit('input', $event.target.value)" 
    autocomplete ="off"
    class="w-full p-1 border-b border-gray-300 leading-6 tracking-wider text-sm placeholder-gray-600 placeholder-opacity-50 focus:ring-gray-800 focus:outline-none focus:border-gray-700"
/>
</template>
<script>
export default {
    props: {
        value: {
            type: String,
        },
    },
}
</script>