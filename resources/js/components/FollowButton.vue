<template>
<div class="text-xs">
    <button class="focus:outline-none" @click="click">
        <div v-if="isFollowed" class="p-1 border border-orange bg-orange rounded">
            <i class="fas fa-star text-white"></i>
            <span class="text-white text-xs text-bold">フォロー中</span>
        </div>
        <div v-else class="p-1 border border-orange rounded">
            <i class="far fa-star text-orange"></i>
            <span class="text-orange text-xs text-bold">フォロー</span>
        </div>
    </button>
</div>
</template>

<script>
export default {
    props: {
        user: { 
            type: Object 
        },
        initialFollowed: { 
            type: Boolean, 
            default: false 
        },
    },
    
    data(){
        return {
            isFollowed: false
        }
    },

    watch: {
        initialFollowed() {
            this.isFollowed = this.initialFollowed
        }
    },

    methods: {
        click() {
            this.isFollowed
            ? this.unfollow()
            : this.follow()
        },

        async follow() {
            await axios.put('/api/user/' + this.user.id + '/follow')
                .then(response => {  
                    this.isFollowed = true
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                })  
        },

        async unfollow() {
            await axios.delete('/api/user/' + this.user.id + '/follow')
                .then(response => {
                    this.isFollowed = false
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                })
        },
    }
}
</script>