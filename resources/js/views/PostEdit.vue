<template>
<post-layout>
    <template #left>

    <!-- 画像を表示（クリックでファイルを選択） -->
        <label for="upload">
            <img v-lazy="'/storage/' + post.image" v-if="!croppedImage" width="100%" height="auto" class="bg-gray-100">
        </label>
        <input v-show="false" @click="clear" @change="upload" id="upload" type="file" ref="file">

    <!-- 画像トリミングモーダル -->
        <image-uploader v-if="modal" @close="close"/>

    <!-- トリミング後の画像を表示（クリックでトリミングモーダル表示） -->
        <img v-if="croppedImage" :src="croppedImage" @click="open" width="100%" height="auto" class="bg-gray-100">

    </template>

    <template #right>

    <!-- 投稿フォーム　-->
        <div class="mt-4 mx-2 sm:mt-0">
            <my-input v-model="postForm.title" placeholder="タイトル" class="mt-2 heading-8"/>
            <div class="flex space-x-4 mt-2">
                <my-input v-model="postForm.departure" placeholder="出発地"></my-input>
                <my-input v-model="postForm.arrival" placeholder="目的地"></my-input>
            </div>
            <div class="flex space-x-4 mt-2">
                <my-input v-model="postForm.distance" placeholder="走行距離(km)"></my-input>
                <my-input v-model="postForm.time" placeholder="所要時間"></my-input>
            </div>
            <my-textarea v-model="postForm.body" class="mt-4"></my-textarea>
        </div>

    <!-- 送信ボタン -->
        <div class="mt-4">
            <my-button @click.native="submit" color="blue-dark">投稿</my-button>
        </div>

    </template>
</post-layout>
</template>

<script>
import PostLayout from '../layouts/PostLayout'
import ImageUploader from '../components/ImageUploader'
import MyButton from '../components/MyButton'
import MyInput from '../components/MyInput'
import MyTextarea from '../components/MyTextarea'

export default {
    components: {
        PostLayout,
        ImageUploader,
        MyButton,
        MyInput,
        MyTextarea,
    },

    async created() {
        //画像のストアを初期化
        this.$store.commit('image/setUploadImage', null)
        this.$store.commit('image/setCroppedImage', null)
        this.$store.commit('image/setBlob', null)

        //投稿データを取得
        await axios.get('/api/post/' + this.id + '/edit')
            .then(response => {
                this.post = response.data.post
                this.postForm.title = this.post.title
                this.postForm.departure = this.post.departure
                this.postForm.arrival = this.post.arrival
                this.postForm.distance = this.post.distance
                this.postForm.time = this.post.time
                this.postForm.body = this.post.body
            })
            .catch(error => {
                this.$store.commit('error/setErrorCode', error.response.status)
            })
    },

    props: {
        id: {
            type: String    //ルートパラメーター（投稿ID）
        }
    },

    data() {
        return {
            post: {},
            postForm: {
                body: '',
                departure: '',
                arrival: '',
                distance: '',
                time: '',
                title: '',
            },
            modal: false,
        }
    },

    computed: {
        //トリミングされた画像(データURL)
        croppedImage() {
            return this.$store.state.image.croppedImage
        },
    },

    methods: {
        
        //ストアにアップロードされた画像を保存する
        upload(event) {       
            const file = event.target.files[0];     

            //画像でない場合
            if(!file || !file.type.includes("image/")){
                this.$store.commit('error/setErrorMessages', '画像を選択してください')
                return;
            }

            if (typeof FileReader === "function") {

                const reader = new FileReader()

                reader.readAsDataURL(file)

                reader.onload = event => {
                    this.$store.commit('image/setUploadImage', event.target.result)
                    this.open()
                };

            } else {
                alert("申し訳ありません。お使いのブラウザでは利用できません。")
            }
        },

        //同じファイルが選択された時に反映されない問題を解消
        clear(){
            this.$refs.file.value = ''
        },

        //トリミングモーダルの開閉
        open(){
            this.modal = true
        },
        close(){
            this.modal = false
        },

        //フォーム送信
        async submit(){
            
            let formData = new FormData()
            formData.append("title", this.postForm.title)
            formData.append("departure", this.postForm.departure)
            formData.append("arrival", this.postForm.arrival)
            formData.append("distance", this.postForm.distance)
            formData.append("time", this.postForm.time)
            formData.append("body", this.postForm.body)
            formData.append("image",　this.$store.state.image.blob)

            await axios.post('/api/post/' + this.id, formData)
                .then(response => {
                    this.$router.push('/post/' + this.id)
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                    this.$store.commit('error/setErrorMessages', error.response.data.errors)
                })
        },
    }
}
</script>

<style scoped>
.rectangle::before {
    content: '';
    display: block;
    padding-top: 100%;
}
</style>