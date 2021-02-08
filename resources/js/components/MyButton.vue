<template>
<button class ="w-full py-2 px-4 text-white font-bold text-sm tracking-widest rounded hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:bg-gray-800 focus:ring-gray-500 transition-all" :class="'bg-' + color">
    <slot></slot>
</button>
</template>

<script>
export default {
   props: {
       //ボタンの背景色を指定できるが、CSSパージされるので、tailwind.config.jsのwhitelistに明示する必要がある。
       color: {
           type: String,
           default: 'gray-500'
        }
   }
}
</script>