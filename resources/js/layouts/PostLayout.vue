<template>
<div class="mb-2 px-2 py-2 text-sm sm:grid sm:grid-cols-2 sm:space-x-8 sm:mt-4 sm:p-8 shadow rounded">
    <div>
        <slot name="left"></slot>
    </div>
    <div>
        <slot name="right"></slot>
    </div>
</div>
</template>
<script>
export default {
    
}
</script>