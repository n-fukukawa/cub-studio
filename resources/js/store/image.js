const state = {
    uploadImage: null,
    croppedImage: null,
    blob: null,
}

const mutations = {
    setUploadImage(state, image){
        state.uploadImage = image
    },
    setCroppedImage(state, image){
        state.croppedImage = image
    },
    setBlob(state, blob){
        state.blob = blob
    }
}

export default {
    namespaced: true,
    state,
    mutations,
}