<template>
<post-layout>
    <template #left>

    <!-- 画像を選択 -->
        <label for="upload" v-if="!croppedImage" class="w-full rectangle flex items-center justify-center border-2 border-dashed border-gray-200 rounded text-center text-gray-500 hover:border-gray-300 hover:bg-gray-100 hover:bg-opacity-50 transition-all">
            <i class="far fa-image mr-2 text-8xl text-gray-300"></i>
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

    created() {
        //画像のストアを初期化
        this.$store.commit('image/setUploadImage', null)
        this.$store.commit('image/setCroppedImage', null)
        this.$store.commit('image/setBlob', null)
    },

    data() {
        return {
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
            this.$store.commit('setLoading', true)
            let formData = new FormData()
            formData.append("title", this.postForm.title)
            formData.append("departure", this.postForm.departure)
            formData.append("arrival", this.postForm.arrival)
            formData.append("distance", this.postForm.distance)
            formData.append("time", this.postForm.time)
            formData.append("body", this.postForm.body)
            formData.append("image",　this.$store.state.image.blob)

            await axios.post('/api/post', formData)
                .then(response => {
                    this.$router.push({path: '/'})
                })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                    this.$store.commit('error/setErrorMessages', error.response.data.errors)
                })
                .finally(() => {
                    this.$store.commit('setLoading', false)
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