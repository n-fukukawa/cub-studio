<template>
<div>
    <!-- <button v-if="isLiked" class="block w-16 h-16 border border-red-500 rounded-full text-red-500 focus:outline-none"> -->
        <!-- <i v-show="!isLiked" class="fas fa-heart text-xl p-1 pr-0 text-base text-gray-400 transition-all"></i>
        <i v-show="isLiked"  class="fas fa-hand-peace text-base p-1 pr-0 text-lg text-gray-400 transition-all text-blue-500"></i> -->
        <!-- <span class="text-sm">Yaeh!</span> -->
    <button v-if="isLiked" @click="click" class="focus:outline-none">
        <span class="font-logo text-sm text-red-700" v-cloak>{{ likesCount }}</span>
        <img src="/img/yaeh.svg" class="w-12 h-12">
    </button>
    <button v-if="!isLiked" @click="click" class="focus:outline-none">
        <span class="font-logo text-sm text-gray-500" v-cloak>{{ likesCount }}</span>
        <img src="/img/yaeh-gray.svg" class="w-12 h-12">
    </button>
    <!-- <button v-if="!isLiked" class="flex items-center bg-white focus:outline-none" @click="click"> -->
        <!-- <i v-show="!isLiked" class="fas fa-heart text-xl p-1 pr-0 text-base text-gray-400 transition-all"></i>
        <i v-show="isLiked"  class="fas fa-hand-peace text-base p-1 pr-0 text-lg text-gray-400 transition-all text-blue-500"></i> -->
        <!-- <span class="text-lg text-gray-500 p-1" v-cloak>{{ likesCount }}</span>
        <span class="text-sm text-gray-500">Yaeh!</span>
    </button> -->
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
