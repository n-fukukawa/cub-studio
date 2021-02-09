<template>
<div>
<post-layout>
    <template #left>
	<!--　画像を表示 -->
		<img v-lazy="'/storage/' + post.image" width="100%" height="auto" alt="">
	</template>

	<template #right>
		<div class="h-full flex flex-col">
		<!-- 投稿本文 -->
			<div class="flex-1 mt-1 leading-6 tracking-wider sm:mt-0">
				<div class="flex my-2 items-center text-gray-400 text-xs">
					<p class="flex-grow self-center text-gray-400">{{ date }}</p>
					<div v-if="post.distance || post.time" class="flex px-2 space-x-2">
						<div v-if="post.distance"><i class="fas fa-motorcycle mr-1"></i>{{ post.distance }} km</div>
						<div v-if="post.time"><i class="far fa-clock mr-1"></i>{{ post.time }}</div>
					</div>
					<div>
						<router-link v-if="mine" :to="'/post/' + post.id + '/edit'" class="flex-end px-2 py-1 text-gray-400 text-sm hover:text-gray-700"><i class="fas fa-pen"></i></router-link>
						<button v-if="mine" @click="open" class="justify-end px-2 py-1 text-gray-400 text-sm focus:outline-none hover:text-gray-700"><i class="fas fa-trash-alt"></i></button>
					</div>
				</div>

				<div class="flex items-center justify-between">
					<p class="inline-block"><span v-if="hasPlace" class="text-xs bg-blue p-1 text-white">{{ post.departure }}〜{{ post.arrival }}</span></p>
				</div>
				<div v-if="post.title" class="mt-2 px-2 text-lg leading-8">{{ post.title }}</div>
				<div v-if="post.body" class="my-4 px-2">{{ post.body }}</div>
			</div>

		<!-- いいねボタン、ユーザー  -->
			<div class="flex mt-2">
				<router-link :to="'/user/' + user.id" class="flex flex-grow mr-2 mb-2 items-end">
					<img :src="image" class="w-8 h-8 mr-2 rounded-full border border-gray-200">
					<p class="text-base tracking-wide">{{ user.name }}</p>
				</router-link>
				<like-button :post="post" :initial-liked="post.is_liked" :initial-count="likes.length"/>
			</div>
		</div>

		<!-- 削除確認モーダル -->
		<my-modal v-if="modal" @close="close">
			<p class="text-center">削除しますか？</p>
			<template #footer>
			<div class="flex space-x-3">
				<my-button @click.native="close" color="gray-500">キャンセル</my-button>
				<my-button @click.native="onDelete" color="pink">削除</my-button>
			</div>
			</template>
		</my-modal>
	</template>
	</post-layout>

	<!-- いいねしたユーザー一覧 -->
    <div v-if="likes.length" class="my-8 sm:w-3/4 sm:mx-auto">
		<div class="flex place-items-center">
			<p class="flex-grow border-b"></p>
			<p class="px-6 text-center text-sm tracking-widest">YAEH!したユーザー</p>
			<p class="flex-grow border-b"></p>
		</div>
        <div class="mt-2 sm:mt-20 sm:gap-1 divide-y">
            <user-card v-for="person in likes" :user="person" :key="person.id"/>
        </div>
    </div>
</div>
</template>
<script>
    import PostLayout from '../layouts/PostLayout'
    import UserCard from '../components/UserCard'
    import MyModal from '../components/MyModal'
    import LikeButton from '../components/LikeButton'
    import MyButton from '../components/MyButton'

	export default {
        components: {
            PostLayout,
            UserCard,
            MyModal,
            LikeButton,
            MyButton,
		},

		async created() {
			this.$store.commit('setLoading', true)

			await axios.get('/api/post/' + this.id)
				.then(response => {
					this.post = response.data.post
					this.user = response.data.user
					this.likes = response.data.likes
				})
				.catch(error => {
					this.$store.commit('error/setErrorCode', error.response.status)
				})
				.finally(() => {
					this.$store.commit('setLoading', false)
				})
		},

		props: {
			id: { 
				type: String	//ルートパラメーター（投稿ID）
			},
		},

		data(){
			return {
				post: {},
				user: {},
				likes: {},
				modal: false,
				loading: false,
			}
		},

		computed: {

			//投稿者が認証ユーザーと同じか
			mine() {
				if(this.$store.state.auth.user){
					return this.$store.state.auth.user.id === this.user.id
				}
			},

			//出発地と目的地が両方あるか
			hasPlace() {
				return this.post.departure || this.post.arrival
			},

			//投稿日
        	date() {
            	return String(this.post.created_at).substr(0,10)
			},

			//ユーザー画像
			image(){
				return this.user.image 
					? '/storage/' + this.user.image
					: '/img/noimage.png'
			}
		},

		methods: {

			//削除確認モーダルの開閉
			open() {
				this.modal = true;
			},

			close() {
				this.modal = false;
			},

			//投稿を削除する
			async onDelete(){
				await axios.delete('/api/post/' + this.post.id)
					.then(response => {
						this.$router.go(-1)
					})
					.catch(error => {
						this.$store.commit('error/setErrorCode', error.response.status)
					});
			}
		},

	}
</script>