<template>
<div>
    <div class="relative">
        <div class="p-8">
        <!-- プロフィール写真 -->
            <div class="mb-4 flex justify-center">
                <img :src="'/storage/' + user.image" alt="" class="h-48 w-48 rounded-full border-2 border-gray-200 shadow-inner">
            </div>
        <!-- ユーザーネーム -->
            <div class="mb-2 flex justify-center place-items-center items-center font-bold text-base sm:text-base flex-grow">
                <router-link :to="'/user/' + user.id" class="text-lg tracking-wider" :class="{'pl-4' :mine}">{{ user.name }}</router-link>
                <router-link v-if="mine" :to="'/user/' + user.id + '/edit'" class="text-sm"><i class="fas fa-pen ml-2 text-gray-400"></i></router-link>
            </div>        
        <!-- フォローボタン -->
            <follow-button v-if="!mine" :user="user" :initial-followed="user.isFollowed" class="flex justify-center mb-4" />
        <!-- ログアウト -->
            <div class="flex justify-center mb-4">
                <button v-if="mine" @click="logout" class="text-sm text-gray-500 focus:outline-none hover:underline">ログアウト</button>
            </div>

            <div class="mb-2 border-t border-gray-300"></div>

        <!-- 投稿数　-->
            <div class="flex mb-2 justify-center  space-x-3 text-sm text-gray-500 sm:text-sm">
                <button @click="active = 'posts'" class="inline-block focus:outline-none">投稿数<span class="pl-1">{{ posts.length }}</span></button>
            </div>
        <!-- フォロー数、フォロワー数 -->
            <div class="flex mb-2 justify-center space-x-3 text-sm text-gray-500 sm:text-sm">
                <button @click="active = 'followings'" class="inline-block focus:outline-none"><span class="pr-1">{{ followings.length }}</span>フォロー</button>
                <button @click="active = 'followers'" class="inline-block focus:outline-none"><span class="pr-1">{{ followers.length }}</span>フォロワー</button>
            </div>

            <div class="mb-6 border-t border-gray-300"></div>

        <!-- 自己紹介文 -->
            <div class="flex px-4 justify-center text-gray-500 text-sm">{{ user.introduction }}</div>

        </div>

        <!-- 表示切り替えタブ -->
        <div class="grid grid-cols-4 justify-items-auto my-2 text-center">
            <button @click="active = 'posts'"      class="inline-block py-2 border-t border-r border-r-gray-900 border-l bg-white shadow-inner focus:outline-none" :class="{'bg-gray-200' :active !== 'posts'}"><i class="far fa-clone"></i></button>
            <button @click="active = 'likes'"      class="inline-block py-2 border-t border-r border-r-gray-900 border-l bg-white shadow-inner focus:outline-none" :class="{'bg-gray-200' :active !== 'likes'}"><i class="far fa-hand-peace"></i></button>
            <button @click="active = 'followings'" class="inline-block py-2 border-t border-r border-r-gray-900 border-l bg-white shadow-inner focus:outline-none" :class="{'bg-gray-200' :active !== 'followings'}"><i class="far fa-star"></i></button>
            <button @click="active = 'followers'"  class="inline-block py-2 border-t border-r border-r-gray-900 border-l bg-white shadow-inner focus:outline-none" :class="{'bg-gray-200' :active !== 'followers'}"><i class="fas fa-user-friends"></i></button>
        </div>
    </div>

<!-- コンテンツ -->
    <transition appear>
    <div v-if="active === 'posts'">
        <p v-if="posts.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">{{user.name}}さんの投稿</p>
        <p v-if="!posts.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">まだ投稿はありません</p>
        <div class="grid grid-cols-12 mt-2 sm:mt-20 sm:gap-1">
            <post-tile v-for="post in posts" :post="post" :key="post.id" class="col-span-6 items-strech sm:col-span-3"/>
        </div>    
    </div>
    <div v-if="active === 'likes'">
        <p v-if="likes.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">{{user.name}}さんがヤエーした投稿</p>
        <p v-if="!likes.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">まだヤエーした投稿はありません</p>
        <div class="grid grid-cols-12 mt-2 sm:mt-20 sm:gap-1">
            <post-tile v-for="post in likes" :post="post" :key="post.id" class="col-span-6 items-strech sm:col-span-3"/>
        </div>
    </div>
    <div v-if="active === 'followings'">
        <p v-if="followings.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">{{user.name}}さんがフォロー中</p>
        <p v-if="!followings.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">まだフォローしていません</p>
        <div class="mt-2 sm:mt-20 sm:gap-1">
            <user-card v-for="person in followings" :user="person" :key="person.id"/>
        </div>
    </div>
    <div v-if="active === 'followers'">
        <p v-if="followers.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">{{user.name}}さんをフォロー中</p>
        <p v-if="!followers.length" class="py-2 text-sm text-center text-gray-500 tracking-wider">まだフォローされていません</p>
        <div class="mt-2 sm:mt-20 sm:gap-1">
            <user-card v-for="person in followers" :user="person" :key="person.id"/>
        </div>
    </div>

    </transition>
	    <!-- <div class="flex justify-center p-4 text-gray-400 sm:p-16">
            <button  @click="getItems()" class="focus:outline-none">つづきを読み込む ↓</button>
    	</div> -->
    <!-- <div class="text-gray-400 text-center my-8">
        まだ投稿がありません
    </div> -->
</div>
</template>

<script>
import PostTile from '../components/PostTile'
import UserCard from '../components/UserCard'
import FollowButton from '../components/FollowButton'

export default {
    components: {
        PostTile,
        UserCard,
        FollowButton
    },

    async created() {
        this.getUser()
    },

    watch:{
        $route (to, from){
            this.getUser(to.params.id)
        }
    },

    props: {
        id: {
                type: String    //ルートパラメーター（ユーザーID）
            }
    },

    data() {
        return {
            user: {},
            posts: {},
            likes: {},
            followings: {},
            followers: {},
            active: 'posts',
        }
    },
    computed: {
        mine() {
            return this.$store.state.auth.user
                ? this.$store.state.auth.user.id === this.user.id
                : false
        }
    },

    methods: {
        async getUser(id = this.id) {
            this.$store.commit('setLoading', true)
            await axios.get('/api/user/' + id)
                .then(response => {
                    this.user = response.data.user
                    this.posts = response.data.posts
                    this.likes = response.data.likes
                    this.followings = response.data.followings
                    this.followers = response.data.followers
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                })
                .finally(() => {
                    this.$store.commit('setLoading', false)
                })
        },

        logout() {
            this.$store.dispatch('auth/logout')
        }
    
    },
}
</script>

<style scoped>
    .v-enter-active {
        transition: opacity 0.8s;
    }
    .v-leave-active {
        transition: opacity 0.3s;
    }
    .v-enter, .v-leave-to {
        opacity: 0.0;
    }

</style>