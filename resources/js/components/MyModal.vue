<template>
<transition name="modal" appear>
   <div class="fixed w-full h-full top-0 left-0 z-30 flex items-center justify-center bg-black bg-opacity-50"
     @click.self="$emit('close')">
        <div class="overflow-hidden w-4/5 bg-white rounded-sm sm:w-1/3">
            <div class="px-4 py-8">
                <slot/>
            </div>
            <div class="p-4 bg-gray-200">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</transition>
</template>

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