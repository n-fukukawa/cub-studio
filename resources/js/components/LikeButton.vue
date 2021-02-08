<template>
<div>
    <button class="focus:outline-none" @click="click">
        <i v-show="!isLiked" class="far fa-hand-peace text-2xl p-1 pr-0 text-lg text-gray-400 transition-all"></i>
        <i v-show="isLiked"  class="fas fa-hand-peace text-2xl p-1 pr-0 text-lg text-gray-400 transition-all text-blue-500"></i>
        <span class="text-lg text-gray-500 p-1 pl-0.5" v-cloak>{{ likesCount }}</span>
    </button>
</div>
</template>
<script>
export default {
    props: [
        'post', 'initialLiked', 'initialCount',
    ],

    data() {
        return {
            isLiked: false,
            likesCount: 0,
        }
    },

    watch: {
        initialLiked() {
            this.isLiked =  this.initialLiked
        },
        initialCount() {
            this.likesCount =  this.initialCount
        },
    },
    
    methods: {
        click() {
            this.isLiked
            ? this.unlike()
            : this.like()
        },

        async like() {
            await axios.put('/api/post/' + this.post.id + '/like')
                .then(response => {
                    this.isLiked = true
                    this.likesCount = response.data.likesCount
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                })
        },

        async unlike() {
            await axios.delete('/api/post/' + this.post.id + '/like')
                .then(response => {
                    this.isLiked = false
                    this.likesCount = response.data.likesCount
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                })
        },
    }
}
</script>
