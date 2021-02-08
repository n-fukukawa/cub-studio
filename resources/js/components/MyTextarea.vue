<template>
<textarea :value="value" @input="$emit('input', $event.target.value)" 
    autocomplete ="off" rows="5" 
    placeholder="本文を入力してください..."
    class="w-full resize-none p-1  border border-gray-300 leading-6 tracking-wider text-sm placeholder-gray-600 placeholder-opacity-50 focus:outline-none focus:ring-transparent focus:border-l focus:border-r-0 focus:border-gray-400 focus:placeholder-transparent">
</textarea>
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