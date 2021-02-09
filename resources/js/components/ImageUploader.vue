<template>
<div @click.self="$emit('close')" class="fixed w-full h-full top-0 left-0 z-40 flex items-center justify-center bg-black bg-opacity-80 rounded">
    <div class="overflow-hidden bg-black mx-2">

        <div class="relative flex items-center justify-center">

        <!-- アップロード画像を削除ボタン -->
            <div class="absolute right-2 top-1 z-10">
                <button @click="onDelete">
                    <i class="fas fa-times text-3xl text-white"></i>
                </button>
            </div>
        <!-- メイン -->
            <vue-cropper
                ref="cropper" :src="uploadImage"
                :guides="true" :view-mode="0"
                drag-mode="move"
                :auto-crop-area="0.8"
                :auto-crop="true"
                :movable="true"
                :aspect-ratio="1 / 1"
                :minContainerHeight="sizeY"
                :img-style="{ 'width': sizeX + 'px', 'height': sizeY + 'px' }"
            ></vue-cropper>

        </div>

    <!-- 回転ボタン、決定ボタン -->
        <div class="flex p-4 bg-gray-200 space-x-2">
            <div class="flex flex-grow space-x-2">
                <my-button @click.native="rotate(-90)" color="blue-dark"><i class="fas fa-undo"></i></my-button>
                <my-button @click.native="rotate(90)" color="blue-dark"><i class="fas fa-undo fa-flip-horizontal"></i></my-button>
            </div>
            <my-button @click.native="crop" color="blue-dark">決定</my-button>
        </div>

    </div>
</div>
</template>

<script>
import VueCropper from 'vue-cropperjs'
import MyButton from './MyButton'
import "cropperjs/dist/cropper.css"

export default {
    components: {
        VueCropper,
        MyButton,
    },

    computed: {
        
        //アップロードされた画像
        uploadImage() {
            return this.$store.state.image.uploadImage
        },

        blob() {
            return this.$store.state.image.blob
        },
        
        //画面サイズに応じて、vueCropperのコンテナサイズを決定
        sizeX() {
            return window.innerHeight > window.innerWidth
             ? window.innerWidth * 0.9
             : window.innerHeight * 0.8
        },
        sizeY() {
            return window.innerHeight > window.innerWidth
             ? window.innerWidth * 1.1
             : window.innerHeight * 0.5
        }
    },

    methods: {
        crop(){
            this.$store.commit('setLoading', true)

            let self = this

            //トリミングされた画像をBlobに変換してストアに保存
            this.$refs.cropper.getCroppedCanvas().toBlob(blob => {
                self.$store.commit('image/setBlob', blob)

            //プレビューのためのトリミング後の画像を、DataURLに変換して取得
                let fileReader = new FileReader()
                fileReader.onload = function() {
                    self.$store.commit('image/setCroppedImage', this.result)
                    self.$store.commit('setLoading', false)
                }
                fileReader.readAsDataURL( blob )
            })

            //このモーダルを閉じる
            this.$emit('close');

        },

        //画像を削除
        onDelete() {
            this.$store.commit('image/setBlob', null);
            this.$store.commit('image/setUploadImage', null)
            this.$store.commit('image/setCroppedImage', null)

            //このモーダルを閉じる
            this.$emit('close');
        },

        //画像の回転
        rotate(deg) {
            this.$refs.cropper.rotate(deg);
        },
    },

};
</script>
