<template>
    <div v-if="show" class="w-full">
        <img src="/img/loadings.gif" class="mx-auto object-cover">
    </div>
</template>
<script>
import MyButton from './MyButton'
export default {
    components: {
        MyButton,
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        }
    }
}
</script>