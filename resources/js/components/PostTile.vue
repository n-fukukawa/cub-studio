<template>
<router-link :to="'/post/' + post.id">
    <img v-lazy="'/storage/' + post.image" class="border-white border" width="100%" height="auto">
</router-link>
</template>
<script>
export default {
    props: {
        post: Object
    }
}
</script>