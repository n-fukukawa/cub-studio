<template>
<div>
	<div class="my-4">
		<search-box @submit="search" @keydown.enter.native="search" v-model="keyword" placeholder="目的地から検索"/>
	</div>
	<div class="grid grid-cols-12 mt-2 sm:mt-20 sm:gap-1">
		<post-tile
			v-for="post in posts"
			:post="post"
			:key="post.id"
			class="col-span-6 items-strech sm:col-span-3"
		/>
	</div>
	<div class="flex justify-center p-4 text-gray-400 sm:p-16">
		<button v-show="canLoadPosts" @click="getPosts" class="focus:outline-none">つづきを読み込む ↓</button>
		<div v-show="!canLoadPosts">投稿は以上です</div>
	</div>
</div>

</template>
<script>
import SearchBox from '../components/SearchBox'
import PostTile from '../components/PostTile'

export default {
	components: {
		SearchBox,
		PostTile,
	},

	created(){
		this.getPosts()
	},

	data(){
		return {
			posts:[],
			postsNumber: 0,
			keyword: '',
			page: 1,
		}
	},

	computed: {
		canLoadPosts(){
			//paginateで読み込んでいる単位数
			const paginateUnit = 32  

			//getPostsメソッド実行後にpageに1加算しているので、実際に現在取得済みのページ数は(page - 1)である
			return this.postsNumber > (this.page - 1) * paginateUnit; 
		}
	},

	methods: {
		async getPosts(){
			await axios.get('/api/post', {
				params: {
					page: this.page++
				}
			})
			.then(response => {
				this.posts = [...this.posts, ...response.data.posts.data]
				this.postsNumber = response.data.postsNumber
			})
			.catch(error => {
				this.$store.commit('error/setErrorCode', error.response.status)
			})
		},

		search(event){
			if(this.keyword === ''){
				return 
			}
			//日本語入力中の時のエンターキーの場合
			if(event && event.type === 'keydown' && event.keyCode !==13){
				return
			}
			this.$router.push('/post/search/' + this.keyword)
		}
	},



}
</script>