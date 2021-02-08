<template>
    <post-layout>
        <template #left>

        <!-- 画像を表示（クリックでファイルを選択） -->
            <label for="upload" class="flex place-items-center justify-center mt-2">
                <img :src="'/storage/' + user.image" v-if="!croppedImage" class="w-48 h-48 mb-4 mx-auto rounded-full border-2 border-gray-200 bg-gray-100 transition-all hover:opacity-80">
                <input v-show="false" @click="clear" @change="upload" id="upload" type="file" ref="file">
            </label>

        <!-- 画像トリミングモーダル -->
            <image-uploader v-if="modal" @close="close" ref="image"></image-uploader>

        <!-- トリミング後の画像を表示（クリックでトリミングモーダル表示） -->
            <img v-if="croppedImage" :src="croppedImage" @click="open" width="100%" height="auto" class="w-48 h-48 mb-4 mx-auto rounded-full border-2 border-gray-200 bg-gray-100 transition-all hover:opacity-80">

        </template>
        
        <template #right>
            <div class="mt-4 mx-2 sm:mt-0">
                <label for="introduction" class="block text-gray-600 mb-2">自己紹介文<span class="taxt-xs">（100文字以内）</span></label>
                <my-textarea v-model="introduction"></my-textarea>
            </div>
            <div class="mt-2 mx-2">
            <my-button @click.native="submit" color="blue-dark">更新</my-button>   
            </div>

        </template>
        
    </post-layout>
</template>

<script>
import PostLayout from '../layouts/PostLayout'
import ImageUploader from '../components/ImageUploader'
import MyButton from '../components/MyButton'
import LoadingComponent from '../components/LoadingComponent'
import MyTextarea from '../components/MyTextarea'
import MyModal from '../components/MyModal'

export default {
    components: {
        PostLayout,
        ImageUploader,
        MyButton,
        LoadingComponent,
        MyTextarea,
        MyModal,
    },

    async created(){
        //画像のストアを初期化
        this.$store.commit('image/setUploadImage', null)
        this.$store.commit('image/setCroppedImage', null)
        this.$store.commit('image/setBlob', null)

        //ユーザーデータを取得
        await axios.get('/api/user/' + this.id + '/edit')
        .then(response => {
            this.user = response.data.user
            this.introduction = this.user.introduction
        })
        .catch(error => {
            this.$store.commit('error/setErrorCode', error.response.status)
        })
    },

    props: {
        id: {
            type: String,
        }
    },

    data() {
        return {
            user: {},
            introduction: '',
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

        submit() {
            let formData = new FormData();
            formData.append("introduction", this.introduction);
            formData.append("image",　this.$store.state.image.blob)

            axios.post('/api/user/' + this.user.id, formData)
                .then(response => {
                    this.$router.push('/user/' + this.user.id)
                    })
                .catch(error => {
                    this.$store.commit('error/setErrorCode', error.response.status)
                    this.$store.commit('error/setErrorMessages', error.response.data.errors)
                })
        },
    }
};
</script>