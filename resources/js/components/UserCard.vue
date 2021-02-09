<template>
<router-link :to="'/user/' + user.id" class="flex place-items-center px-2 py-4">
    <div>
        <img :src="image" alt="" class="h-8 w-8 rounded-full border border-gray-200 shadow-inner">
    </div>
    <div class="ml-2 text-base sm:text-base flex-grow">{{ user.name }}</div>
    <!-- <follow-component v-if="!user.isMe" :user="user" :initialIsFollowed="user.isFollowed"/> -->
</router-link>
</template>

<script>
import FollowButton from './FollowButton'
export default {
    components: {
        FollowButton,
    },
    props: {
        user: { type: Object },
    },
    computed: {
         image(){
            return this.user.image 
                ? '/storage/' + this.user.image
                : '/img/noimage.png'
        }
    }
}
</script>