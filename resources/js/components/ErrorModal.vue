<template>
<transition name="modal" appear>
    <div @click.self="$emit('close')" class="fixed w-full h-full top-0 left-0 z-50 flex items-center justify-center bg-black bg-opacity-50" >
        <div class="overflow-hidden w-4/5 bg-white rounded-sm sm:w-3/5">
            <ul class="px-4 py-8 text-center">
                <li v-for="(errorMessage, i) in errorMessages" :key="i" class="py-1 text-sm">{{ errorMessage }}</li>
            </ul>
            <div class="p-4 bg-gray-200">
                <my-button @click.native="$emit('close')" color="gray-500">閉じる</my-button>
            </div>
        </div>
    </div>
</transition>
</template>

<script>
import MyButton from './MyButton'
export default {
    components: {
        MyButton,
    },
    computed: {
        errorMessages() {
            return this.$store.getters['error/preErrorMessages']
        },
    },
}
</script>

<style scoped>
.modal-enter-active {
  transition: opacity 0.3s;
}

.modal-leave-active {
  transition: opacity 0.4s ease 0.2s;
}

.modal-enter, .modal-leave-to {
  opacity: 0;
}

</style>